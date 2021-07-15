<?php
namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Follower;
use App\Models\Post;
use App\Models\Feed;
use App\Models\PostLocation;
use App\Models\PostImage;
use App\Models\SaveCounters;
use App\Models\Notification;
use Carbon\Carbon;
use Session;

class PostController extends Controller
{    
    /*
     * |--------------------------------------------------------------------------
     * | Post Controller
     * |--------------------------------------------------------------------------
     * |
     * | This controller handles authenticating Post for the application and
     * | redirecting them to your home screen. The controller uses a trait
     * | to conveniently provide its functionality to your applications.
     * |
     */
    public function tourSave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "card_title"  => 'required|max:50',
            "lati"  => 'required',
            "card_image"  => 'required',
        ],
            [
                'lati.required' => 'Add location is required',
            ]);
        if ($validator->fails()) {
                return response()->json(array('status'=>"Please create post properly"));
        } else {
            DB::beginTransaction();
            try {
                $post = new Post();
                $post->title = $request->input('card_title');
                $post->created_by_id = Auth::id();
                $post->state_id = Post::STATE_ACTIVE;
                $image = $request->input('card_image'); // your base64 encoded
                $imageName = date('Ymd').'_'.time().'.'.explode('/', mime_content_type($image))[1];
                $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $image));
                \File::put(public_path('uploads/card_image'). '/' .$imageName, $data);
                $post->card_image = $imageName;
                $post->save();
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json(array('status'=>$e->getMessage()));
            }
            try {
                $data = $request->all();
                $description = $data['description'];
                $latitude = $data['latitude'];
                $longitude = $data['longitude'];
                $address = $data['address'];
                $country = $data['country'];
                if(isset($data['getlocImgId'])){    
                $ImgId = $data['getlocImgId'];
                }
                
                // insert using foreach loop
                foreach ($description as $key => $input) {
                    $location = new PostLocation();
                    $location->description = isset($description[$key]) ? $description[$key] : '';
                    $location->latitude = isset($latitude[$key]) ? $latitude[$key] : '';
                    $location->longitude = isset($longitude[$key]) ? $longitude[$key] : '';
                    $location->location = isset($address[$key]) ? $address[$key] : '';
                    $location->country = isset($country[$key]) ? $country[$key] : '';
                    $location->post_id = $post->id;
                    $location->created_by_id = Auth::id();
                    $location->save();
                    if(!empty($request->input('uploadLoctionImg'))){
                    $c = rand(1, 100);
                    foreach ($request->input('uploadLoctionImg') as $f) {
                        if(isset($ImgId[$key])){  
                        if($f['imgId']==$ImgId[$key]){
                            $file = new PostImage();
                            $image = $f['img']; // your base64 encoded
                            $imageName = date('Ymd').'_'.time(). $c ++ .'.'.explode('/', mime_content_type($image))[1];
                            $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $image));
                            \File::put(public_path('uploads/card_image'). '/' .$imageName, $data);
                            $post->card_image = $imageName;
                            $file->location_image = $imageName;
                            $file->post_location_id = $location->id;
                            $file->created_by_id = Auth::id();
                            $file->save(); 
                        }
                        }
                    }
                }
                }
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json(array('status'=>$e->getMessage()));
            }
            try {
                $getUserfollowing = Follower::where('following_id',Auth::id())->get();
                foreach ($getUserfollowing as $key => $value) {
                    $sendNotification = new Notification();
                    $sendNotification->user_id = Auth::id();
                    $sendNotification->to_user_id = $value->follower_id;
                    $sendNotification->model_id = $post->id;
                    $sendNotification->model_type = Post::MODEL_NAME;
                    $sendNotification->title = $post->title;
                    $sendNotification->description = $location->description;
                    $sendNotification->save();
                }
            } catch (\Exception $e) {
                return response()->json(array('status'=>$e->getMessage()));
            }
            DB::commit();
            Session::flash('message','Tour added successfully.');
            Feed::add($request,  Feed::CONTENT_DATA, url()->current(), $post->id, Feed::STATE_ACTIVE, Feed::TYPE_WEB);
            return response()->json(array('status'=>'Added'));
        }
    }
    
    
    public function tourEdit($id)
    {
        $postCard = Post::findOrfail(decrypt($id));
        $PostLocationData = PostLocation::where('post_id',$postCard->id)->with('getLocationImage')->get();
        $imageData = PostImage::whereIn('post_location_id', $postCard->getLocationData->pluck('id'))->get();
        $imgData =[];
        $locationId =[];
        if(!$PostLocationData->isEmpty()){
            foreach($PostLocationData as $value){
                $getlngData[] = $value->longitude;
                $getlatData[] = $value->latitude;
                $locationData[]  = $value->location;
                $descriptionData[]  = $value->description;
                $postLocationId[]  = $value->id;
                $countryData[]  = $value->country;
                foreach ($value->getLocationImage as $key => $value) {
                    $imgData[] = $value->location_image;
                    $locationId[] = $value->post_location_id;
                }
            }
        }else{
            $getlngData =[];
            $getlatData =[];
            $locationData = [];
            $descriptionData = [];
            $postLocationId =[];
            $countryData =[];
        }
        if ($postCard) {
            return view('frontend/users/tour_edit', compact('postCard','PostLocationData','imageData', 'getlngData', 'getlatData', 'locationData', 'descriptionData', 'imgData', 'locationId', 'postLocationId', 'countryData'));
        } else {
            return Redirect::back()->withInput()->with('error', 'Some error occured');
        }
    }
    
    public function tourUpdate(Request $request, $id)
    {
        DB::beginTransaction();
        $deleteLocation = PostLocation::where('post_id', decrypt($id))->delete();
            $validator = Validator::make($request->all(), [
            "card_title"  => 'required|max:50',
            "lati"  => 'required',
            "card_image"  => 'required',
        ],
            [
                'lati.required' => 'Add location is required',
            ]);
        if ($validator->fails()) {
                return response()->json(array('status'=>"Please create post properly"));
        } else {
            try {
                $image = $request->input('card_image'); // your base64 encoded
                $imageName = date('Ymd').'_'.time().'.'.explode('/', mime_content_type($image))[1];
                $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $image));
                \File::put(public_path('uploads/card_image'). '/' .$imageName, $data);
                Post::where('id', decrypt($id))->update([
                'title' => $request->input('card_title'),
                'created_by_id' => Auth::id(),
                'state_id' => Post::STATE_ACTIVE,
                'card_image' => $imageName
                ]);
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json(array('status'=>$e->getMessage()));
            }
            try {
                $data = $request->all();
                $description = $data['description'];
                $latitude = $data['latitude'];
                $longitude = $data['longitude'];
                $address = $data['address'];
                $country = $data['country'];
                if(isset($data['getlocImgId'])){    
                $ImgId = $data['getlocImgId'];
                }
                
                // insert using foreach loop
                foreach ($description as $key => $input) {
                    $location = new PostLocation();
                    $location->description = isset($description[$key]) ? $description[$key] : '';
                    $location->latitude = isset($latitude[$key]) ? $latitude[$key] : '';
                    $location->longitude = isset($longitude[$key]) ? $longitude[$key] : '';
                    $location->location = isset($address[$key]) ? $address[$key] : '';
                    $location->country = isset($country[$key]) ? $country[$key] : '';
                    $location->post_id = decrypt($id);
                    $location->created_by_id = Auth::id();
                    $location->save();
                    if(!empty($request->input('uploadLoctionImg'))){
                    $c = rand(1, 100);
                    foreach ($request->input('uploadLoctionImg') as $f) {
                        if(isset($ImgId[$key])){  
                        if($f['imgId']==$ImgId[$key]){
                            $file = new PostImage();
                            $image = $f['img']; // your base64 encoded
                            $imageName = date('Ymd').'_'.time(). $c ++ .'.'.explode('/', mime_content_type($image))[1];
                            $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $image));
                            \File::put(public_path('uploads/card_image'). '/' .$imageName, $data);
                            $file->location_image = $imageName;
                            $file->post_location_id = $location->id;
                            $file->created_by_id = Auth::id();
                            $file->save(); 
                        }
                        }
                    }
                }
                }
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json(array('status'=>$e->getMessage()));
            }
            DB::commit();
            Feed::add($request,  Feed::CONTENT_DATA, url()->current(), decrypt($id), Feed::STATE_ACTIVE, Feed::TYPE_WEB);
            return response()->json(array('status'=>'Added'));
        }
        return response()->json(array('status'=>'failed'));
    }
    
    public function tourDelete($id)
    {
        $tour = Post::findOrFail(decrypt($id));
        $tour->state_id = Post::STATE_INACTIVE;
        if ($tour->save()) {
            return Redirect::back()->withInput()->with('success', 'Tour exprience deleted succesfully');
        } else {
            return Redirect::back()->withInput()->with('error', 'Some error occured');
        }
    }
    
    public function deleteImage($id){
        $image = PostImage::findOrFail($id);
        if ($image->delete()) {
            return Redirect::back()->withInput()->with('success', 'Tour Image deleted succesfully');
        } else {
            return Redirect::back()->withInput()->with('error', 'Some error occured');
        }
        
    }
    
    public function bookMarkCard(Request $request){
        $decryptId = decrypt($request->id);
        $postId = Post::where('id', $decryptId)->first();
        $saveCounterData = SaveCounters::where('post_id', $decryptId)->where('user_id',Auth::id())->first();
        if($saveCounterData != null){
            $bookMarkDelete = SaveCounters::findOrFail($saveCounterData->id);
            if ($bookMarkDelete->delete()) {
                return response()->json(array('status'=>'removed','id'=>$decryptId));
            } else {
                return Redirect::back()->withInput()->with('error', 'Some error occured');
            }
        }else{
            $bookMarkSave = new SaveCounters();
            $bookMarkSave->user_id = Auth::id();
            $bookMarkSave->post_id = $decryptId;
            if($bookMarkSave->save()) {
                try {
                    $notificationData = Notification::where('user_id',Auth::id())->where('to_user_id',$postId->created_by_id)->where('model_id',$decryptId)->where('model_type',SaveCounters::MODEL_NAME)->where('title',SaveCounters::TITLE)->latest('created_at')->first();
                    if($notificationData){
                        if($notificationData->created_at < now()->subDay()){
                            $sendNotification = new Notification();
                            $sendNotification->user_id = Auth::id();
                            $sendNotification->to_user_id = $postId->created_by_id;
                            $sendNotification->model_id = $decryptId;
                            $sendNotification->model_type = SaveCounters::MODEL_NAME;
                            $sendNotification->title = SaveCounters::TITLE;
                            $sendNotification->description = SaveCounters::DESC;
                            $sendNotification->save();
                            return response()->json(array('status'=>'Added','id'=>$decryptId));
                        }else{
                            return response()->json(array('status'=>'Added','id'=>$decryptId));
                        }
                    }
                    $sendNotification = new Notification();
                    $sendNotification->user_id = Auth::id();
                    $sendNotification->to_user_id = $postId->created_by_id;
                    $sendNotification->model_id = $decryptId;
                    $sendNotification->model_type = SaveCounters::MODEL_NAME;
                    $sendNotification->title = SaveCounters::TITLE;
                    $sendNotification->description = SaveCounters::DESC;
                    $sendNotification->save();
                } catch (\Exception $e) {
                    return Redirect::back()->withInput()->with('error', $e->getMessage());
                }
                return response()->json(array('status'=>'Added','id'=>$decryptId));
            } else {
                return Redirect::back()->withInput()->with('error', 'Some error occured');
            }
        }
    }
    
    public function bookMarkCardRemove(Request $request){
        $user = Auth::user();
        $decryptId=decrypt($request->id);
        $saveCounterData = SaveCounters::where('post_id', $decryptId)->where('user_id',Auth::id())->first();
        if ($saveCounterData->delete()) {
            $getLocationId = SaveCounters::where('user_id', Auth::id())->with('getSaveCounterLocation', 'getSaveCounterCardImg')->paginate(12);
            if(!$getLocationId->isEmpty()):
            foreach($getLocationId as $locations):
            foreach ($locations->getSaveCounterLocation as $value){
                $lngLat[$value->longitude] = ['id'=>encrypt($value->post_id),'latitude'=>$value->latitude];
            }
            endforeach;
            else:
            $lngLat[$user->longitude] = ['remove'=>'allremoved'];
            endif;
            return response()->json(array('status'=>'removed','id'=>$decryptId,'lngLat'=>$lngLat));
        } else {
            return Redirect::back()->withInput()->with('error', 'Some error occured');
        }
    }
    
    
    public function previewBookMark($id){
        $decryptId=decrypt($id);
        $postId = Post::where('id', $decryptId)->first();
        $saveCounterData = SaveCounters::where('post_id', $decryptId)->where('user_id',Auth::id())->first();
        if($saveCounterData != null){
            $bookMarkDelete = SaveCounters::findOrFail($saveCounterData->id);
            if ($bookMarkDelete->delete()) {
                return Redirect::back()->withInput()->with('sucess', 'Bookmark remove succesfully');
            } else {
                return Redirect::back()->withInput()->with('error', 'Some error occured');
            }
        }else{
            $bookMarkSave = new SaveCounters();
            $bookMarkSave->user_id = Auth::id();
            $bookMarkSave->post_id = $decryptId;
            if($bookMarkSave->save()) {
                try {
                    $notificationData = Notification::where('user_id',Auth::id())->where('to_user_id',$postId->created_by_id)->where('model_id',$decryptId)->where('model_type',SaveCounters::MODEL_NAME)->where('title',SaveCounters::TITLE)->latest('created_at')->first();
                    if($notificationData){
                        if($notificationData->created_at < now()->subDay()){
                            $sendNotification = new Notification();
                            $sendNotification->user_id = Auth::id();
                            $sendNotification->to_user_id = $postId->created_by_id;
                            $sendNotification->model_id = $decryptId;
                            $sendNotification->model_type = SaveCounters::MODEL_NAME;
                            $sendNotification->title = SaveCounters::TITLE;
                            $sendNotification->description = SaveCounters::DESC;
                            $sendNotification->save();
                            return Redirect::back()->withInput()->with('sucess', 'Bookmark added succesfully');
                        }else{
                            return Redirect::back()->withInput()->with('sucess', 'Bookmark added succesfully');
                        }
                    }
                    $sendNotification = new Notification();
                    $sendNotification->user_id = Auth::id();
                    $sendNotification->to_user_id = $postId->created_by_id;
                    $sendNotification->model_id = $decryptId;
                    $sendNotification->model_type = SaveCounters::MODEL_NAME;
                    $sendNotification->title = SaveCounters::TITLE;
                    $sendNotification->description = SaveCounters::DESC;
                    $sendNotification->save();
                } catch (\Exception $e) {
                    return Redirect::back()->withInput()->with('error', $e->getMessage());
                }
                return Redirect::back()->withInput()->with('sucess', 'Bookmark added succesfully');
            } else {
                return Redirect::back()->withInput()->with('error', 'Some error occured');
            }
        }
    }
    
    public function userFollow($id){
        $decryptId=decrypt($id);
        $follow = new Follower();
        $follow->follower_id = Auth::id();
        $follow->following_id = $decryptId;
        if($follow->save()) {
            try {
                $notificationData = Notification::where('user_id',Auth::id())->where('to_user_id',$decryptId)->where('model_type',Follower::MODEL_NAME)->where('title',Follower::TITLE)->latest('created_at')->first();
                if($notificationData){
                    if($notificationData->created_at < now()->subDay()){
                        $sendNotification = new Notification();
                        $sendNotification->user_id = Auth::id();
                        $sendNotification->to_user_id = $decryptId;
                        $sendNotification->model_id = Auth::id();
                        $sendNotification->model_type = Follower::MODEL_NAME;
                        $sendNotification->title = Follower::TITLE;
                        $sendNotification->description = Follower::DESC;
                        $sendNotification->save();
                        return Redirect::back()->withInput()->with('success', 'Follow succesfully');
                    }else{
                        return Redirect::back()->withInput()->with('success', 'Follow succesfully');
                    }
                }
                $sendNotification = new Notification();
                $sendNotification->user_id = Auth::id();
                $sendNotification->to_user_id = $decryptId;
                $sendNotification->model_id = Auth::id();
                $sendNotification->model_type = Follower::MODEL_NAME;
                $sendNotification->title = Follower::TITLE;
                $sendNotification->description = Follower::DESC;
                $sendNotification->save();
            } catch (\Exception $e) {
                return Redirect::back()->withInput()->with('error', $e->getMessage());
            }
            return Redirect::back()->withInput()->with('success', 'Follow succesfully');
        } else {
            return Redirect::back()->withInput()->with('error', 'Some error occured');
        }
    }
    
    public function userUnfollow($id){
        $decryptId=decrypt($id);
        $followData = Follower::where('follower_id',Auth::id())->where('following_id', $decryptId)->first();
        if ($followData->delete()) {
            return Redirect::back()->withInput()->with('success', 'Un-Follow succesfully');
        } else {
            return Redirect::back()->withInput()->with('error', 'Some error occured');
        }
    }
    
    public function followAjax(Request $request){
        $decryptId=decrypt($request->id);
        $followData = Follower::where('follower_id',Auth::id())->where('following_id', $decryptId)->first();
        if($followData){
            if ($followData->delete()) {
                return response()->json(array('status'=>'removed','id'=>$decryptId));
            } else {
                return Redirect::back()->withInput()->with('error', 'Some error occured');
            }
        }else{
            $follow = new Follower();
            $follow->follower_id = Auth::id();
            $follow->following_id = $decryptId;
            if($follow->save()) {
                try {
                    $notificationData = Notification::where('user_id',Auth::id())->where('to_user_id',$decryptId)->where('model_type',Follower::MODEL_NAME)->where('title',Follower::TITLE)->latest('created_at')->first();
                    if($notificationData){
                        if($notificationData->created_at < now()->subDay()){
                            $sendNotification = new Notification();
                            $sendNotification->user_id = Auth::id();
                            $sendNotification->to_user_id = $decryptId;
                            $sendNotification->model_id = Auth::id();
                            $sendNotification->model_type = Follower::MODEL_NAME;
                            $sendNotification->title = Follower::TITLE;
                            $sendNotification->description = Follower::DESC;
                            $sendNotification->save();
                            return response()->json(array('status'=>'Added','id'=>$decryptId));
                        }else{
                            return response()->json(array('status'=>'Added','id'=>$decryptId));
                        }
                    }
                    $sendNotification = new Notification();
                    $sendNotification->user_id = Auth::id();
                    $sendNotification->to_user_id = $decryptId;
                    $sendNotification->model_id = Auth::id();
                    $sendNotification->model_type = Follower::MODEL_NAME;
                    $sendNotification->title = Follower::TITLE;
                    $sendNotification->description = Follower::DESC;
                    $sendNotification->save();
                } catch (\Exception $e) {
                    return Redirect::back()->withInput()->with('error', $e->getMessage());
                }
                return response()->json(array('status'=>'Added','id'=>$decryptId));
            } else {
                return Redirect::back()->withInput()->with('error', 'Some error occured');
            }
        }
    }
    
    public function userFollowList($id){
        $follower=Follower::where('following_id', decrypt($id))->with('getFollowerUser')->get();
        $getFollower = Follower::where('follower_id', decrypt($id))->with('getFollowerUser')->get();
        return view('frontend.users.followers-list', compact('follower','getFollower'));
    }
    
    public function allSearch(Request $request){
        $keyword = $request->text;
        if($keyword == null){
            return Redirect::back();
        }
        if($request->ajax())
        {
            // Search from Users table
            $userData = USer::where('id', '!=', User::ROLE_ADMIN)
            ->where(function($query)use($keyword){
                $query->orWhere (DB::raw("CONCAT(`first_name`, ' ', `last_name`)"), 'LIKE', '%' . $keyword . '%')
                ->orWhere ( 'first_name', 'LIKE', '%' . $keyword . '%' )
                ->orWhere ( 'last_name', 'LIKE', '%' . $keyword . '%' )
                ->orWhere ( 'email', 'LIKE', '%' . $keyword . '%' );
            })->withCount('getfollower');
            // Combine search results
            $user = $userData->orderBy('getfollower_count', 'DESC')->paginate(12);
            $html = view('frontend.users.search_user',compact('user', 'keyword'))->render();
            return response()->json([
                'html' => $html,
            ]);
        }
        // Search from Users table
        $userData = USer::where('id', '!=', User::ROLE_ADMIN)
        ->where(function($query)use($keyword){
            $query->orWhere (DB::raw("CONCAT(`first_name`, ' ', `last_name`)"), 'LIKE', '%' . $keyword . '%')
            ->orWhere ( 'first_name', 'LIKE', '%' . $keyword . '%' )
            ->orWhere ( 'last_name', 'LIKE', '%' . $keyword . '%' )
            ->orWhere ( 'email', 'LIKE', '%' . $keyword . '%' );
        })->withCount('getfollower');
        // Search from post_locations with posts table
        $experience = Post::with('getLocationData')->whereHas('getLocationData', function ($query) use ($keyword) {
            $query->where('description','LIKE', '%' . $keyword . '%');
        })->orWhere( 'title', 'LIKE', '%' . $keyword . '%' )->latest()->get();
        $location = Post::whereHas('getLocationData', function ($query) use ($keyword) {
            $query->where( 'country', 'LIKE', '%' . $keyword . '%' );
            $query->orWhere( 'location', 'LIKE', '%' . $keyword . '%' );
        })->latest()->get();
        $lngLat=[];
        if(!$location->isEmpty()):
        foreach ($location as $key => $value):
        foreach($value->getLocationData as $data){
            $lngLat[$data->longitude] = ['id'=>encrypt($data->post_id),'latitude'=>$data->latitude];
        }
        endforeach;
        else:
        $lngLat[env('LNG')] = env('LAT');
        endif;
        // Combine search results
        $user = $userData->orderBy('getfollower_count', 'DESC')->paginate(12);
        return view ('frontend.users.search-result',compact('user', 'keyword'));
        
    }
    
    public function experienceSearch(Request $request){
        $keyword = $request->text;
        if($keyword == null){
            return Redirect::back();
        }
        // Search from post_locations with posts table
        $experience = Post::with('getLocationData')->whereHas('getLocationData', function ($query) use ($keyword) {
            $query->where('description','LIKE', '%' . $keyword . '%');
        })->orWhere( 'title', 'LIKE', '%' . $keyword . '%' )->latest()->get();
        $experience = $experience->paginate(12);
        $html = view('frontend.users.search_experience',compact('experience'))->render();
        return response()->json([
            'html' => $html,
        ]);
    }
    
    public function locationSearch(Request $request){
        $keyword = $request->text;
        if($keyword == null){
            return Redirect::back();
        }
        // Search location
        $location = Post::whereHas('getLocationData', function ($query) use ($keyword) {
            $query->where( 'country', 'LIKE', '%' . $keyword . '%' );
            $query->orWhere( 'location', 'LIKE', '%' . $keyword . '%' );
        })->latest()->paginate(12);
        $lngLat=[];
        if(!$location->isEmpty()):
        foreach ($location as $key => $value):
        foreach($value->getLocationData as $data){
            $lngLat[$data->longitude] = ['id'=>encrypt($data->post_id),'latitude'=>$data->latitude];
        }
        endforeach;
        else:
        $lngLat[env('LNG')] = env('LAT');
        endif;
        $html = view('frontend.users.search_location',compact('location','lngLat'))->render();
        return response()->json([
            'html' => $html,
        ]);
    }    
}