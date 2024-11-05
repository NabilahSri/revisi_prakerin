@extends('component.template')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
    {{-- <li class="breadcrumb-item"><a href="javascript: void(0)">Manajemen</a></li> --}}
    <li class="breadcrumb-item" aria-current="page">Kelas</li>
@endsection
@section('page_header')
    <h2 class="mb-0">Kelas</h2>
@endsection
@section('content')
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="col">
                    <form action="/kelas/add" method="post">
                        @csrf
                        <div class="row g-3 align-items-center">
                            <div class="col">
                                <input type="text" class="form-control" name="kelas" placeholder="Masukan Kelas"
                                    required />
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-primary"><i class="ti ti-circle-plus"></i> Simpan
                                    Data</button>
                                <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="ti ti-download"></i> Import Data
                                </button>
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
                                <th>Kelas</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kelas as $key => $item)
                                <tr>
                                    <td class="text-start">{{ $key + 1 }}</td>
                                    <td>{{ $item->kelas }}</td>
                                    <td>
                                        <a href="/kelas/delete/{{ $item->id }}"  onclick="return confirmDelete()" class="btn btn-danger d-inline-flex btndelete"><i class="ti ti-trash me-1"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Import -->
    <form action="/kelas/import-excel" method="post" enctype="multipart/form-data">
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


