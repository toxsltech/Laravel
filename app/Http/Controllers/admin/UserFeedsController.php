<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\Models\Feed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserFeedsController extends Controller
{

    public function allFeed(Request $request)
    {       
        $feedData=Feed::latest();
        $id = $request->query('id');
        $title = $request->query('content');
        $userAgent = $request->query('user_agent');
        $userIp = $request->query('user_ip');
        $userName = $request->query('name');
        $created = $request->query('created_at');
        if (! empty($id)) {
            $feedData = $feedData->where('id', $id);
        }
        if (! empty($title)) {
            $feedData = $feedData->where('content', 'like', '%' . $title . '%');
        }
        if (! empty($userAgent)) {
            $feedData = $feedData->where('user_agent', 'like', '%' . $userAgent . '%');
        }
        if (! empty($userIp)) {
            $feedData = $feedData->where('user_ip', 'like', '%' . $userIp . '%');
        }
        if (! empty($userName)) {
            $feedData = Feed::whereHas('getUser', function ($query) use ($userName) {
                $query->where('first_name','like', '%' . $userName . '%');
            })->orWhereHas('getUser', function ($query) use ($userName) {
                $query->where('last_name','like', '%' . $userName . '%');
            })->orWhereHas('getUser', function ($query) use ($userName){
                $query->where(DB::raw("CONCAT(`first_name`, ' ', `last_name`)"), 'LIKE', '%' . $userName . '%');
            });
        }
        if (! empty($created)) {
            $feedData = $feedData->where('created_at', 'like', '%' . $created . '%');
        }
        $feedData = $feedData->paginate(25);
        return view('admin.user-feeds.index', [
            'feedData' => $feedData,
            'id'        => $id,
            'title'     => $title,
            'userAgent' => $userAgent,
            'userIp'    => $userIp,
            'userName'  => $userName,
            'created'   => $created
            ]);        
    }

    public function viewFeed($id)
    {
        $feedData = Feed::findOrfail($id);     
        return view('admin.user-feeds.view', compact('feedData'));        
    }
    public function deleteFeed(Request $request)
    {
        $id = $request->id;
        $record = Feed::findOrFail($id);
        if ($record->delete()) {
            return redirect('admin/user-feeds')->with('success', 'User Feeds deleted succesfully');
        }else {
            return Redirect::back()->with('error', 'Some error occured. Please try again later');
        }
    }
}
