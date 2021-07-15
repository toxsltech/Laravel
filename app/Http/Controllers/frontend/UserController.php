<?php
namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Page;
use App\Models\PostLocation;
use App\Models\SaveCounters;
use App\Models\Post;
use App\Models\Notification;
use App\Models\Follower;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;

class UserController extends Controller
{
    /*
     * |--------------------------------------------------------------------------
     * | User Controller
     * |--------------------------------------------------------------------------
     * |
     * | This controller handles authenticating User for the application and
     * | redirecting them to your home screen. The controller uses a trait
     * | to conveniently provide its functionality to your applications.
     * |
     */
    public function disCover()
    {
        try{
            $user = Auth::user();
            $SaveCounterData = SaveCounters::where('user_id','=', $user->id)->get();
            $postData = Post::where('state_id', Post::STATE_ACTIVE)->where('created_by_id','!=', Auth::id())->whereNotIn('id',$SaveCounterData->pluck('post_id'))->with('getLocationData')->latest()->paginate(12);
            return view('frontend.pages.discover', compact('user', 'postData', 'SaveCounterData'));
        }catch (\Exception $e){
            return Redirect::back()->with('error', $e->getMessage());
        }
    }
    
    public function getUserNearLoaction($userData)
    {
        $nearLoctions = PostLocation::select("post_locations.*")->selectRaw("6371 * acos(cos(radians(" . $userData->latitude . "))* cos(radians(latitude)) * cos(radians(longitude) - radians(" . $userData->longitude . "))+ sin(radians(" .$userData->latitude. ")) * sin(radians(latitude))) AS distance")->having('distance', '<', 3500)->orderBy('distance', 'asc')->get();
        return $nearLoctions;
    }
    
    public function getNearLoaction($SaveCounterData)
    {
        $loctionLngLat = PostLocation::whereIn('post_id',$SaveCounterData->pluck('post_id'))->latest()->first();
        $nearLoctions = PostLocation::select("post_locations.*")->selectRaw("6371 * acos(cos(radians(" . $loctionLngLat->latitude . "))* cos(radians(latitude)) * cos(radians(longitude) - radians(" . $loctionLngLat->longitude . "))+ sin(radians(" .$loctionLngLat->latitude. ")) * sin(radians(latitude))) AS distance")->having('distance', '<', 5000)->orderBy('distance', 'asc')->get();
        return $nearLoctions;
    }
    
    
    public function updateLatLog(Request $request)
    {
        User::where('id', Auth::id())->update(['latitude' => $request->latitude, 'longitude' => $request->longitude]);
        return json_encode(array('statusCode' => 200));
    }
    
    public function privacyPolicy()
    {
        $policy = Page::where('type_id', Page::TYPE_POLICIES)->where('state_id', Page::STATE_ACTIVE)->first();
        return view('frontend.pages.privacy_policy', compact('policy'));
    }
    
    public function termCondition()
    {
        $term = Page::where('type_id', Page::TYPE_TERMS)->where('state_id', Page::STATE_ACTIVE)->first();
        return view('frontend.pages.terms_conditions', compact('term'));
    }
    
    public function ourMission()
    {
        $mission = Page::where('type_id', Page::TYPE_MISSION)->where('state_id', Page::STATE_ACTIVE)->first();
        return view('frontend.pages.our-mission', compact('mission'));
    }
        
    public function profileUpdate(Request $request){
        $user = User::where('id', Auth::id())->first();
        if (!empty($user)) {
            $user->about_me = $request->input('about_me');
            if ($user->save()) {
                try {
                    $getUserfollowing = Follower::where('following_id',Auth::id())->get();
                    foreach ($getUserfollowing as $key => $value) {
                        $sendNotification = new Notification();
                        $sendNotification->user_id = Auth::id();
                        $sendNotification->to_user_id = $value->follower_id;
                        $sendNotification->model_id = Auth::id();
                        $sendNotification->model_type = User::MODEL_NAME;
                        $sendNotification->title = User::TITLE;
                        $sendNotification->description = $user->about_me;
                        $sendNotification->save();
                    }
                } catch (\Exception $e) {
                    return Redirect::back()->withInput()->with('error', $e->getMessage());
                }
                return redirect('profile')->with('success', 'Profile Updated succesfully');
            } else {
                return Redirect::back()->withInput()->with('error', 'Some error occured. Please try again later');
            }
        }else{
            return Redirect::back()->withInput()->with('error', 'Please first login');
        }
    }
        
    public function updateFile(Request $request, $id)
    {
        request()->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg|max:10000'
        ], [
            'file' => 'Image is required.'
        ]);
        $data = [];
        $imageName = date('Ymd') . '_' . time() . '.' . $request->file->getClientOriginalExtension();
        $request->file->move(public_path('uploads'), $imageName);
        $update_arr = [];
        $update_arr['profile_file'] = $imageName;
        User::where('id', $id)->update($update_arr);
        $user = User::where('id', $id)->first();
        $data['status'] = 200;
        $data['file'] = $user->profile_file;
        return response()->json($data);
    }   
    
    public function userSetting(){
        return view('frontend.users.settings');       
    }
    
    public function updatePassword(Request $request)
    {
        $user = User::findOrFail(Auth::id());
        $rules = array(
            'current_password' => 'required',
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password'
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        } else {
            if(Hash::check($request->current_password, auth()->user()->password)){ 
                $user->password = bcrypt($request->password);
                if ($user->save()) {
                    Auth::login($user);
                    return redirect('setting')->with('success', 'Password updated succesfully');
                } else {
                    return Redirect::back()->withInput()->with('error', 'Some error occured. Please try again later');
                }
            }else{
                return Redirect::back()->withInput()->with('current_password_error',  'Please enter correct current password');
            }    
        }
    }
}