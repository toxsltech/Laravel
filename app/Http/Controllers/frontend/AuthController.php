<?php
namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\LoginHistory;
use App\Models\EmailQueue;
use App\Models\Feed;
use App\Models\Age;

class AuthController extends Controller
{
    
    /*
     * |--------------------------------------------------------------------------
     * | Auth Controller
     * |--------------------------------------------------------------------------
     * |
     * | This controller handles authenticating Auth for the application and
     * | redirecting them to your home screen. The controller uses a trait
     * | to conveniently provide its functionality to your applications.
     * |
     */
    public function addAdmin()
    {
        $user = User::all();
        if ($user->isEmpty()) {
            return view('frontend.auth.add-admin');
        } else {
            return redirect('/');
        }
    }
    
    public function saveAdmin(Request $request)
    {
        $user = User::all();
        if ($user->isEmpty()) {
            $rules = array(
                'first_name' => 'required|min:2',
                'last_name' => 'required|min:1',
                'email' => 'required|email',
                'password' => 'required|min:8',
                'confirm_password' => 'required|same:password'
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return Redirect::back()->withInput()->withErrors($validator);
            } else {
                $user = new User();
                $user->first_name = $request->input('first_name');
                $user->last_name = $request->input('last_name');
                $user->email = $request->input('email');
                $user->password = bcrypt($request->input('password'));
                $user->role_id = User::ROLE_ADMIN;
                $user->state_id = User::STATE_ACTIVE;
                $user->Type_id = User::TYPE_UNBLOCK;
                if ($user->save()) {
                    return redirect('/')->with('success', 'Please login');
                } else {
                    return Redirect::back()->withInput()->with('error', 'Some error occured. Please try again later');
                }
            }
        } else {
            return redirect('/')->with('error', 'Please login');
        }
    }
    
    public function signUp()
    {
        $user = User::all();
        if ($user->isEmpty()) {
            return redirect('add-admin');
        } else {
            if(Auth::check()):
                return redirect('discover');
            else:   
            return view('frontend.auth.register');
            endif;
        }
    }
    
    public function saveUser(Request $request)
    {
        $user = User::all();
        $dt = new Carbon();
        $before = $dt->subYears(120)->format('Y-m-d');
        if ($user->isEmpty()) {
            return view('frontend.auth.add-admin');
        } else {
            $rules = array(
                'first_name' => 'required|alpha|max:30',
                'last_name' => 'required|alpha|max:30',
                'date_of_birth' => 'required|date_format:Y-m-d|before:today|after:' . $before,
                'email' => 'required|regex:/(.+)@(.+)\.(.+)/i|unique:users,email',
                'password' => 'required|min:8',
                'confirm_password' => 'required|same:password',
                'terms_condition' => 'required'
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return Redirect::back()->withInput()->withErrors($validator);
            } else {
                $getAge=Age::pluck('age');
                if(!$getAge->isEmpty()):
                $dob = $request->date_of_birth;
                $calAge = Carbon::parse($dob)->age;
                if($calAge < $getAge[0]){
                    return Redirect::back()->withInput()->with('age_error', 'You must be '. $getAge[0] . ' years above');
                };
                else:
                return Redirect::back()->withInput()->with('error', 'Authorized User Age not pass by Admin, Sorry for inconvenience');
                endif;
                $user = new User();
                $user->first_name = $request->input('first_name');
                $user->last_name = $request->input('last_name');
                $user->date_of_birth = $request->input('date_of_birth');
                $user->email = $request->input('email');
                $user->password = bcrypt($request->input('password'));
                $user->terms_condition = User::TERM_CONDITION;
                $user->role_id = User::ROLE_USER;
                $user->state_id = User::STATE_ACTIVE;
                $user->Type_id = User::TYPE_UNBLOCK;
                $user->generateAuthKey();                
                if ($user->save()) {
                    $user = EmailQueue::add([
                        'to' => $user->email,
                        'from' => env('MAIL_FROM_ADDRESS'),
                        'subject' => 'Your Email Verification Link',
                        'view' => 'email.user-verification',
                        'model' => [
                            'user' => $user
                        ]
                    ]);
                    $credentials = $request->only('email', 'password');                    
                    if (Auth::attempt($credentials)) {
                        LoginHistory::add($request, LoginHistory::TYPE_WEB, LoginHistory::STATE_SUCCESS, Auth::id());
                        Feed::add($request,  Feed::CONTENT_USER, url()->current(), Auth::id(), Feed::STATE_ACTIVE, Feed::TYPE_WEB);
                        return redirect('discover')->with('success', 'SignUp Successfully');
                    }else{
                        return Redirect::back()->withInput()->with('error', 'Some error occured');
                    }
                } else {
                    return Redirect::back()->withInput()->with('error', 'Some error occured');
                }
            }
        }
    }
    
