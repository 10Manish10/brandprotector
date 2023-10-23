<?php

namespace App\Http\Controllers;

use App\Models\Subscription;

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
        
        Mail::html($data['body'], function($message) use ($data) {
            $message->from($data['from'], '');
            $message->replyTo($data['from']);
            $message->to($data['to']);
            $message->subject($data['subject']);
        });
        return redirect()->route('admin.email-templates.show', ['email_template' => $data['email_template_id']]);
    }
}
