<?php
namespace App\Models;

use App\Mail\MailFromAdmin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class EmailQueue extends Model
{

    const STATE_PENDING = 0;

    const STATE_SENT = 1;

    const STATE_FAILED = 2;

    const STATE_DELETED = 3;

    protected $table = "email_queue";

    protected $fillable = [
        'from_email',
        'to_email',
        'message',
        'subject',
        'date_published',
        'last_attempt',
        'date_sent',
        'attempts',
        'state_id'
    ];

    public static function getStateOptions()
    {
        return [
            self::STATE_PENDING => "Pending",
            self::STATE_SENT => "Sent",
            self::STATE_FAILED => "Failed",
            self::STATE_DELETED => "Discarded"
        ];
    }

    public function getState()
    {
        $list = self::getStateOptions();
        return isset($list[$this->state_id]) ? $list[$this->state_id] : 'Not Defined';
    }

    public static function add($args = [], $trySendNow = true)
    {
        if (! $args)
            return false;
        $mail = new EmailQueue();
        $mail->from_email = (isset($args['from'])) ? $args['from'] : 'admin@toxsl.in';
        $mail->to_email = $args['to'];
        $mail->subject = (isset($args['subject'])) ? $args['subject'] : config('app.name');
        $mail->attempts = 1;
        $mail->date_sent = date('Y-m-d H:i:s');
        $model = isset($args['model']) ? $args['model'] : [];
        $message = view($args['view'], [
            'data' => $args['model']
        ])->render();
        $mail->message = $message;
        if ($trySendNow) {
            return $mail->sendNow($args['view'], $model);
        } else {
            $mail->state_id = self::STATE_PENDING;
            if ($mail->save()) {
                return true;
            }
        }
        return false;
    }

    public function sendNow($view, $data)
    {
        $this->save();
        return true;
        Mail::to($this->to_email)->send(new MailFromAdmin($view, $data, $this->from_email));
        if (Mail::failures()) {
            $this->state_id = self::STATE_PENDING;
            $this->save();
            return false;
        } else {
            $this->state_id = self::STATE_SENT;
            $this->save();
            return true;
        }
    }
}
