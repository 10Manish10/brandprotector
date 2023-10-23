<?php

namespace App\Http\Controllers;

use App\Models\Subscription;

use Illuminate\Http\Request;
use Symfony\Component\Mime\Part\HtmlPart;

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
        // dd($data);
        
        Mail::send([], [], function($msg) use ($data) {
            $textPart = new HtmlPart($data['body']);
            $msg->to([$data['to']])
                ->from($address = $data['from'], $name = '')
                ->subject($data['subject'])
                ->setBody($textPart, 'text/html');
        });

        return redirect()->route('admin.subscriptions.index');
    }
}
