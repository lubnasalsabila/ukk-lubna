@extends('layouts.side-navbar')

@section('content')

<div class="container-fluid px-4">
    <h1 class="mt-4">Tambah User</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('user.index') }}">User</a></li>
        <li class="breadcrumb-item active">Tambah User</li>
    </ol>
    <form action="{{ route('user.store') }}" method="post">
        @csrf

        @if ($message = Session::get('failed')) 
            <script>
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text:"{{ $message }}"
                    });
            </script>
        @endif
        @if ($message = Session::get('success')) 
            <script>
                Swal.fire({
                    title: "Drag me!",
                    icon: "success",
                    text:"{{ $message }}",
                    draggable: true
                });
            </script>
        @endif

        <div class="card">
            <div class="card-body row">
                <div class="ms-1 col">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control" id="email" name="email">
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select id="role" name="role" class="form-select" aria-label="Default select example">
                            <option selected>Select Role</option>
                            <option id="role" name="role" value="admin">Admin</option>
                            <option id="role" name="role" value="staff">Staff</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="text" class="form-control" id="password" name="password">
                    </div>
                </div>
            </div>
            <div class="me-4 mb-4 d-flex ms-auto">
                <button type="submit" class="btn btn-primary ms-1" href="">
                    <i class="fa-solid fa-paper-plane"></i>
                    Kirim Data
                </button>
            </div>
        </div>
    </form>
</div>

@endsection