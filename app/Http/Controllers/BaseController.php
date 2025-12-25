<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class BaseController extends Controller
{
    protected $admin;
    protected $doctor;
    protected $staff;

    public function __construct()
    {
        $this->admin = Auth::guard('admin')->user();
        view()->share('admin', $this->admin);

        $this->doctor = Auth::guard('doctor')->user();
        view()->share('doctor', $this->doctor);


        $this->staff = Auth::guard('staff')->user();
        view()->share('staff', $this->staff);
    }

    public function splash(){
        return view('splash');
    }
    public function index(){
        
        return view('index');
    }
    public function about_us(){
        
        return view('about_us');
    }
}
