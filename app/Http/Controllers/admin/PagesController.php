<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Models\Page;

class PagesController extends Controller
{

    /*
     * |--------------------------------------------------------------------------
     * | Pages Controller
     * |--------------------------------------------------------------------------
     * |
     * | This controller handles authenticating pages for the application and
     * | redirecting them to your home screen. The controller uses a trait
     * | to conveniently provide its functionality to your applications.
     * |
     */
    public function all(Request $request)
    {
        $pages = Page::latest();
        $id = $request->query('id');
        $title = $request->query('title');
        $description = $request->query('description');
        $states = $request->query('state_id');
        $types = $request->query('type_id');
        if (! empty($id)) {
            $pages = $pages->where('id', $id);
        }
        if (! empty($title)) {
            $pages = $pages->where('title', 'like', '%' . $title . '%');
        }
        if (! empty($description)) {
            $pages = $pages->where('description', 'like', '%' . $description . '%');
        }
        if (! empty($states)) {
            $pages = $pages->where('state_id', $states);
        }
        if (! empty($types)) {
            $pages = $pages->where('type_id', $types);
        }
        $pages = $pages->paginate(20);
        return view('admin.pages.index', [
            'pages' => $pages,
            'id' => $id,
            'title' => $title,
            'description' => $description,
            'stateid' => $states,
            'typeid' => $types
        ]);
    }

    public function view($id)
    {
        $pages = Page::findOrfail($id);
        return view('admin.pages.view', compact('pages'));        
    }

    /**
     * Save Pages Data
     *
     * @param Request $request
     */
    public function save(Request $request)
    {
        $rules = array(
            'title' => 'required',
            'description' => 'required',
            'type_id' => 'required|integer|unique:pages',
            'state_id' => 'required|integer'
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        } else {
            $pages = new Page();
            $pages->state_id = $request->state_id;
            $pages->type_id = $request->type_id;
            $pages->created_by_id = Auth::id();
            if (! empty($pages)) {
                $pages->title = $request->title;
                if (! empty($pages)) {
                    $pages->description = $request->description;
                    if ($pages->save()) {
                        return redirect('admin/page')->with('success', 'Pages added succesfully');
                    }
                }
            } else {
                return Redirect::back()->withInput()->with('error', 'Some error occured. Please try again later');
            }
        }
    }

    public function edit($id)
    {
        $pages = Page::findOrfail($id);
        return view('admin.pages.edit', compact('pages'));
       
    }

    public function editupdate(Request $request, $id)
    {
        $rules = array(
            'title' => 'required',
            'description' => 'required',
            'state_id' => 'required|integer',
            'type_id' => 'required|integer'
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        } else {
            $pages = Page::find($id);
            $pages->state_id = $request->state_id;
            $pages->type_id = $request->type_id;
            if (! empty($pages)) {
                $pages->title = $request->title;
                if (! empty($pages)) {
                    $pages->description = $request->description;
                    if ($pages->save()) {
                        return redirect('admin/page')->with('success', 'Page updated succesfully');
                    } else {
                        return Redirect::back()->withInput()->with('error', 'Some error occured. Please try again later');
                    }
                }
            } else {
                abort(404);
            }
        }
    }

    public function delete(Request $request)
    {
        $id=$request->id;      
        $pages = Page::findOrFail($id);
        if ($pages->delete()) {
            return redirect('admin/page')->with('success', 'Page deleted succesfully');
        }else{
            return redirect()->back()->with('error', 'Some error occured. Please try again later');
        }       
    }
    
}
