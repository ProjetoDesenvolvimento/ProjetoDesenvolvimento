<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class MainController extends Controller
{
    public function __construct() {

    }

    public function index() {
        return view("main.index")->with("user", session()->get("user_data"));
    }

}
