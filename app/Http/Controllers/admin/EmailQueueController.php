<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\EmailQueue;
use Illuminate\Http\Request;

class EmailQueueController extends Controller
{
    
    /**
     * Get all the emails
     *
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function all()
    {
        $emails = EmailQueue::orderBy('id', 'DESC')->paginate(env('PAGINATE_LENGTH'));
        return view('admin.email-queue.index', [
            'emails' => $emails
        ]);
    }

    /**
     * View details of single email queue
     *
     * @param integer $id
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function view($id)
    {
        $email = EmailQueue::findOrFail($id);
        return view('admin.email-queue.view', [
            'email' => $email
        ]);
    }

    public function show($id)
    {
        $email = EmailQueue::findOrFail($id);
        echo $email->message;
    }

    /**
     * Delete an email queue
     *
     * @param integer $id
     */
    public function delete(Request $request)
    {
        $id = $request->id;
        $email = EmailQueue::findOrFail($id);
        if ($email->delete()) {
            return redirect('admin/email-queue')->with('success', 'Email deleted succesfully');
        }
    }
}
