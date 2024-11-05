@extends('component.template')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="javascript: void(0)">Token</a></li>
    <li class="breadcrumb-item" aria-current="page">Token Keluar</li>
@endsection
@section('page_header')
    <h2 class="mb-0">Token Keluar</h2>
@endsection
@section('content')
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="col">
                    <form action="/token/keluar/add" method="post">
                        @csrf
                        <button type="submit" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#exampleModal">Generate Token</button>
                    </form>
                </div>
            </div>
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table id="example" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-start">No</th>
                                <th class="text-start">Token Keluar</th>
                                <th class="text-start">Kadaluarsa Pada</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($token_keluar as $key => $item)
                                <tr>
                                    <td class="text-start">{{ $key + 1 }}</td>
                                    <td class="text-start">{{ $item->token }}</td>
                                    <td class="text-start">{{ $item->kadaluarsa_pada }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
