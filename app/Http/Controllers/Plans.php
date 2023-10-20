<?php

namespace App\Http\Controllers;

use App\Models\Subscription;

use Illuminate\Http\Request;

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
}
