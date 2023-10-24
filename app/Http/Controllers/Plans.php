<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\EmailLogs;

use Illuminate\Http\Request;

use Mail;

class Plans extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function pre($data) {
        echo "<pre>";
        print_r($data);
        echo "<pre>";
    }

    public function test() {
        $data = Subscription::all();
        return view('plans', compact('data'));
    }

    public function sendInfringmentMail(Request $request) {
        $data = $request->all();
        $result = preg_replace_callback('/\{\{(.*?)\}\}/', function ($matches) use ($data) {
            $variable = $matches[1];
            return isset($data[$variable]) ? $data[$variable] : " ";
        }, $data['body']);
        $data['body'] = $result;

        $insert = [
            'template_id' => $data['email_template_id'],
            'channel' => $data['channel'],
            'from' => $data['from'],
            'to' => $data['to'],
            'subject' => $data['subject'],
            'email_body' => $data['body'],
            'priority' => $data['priority'],
            'status' => 'PENDING'
        ];
        try {
            Mail::html($data['body'], function($message) use ($data) {
                $message->from($data['from'], '');
                $message->replyTo($data['from']);
                $message->to($data['to']);
                $message->subject($data['subject']);
            });
            $insert['status'] = "SUCCESS";
        } catch (Exception $e) {
            $insert['status'] = "ERROR";
        }
        EmailLogs::create($insert);
        return redirect()->route('admin.email-templates.show', ['email_template' => $data['email_template_id']]);
    }
}
