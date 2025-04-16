@extends('layouts.side-navbar')

@section('content')

<div class="container-fluid px-4">
    <h1 class="mt-4">Tambah User</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="">User</a></li>
        <li class="breadcrumb-item active">Tambah User</li>
    </ol>
    <form action="" method="post">
        @csrf

            <script>
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text:"error"
                    });
            </script>
            
            
            <script>
                Swal.fire({
                    title: "Drag me!",
                    icon: "success",
                    text:"success",
                    draggable: true
                });
            </script>


        <div class="card">
            <div class="card-body row">
                <div class="ms-1 col">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username">
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select id="role" name="role" class="form-select" aria-label="Default select example">
                            <option selected>Select Role</option>
                            <option id="role" name="role" value="Admin">Admin</option>
                            <option id="role" name="role" value="Kasir">Kasir</option>
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