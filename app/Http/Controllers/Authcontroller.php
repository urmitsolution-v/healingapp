<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class Authcontroller extends Controller
{
      public function login(){
        return view('auth.login');
    }

  public function loginSubmit(Request $request)
{
    $request->validate([
        'phone' => ['required', 'digits:10'], 
        'password' => ['required', 'string'],
    ]);

    $credentials = [
        'phone' => $request->phone,
        'password' => $request->password,
    ];
    
    $remember = $request->has('remember');
   $user = \App\Models\User::where('phone', $request->phone)
    ->whereIn('role', ['admin', 'team'])
    ->first();

if ($user && Hash::check($request->password, $user->password)) {
    Auth::login($user, $remember);
    $request->session()->regenerate();

    \Log::info('Login successful for user ID: ' . $user->id); // <-- Debug line

    return redirect('/dashboard');
}
    return back()->withErrors([
        'phone' => 'Invalid mobile number or password.',
    ])->onlyInput('phone');
}

public function logout(){
    Auth::logout();
    return redirect('/');
}

}