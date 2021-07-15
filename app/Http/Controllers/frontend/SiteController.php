<?php
namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Post;
use App\Models\PostLocation;
use App\Models\Follower;
use App\Models\PostImage;
use App\Models\SaveCounters;
use App\Models\EmailQueue;
use PhpParser\Node\Expr\Isset_;
use App\Models\Notification;
use Carbon\Carbon;



class SiteController extends Controller
{

    /*
     * |--------------------------------------------------------------------------
     * | Site Controller
     * |--------------------------------------------------------------------------
     * |
     * | This controller handles authenticating Site for the application and
     * | redirecting them to your home screen. The controller uses a trait
     * | to conveniently provide its functionality to your applications.
     * |
     */
 
    public function create()
    {
        $user = Auth::user();
        return view('frontend.users.create', compact('user'));
    }
    
    public function userSetting()
    {
        $user = Auth::user();
        return view('frontend.users.user_setting', compact('user'));
    }
    
    public function userProfile()
    {
        $user = Auth::user();
        $data = Post::where('created_by_id', Auth::id())->where('state_id', Post::STATE_ACTIVE)->with('getLocationData')->orderBy('created_at', 'desc');        
        $postData = $data->get();
        $posts=$data->paginate(12);
        $followerCount =  Follower::where('following_id', Auth::id())->count();
        $saveCountersCount =  SaveCounters::where('user_id','!=', Auth::id())->whereIn('post_id' , $postData->pluck('id'))->count();
        if(!$posts->isEmpty()):
        foreach ($posts as $key => $location):
        foreach($location->getLocationData as $value){
            $lngLat[$value->longitude] = ['id'=>encrypt($value->post_id),'latitude'=>$value->latitude];
            $countries[] = $value->country;
        }
        endforeach;
        else:
        $lngLat='';
        endif;
        
        foreach ($postData as $key => $country):
        foreach($country->getLocationData as $value){
            $countries[] = $value->country;
        }
        endforeach;
        if(isset($countries)){
            $countryCount = count(array_unique($countries));
        }else{
            $countryCount = PostLocation::COUNTRY_COUNT;
        }        
        return view('frontend.users.profile', compact('user', 'posts', 'postData', 'lngLat', 'followerCount', 'saveCountersCount', 'countryCount' ));
    }
    
    public function profileEdit()
    { 
        $user = Auth::user();
        $data = Post::where('created_by_id', Auth::id())->where('state_id', Post::STATE_ACTIVE)->orderBy('created_at','desc'); 
        $postData = $data->get();
        $posts = $data->paginate(12);
        $followerCount =  Follower::where('following_id', Auth::id())->count();
        $saveCountersCount =  SaveCounters::where('user_id','!=', Auth::id())->whereIn('post_id' , $postData->pluck('id'))->count();
        if(!$posts->isEmpty()):
        foreach ($posts as $key => $location):
        foreach($location->getLocationData as $value){
            $lngLat[$value->longitude] = ['id'=>encrypt($value->post_id),'latitude'=>$value->latitude];
            $countries[] = $value->country;
        } 
        endforeach;
        else:
        $lngLat='';
        endif;
       
        foreach ($postData as $key => $country):
        foreach($country->getLocationData as $value){            
            $countries[] = $value->country;
        }
        endforeach;
        if(isset($countries)){
            $countryCount = count(array_unique($countries));
        }else{
            $countryCount = PostLocation::COUNTRY_COUNT;
        }        
        return view('frontend.users.profile-edit', compact('user', 'posts', 'postData', 'lngLat', 'followerCount', 'saveCountersCount','countryCount'));
    }
    
    
    public function travelBoard()
    {
        $getLocationId = SaveCounters::where('user_id', Auth::id())->with('getSaveCounterLocation', 'getSaveCounterCardImg')->orderBy('created_at', 'desc')->paginate(12);
        if(!$getLocationId->isEmpty()):
        foreach($getLocationId as $locations):
        foreach ($locations->getSaveCounterLocation as $value){
            $lngLat[$value->longitude] = ['id'=>encrypt($value->post_id),'latitude'=>$value->latitude];
        }
        endforeach;
        else:
        $lngLat[env('LNG')] = env('LAT');
        endif;
        return view('frontend.pages.travel_board', compact('getLocationId', 'lngLat'));
    }
    
    public function contact()
    {
        return view('frontend.pages.contact-us');
    }
        