    public function actionLogin(Request $request)
    {
        $rules = array(
            'email' => 'required|email',
            'password' => 'required'
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        } else {
            $user = User::where('email', $request->input('email'))->first();
            if (! empty($user)) {
               if ($user->type_id == User::TYPE_UNBLOCK) {
                if ($user->state_id == User::STATE_ACTIVE) {
                    $credentials = $request->only('email', 'password');
                    $remember = $request->has('remember_me') ? true : false;
                    if (Auth::attempt($credentials, $remember)) {
                        if($remember==true){
                        Auth::login(Auth::user(), true);
                        }
                        $user->generateAccessToken();
                        $user->save();
                        LoginHistory::add($request, LoginHistory::TYPE_WEB, LoginHistory::STATE_SUCCESS, $user->id);
                        if ($user->role_id == User::ROLE_ADMIN) {
                            return redirect('admin/dashboard')->with('success', 'Login succesfully');
                        } elseif ($user->role_id == User::ROLE_USER) {
                            if($request->latitude && $request->longitude){   
                            User::where('id', Auth::id())->update(['latitude' =>$request->latitude,'longitude'=>$request->longitude]);
                            }
                            return redirect('discover')->with('success', 'Login succesfully');
                        } else {
                            return redirect('/')->with('errore', 'Some error occured');
                        }
                    } else {
                        $error = 'Password is incorrect';
                        LoginHistory::add($request, LoginHistory::TYPE_WEB, LoginHistory::STATE_FAILED, $error);
                        return Redirect::back()->withInput()->with('errorp', $error);
                    }
                } else {
                    return Redirect::back()->withInput()->with('errore', 'Please verified Email first. Link Send to Your Email Address.');
                }
               } else {
                   return Redirect::back()->withInput()->with('errore', 'Your Email has been blocked.');
               }
            } else {
                $error = 'Email does not exist';
                LoginHistory::add($request, LoginHistory::TYPE_WEB, LoginHistory::STATE_FAILED, $error);
                return Redirect::back()->withInput()->with('errore', $error);
            }
        }
    }
    
    public function forgotPassword(Request $request)
    {
        $rules = array(
            'email' => 'required|email'
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator); 
        } else {           
            $user = User::where('email', $request->input('email'))->first();
            if (! empty($user)) {
                $user->getResetUrl();
                $res = EmailQueue::add([
                    'to' => $user->email,
                    'from' => 'admin@toxsl.in',
                    'subject' => 'Reset Password Email',
                    'view' => 'email.forgot-password',
                    'model' => [
                        'user' => $user
                    ]
                ]);
                if ($res) {
                    return Redirect::back()->with('success', 'Mail has been sent to you with a reset link.');
                } else {
                    return Redirect::back()->with('error', 'Some error occured. Please try again later');
                }
            } else {
                return Redirect::back()->withInput()->with('error', 'Email does not exist');
            }
        }
    }
    
    public function resetPassword(Request $request, $token)
    {
        $user = User::where('password_reset_token', $token)->first();
        if (! empty($user)) {
            return view('frontend.auth.update-password');
        } else {
            return view('frontend.auth.update-password', [
                'error' => 'This URL is expired'
            ]);
        }
    }
    
    public function updateUserPassword(Request $request, $token)
    {
        $rules = array(
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password'
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        } else {
            $user = User::where('password_reset_token', $token)->first();
            if (! empty($user)) {
                $user->password = bcrypt($request->input('password'));
                $user->password_reset_token = '';
                if ($user->save()) {
                    return Redirect::back()->with('success', 'Password updated succesfully');
                } else {
                    return Redirect::back()->with('error', 'Some error occured. Please try again later');
                }
            } else {
                return Redirect::back()->with('error', 'This URL is expired');
            }
        }
    }
    
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }
    
    
    public function handleFacebookCallback()
    {
        $user = Socialite::driver('facebook')->stateless()->user();
        $name = trim($user->name);
        $last_name = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
        $first_name = trim( preg_replace('#'.preg_quote($last_name,'#').'#', '', $name ) );        
        $finduser = User::where('email', $user->email)->first();
        if($finduser){
            Auth::login($finduser);
            return redirect('discover');
        }else{
            $user = User::create([
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $user->email,
                'role_id' => User::ROLE_USER,
                'state_id' => User::STATE_ACTIVE,
                'type_id' => User::TYPE_UNBLOCK,
                'social_id'=> $user->id,
                'social_type' => User::SOCIAL_FACEBOOK,
                'password' => Hash::make(Str::random(10))
            ]);
            if ($user->save()) {
                Auth::login($user);
                return redirect('discover')->with('success', 'signUp Successfully');
            } else {
                return Redirect::back()->withInput()->with('error', 'Some error occured');
            }
        }
    }
    
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
    
    
    public function handleGoogleCallback()
    { 
        $user = Socialite::driver('google')->stateless()->user();
        $name = trim($user->name);
        $last_name = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
        $first_name = trim( preg_replace('#'.preg_quote($last_name,'#').'#', '', $name ) );
        $finduser = User::where('email', $user->email)->first();
        if($finduser){
            Auth::login($finduser);
            return redirect('discover');
        }else{
            $user = User::create([
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $user->email,
                'role_id' => User::ROLE_USER,
                'state_id' => User::STATE_ACTIVE,
                'type_id' => User::TYPE_UNBLOCK,
                'social_id'=> $user->id,
                'social_type' => User::SOCIAL_GOOGLE,
                'password' => Hash::make(Str::random(10))
            ]);
            if ($user->save()) {
                Auth::login($user);
                return redirect('discover')->with('success', 'signUp Successfully');
            } else {
                return Redirect::back()->withInput()->with('error', 'Some error occured');
            }
        }
    }
}