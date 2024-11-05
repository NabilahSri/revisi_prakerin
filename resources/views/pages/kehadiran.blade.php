@php
    use Carbon\Carbon;
    use App\Models\Kegiatan;

    Carbon::setLocale('id');
@endphp
@extends('component.template')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
    {{--  <li class="breadcrumb-item"><a href="javascript: void(0)">Aplikasi Mobile</a></li>  --}}
    @if (auth()->user()->level != 'siswa')
        <li class="breadcrumb-item" aria-current="page">Kehadiran & Kegiatan</li>
    @else
        <li class="breadcrumb-item" aria-current="page">Kehadiran</li>
    @endif
@endsection
@section('page_header')
    @if (auth()->user()->level != 'siswa')
        <h2 class="mb-0">Kehadiran & Kegiatan</h2>
    @else
        <h2 class="mb-0">Kehadiran</h2>
    @endif
@endsection
@section('content')
    <div class="col">
        <div class="card">
            @if (auth()->user()->level != 'industri' && auth()->user()->level != 'siswa')
                <div class="card-header">
                    <div class="col">
                        <div class="row g-3 align-items-center">
                            <div class="col">
                                <button type="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kehadiranModal"><i class="ti ti-circle-plus"></i> Tambah Data</button>
                                {{-- @if (auth()->user()->level == 'admin') --}}
                                    <a href="/kehadiran/export_excel" class="btn btn-secondary"><i class="ti ti-upload"></i> Export Data</a>
                                {{-- @endif --}}
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
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Nama Siswa</th>
                                <th>Kelas</th>
                                <th>Jam Masuk</th>
                                <th>Jam Pulang</th>
                                <th>Total Jam</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kehadiran as $key => $item)
                                <tr>
                                    <td>{{ $key+1}}</td>
                                    <td>{{ Carbon::parse($item->tanggal)->translatedFormat('l, d-m-Y') }}</td>
                                    <td>{{ $item->siswa->name }}</td>
                                    <td>{{ $item->siswa->kelas->kelas }}</td>
                                    <td>{{ $item->jam_masuk ? $item->jam_masuk : '-' }}</td>
                                    <td>{{ $item->jam_pulang ? $item->jam_pulang : '-' }}</td>
                                    <td>
                                        @if ($item->jam_masuk && $item->jam_pulang)
                                            <?php
                                            // Hitung perbedaan waktu antara jam masuk dan jam pulang
                                            $jamMasuk = strtotime($item->jam_masuk);
                                            $jamPulang = strtotime($item->jam_pulang);
                                            $selisihWaktu = $jamPulang - $jamMasuk;

                                            // Konversi selisih waktu ke dalam format jam:menit
                                            $totalJam = floor($selisihWaktu / 3600); // 1 jam = 3600 detik
                                            $totalMenit = floor(($selisihWaktu % 3600) / 60);

                                            // Tampilkan total jam
                                            echo $totalJam . ' jam ' . $totalMenit . ' menit';
                                            ?>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->status == 'hadir')
                                            <span class="badge rounded-pill text-bg-success">Hadir</span>
                                        @elseif ($item->status == 'izin')
                                            <span class="badge rounded-pill text-bg-warning">Izin</span>
                                        @else
                                            <span class="badge rounded-pill text-bg-secondary">Sakit</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->status == 'hadir')
                                            <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#kegiatanModal{{ $item->id }}">Lihat Kegiatan</a>
                                        @else
                                            <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#detailModal{{ $item->id }}">Lihat Keterangan</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @if (auth()->user()->level != 'siswa')
        {{-- Kehadiran Modal --}}
        <div id="kehadiranModal" class="modal fade" tabindex="-1"
        role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Tambah Kehadiran Siswa
                    </h4>
                    <button class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form action="/kehadiran/add" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 mb-1">
                                <div class="form-group">
                                    <label for="" class="col-form-label">Nama Siswa</label>
                                    <select class="form-control" name="id_siswa" style="width: 100%">
                                        <option selected="selected">Pilih Siswa</option>
                                        @foreach ($siswa as $data)
                                            <option value="{{ $data->id }}">{{ $data->name }} - {{ $data->kelas->kelas }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mb-1">
                                <div class="form-group">
                                    <label for=""
                                        class="col-form-label">Tanggal</label>
                                    <input type="date" name="tanggal" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-1">
                                <label class="col-form-label mb-3">Status kehadiran</label>
                                <div class="col-sm-9">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" value="hadir">
                                    <label class="form-check-label"> Hadir </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" value="sakit">
                                    <label class="form-check-label"> Sakit </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" value="izin">
                                    <label class="form-check-label"> Izin </label>
                                </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-1">
                                <div class="form-group">
                                    <label for="" class="col-form-label">Catatan <small class="form-text text-danger">(Optional)</small></label>
                                    <input type="text" name="catatan"
                                        id=""
                                        placeholder="Masukan catatan"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6 mb-1">
                                <div class="form-group">
                                    <label for=""
                                        class="col-form-label">Bukti <small class="form-text text-danger">(Optional)</small></label>
                                    <input type="file" name="bukti"
                                        id="" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    @endif
    @foreach ($kehadiran as $key => $item)
    {{-- Modal Kegiatan --}}
    <div class="modal fade" id="kegiatanModal{{ $item->id }}" tabindex="-1">
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
                                <th>Aktivitas/Kegiatan Harian</th>
                                <th>Foto Kegiatan</th>
                                <th>Durasi (menit)</th>
                            </tr>
                            @php
                                $kegiatan = Kegiatan::where('id_kehadiran', $item->id)
                                    ->get();
                                $totalDurasi = array_sum($kegiatan->pluck('durasi')->toArray());
                                $jam = floor($totalDurasi / 60);
                                $menit = $totalDurasi % 60;
                            @endphp
                            @foreach ($kegiatan as $key => $data)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $data->deskripsi }}</td>
                                    <td>
                                        @if ($data->foto)
                                            <img src="{{ asset('storage/' . $data->foto) }}" alt="foto"
                                                style="border-radius: 50%; width: 100px; height: 100px;">
                                        @else
                                            <span class="text-danger">Tidak ada foto kegiatan</span>
                                        @endif
                                    </td>
                                    <td>{{ $data->durasi }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <th colspan = '2'></th>
                                <th>Total Durasi</th>
                                <th>{{ $jam }} jam {{ $menit }} menit</th>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="modal-footer modal-footer-uniform d-flex justify-content-end">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Kembali</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Detail --}}
    <div class="modal fade" id="detailModal{{ $item->id }}" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Keterangan {{ $item->siswa->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="catatan" class="form-label">Catatan</label>
                                <input type="text" name="catatan" id="catatan" value="{{ $item->catatan }}"
                                    class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="bukti" class="form-label">Bukti</label>
                                @if ($item->bukti)
                                    <img src="{{ asset('storage/' . $item->bukti) }}" alt="bukti"
                                        style="border-radius: 2%; height:200px;" class="img-fluid">
                                @else
                                    <span class="text-danger">Tidak Ada Bukti</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer modal-footer-uniform d-flex justify-content-end">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Kembali</button>
                </div>
            </div>
        </div>
    </div>
    @endforeach
@endsection
