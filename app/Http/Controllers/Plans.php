<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\EmailLogs;
use App\Models\Client;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function test(Request $request) {
        $paymentStatus = "";
        // cancelled
        // success
        if ($request->has('checkout')) {
            $paymentStatus = $request->query('checkout');
        }
        $data = Subscription::all();
        $error = "";
        return view('plans', compact('data'), compact('error'), compact('paymentStatus'));
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
        // dd([$data, $insert]);
        try {
            Mail::html($data['body'], function($message) use ($data) {
                $message->from($data['from'], 'Brand Protection Enforcement');
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

    public function createPayment(Request $req) {
        $user = Auth::user();
        $email = $user->email;
        $name = $user->name;
        $client = Client::where("email", $email)->get()->toArray();
        if ($client) {
            $amt = $req->input('amount') * 100;
            $desc = "TKO_".$name."_".$email."_Plan_".$req->input('txn_desc')."_".date('d/m/Y');
            return $req->user()->checkoutCharge($amt, $desc);
            // return view('vendor.cashier.checkout', [
            //     'amount' => $amt,
            //     'description' => $desc,
            // ]);
        } else {
            $data = Subscription::all();
            $error = "Unauthorized client, please make sure client exists!";
            return view('plans', compact('data'), compact('error'));
        }
    }

    public function paymentWebhook(Request $req) {
        $requestData = $request->getContent();
        $requestDataJson = json_encode($requestDataArray);
        $logFilePath = storage_path('logs/request.log');
        file_put_contents($logFilePath, $requestDataJson . PHP_EOL, FILE_APPEND);
        return response()->json(['message' => 'OK'], 200);
    }
}
