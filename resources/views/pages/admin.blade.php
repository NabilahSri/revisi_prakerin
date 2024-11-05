@extends('component.template')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="javascript: void(0)">Pengguna</a></li>
    <li class="breadcrumb-item" aria-current="page">Admin</li>
@endsection
@section('page_header')
    <h2 class="mb-0">Administrator</h2>
@endsection
@section('content')
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="col">
                    <form action="/pengguna/admin/add" method="post">
                        @csrf
                        <div class="row g-3 align-items-center">
                            <div class="col">
                                <input type="text" class="form-control" name="username" placeholder="Masukan Username"
                                    required />
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-primary"><i class="ti ti-circle-plus"></i> Simpan
                                    Data</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table id="example" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-start">No</th>
                                <th>Username</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($admin as $key => $item)
                                <tr>
                                    <td class="text-start">{{ $key + 1 }}</td>
                                    <td>{{ $item->username }}</td>
                                    <td>
                                        <a href="/pengguna/admin/delete/{{ $item->id }}"  onclick="return confirmDelete()" class="btn btn-danger d-inline-flex btndelete"><i class="ti ti-trash me-1"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
