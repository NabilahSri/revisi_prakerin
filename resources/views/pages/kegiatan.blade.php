@php
    use Carbon\Carbon;
    use App\Models\Kehadiran;
    use App\Models\Kegiatan;
    Carbon::setLocale('id');
@endphp
@extends('component.template')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
    {{-- <li class="breadcrumb-item"><a href="javascript: void(0)">Pengguna</a></li> --}}
    <li class="breadcrumb-item" aria-current="page">Kegiatan</li>
@endsection
@section('page_header')
    <h2 class="mb-0">Kegiatan</h2>
@endsection
@section('content')
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="col">
                    <button type="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal"><i class="ti ti-circle-plus"></i> Tambah Kegiatan</button>
                </div>
            </div>
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table id="example" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-start">No</th>
                                <th>Tanggal</th>
                                <th>Deskripsi Kegiatan</th>
                                <th>Durasi Pengerjaan</th>
                                <th>Foto Kegiatan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kegiatan as $key=>$item)
                                <tr>
                                    <td class="text-start">{{ $key +1 }}</td>
                                    <td>{{ Carbon::parse($item->kehadiran->tanggal)->translatedFormat('l, d-m-Y') }}</td>
                                    <td>{{ $item->deskripsi }}</td>
                                    <td>{{ $item->durasi }} menit</td>
                                    <td>
                                        @if ($item->foto)
                                            <img src="{{ asset('storage/' . $item->foto) }}" alt="user image" class="img-radius align-top m-r-15" style="width: 40px" />
                                        @else
                                            <p class="text-danger">Tidak Ada Foto Kegiatan</p>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-warning d-inline-flex" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}"><i class="ti ti-edit me-1"></i></a>
                                        <a href="/kegiatan/delete/{{ $item->id }}"  onclick="return confirmDelete()" class="btn btn-danger d-inline-flex"><i class="ti ti-trash me-1"></i></a>
                                    </td>
                                </tr>
                                <!-- Edit Tambah-->
                                <div id="editModal{{ $item->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">Tambah Kegiatan</h4>
                                                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="/kegiatan/edit/{{ $item->id }}" method="post" enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-6 mb-1">
                                                            <div class="form-group">
                                                                <label for="" class="col-form-label">Tanggal Kehadiran</label>
                                                                <select class="form-control select2" name="id_kehadiran" style="width: 100%">
                                                                    @foreach ($tanggal_kehadiran as $data)
                                                                        <option value="{{ $data->kehadiran->id }}" {{ $data->kehadiran->id == $item->kehadiran->id ? 'selected' : '' }}>{{ Carbon::parse($data->kehadiran->tanggal)->translatedFormat('l, d-m-Y') }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 mb-1">
                                                            <div class="form-group">
                                                                <label for="" class="col-form-label">Deskripsi Kegiatan</label>
                                                                <input type="text" name="deskripsi" id="" placeholder="Masukan deskripsi kegiatan"
                                                                    class="form-control" value="{{ $item->deskripsi }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 mb-1">
                                                            <div class="form-group">
                                                                <label for="" class="col-form-label">Durasi Pengerjaan (menit)</label>
                                                                <input type="number" name="durasi" value="{{ $item->durasi }}" id="" placeholder="Masukan durasi pengerjaan"
                                                                    class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 mb-1">
                                                            <div class="form-group">
                                                                <label for="" class="col-form-label">Foto</label>
                                                                <input type="file" name="foto" id="" class="form-control">
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
                    <h4 class="modal-title" id="myModalLabel">Tambah Kegiatan</h4>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/kegiatan/add" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-1">
                                <div class="form-group">
                                    <label for="" class="col-form-label">Tanggal Kehadiran</label>
                                    <select class="form-control select2" name="id_kehadiran" style="width: 100%">
                                        <option selected="selected">Pilih Tanggal</option>
                                        @foreach ($tanggal_kehadiran as $data)
                                            <option value="{{ $data->kehadiran->id }}">{{ Carbon::parse($data->kehadiran->tanggal)->translatedFormat('l, d-m-Y') }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mb-1">
                                <div class="form-group">
                                    <label for="" class="col-form-label">Deskripsi Kegiatan</label>
                                    <input type="text" name="deskripsi" id="" placeholder="Masukan deskripsi kegiatan"
                                        class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-1">
                                <div class="form-group">
                                    <label for="" class="col-form-label">Durasi Pengerjaan (menit)</label>
                                    <input type="number" name="durasi" id="" placeholder="Masukan durasi pengerjaan"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6 mb-1">
                                <div class="form-group">
                                    <label for="" class="col-form-label">Foto</label>
                                    <input type="file" name="foto" id="" class="form-control">
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
@endsection
