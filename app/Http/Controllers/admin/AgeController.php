<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Models\Age;
use App\Models\User;

class AgeController extends Controller
{

    /*
     * |--------------------------------------------------------------------------
     * | Age Controller
     * |--------------------------------------------------------------------------
     * |
     * | This controller handles authenticating Age for the application and
     * | redirecting them to your home screen. The controller uses a trait
     * | to conveniently provide its functionality to your applications.
     * |
     */
    public function all(Request $request)
    { 
        $ages = Age::get();
        return view('admin.age.index', compact('ages'));
    }

    public function view($id)
    {
        $age = Age::findOrfail($id);
        return view('admin.age.view', compact('age'));
    }

    /**
     * Save Age Data
     *
     * @param Request $request
     */
    public function save(Request $request)
    {
        $rules = array(
            'age' => 'required|integer',
            'state_id' => 'integer'
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        } else {
            $age = new Age();
            $age->age = $request->age;
            $age->state_id = $request->state_id;
            $age->created_by_id = Auth::id();         
            if ($age->save()) {
                return redirect('admin/age')->with('success', 'Age added succesfully');
            } else {
                return Redirect::back()->withInput()->with('error', 'Some error occured. Please try again later');
            }
        }
    }

    public function edit($id)
    {
        $age = Age::findOrfail($id);
        return view('admin.age.edit', compact('age'));
    }

    public function editupdate(Request $request, $id)
    {
        $rules = array(
            'age' => 'required|integer',           
            'state_id' => 'integer',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        } else {
            $age = Age::find($id);
            $age->age = $request->age;
            $age->state_id = $request->state_id;
            $age->created_by_id = Auth::id();
            if ($age->save()) {
                return redirect('admin/age')->with('success', 'Age Update succesfully');
            } else {
                return Redirect::back()->withInput()->with('error', 'Some error occured. Please try again later');
            }            
        }
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        $age = Age::findOrFail($id);
        if ($age->delete()) {
            return redirect('admin/age')->with('success', 'age deleted succesfully');
        } else {
            return redirect()->back()->with('error', 'Some error occured. Please try again later');
        }
    }
}
