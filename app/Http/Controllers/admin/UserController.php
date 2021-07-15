<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Feed;
use App\Models\Post;
use App\Models\PostLocation;
use App\Models\LoginHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;
use Carbon\Carbon;
class UserController extends Controller
{

    /*
     * |--------------------------------------------------------------------------
     * | User Controller
     * |--------------------------------------------------------------------------
     * |
     * | This controller handles authenticating users for the application and
     * | redirecting them to your home screen. The controller uses a trait
     * | to conveniently provide its functionality to your applications.
     * |
     */
    public function index(Request $request)
    {
        $count = User::where('role_id', User::ROLE_USER)->count();
        $activeUser = User::where('role_id', User::ROLE_USER)->where('type_id',User::TYPE_UNBLOCK)->count();
        $inactiveUser = User::where('role_id', User::ROLE_USER)->where('type_id',User::TYPE_BLOCK)->count();
        $countlogin = LoginHistory::get()->count();
        $countpost = Post::get()->count();
        $facebooksocial = User::where('social_type', User::SOCIAL_FACEBOOK)->get()->count();
        $googleSocial = User::where('social_type', User::SOCIAL_GOOGLE)->get()->count();
        $countActivePost = Post::where('state_id', Post::STATE_ACTIVE)->get()->count();
        
        $data['pieChart'] = User::where('role_id', User::ROLE_USER)->select(DB::raw("COUNT(*) as count"), DB::raw("MONTHNAME(created_at) as month_name"))
        ->whereYear('created_at', date('Y'))
        ->groupBy('month_name')
        ->orderBy('count')
        ->get();        
        
        $record['pieChart'] = User::where('role_id', User::ROLE_USER)->select(DB::raw("COUNT(*) as count"), DB::raw("DAYNAME(created_at) as day_name"), DB::raw("DAY(created_at) as day"))
        ->where('created_at', '>', Carbon::today()->subDay(6))
        ->groupBy('day_name','day')
        ->orderBy('day')
        ->get();
        
        $record['pieChart'] = User::select(DB::raw("COUNT(*) as count"), DB::raw("DAYNAME(created_at) as day_name"), DB::raw("DAY(created_at) as day"))
        ->where('created_at', '>', Carbon::today()->subDay(6))
        ->groupBy('day_name','day')
        ->orderBy('day')
        ->get();
        
        $location['pieChart'] = Post::select(DB::raw("COUNT(*) as count"), DB::raw("MONTHNAME(created_at) as month_name"))
        ->whereYear('created_at', date('Y'))
        ->groupBy('month_name')
        ->orderBy('count')
        ->get();
        
        $locationData= Post::select(DB::raw("COUNT(*) as count"), DB::raw("MONTHNAME(created_at) as month_name"))
        ->whereYear('created_at', date('Y'))
        ->groupBy('month_name')
        ->orderBy('count')
        ->get();
        if(!$locationData->isEmpty()){
            foreach ($locationData as $key=>$val){
                $yearlocation[$key] = $val->month_name;
                $userlocation[$key] = $val->count;
            }
        }else{
            $yearlocation="";
            $userlocation="";
        }
        
        $travelRecord['pieChart'] = Post::select(DB::raw("COUNT(*) as count"), DB::raw("DAYNAME(created_at) as day_name"), DB::raw("DAY(created_at) as day"))
        ->where('created_at', '>', Carbon::today()->subDay(6))
        ->groupBy('day_name','day')
        ->orderBy('day')
        ->get();
        
        $getYearData =User::where('role_id', User::ROLE_USER)->select(DB::raw("COUNT(*) as count"), DB::raw("MONTHNAME(created_at) as month_name"))
        ->whereYear('created_at', date('Y'))
        ->groupBy('month_name')
        ->orderBy('count')
        ->get();
        if(!$getYearData->isEmpty()){
        foreach ($getYearData as $key=>$val){
            $year[$key] = $val->month_name;
            $users[$key] = $val->count;
        }
        }else{
            $year="";
            $users="";
        }

        $user = User::select(DB::raw("COUNT(*) as count"))->whereYear('created_at', date('Y'))
            ->groupBy(DB::raw("Month(created_at)"))
            ->pluck('count');     
        return view('admin.index', [
            'count' => $count,
            'activeUser' => $activeUser,
            'inactiveUser' => $inactiveUser,
            'countlogin' => $countlogin,
            'countpost' => $countpost,
            'facebooksocial' => $facebooksocial,
            'googleSocial' => $googleSocial,
            'countActivePost' => $countActivePost,
            'user' => $user, 
            'data' => $data,
            'record' => $record,
            'location' => $location,
            'travelRecord' => $travelRecord,
        ])->with('year',json_encode($year,JSON_NUMERIC_CHECK))->with('users',json_encode($users,JSON_NUMERIC_CHECK))->with('yearlocation',json_encode($yearlocation,JSON_NUMERIC_CHECK))->with('userlocation',json_encode($userlocation,JSON_NUMERIC_CHECK));        
    }

