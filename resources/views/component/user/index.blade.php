@extends('layouts.side-navbar')

@section('content')

<div class="container-fluid px-4">
    <h1 class="mt-4">Data User</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">User</li>
    </ol>

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
                    title: "Success !",
                    icon: "success",
                    text:"{{ $message }}",
                    draggable: true
                });
            </script>
        @endif

    <div class="d-flex">
        <a href="{{ route('user.create') }}" type="button" class="btn btn-secondary mb-3 ms-auto">
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
                    @php $no = 1; @endphp
                    @foreach ($users as $item)
                        <tr class="d-flex align-items-center">
                            <td>{{ $no++ }}</td>
                            <td>{{ $item['username'] }}</td>
                            <td>{{ $item['role'] }}</td>
                            <td>{{ \Carbon\Carbon::parse($item['created_at'])->translatedFormat('d F Y') }}</td>
                            <td class="me-4 mb-4 d-flex ms-auto">
                                <a type="button" class="btn btn-warning me-1" href="{{ route('user.edit', $item['id']) }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    Edit
                                </a>
                                <!-- Tombol Delete -->
                                <button type="button" class="btn btn-danger ms-1" onclick="confirmDelete({{ $item['id'] }})">
                                    <i class="fa-solid fa-trash"></i>
                                    Delete
                                </button>
                                
                                <!-- Form Hapus -->
                                <form id="delete-form-{{ $item['id'] }}" action="{{ route('user.delete', $item['id']) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                    @endforeach
                        </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>    

<!-- JavaScript untuk konfirmasi delete -->
<script>
    function confirmDelete(userId) {
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
                document.getElementById(`delete-form-${userId}`).submit();
            }
        });
    }
</script>

@endsection          
