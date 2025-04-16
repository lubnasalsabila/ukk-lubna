<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('login');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'email'=> 'alpha_dash',
            'password' => 'alpha_dash',
        ], [
            'email.required' => 'Email harus valid',
            'email.email' => 'Email harus valid',
            'password.required' => 'Password harus valid',
            'password.alpha_dash' => 'Password harus berisikan huruf dan simbol tanpa spasi',
        ]);

        if(Auth::attempt()) {
            return redirect()->route('home')->with('success', 'Anda berhasil login');
        }
    }

    public function logout() {

        Auth::logout();

        return redirect()->route('login')->with('success', 'Anda berhasil logout');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
