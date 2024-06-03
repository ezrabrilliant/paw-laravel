<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit-profile');
    }

    public function update(Request $request)
    {
        // Logika untuk update profil
    }
}
