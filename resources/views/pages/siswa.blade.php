@extends('component.template')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="javascript: void(0)">Pengguna</a></li>
    <li class="breadcrumb-item" aria-current="page">Siswa</li>
@endsection
@section('page_header')
    <h2 class="mb-0">Siswa</h2>
@endsection
@section('content')
    <div class="col">
        <div class="card">
            @if (auth()->user()->level == 'admin')
                <div class="card-header">
                    <div class="col">
                        <div class="row g-3 align-items-center">
                            <div class="col">
                                <button type="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal"><i class="ti ti-circle-plus"></i> Tambah
                                    Data</button>
                                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal"><i class="ti ti-download"></i> Import Data
                                    </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table id="example" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-start">Nama</th>
                                <th>Email</th>
                                <th>Username</th>
                                <th>Kelas</th>
                                <th class="text-start">No Telepon</th>
                                <th>Alamat</th>
                                <th class="text-start">Latitude</th>
                                <th class="text-start">Longitude</th>
                                @if (auth()->user()->level == 'admin' || auth()->user()->level == 'pemonitor')
                                    <th>Kunci Lokasi</th>
                                @endif
                                {{-- @if (auth()->user()->level == 'admin') --}}
                                    <th>Aksi</th>
                                {{-- @endif --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($siswa as $key => $item)
                                <tr>
                                    <td class="text-start">
                                        <div class="d-inline-block align-middle">
                                            @if ($item->foto)
                                                <img src="{{ asset('storage/' . $item->foto) }}" alt="user image" class="img-radius align-top m-r-15" style="width: 40px" />
                                            @else
                                                <img src="../assets/images/user/avatar-9.jpg" alt="user image" class="img-radius align-top m-r-15" style="width: 40px" />
                                            @endif

                                            <div class="d-inline-block">
                                              <h6 class="m-b-0">{{ $item->name }}</h6>
                                              <p class="m-b-0 text-primary">{{ $item->nisn }}</p>
                                            </div>
                                          </div>
                                    </td>
                                    <td>{{ $item->email ? $item->email : '-' }}</td>
                                    <td>{{ $item->user->username }}</td>
                                    <td>{{ $item->kelas->kelas }}</td>
                                    <td class="text-start">{{ $item->telp ? $item->telp : '-' }}</td>
                                    <td>{{ $item->alamat ? $item->alamat : '-' }}</td>
                                    <td class="text-start">{{ $item->lat ? $item->lat : '-' }}</td>
                                    <td class="text-start">{{ $item->long ? $item->long : '-' }}</td>
                                    @if (auth()->user()->level == 'admin' || auth()->user()->level == 'pemonitor')
                                        <td>
                                            <form action="/pengguna/siswa/update-kunci-lokasi/{{ $item->id }}" method="post">
                                                @csrf
                                                <div class="form-check form-switch custom-switch-v1 form-check-inline ms-1">
                                                    <input type="checkbox" class="form-check-input" id="customswitchlightv1-4" @if ($item->kunci_lokasi == 1) checked @endif onchange="this.form.submit()">
                                                    <label class="form-check-label" for="customswitchlightv1-4">
                                                        @if ($item->kunci_lokasi == 1)
                                                            Terkunci
                                                        @else
                                                            Tidak terkunci
                                                        @endif
                                                    </label>
                                                </div>
                                                <input type="hidden" name="kunci_lokasi" value="{{ $item->kunci_lokasi == 1 ? 0 : 1 }}">
                                            </form>
                                        </td>
                                    @endif
                                    <td>
                                        <a href="#" class="btn btn-warning d-inline-flex" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}"><i class="ti ti-edit me-1"></i></a>
                                        @if (auth()->user()->level == 'admin')
                                            <a href="/pengguna/siswa/delete/{{ $item->id }}"  onclick="return confirmDelete()" class="btn btn-danger d-inline-flex"><i class="ti ti-trash me-1"></i></a>
                                        @endif
                                        </td>
                                </tr>
                                {{-- Edit Modal --}}
                                <div id="editModal{{ $item->id }}" class="modal fade" tabindex="-1"
                                    role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">Edit Data Siswa
                                                </h4>
                                                <button class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="/pengguna/siswa/edit/{{ $item->id }}" method="post" enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-12 mb-1">
                                                            <div class="form-group">
                                                                <label for=""
                                                                    class="col-form-label">NISN</label>
                                                                <input type="number" name="nisn" id=""
                                                                    placeholder="Masukan nisn" class="form-control"
                                                                    value="{{ $item->nisn }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 mb-1">
                                                            <div class="form-group">
                                                                <label for=""
                                                                    class="col-form-label">Nama</label>
                                                                <input type="text" name="name" id=""
                                                                    placeholder="Masukan nama" class="form-control"
                                                                    value="{{ $item->name }}" required>
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
                                                                <label for="" class="col-form-label">Kelas</label>
                                                                <select class="form-control select2" name="id_kelas" style="width: 100%" required>
                                                                    @foreach ($kelas as $data)
                                                                        <option value="{{ $data->id}}" {{ $data->id == $item->id_kelas ? 'selected' : '' }}> {{ $data->kelas }}</option>
                                                                    @endforeach
                                                                </select>
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
                                                        <div class="col-md-12 mb-1">
                                                            <div class="form-group">
                                                                <label for=""
                                                                    class="col-form-label">Foto</label>
                                                                <input type="file" name="foto"
                                                                    id="" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 mb-1">
                                                            <div class="form-group">
                                                                <label for=""
                                                                    class="col-form-label">Alamat</label>
                                                                <textarea name="alamat" id="" cols="30" rows="2" class="form-control">{{ $item->alamat }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 mb-1">
                                                            <div class="form-group">
                                                                <label for=""
                                                                    class="col-form-label">Latitude</label>
                                                                <input type="text" name="lat"
                                                                    id=""
                                                                    placeholder="Masukan latitude"
                                                                    class="form-control" value="{{ $item->lat }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 mb-1">
                                                            <div class="form-group">
                                                                <label for=""
                                                                    class="col-form-label">Longitude</label>
                                                                <input type="text" name="long"
                                                                    id=""
                                                                    placeholder="Masukan longitude"
                                                                    class="form-control" value="{{ $item->long }}">
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
                    <h4 class="modal-title" id="myModalLabel">Tambah Data Siswa</h4>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/pengguna/siswa/add" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 mb-1">
                                <div class="form-group">
                                    <label for="" class="col-form-label">NISN</label>
                                    <input type="text" name="nisn" id="" placeholder="Masukan nisn"
                                        class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-1">
                                <div class="form-group">
                                    <label for="" class="col-form-label">Nama</label>
                                    <input type="text" name="name" id="" placeholder="Masukan nama"
                                        class="form-control" required>
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
                                    <label for="" class="col-form-label">Kelas</label>
                                    <select class="form-control select2" name="id_kelas" style="width: 100%">
                                        <option selected="selected">Pilih Kelas</option>
                                        @foreach ($kelas as $data)
                                            <option value="{{ $data->id }}">{{ $data->kelas }}</option>
                                        @endforeach
                                    </select>
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
                                    <label for="" class="col-form-label">Foto</label>
                                    <input type="file" name="foto" id="" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12 mb-1">
                                <div class="form-group">
                                    <label for="" class="col-form-label">Alamat</label>
                                    <textarea name="alamat" id="" cols="30" rows="2" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6 mb-1">
                                <div class="form-group">
                                    <label for=""
                                        class="col-form-label">Latitude</label>
                                    <input type="text" name="lat"
                                        id=""
                                        placeholder="Masukan latitude"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6 mb-1">
                                <div class="form-group">
                                    <label for=""
                                        class="col-form-label">Longitude</label>
                                    <input type="text" name="long"
                                        id=""
                                        placeholder="Masukan longitude"
                                        class="form-control">
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
    <form action="/pengguna/siswa/import-excel" method="post" enctype="multipart/form-data">
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

