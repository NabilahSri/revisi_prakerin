@extends('component.template')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="javascript: void(0)">Laporan</a></li>
    <li class="breadcrumb-item" aria-current="page">Kehadiran</li>
@endsection
@section('page_header')
    <h2 class="mb-0">Laporan Kehadiran Siswa</h2>
@endsection
@section('content')
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="col">
                    <form action="/laporan/kehadiran" method="post">
                        @csrf
                        <div class="row g-3 align-items-center">
                            <div class="col">
                                <input type="date" class="form-control" name="tanggal_awal" required />
                            </div>
                            <div class="col">
                                <input type="date" class="form-control" name="tanggal_akhir"/>
                            </div>
                            @if (auth()->user()->level == 'admin')
                                <div class="col">
                                    <div class="form-group">
                                        <select name="id_kelas" id="" class="select2" style="width: 100%;" required>
                                            <option selected="selected">Pilih Kelas</option>
                                            @foreach ($kelas as $data)
                                                <option value="{{ $data->id }}">{{ $data->kelas }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endif
                            <div class="col">
                                <button type="submit" class="btn btn-primary"><i class="ti ti-search"></i> Cari Data</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-body table-border-style">
                <form action="/laporan/kehadiran/export_excel" method="POST">
                    @csrf
                    <input type="hidden" name="tanggal_awal" value="{{ request('tanggal_awal') }}">
                    <input type="hidden" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}">
                    @if(auth()->user()->level == 'admin')
                        <input type="hidden" name="id_kelas" value="{{ request('id_kelas') }}">
                    @endif
                    <button type="submit" class="btn btn-secondary mb-4"><i class="ti ti-upload"></i> Export Data</button>
                </form>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Siswa</th>
                                <th>Total Hadir</th>
                                <th>Total Sakit</th>
                                <th>Total Izin</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($kehadiran != null)
                                @foreach ($kehadiran as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $item->siswa->name }}</td>
                                        <td>{{ $item->where('status', 'hadir')->where('id_siswa', $item->siswa->id)->count() }}
                                            Hari
                                        </td>
                                        <td>{{ $item->where('status', 'sakit')->where('id_siswa', $item->siswa->id)->count() }}
                                            Hari
                                        </td>
                                        <td>{{ $item->where('status', 'izin')->where('id_siswa', $item->siswa->id)->count() }}
                                            Hari
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
