@extends('component.template')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="javascript: void(0)">Lainnya</a></li>
    <li class="breadcrumb-item" aria-current="page">Penganturan Aplikasi</li>
@endsection
@section('page_header')
    <h2 class="mb-0">Penganturan Aplikasi</h2>
@endsection
@section('content')
    <div class="col">
        <div class="card">
            <div class="card-body table-border-style">
                <div class="col">
                    <div class="row mb-3">
                        <div class="col">
                            <h4>Logo 1</h4>
                            <img src="https://www.littlethings.info/wp-content/uploads/2014/04/dummy-image-green-e1398449160839.jpg" alt="user image" style="width: 32%; border-radius:10%" />
                        </div>
                        <div class="col">
                            <h4>Logo 2</h4>
                            <img src="https://www.littlethings.info/wp-content/uploads/2014/04/dummy-image-green-e1398449160839.jpg" alt="user image" style="width: 32%; border-radius:10%" />
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6 mb-1">
                            <div class="form-group">
                                <label for="" class="form-label">Nama Aplikasi</label>
                                <input type="text" name="nama_aplikasi" id="" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                    {{--  <div class="row">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>  --}}
                </div>
            </div>
        </div>
    </div>
@endsection
