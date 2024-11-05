@extends('component.template')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="javascript: void(0)">Pengguna</a></li>
    <li class="breadcrumb-item" aria-current="page">Industri</li>
@endsection
@section('page_header')
    <h2 class="mb-0">Industri</h2>
@endsection
@section('content')
    <div class="col">
        <div class="card">
            @if (auth()->user()->level == 'admin')
                <div class="card-header">
                    <div class="col">
                        <button type="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal"><i class="ti ti-circle-plus"></i> Tambah Data</button>
                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="ti ti-download"></i> Import Data</button>
                    </div>
                </div>
            @endif
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table id="example" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-start">Nama Industri</th>
                                <th>Email</th>
                                <th>Username</th>
                                <th class="text-start">No Telepon</th>
                                <th>Alamat</th>
                                {{-- @if (auth()->user()->level == 'admin') --}}
                                    <th>Aksi</th>
                                {{-- @endif --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($industri as $key => $item)
                                <tr>
                                    <td class="text-start">
                                        <div class="d-inline-block align-middle">
                                            @if ($item->logo)
                                                <img src="{{ asset('storage/' . $item->foto) }}" alt="user image" class="img-radius align-top m-r-15" style="width: 40px" />
                                            @else
                                                <img src="https://www.littlethings.info/wp-content/uploads/2014/04/dummy-image-green-e1398449160839.jpg" alt="user image" class="img-radius align-top m-r-15" style="width: 40px" />
                                            @endif
                                            <div class="d-inline-block">
                                              <h6 class="m-b-0">{{ $item->name }}</h6>
                                              <p class="m-b-0 text-primary">{{ $item->ceo ? $item->ceo : '-' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $item->email ? $item->email : '-' }}</td>
                                    <td>{{ $item->user->username }}</td>
                                    <td class="text-start">{{ $item->telp ? $item->telp : '-' }}</td>
                                    <td>{{ $item->alamat ? $item->alamat : '-' }}</td>
                                    <td>
                                        <a href="#" class="btn btn-warning d-inline-flex" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}"><i class="ti ti-edit me-1"></i></a>
                                        @if (auth()->user()->level == 'admin')
                                            <a href="/pengguna/industri/delete/{{ $item->id }}"  onclick="return confirmDelete()" class="btn btn-danger d-inline-flex btndelete"><i class="ti ti-trash me-1"></i></a>
                                        @endif
                                        </td>
                                </tr>

                                {{-- Modal Edit --}}
                                <div id="editModal{{ $item->id }}" class="modal fade" tabindex="-1"
                                    role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">Edit Data Industri
                                                </h4>
                                                <button class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="/pengguna/industri/edit/{{ $item->id }}" method="post">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-12 mb-1">
                                                            <div class="form-group">
                                                                <label for=""
                                                                    class="col-form-label">Nama Industri</label>
                                                                <input type="text" name="name" id=""
                                                                    placeholder="Masukan nama industri" class="form-control"
                                                                    value="{{ $item->name }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 mb-1">
                                                            <div class="form-group">
                                                                <label for=""
                                                                    class="col-form-label">Pimpinan</label>
                                                                <input type="text" name="ceo" id=""
                                                                    placeholder="Masukan nama pimpinan" class="form-control"
                                                                    value="{{ $item->ceo }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 mb-1">
                                                            <div class="form-group">
                                                                <label for=""
                                                                    class="col-form-label">Email</label>
                                                                <input type="email" name="email"
                                                                    id="" placeholder="Masukan email"
                                                                    class="form-control"
                                                                    value="{{ $item->email }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 mb-1">
                                                            <div class="form-group">
                                                                <label for=""
                                                                    class="col-form-label">Username</label>
                                                                <input type="text" name="username"
                                                                    id="" placeholder="Masukan username"
                                                                    class="form-control"
                                                                    value="{{ $item->user->username }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 mb-1">
                                                            <div class="form-group">
                                                                <label for="" class="col-form-label">No
                                                                    Telepon</label>
                                                                <input type="number" name="telp"
                                                                    id=""
                                                                    placeholder="Masukan no telepon"
                                                                    class="form-control"
                                                                    value="{{ $item->telp }}">
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
                                                        <div class="col-md-6 mb-1">
                                                            <div class="form-group">
                                                                <label for="" class="col-form-label">Logo</label>
                                                                <input type="file" name="logo" id=""
                                                                    placeholder="Masukan logo perusahaan" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 mb-1">
                                                            <div class="form-group">
                                                                <label for=""
                                                                    class="col-form-label">Alamat</label>
                                                                <textarea name="alamat" id="" cols="30" rows="2" class="form-control">{{ $item->alamat }}</textarea>
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
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Tambah-->
    <div id="addModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Tambah Data Industri</h4>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/pengguna/industri/add" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-1">
                                <div class="form-group">
                                    <label for="" class="col-form-label">Nama Industri</label>
                                    <input type="text" name="name" id="" placeholder="Masukan nama industri"
                                        class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-1">
                                <div class="form-group">
                                    <label for="" class="col-form-label">Pimpinan</label>
                                    <input type="text" name="ceo" id="" placeholder="Masukan pimpinan"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6 mb-1">
                                <div class="form-group">
                                    <label for="" class="col-form-label">Email</label>
                                    <input type="email" name="email" id="" placeholder="Masukan email"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6 mb-1">
                                <div class="form-group">
                                    <label for="" class="col-form-label">Username</label>
                                    <input type="text" name="username" id=""
                                        placeholder="Masukan username" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-1">
                                <div class="form-group">
                                    <label for="" class="col-form-label">No Telepon</label>
                                    <input type="number" name="telp" id=""
                                        placeholder="Masukan no telepon" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6 mb-1">
                                <div class="form-group">
                                    <label for="" class="col-form-label">Logo</label>
                                    <input type="file" name="logo" id=""
                                        placeholder="Masukan logo perusahaan" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12 mb-1">
                                <div class="form-group">
                                    <label for="" class="col-form-label">Alamat</label>
                                    <textarea name="alamat" id="" cols="30" rows="2" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Import -->
    <form action="/pengguna/industri/import-excel" method="post" enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Pilih File</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="file" class="form-control" name="file" id="" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