    public function contactUs(Request $request)
    {
        $rules = array(
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'integer|digits_between:5,15|nullable',
            'message' => 'required'
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        } else {
            $contact = $request->all();
            EmailQueue::add([
                'to' => $request->email,
                'from' => env('MAIL_FROM_ADDRESS'),
                'subject' => 'Contct-us',
                'view' => 'email.contact-us',
                'model' => [
                    'contact' => $contact
                ]
            ]);
            return redirect()->back()->with('success', 'Thanks for contacting us!');
        }
    }
    
    public function postPreview($id) { 
        $decryptId=decrypt($id);
        $location=PostLocation::where('post_id', $decryptId)->get();
        $card = Post::where('id', $decryptId)->first();
        $images= PostImage::whereIn('post_location_id', $location->pluck('id'))->get();
        if(!$location->isEmpty()):
        foreach ($location as $key => $value):
        $lngLat[$value->longitude] = ['description'=>$value->description,'latitude'=>$value->latitude];
        endforeach;
        else:
        $lngLat[env('LNG')] = ['description'=>"welcome to Aery",'latitude'=>env('LAT')];
        endif;
        return view('frontend.pages.travel_view', compact('location', 'card', 'images', 'lngLat'));
    }
    
    public function discoverPostPreview($id){ 
        try{
        $decryptId=decrypt($id);
        $locationData=PostLocation::where('post_id', $decryptId)->with('getLocationImage')->get();
        $location = Post::where('id', $decryptId)->first();   
        $getFollower = Follower::where('follower_id', Auth::id())->whereIn('following_id', $location)->get();
        $bookmark = SaveCounters::where('user_id', Auth::id())->where('post_id', $decryptId)->first();
        if(!$locationData->isEmpty()):
        foreach ($locationData as $key => $value):
        $lngLat[$value->longitude] = ['description'=>$value->description,'latitude'=>$value->latitude];;
        endforeach;
        else:
        $lngLat[env('LNG')] = ['description'=>"welcome to Aery",'latitude'=>env('LAT')];
        endif;
        }catch(\Exception $e){
            return Redirect::back()->with('error', $e->getMessage());
        }
        return view('frontend.pages.discover_travel_view', compact('location', 'lngLat', 'getFollower', 'locationData', 'bookmark'));
    }
    
    public function PostUserProfile($id){
        $decryptId=decrypt($id);
        if(Auth::id()==$decryptId){
            return redirect('/profile');            
        }
        $user=User::where('id',$decryptId)->first();  
        $saveData = SaveCounters::where('user_id','=', Auth::id())->get();
        $data = Post::where('created_by_id', $user->id)->where('state_id', Post::STATE_ACTIVE)->with('getLocationData')->orderBy('created_at','desc');       
        $postsCount = $data->get();
        $posts = $data->paginate(12);
        $followerCount =  Follower::where('following_id', $user->id)->count(); 
        $countSavecounter = SaveCounters::where('user_id','!=', $decryptId)->whereIn('post_id' , $postsCount->pluck('id'))->count();
        $getFollower = Follower::where('follower_id', Auth::id())->where('following_id', $decryptId)->get();
        if(!$posts->isEmpty()):
        foreach ($posts as $key => $location):
        foreach($location->getLocationData as $value){
            $lngLat[$value->longitude] = ['id'=>encrypt($value->post_id),'latitude'=>$value->latitude];
            $countries[] = $value->country;
        }  
        endforeach;
        else:
        $lngLat = "";
        endif;
        foreach ($postsCount as $key => $country):
        foreach($country->getLocationData as $value){
            $countries[] = $value->country;
        }
        endforeach;        
        if(isset($countries)){
            $countryCount = count(array_unique($countries));
        }else{
            $countryCount = PostLocation::COUNTRY_COUNT;
        }        
        return view('frontend.users.user-view_profile', compact('user', 'posts','lngLat', 'followerCount', 'getFollower', 'countryCount','saveData', 'postsCount', 'countSavecounter'));        
    }
    
    public function notification()
    {
        $currentDate = \Carbon\Carbon::now();
        $currentWeek = $currentDate->subDays($currentDate->dayOfWeek)->subWeek();
        Notification::where('to_user_id', Auth::id())->update(['is_read' =>Notification::READ]);
        $notificationData = Notification::where('to_user_id',Auth::id())->orderBy('id', 'DESC')->latest()->paginate(10);
        if($notificationData){
             return view('frontend.pages.notification',compact('notificationData', 'currentWeek'));
        } else {
             return Redirect::back()->withInput()->with('error', 'Some error occured');
        }   
    }   
    
}