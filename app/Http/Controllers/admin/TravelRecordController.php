<?php
namespace App\Http\Controllers\admin;

use App\Exports\TravelRecordExport;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\File; 

class TravelRecordController extends Controller
{

    public function all(Request $request)
    {
        $records = Post::latest();
        $id = $request->query('id');
        $title = $request->query('title');
        $users = $request->query('name');
        $created = $request->query('created_at');
        if (! empty($id)) {
            $records = $records->where('id', $id);
        }
        if (! empty($title)) {
            $records = $records->where('title', 'like', '%' . $title . '%');
        }
        if (! empty($users)) {
            $records = Post::whereHas('getUser', function ($query) use ($users) {
                $query->where('first_name', 'like', '%' . $users . '%');
            })->orWhereHas('getUser', function ($query) use ($users) {
                $query->where('last_name', 'like', '%' . $users . '%');
            })
                ->orWhereHas('getUser', function ($query) use ($users) {
                $query->where(DB::raw("CONCAT(`first_name`, ' ', `last_name`)"), 'LIKE', '%' . $users . '%');
            });
        }
        if (! empty($created)) {
            $records = $records->where('created_at', 'like', '%' . $created . '%');
        }
        $records = $records->paginate(25);
        return view('admin.travel-record.index', [
            'records' => $records,
            'id' => $id,
            'title' => $title,
            'userid' => $users,
            'created' => $created
        ]);
    }

    public function view($id)
    {
        $record = Post::with('getLocationData')->findOrfail(decrypt($id));
        $imageData = PostImage::whereIn('post_location_id', $record->getLocationData->pluck('id'))->get();
        return view('admin.travel-record.view', compact('record', 'imageData'));
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        $record = Post::findOrFail($id);
        $image_path = (public_path('uploads/card_image/'.$record->card_image));
        if (File::exists($image_path)) {
            unlink($image_path);
        }
        $imageDa = PostImage::whereIn('post_location_id', $record->getLocationData->pluck('id'))->get();
        foreach($imageDa as $imageData){
            $image_path = (public_path('uploads/card_image/'.$imageData->location_image));
            if (File::exists($image_path)) {
                unlink($image_path);
            }
        }
        if ($record->delete()) {
            return redirect('admin/travel-record')->with('success', 'Travel Record deleted succesfully');
        }
    }

    public function recordActiveInactive($id)
    {
        $data = Post::findOrFail($id);
        if ($data->state_id == Post::STATE_ACTIVE) {
            $data->state_id = Post::STATE_INACTIVE;
        } else {
            $data->state_id = Post::STATE_ACTIVE;
        }
        if ($data->save()) {
            return redirect()->back()->with('success', 'Action Updated successfully');
        } else {
            return redirect()->back()->with('error', 'Some error occured. Please try again later');
        }
    }

    public function export()
    {
        return Excel::download(new TravelRecordExport(), 'Travel_Record.xlsx');
    }
}
