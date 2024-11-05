@php
    use Carbon\Carbon;
    Carbon::setLocale('id');
@endphp

@extends('component.template')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="javascript: void(0)">Lainnya</a></li>
    <li class="breadcrumb-item" aria-current="page">Log Aktivitas</li>
@endsection
@section('page_header')
    <h2 class="mb-0">Log Aktivitas</h2>
@endsection
@section('content')
    <div class="col">
        <div class="card">
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table id="example" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-start">No</th>
                                <th>Username</th>
                                <th>Hak Akses</th>
                                <th>Aktivitas</th>
                                <th class="text-start">Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($log_aktivitas as $key => $item)
                                <tr>
                                    <td class="text-start">{{ $key+1}}</td>
                                    <td>{{ $item->username }}</td>
                                    <td>{{ $item->level }}</td>
                                    <td>{{ $item->aktivitas }}</td>
                                    <td class="text-start">{{ Carbon::parse($item->waktu)->translatedFormat('l, d-m-Y H:m:s') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
