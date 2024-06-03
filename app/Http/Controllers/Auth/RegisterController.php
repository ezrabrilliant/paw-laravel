<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Member;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.signup');
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|unique:member',
            'email' => 'required|string|email|unique:member',
            'telepon' => 'required|string|min:10|max:13|regex:/^08[0-9]{8,11}$/',
            'password' => 'required|string|min:6',
        ]);

        Member::create([
            'username' => $request->username,
            'email' => $request->email,
            'nomor_telepon' => $request->telepon,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Registration successful. Please log in.');
    }
}
