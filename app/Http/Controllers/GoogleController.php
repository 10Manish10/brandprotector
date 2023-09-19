<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\Client;
use App\Models\TKO_SearchEngine;
use Gate;
use DB;

use Illuminate\Http\Request;

class GoogleController extends Controller
{
    public function __construct() {
        // $this->middleware('auth');
    }

    public function pre($data) {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }

}
