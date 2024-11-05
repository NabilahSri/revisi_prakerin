@php
    use Carbon\Carbon;

    Carbon::setLocale('id');
@endphp
@extends('component.template')
@section('page_header')
    <h2 class="mb-0">Dashboard</h2>
@endsection
@section('content')
    @if (auth()->user()->level == 'admin')
        <div class="col-md-6 col-xxl-4">
            <div class="card statistics-card-1">
                <div class="card-body">
                    <img src="../assets/images/widget/img-status-2.svg" alt="img" class="img-fluid img-bg" />
                    <div class="d-flex align-items-center">
                        <div class="avtar bg-brand-color-1 text-white me-3">
                            <i class="ph-duotone ph-user f-26"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-0">Pengguna Role Admin</p>
                            <div class="d-flex align-items-end">
                                <h2 class="mb-0 f-w-500">{{ $admin }}<small class="text-muted"> Admin</small></h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xxl-4">
            <div class="card statistics-card-1">
                <div class="card-body">
                    <img src="../assets/images/widget/img-status-1.svg" alt="img" class="img-fluid img-bg" />
                    <div class="d-flex align-items-center">
                        <div class="avtar bg-brand-color-2 text-white me-3">
                            <i class="ph-duotone ph-graduation-cap f-26"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-0">Pengguna Role Siswa</p>
                            <div class="d-flex align-items-end">
                                <h2 class="mb-0 f-w-500">{{ $siswa }}<small class="text-muted"> Siswa</small></h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xxl-4">
            <div class="card statistics-card-1">
                <div class="card-body">
                    <img src="../assets/images/widget/img-status-3.svg" alt="img" class="img-fluid img-bg" />
                    <div class="d-flex align-items-center">
                        <div class="avtar bg-brand-color-3 text-white me-3">
                            <i class="ph-duotone ph-users f-26"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-0">Pengguna Role Pemonitor</p>
                            <div class="d-flex align-items-end">
                                <h2 class="mb-0 f-w-500">{{ $pemonitor }}<small class="text-muted"> Pemonitor</small></h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xxl-4">
            <div class="card statistics-card-1">
                <div class="card-body">
                    <img src="../assets/images/widget/img-status-3.svg" alt="img" class="img-fluid img-bg" />
                    <div class="d-flex align-items-center">
                        <div class="avtar bg-brand-color-3 text-white me-3">
                            <i class="ph-duotone ph-house-simple f-26"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-0">Pengguna Role Industri</p>
                            <div class="d-flex align-items-end">
                                <h2 class="mb-0 f-w-500">{{ $industri }}<small class="text-muted"> Industri</small></h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xxl-8">
            <div class="card">
                <div class="card-header">
                    <h4>Aktivitas Terbaru Pengguna</h4>
                </div>
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table table-striped" style="width:100%">
                            <thead>
                                <tr class="text-center">
                                    <th class="text-start">No</th>
                                    <th>Username</th>
                                    <th>Hak Akses</th>
                                    <th>Aktivitas</th>
                                    <th>Waktu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($log_aktivitas as $key => $item)
                                    <tr class="text-center">
                                        <td class="text-start">{{ $key + 1 }}</td>
                                        <td>{{ $item->username }}</td>
                                        <td>{{ $item->level }}</td>
                                        <td>{{ $item->aktivitas }}</td>
                                        <td>{{ Carbon::parse($item->waktu)->translatedFormat('l, d-m-Y H:i') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @elseif(auth()->user()->level == 'pemonitor')
        <div class="col-md-6 col-xxl-4">
            <div class="card statistics-card-1">
                <div class="card-body">
                    <img src="../assets/images/widget/img-status-2.svg" alt="img" class="img-fluid img-bg" />
                    <div class="d-flex align-items-center">
                        <div class="avtar bg-brand-color-1 text-white me-3">
                            <i class="ph-duotone ph-user f-26"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-0">Total Monitoring</p>
                            <div class="d-flex align-items-end">
                                <h2 class="mb-0 f-w-500">{{ $monitoring }}<small class="text-muted"> Data Monitoring</small></h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @elseif (auth()->user()->level == 'siswa')
    <div class="col-md-6 col-xxl-4">
        <div class="card statistics-card-1">
            <div class="card-body">
                <img src="../assets/images/widget/img-status-3.svg" alt="img" class="img-fluid img-bg" />
                <div class="d-flex align-items-center">
                    <div class="avtar bg-brand-color-3 text-white me-3">
                        <i class="ph-duotone ph-activity f-26"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-0">Total Kegiatan</p>
                        <div class="d-flex align-items-end">
                            <h2 class="mb-0 f-w-500">{{ $kegiatan }}<small class="text-muted"> Kegiatan</small></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xxl-4">
        <div class="card statistics-card-1">
            <div class="card-body">
                <img src="../assets/images/widget/img-status-2.svg" alt="img" class="img-fluid img-bg" />
                <div class="d-flex align-items-center">
                    <div class="avtar bg-brand-color-1 text-white me-3">
                        <i class="ph-duotone ph-check-square f-26"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-0">Status Kehadiran</p>
                        <div class="d-flex align-items-end">
                            <h2 class="mb-0 f-w-500">{{ $hadir }}<small class="text-muted"> Hadir</small></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xxl-4">
        <div class="card statistics-card-1">
            <div class="card-body">
                <img src="../assets/images/widget/img-status-1.svg" alt="img" class="img-fluid img-bg" />
                <div class="d-flex align-items-center">
                    <div class="avtar bg-brand-color-2 text-white me-3">
                        <i class="ph-duotone ph-stethoscope f-26"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-0">Status Kehadiran</p>
                        <div class="d-flex align-items-end">
                            <h2 class="mb-0 f-w-500">{{ $sakit }}<small class="text-muted"> Sakit</small></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xxl-4">
        <div class="card statistics-card-1">
            <div class="card-body">
                <img src="../assets/images/widget/img-status-3.svg" alt="img" class="img-fluid img-bg" />
                <div class="d-flex align-items-center">
                    <div class="avtar bg-brand-color-3 text-white me-3">
                        <i class="ph-duotone ph-note-pencil f-26"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-0">Status Kehadiran</p>
                        <div class="d-flex align-items-end">
                            <h2 class="mb-0 f-w-500">{{ $izin }}<small class="text-muted"> Izin</small></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
        <div class="col-md-6 col-xxl-4">
            <div class="card statistics-card-1">
                <div class="card-body">
                    <img src="../assets/images/widget/img-status-2.svg" alt="img" class="img-fluid img-bg" />
                    <div class="d-flex align-items-center">
                        <div class="avtar bg-brand-color-1 text-white me-3">
                            <i class="ph-duotone ph-user f-26"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-0">Total Siswa</p>
                            <div class="d-flex align-items-end">
                                <h2 class="mb-0 f-w-500">{{ $siswa }}<small class="text-muted"> Data Siswa</small></h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
