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
        // dd('halo');
        //
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|alpha_dash',
        ], [
            'email.required' => 'email harus diisi',
            'email.email' => 'email harus valid',
            'password.required' => 'Password harus diisi',
            'password.alpha_dash' => 'Password harus berisi huruf dan karakter tanpa spasi'
        ]);

        $validate = [
            'email' => $request -> email,
            'password' => $request -> password
        ];

        if (Auth::attempt($validate)) {
            return redirect()->route('home')->with('success', 'Anda berhasil login');
        } else {
            return redirect()->route('login')->with('failed', 'email/password anda salah');
        }
    }

    public function logout()
    {
        Auth::logout();
        
        return redirect()->route('login')->with('success', 'Anda telah logout');
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
