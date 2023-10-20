<?php

namespace App\Http\Controllers;

use App\Models\TKO_Ecommerce;

use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function __construct() {
    }

    public function pre($data) {
        echo "<pre>";
        print_r($data);
        echo "<pre>";
    }

    public function test() {
        $data = TKO_Ecommerce::all();
        return view('reports', compact('data'));
    }
}
