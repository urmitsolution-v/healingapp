<?php

namespace App\Http\Controllers\Healing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\HealingRequest;
use App\Models\MonthlyWallet;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class Commoncontroller extends Controller
{
  public function index()
    {

        $query = HealingRequest::where('user_id', '!=', auth()->id())
        ->where('status', 'pending') // Only open for bid
        ->whereDoesntHave('bids', function ($q) {
            $q->where('healer_id', auth()->id());
        });
         $totalRequests = $query->count();
         $wallet = MonthlyWallet::where('user_id', auth()->id())
        ->where('month', now()->month)
         ->where('year', now()->year)
            ->first();


         return view('healing.index',compact('totalRequests','wallet'));
    }

    public function signUp()
    {
        return view('healing.signUp');
        
    }

    public function register_store(Request $request)
    {
          $validator = Validator::make($request->all(), [
        'name'     => 'required|string|max:255',
        'email'    => 'required|email|unique:users,email',
        'password' => 'required|min:6',
        'dob'      => 'required|date',
        'address'  => 'required|string|max:500',
        'phone'    => 'required|numeric|digits:10|unique:users,phone',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => 400,
            'errors' => $validator->errors()
        ]);
    }

     $name = strtoupper(preg_replace('/[^A-Z]/', '', strtoupper($request->name)));
    $prefix = substr($name, 0, 2); // e.g. "HB"

    $lastUser = User::orderBy('id', 'desc')->first();
    $nextId = $lastUser ? $lastUser->id + 1 : 1;
    $paddedId = str_pad($nextId, 4, '0', STR_PAD_LEFT); // e.g. 0028

    $randomNumber = rand(10, 99); // 2-digit random number

    $user_code = $prefix . $paddedId . $randomNumber; 

       $user = User::create([
        'name'     => $request->name,
        'email'    => $request->email,
        'password' => Hash::make($request->password),
        'dob'      => $request->dob,
        'address'  => $request->address,
        'phone'    => $request->phone,
        'user_code' => $user_code,
        'is_block'    => 'Y',
        'role'    => 'user',
        'status'    => 'pending',
    ]);
    
     Auth::login($user);

    return response()->json([
        'status' => 200,
        'message' => 'Registered successfully.'
    ]);
    }

    public function declearation()
    {
        return view('healing.declearation');
    }
 
    
    public function finalSubmit(Request $request)
{
    if (!$request->agreed) {
        return response()->json(['error' => 'You must agree first.'], 422);
    }

    auth()->user()->update([
        'declearation' => "Y"
    ]);

    return response()->json(['success' => true]);
}


public  function payment_submit(Request $request)
{
    if (Auth::check()) {

        if($request->isMethod('post')) {
           
             $validator = Validator::make($request->all(), [
        'screenshop' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'certificate' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'utr_no' => 'required|string|max:255',
    ]);

    if ($validator->fails()) {
        return response()->json(['status' => 400, 'errors' => $validator->errors()]);
    }

    $user = Auth::user();

    // Handle file uploads
    $screenshotName = null;
    $certificateName = null;

    if ($request->hasFile('screenshop')) {
        $screenshotName = time() . '_screenshot.' . $request->screenshop->extension();
        $request->screenshop->move(public_path('uploads/screenshots'), $screenshotName);
    }

    if ($request->hasFile('certificate')) {
        $certificateName = time() . '_certificate.' . $request->certificate->extension();
        $request->certificate->move(public_path('uploads/certificates'), $certificateName);
    }

    // Save to user
    $user->amount = $request->input('amount', 999); // default amount
    $user->utr_no = $request->utr_no;
    $user->screenshot = $screenshotName;
    $user->certificate = $certificateName;
    $user->payment_time = now()->format('H:i:s');
    $user->payment_date = now()->format('Y-m-d');
    $user->save();

    return response()->json(['status' => 200, 'message' => 'Payment info submitted']);

            return response()->json(['success' => true, 'message' => 'Payment processed successfully.']);
        }

        return view('healing.payment_submit');
    } else {
        return redirect()->route('healing.signIn');
    }
}

public function signIn(Request $request)
{
    if (Auth::check()) {
        return redirect()->route('healing.index');
    }

    return view('healing.signIn');
    
}


public function login(Request $request)
{
    $request->validate([
        'phone' => 'required|digits:10',
        'password' => 'required|string|min:4',
    ]);

    $user = User::where('phone', $request->phone)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Invalid phone number or password.'], 401);
    }

    // Check if user is inactive
    if ($user->is_block == 'Y') {
        return response()->json(['message' => 'Your account is inactive. Please contact support.'], 403);
    }

    Auth::login($user);

    // Redirect based on declaration status
    if ($user->declearation != 'Y') {
        return response()->json(['redirect' => url('/declearation')]);
    }

    return response()->json(['redirect' => url('/')]);
}

}