@extends('layouts.side-navbar')

@section('content')

<div class="container-fluid px-4">
    <h1 class="mt-4">Data User</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
        <li class="breadcrumb-item active">User</li>
    </ol>

       
            <script>
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text:"error"
                    });
            </script>
 

            <script>
                Swal.fire({
                    title: "Success !",
                    icon: "success",
                    text:"success",
                    draggable: true
                });
            </script>
      

    <div class="d-flex">
        <a href="{{route('user.create')}}" type="button" class="btn btn-secondary mb-3 ms-auto">
            <i class="fa-solid fa-user-plus me-1"></i>
            Tambah User
        </a>    
    </div>
    <div class="card mb-4">
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Tanggal Bergabung</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Tanggal Bergabung</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody >


                        <tr class="d-flex align-items-center">
                            <td>1</td>
                            <td>kasir-1</td>
                            <td>kasir</td>
                            <td>24 Apr 2025</td>
                            <td class="me-4 mb-4 d-flex ms-auto">
                                <a type="button" class="btn btn-warning me-1" href="">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    Edit
                                </a>
                                <!-- Tombol Delete -->
                                <button type="button" class="btn btn-danger ms-1" onclick="confirmDelete()">
                                    <i class="fa-solid fa-trash"></i>
                                    Delete
                                </button>
                                
                                <!-- Form Hapus -->
                                <form id="delete-form-id" action="{{route('user.delete')}}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                    
                        </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>    

<!-- JavaScript untuk konfirmasi delete -->
<script>
    function confirmDelete(userID) {
        Swal.fire({
            title: "Apakah Anda yakin?",
            text: "Data user akan dihapus secara permanen!",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Ya, hapus!"
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`delete-form-${userID}`).submit();
            }
        });
    }
</script>

@endsection          
