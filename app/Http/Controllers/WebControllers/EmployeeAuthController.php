<?php

namespace App\Http\Controllers\WebControllers;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class EmployeeAuthController extends Controller
{
    public function login(Request $request) : View
    {
        $validator = Validator::make([
            'email' => 'required|email',
            'password' => 'required'
        ], $request->all());

        if($validator->fails())
            return view('system.login', ['message' => 'Please Login to use the system']);
        
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();
    
            return view('employees.dashboard');
        }
    
        return view('system.login', ['message' => 'Login Failed']);
    }

    public function logout(Request $request) : RedirectResponse
    {
        Auth::logout();
 
        $request->session()->invalidate();
     
        $request->session()->regenerateToken();
     
        return redirect('/');
    }
}