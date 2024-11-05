@php
    use App\Models\Monitoring;
    use App\Models\Siswa;
@endphp

@extends('component.template')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
    {{-- <li class="breadcrumb-item"><a href="javascript: void(0)">Manajemen</a></li> --}}
    <li class="breadcrumb-item" aria-current="page">Monitoring</li>
@endsection
@section('page_header')
    <h2 class="mb-0">Kelompok Monitoring Prakerin</h2>
@endsection
@section('content')
    <div class="col">
        <div class="card">
            @if (auth()->user()->level == 'admin')
                <div class="card-header">
                    <div class="col">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal"><i class="ti ti-circle-plus"></i> Tambah Data</button>
                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="ti ti-download"></i> Import Data</button>
                    </div>
                </div>
            @endif
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table id="example" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-start">No</th>
                                <th>Nama Pemonitor</th>
                                <th>Nama Industri</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($monitoring as $key => $item)
                                <tr>
                                    <td class="text-start">{{ $key + 1 }}</td>
                                    <td>{{ $item->pemonitor->name }}</td>
                                    <td>{{ $item->industri->name }}</td>
                                    <td>
                                        @if (auth()->user()->level == 'admin')
                                            <a href="#" class="btn btn-warning d-inline-flex" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id_industri }}"><i class="ti ti-edit me-1"></i></a>
                                            <a href="/monitoring/delete/{{ $item->id_industri }}"  onclick="return confirmDelete()" class="btn btn-danger d-inline-flex"><i class="ti ti-trash me-1"></i></a>
                                        @endif
                                        <a href="#" class="btn btn-success d-inline-flex" data-bs-toggle="modal" data-bs-target="#rincianModal{{ $item->id_industri }}"><i class="ti ti-eye me-1"></i></a>
                                    </td>
                                </tr>
                                {{-- Modal Edit --}}
                                <div id="editModal{{ $item->id_industri }}" class="modal fade" tabindex="-1"
                                    role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">Edit Kelompok
                                                    Monitoring Prakerin
                                                </h4>
                                                <button class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="/monitoring/edit/{{ $item->id_industri }}"
                                                method="post">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for=""
                                                                    class="form-label">Pemonitor</label>
                                                                <select name="id_pemonitor" id=""
                                                                    class="form-control select2"
                                                                    style="width: 100%" required>
                                                                    @foreach ($pemonitor as $data)
                                                                        <option value="{{ $data->id }}" {{ $data->id == $item->pemonitor->id ? 'selected' : '' }}>{{ $data->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for=""
                                                                    class="form-label">Industri</label>
                                                                <select name="id_industri" id=""
                                                                    class="form-control select2"
                                                                    style="width: 100%" required>
                                                                    @foreach ($industri as $data)
                                                                        <option value="{{ $data->id }}" {{ $data->id == $item->industri->id ? 'selected' : '' }}>
                                                                            {{ $data->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        @php
                                                            $siswa1 = Siswa::all();
                                                            $monitoring1 = Monitoring::where(
                                                                'id_industri',
                                                                $item->id_industri,
                                                            )
                                                                ->with('siswa')
                                                                ->get();
                                                        @endphp
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="form-label">Nama Siswa</label>
                                                                <select name="id_siswa[]"
                                                                    class="form-control select2"
                                                                    multiple="multiple"
                                                                    data-placeholder="Pilih Siswa"
                                                                    style="width: 100%;" required>
                                                                    @foreach ($monitoring1 as $siswaa)
                                                                        <option
                                                                            value="{{ $siswaa->siswa->id }}"
                                                                            selected>
                                                                            {{ $siswaa->siswa->name }} -
                                                                            {{ $siswaa->siswa->kelas->kelas }}
                                                                        </option>
                                                                    @endforeach
                                                                    @foreach ($siswa as $data)
                                                                        <option value="{{ $data->id }}">
                                                                            {{ $data->name }} -
                                                                            {{ $data->kelas->kelas }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
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

    <!-- Modal Tambah-->
    <div id="addModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Tambah Data Monitoring kelompok Prakerin</h4>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/monitoring/add" method="post">
                    @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="form-label">Pemonitor</label>
                                <select name="id_pemonitor" id="" class="form-control select2"
                                    style="width: 100%" required>
                                    <option selected="selected">Pilih pemonitor</option>
                                    @foreach ($pemonitor as $data)
                                        <option value="{{ $data->id }}">
                                            {{ $data->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="form-label">Industri</label>
                                <select name="id_industri" id="" class="form-control select2"
                                    style="width: 100%" required>
                                    <option selected="selected">Pilih industri</option>
                                    @foreach ($industri as $data)
                                        <option value="{{ $data->id }}">
                                            {{ $data->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Nama Siswa</label>
                                <select name="id_siswa[]" class="form-control select2" multiple="multiple"
                                    data-placeholder="Pilih Siswa" style="width: 100%;" required>
                                    @foreach ($siswa as $data)
                                        <option value="{{ $data->id }}">{{ $data->name }} -
                                            {{ $data->kelas->kelas }}</option>
                                    @endforeach
                                </select>
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
    <form action="/monitoring/import-excel" method="post" enctype="multipart/form-data">
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
    <!-- Modal Rinci-->
    @foreach ($monitoring as $item)
        <div id="rincianModal{{ $item->id_industri }}" class="modal fade" tabindex="-1"
            role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Kelompok {{ $item->industri->name }}</h4>
                        <button class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <tr>
                                    <th>NISN</th>
                                    <th>Nama</th>
                                    <th>Kelas</th>
                                    <th>No Telepon</th>
                                </tr>
                                @php
                                    $siswa = Monitoring::with('siswa')
                                        ->where('id_industri', $item->id_industri)
                                        ->get()
                                        ->pluck('siswa')
                                        ->unique('id');
                                @endphp
                                @foreach ($siswa as $data)
                                    <tr>
                                        <td>{{ $data->nisn }}</td>
                                        <td>{{ $data->name }}</td>
                                        <td>{{ $data->kelas->kelas }}</td>
                                        <td>{{ $data->telp ? $data->telp : '-' }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">Selesai</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
