<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\LoginHistory;
use Illuminate\Http\Request;

class LoginHistoryController extends Controller
{

    public function all()
    {
        $history = LoginHistory::orderBy('id', 'DESC')->paginate(25);
        return view('admin.login-history.index', compact('history'));
    }

    public function view($id)
    {
        $history = LoginHistory::findOrfail($id);     
            return view('admin.login-history.view', compact('history'));        
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        $history = LoginHistory::findOrFail($id);
        if ($history->delete()) {
            return redirect('admin/login-history')->with('success', 'Login history deleted succesfully');
        }
    }
}
