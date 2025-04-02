<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MakeupController extends Controller
{
    public function makeup(){
        return view('admin.makeup');
    }
}
