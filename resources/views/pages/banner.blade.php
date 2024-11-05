@php
    use Carbon\Carbon;
    Carbon::setLocale('id');
@endphp
@extends('component.template')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
    {{--  <li class="breadcrumb-item"><a href="javascript: void(0)">Aplikasi Mobile</a></li>  --}}
    <li class="breadcrumb-item" aria-current="page">Spanduk</li>
@endsection
@section('page_header')
    <h2 class="mb-0">Spanduk</h2>
@endsection
@section('content')
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="col">
                    <div class="row g-3 align-items-center">
                        <div class="col">
                            <button type="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal"><i class="ti ti-circle-plus"></i> Tambah
                                Data</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table id="example" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-start">No</th>
                                <th class="text-start">Tanggal dibuat</th>
                                <th>Nama</th>
                                <th>Gambar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($banner as $key => $item)
                                <tr>
                                    <td class="text-start">{{ $key+1}}</td>
                                    <td class="text-start">{{ Carbon::parse($item->tanggal)->translatedFormat('l, d-m-Y') }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>
                                        @if ($item->gambar)
                                            <img src="{{ asset('storage/' . $item->gambar) }}" alt="" class="m-r-15" style="width: 150px" />
                                        @else
                                            <img src="https://www.littlethings.info/wp-content/uploads/2014/04/dummy-image-green-e1398449160839.jpg" alt="" class="m-r-15" style="width: 150px" />
                                        @endif
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-warning d-inline-flex" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}"><i class="ti ti-edit me-1"></i></a>
                                        <a href="/banner/delete/{{ $item->id }}"  onclick="return confirmDelete()" class="btn btn-danger d-inline-flex"><i class="ti ti-trash me-1"></i></a>
                                        <a href="#" class="btn btn-success d-inline-flex" data-bs-toggle="modal" data-bs-target="#detailModal{{ $item->id }}"><i class="ti ti-eye me-1"></i></a>
                                    </td>
                                </tr>
                                {{-- Edit Modal --}}
                                <div id="editModal{{ $item->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">Edit Data Spanduk</h4>
                                                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="/banner/edit/{{ $item->id }}" method="post" enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-6 mb-1">
                                                            <div class="form-group">
                                                                <label for="" class="form-label">Tanggal dibuat</label>
                                                                <input type="date" name="tanggal" id="" placeholder="Masukan tanggal"
                                                                    class="form-control" value="{{ $item->tanggal }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 mb-1">
                                                            <div class="form-group">
                                                                <label for="" class="form-label">Nama</label>
                                                                <input type="text" name="name" id="" placeholder="Masukan nama"
                                                                    class="form-control" value="{{ $item->name }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 mb-1">
                                                            <div class="form-group">
                                                                <label for="" class="form-label">Gambar</label>
                                                                <input type="file" name="gambar" id="" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 mb-1">
                                                            <div class="form-group">
                                                                <label for="" class="form-label">Deskripsi</label>
                                                                <textarea id="mytextarea" name="deskripsi" cols="30" rows="2" class="form-control">{{ $item->deskripsi }}</textarea>
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
                    <h4 class="modal-title" id="myModalLabel">Tambah Data Spanduk</h4>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/banner/add" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-1">
                                <div class="form-group">
                                    <label for="" class="form-label">Tanggal dibuat</label>
                                    <input type="date" name="tanggal" id="" placeholder="Masukan tanggal"
                                        class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-1">
                                <div class="form-group">
                                    <label for="" class="form-label">Nama</label>
                                    <input type="text" name="name" id="" placeholder="Masukan nama"
                                        class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-12 mb-1">
                                <div class="form-group">
                                    <label for="" class="form-label">Gambar</label>
                                    <input type="file" name="gambar" id="" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12 mb-1">
                                <div class="form-group">
                                    <label for="" class="form-label">Deskripsi</label>
                                    <textarea id="mytextarea" name="deskripsi" cols="30" rows="2" class="form-control"></textarea>
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
    {{-- detail Modal --}}
    @foreach ($banner as $item)
    <div class="modal fade" id="detailModal{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Detail Spanduk</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <h3>{{ $item->name }}</h3>
                    </div>
                    <div class="row">
                            @if ($item->gambar)
                                <img src="{{ asset('storage/'.$item->gambar) }}" alt="" width="150px">
                            @else
                            <img src="https://www.littlethings.info/wp-content/uploads/2014/04/dummy-image-green-e1398449160839.jpg" alt="" style="width: 100%" />
                            @endif
                    </div>
                    <div class="row mb-3">
                        <small>{{ Carbon::parse($item->tanggal)->translatedFormat('l, d-m-Y') }}</small>
                    </div>
                    <div class="row">
                        {!! $item->deskripsi !!}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Selesai</button>
                </div>
            </div>
        </div>
    </div>
    @endforeach
@endsection