    public function all(Request $request)
    {
        $users = User::where('role_id', User::ROLE_USER)->latest();
        $id = $request->query('id');
        $first_name = $request->query('first_name');
        $last_name = $request->query('last_name');
        $email = $request->query('email');       
        $types = $request->query('type_id');
        $created = $request->query('created_at');
        if (! empty($id)) {
            $users = $users->where('id', $id);
        }
        if (! empty($first_name)) {
            $users = $users->where('first_name', 'like', '%' . $first_name . '%');
        }
        if (! empty($last_name)) {
            $users = $users->where('last_name', 'like', '%' . $last_name . '%');
        }
        if (! empty($email)) {
            $users = $users->where('email', 'like', '%' . $email . '%');
        } 
        if (! empty($created)) {
            $users = $users->where('created_at', 'like', '%' . $created . '%');
        } 
        if (! empty($types)) {
            $users = $users->where('type_id', $types);
        }
        $users = $users->paginate(10);
        return view('admin.users.index', [
            'users' => $users,
            'id' => $id,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,   
            'create' => $created,
            'typeid' => $types
        ]);
    }

    public function view($id)
    {
        $user = User::findOrfail($id);
        if (! empty($user)) {
            return view('admin.users.view', [
                'user' => $user
            ]);
        } else {
            abort(404, 'User does not exist');
        }
    }

    public function save(Request $request)
    {
        $rules = array(
            'first_name' => 'required|min:2',
            'last_name' => 'required|min:1',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password',
            'profile_file' => 'image|mimes:jpeg,png,jpg|max:10000'
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
            $user->role_id = User::ROLE_USER;
            $user->state_id = User::STATE_ACTIVE;
            $user->Type_id = User::TYPE_UNBLOCK;
            $user->generateAuthKey();           
            if ($request->hasFile('profile_file')) {
                $icon = date('Ymd') . '_' . time() . '.' . $request->file('profile_file')->getClientOriginalExtension();
                $request->profile_file->move(public_path('uploads'), $icon);
                $user->profile_file = $icon;
            }
            if ($user->save()) {               
                return redirect('admin/user/' . $user->id)->with('success', 'User added succesfully');
            } else {
                return Redirect::back()->withInput()->with('error', 'Some error occured. Please try again later');
            }
        }
    }

    public function edit($id)
    {
        $user = User::findOrfail($id);        
        return view('admin.users.edit',compact('user'));       
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrfail($id);
        if (! empty($user)) {
            $rules = array(
                'first_name' => 'required|min:2',
                'last_name' => 'required|min:1'
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return Redirect::back()->withInput()->withErrors($validator);
            } else {
                $user->first_name = $request->input('first_name');
                $user->last_name = $request->input('last_name');              
                if ($user->save()) {
                    if ($user->id == Auth::id()) {
                        return redirect('admin/profile')->with('success', 'User updated succesfully');
                    }
                    return redirect('admin/user/' . $user->id)->with('success', 'User updated succesfully');
                } else {
                    return Redirect::back()->withInput()->with('error', 'Some error occured. Please try again later');
                }
            }
        } else {
            abort(404);
        }
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        $model= new Feed;
        User::allRelatedDelete($id, $model);
        $user = User::where('role_id', User::ROLE_USER)->findOrFail($id);
        if ($user->delete()) {
            return redirect('admin/users')->with('success', 'User deleted succesfully');
        } else {
            return Redirect::back()->with('error', 'You can not delete your own account');
        }
    }

    public function changePassword($id)
    {
        User::findOrfail($id);             
        return view('admin.users.change-password');       
    }

    public function updatePassword(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $rules = array(
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password'
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        } else {
            $user->password = bcrypt($request->password);
            if ($user->save()) {
                if (($user->id == Auth::id()) && ($id == Auth::id())) {
                    Auth::login($user);
                    return redirect('admin')->with('success', 'Password updated succesfully');
                }
                if ($user->role_id == User::ROLE_USER) {                   
                    return redirect('admin/users')->with('success', 'Password updated succesfully');
                } 
            } else {
                return Redirect::back()->withInput()->with('error', 'Some error occured. Please try again later');
            }
        }
    }

    public function myProfile()
    {
        $user = Auth::User();
        if (User::isUser()) {
            return view('frontend.pages.profile', [
                'user' => $user
            ]);
        }
        return view('admin.users.view', [
            'user' => $user
        ]);
    }

    /**
     * Updates the profile image of the user
     *
     * @param Request $request
     * @param integer $id
     */
    public function updateFile(Request $request, $id)
    {
        request()->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg|max:5120'
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

    public function confirmEmail($id)
    {
        $user = User::where('activation_key', $id)->where('email_verified', User::EMAIL_NOT_VERIFIED)->first();

        if (! empty($user)) {
            $user->email_verified = User::EMAIL_VERIFIED;
            $user->state_id = User::STATE_ACTIVE;
            if ($user->save()) {
                return redirect('/')->with('success', 'Congratulations! your account is verified');
            } else {
                return redirect('admin')->with('error', 'Some error occured. Please try again later');
            }
        } else {
            return view('custom_errors.404');
        }
    }
    
    public function userBlockUnblock($id){
        $data = User::findOrFail($id);
        if($data->type_id == User::TYPE_UNBLOCK) {
            $data->type_id = User::TYPE_BLOCK;
        }else{
            $data->type_id = User::TYPE_UNBLOCK;
        }
        if ($data->save()) {
            return redirect()->back()->with('success', 'Action Updated successfully');
        } else {
            return redirect()->back()->with('error', 'Some error occured. Please try again later');
        }
    }
    
    public function exportUserData()
    {
        return Excel::download(new UsersExport(), 'User_Record.xlsx');
    }
  
}