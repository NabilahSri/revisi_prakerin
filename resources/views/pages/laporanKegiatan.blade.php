@php
    use App\Models\Kegiatan;
    use Carbon\Carbon;

    Carbon::setLocale('id');
@endphp
@extends('component.template')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="javascript: void(0)">Laporan</a></li>
    <li class="breadcrumb-item" aria-current="page">Kegiatan</li>
@endsection
@section('page_header')
    <h2 class="mb-0">Laporan Kegiatan Siswa</h2>
@endsection
@section('content')
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="col">
                    <form action="/laporan/kegiatan" method="post">
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
                            @else
                                <div class="col">
                                    <div class="form-group">
                                        <select name="id_siswa" id="" class="select2" style="width: 100%;" required>
                                            <option selected="selected">Pilih Siswa</option>
                                            @foreach ($siswa as $data)
                                                <option value="{{ $data->id }}">{{ $data->name }}</option>
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
                <form action="/laporan/kegiatan/export_excel" method="POST">
                    @csrf
                    <input type="hidden" name="tanggal_awal" value="{{ request('tanggal_awal') }}">
                    <input type="hidden" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}">
                    @if(auth()->user()->level == 'admin')
                        <input type="hidden" name="id_kelas" value="{{ request('id_kelas') }}">
                    @else
                        <input type="hidden" name="id_siswa" value="{{ request('id_siswa') }}">
                    @endif
                    <button type="submit" class="btn btn-secondary mb-4"><i class="ti ti-upload"></i> Export Data</button>
                </form>

                {{-- <button  type="button" class="btn btn-secondary mb-4"><i class="ti ti-upload"></i> Export Data </button> --}}
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" style="width:100%">
                        @if (auth()->user()->level == 'admin')
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Siswa</th>
                                    <th>Total Jam Kerja</th>
                                    <th style="width: 100px">Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($kegiatan != null)
                                    @foreach ($kegiatan as $key => $item)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $item->siswa->name }}</td>
                                            <td>{{ $item->total_durasi }}</td>
                                            <td>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#kegiatanModal{{ $item->siswa->id }}" class="btn btn-success btn-sm d-inline-flex">Lihat Detail Kegiatan</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        @else
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Kegiatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($kegiatan != null)
                                    @php
                                        $groupedKegiatan = $kegiatan->groupBy(function($item) {
                                            return Carbon::parse($item->kehadiran->tanggal)->translatedFormat('l, d-m-Y');
                                        });
                                    @endphp
                                    @foreach ($groupedKegiatan as $tanggal => $items)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $tanggal }}</td>
                                            <td>
                                                <ul>
                                                    @foreach ($items as $item)
                                                        <li>{{ $item->deskripsi }}</li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
    @if ($kegiatan != null)
        @foreach ($kegiatan as $key => $item)
        {{-- Modal Kegiatan --}}
        <div class="modal fade" id="kegiatanModal{{ $item->siswa->id }}" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Kegiatan {{ $item->siswa->name }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <tr>
                                    <th>No</th>
                                    <th>Kegiatan</th>
                                </tr>
                                @php
                                    $detail_kegiatan = Kegiatan::where('id_siswa',$item->siswa->id)->get();
                                @endphp
                                @foreach ($detail_kegiatan as $key => $data)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $data->deskripsi }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer modal-footer-uniform d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Kembali</button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    @endif
@endsection
