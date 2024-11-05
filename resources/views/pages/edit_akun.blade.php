@extends('component.template');
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
    {{-- <li class="breadcrumb-item"><a href="javascript: void(0)">Laporan</a></li> --}}
    <li class="breadcrumb-item" aria-current="page">Edit Akun</li>
@endsection
@section('page_header')
    <h2 class="mb-0">Edit Akun</h2>
@endsection
@section('content')
    <div class="row d-flex justify-content-center">
        <div class="col-xl-8 col-lg-7">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4>Informasi Pengguna</h4>
                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#editModal{{ $admin->id }}"><i class="ti ti-edit"></i> Edit</button>
                </div>
                <div class="card-body">
                    <div class="col">
                            <div class="row">
                               <div class="form-group col-md-6">
                                     <label class="col-form-label">Username:</label>
                                     <input type="text" class="form-control" value="{{ $admin->username }}" readonly>
                                 </div>
                               <div class="form-group col-md-6">
                                  <label class="col-form-label" for="lname">Password:</label>
                                  <input type="text" class="form-control" value="........." readonly>
                               </div>
                               <div class="form-group col-md-12">
                                  <label class="col-form-label" for="add1">Role:</label>
                                  <input type="text" class="form-control" value="{{ $admin->level }}" readonly>
                               </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Edit Modal --}}
    <div id="editModal{{ $admin->id }}" class="modal fade" tabindex="-1"
        role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Edit Data Pengguna
                    </h4>
                    <button class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form action="/edit-akun/{{ $admin->id }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-1">
                                <div class="form-group">
                                    <label for=""
                                        class="col-form-label">Username</label>
                                    <input type="text" name="username" id=""
                                        placeholder="Masukan username" class="form-control"
                                        value="{{ $admin->username }}">
                                </div>
                            </div>
                            <div class="col-md-6 mb-1">
                                <div class="form-group">
                                    <label for=""
                                        class="col-form-label">Password</label>
                                    <input type="password" name="password"
                                        id=""
                                        placeholder="Masukan password jika ingin diubah"
                                        class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan
                            Perubahan</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection
