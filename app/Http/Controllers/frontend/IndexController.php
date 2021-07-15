<?php
namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class IndexController extends Controller
{

    public function index(Request $request)
    {
        $user =User::all();
        if ($user->isEmpty()) {
            return redirect('add-admin');
        } else {
            if(Auth::check()):
                if (Auth::user()->role_id == User::ROLE_ADMIN) {
                    return redirect('admin/dashboard');
                } elseif (Auth::user()->role_id == User::ROLE_USER) {
                    return redirect('discover');
                } else {
                    return redirect('/')->with('errore', 'Some error occured');
                }
            else:
               return view('frontend.index');
            endif;
        }        
    }
}
