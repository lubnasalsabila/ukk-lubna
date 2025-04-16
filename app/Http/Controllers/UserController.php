<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $users = User::All();
        return view('component.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('component.user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'username' => 'required',
            'email' => 'required',
            'role' => 'required',
        ]);

        $validateData = [
            'username' => $request->username,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if($request->password('IsValid')){
            $validateData = Hash::make($request->password);
        }

        User::create($validateData);

        return redirect()->route('user.index')->with('success', 'berhasil menambahkan data user');
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
        $user = User::find($id);
        return view('component.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'username' => 'required',
            'email' => 'required',
            'role' => 'required',
        ]);

        $validateData = [
            'username' => $request->username,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if($request->password('isValid'));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
