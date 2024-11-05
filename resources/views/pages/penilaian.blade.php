@php
    use App\Models\Penilaian;
    use App\Models\Monitoring;
    use App\Models\Industri;
@endphp
@extends('component.template')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
    {{-- <li class="breadcrumb-item"><a href="javascript: void(0)">Pengguna</a></li> --}}
    <li class="breadcrumb-item" aria-current="page">Penialaian</li>
@endsection
@section('page_header')
    <h2 class="mb-0">Penilaian Siswa</h2>
@endsection
@section('content')
    <div class="col">
        <div class="card">
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table id="example" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-start">Nama</th>
                                <th>Email</th>
                                <th>Kelas</th>
                                <th class="text-start">No Telepon</th>
                                <th>Alamat</th>
                                <th>Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($siswa as $key => $item)
                                <tr>
                                    <td class="text-start">
                                        <div class="d-inline-block align-middle">
                                            @if ($item->foto)
                                                <img src="{{ asset('storage/' . $item->foto) }}" alt="user image" class="img-radius align-top m-r-15" style="width: 40px" />
                                            @else
                                                <img src="../assets/images/user/avatar-9.jpg" alt="user image" class="img-radius align-top m-r-15" style="width: 40px" />
                                            @endif

                                            <div class="d-inline-block">
                                              <h6 class="m-b-0">{{ $item->name }}</h6>
                                              <p class="m-b-0 text-primary">{{ $item->nisn }}</p>
                                            </div>
                                          </div>
                                    </td>
                                    <td>{{ $item->email ? $item->email : '-' }}</td>
                                    <td>{{ $item->kelas->kelas }}</td>
                                    <td class="text-start">{{ $item->telp ? $item->telp : '-' }}</td>
                                    <td>{{ $item->alamat ? $item->alamat : '-' }}</td>
                                    <td>
                                        @if (auth()->user()->level == 'industri')
                                            <a href="#" class="btn btn-warning d-inline-flex" data-bs-toggle="modal" data-bs-target="#nilaiModal{{ $item->id }}"><i class="ti ti-edit me-1"></i></a>
                                        @else
                                            <a href="#" class="btn btn-secondary d-inline-flex" data-bs-toggle="modal" data-bs-target="#hasilNilaiModal{{ $item->id }}"><i class="ti ti-notes me-1"></i></a>
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
    @if (auth()->user()->level == 'industri')
        {{-- Nilai Modal --}}
        @foreach ($siswa as $item)
        @php
            $penilaian = Penilaian::where('id_siswa', $item->id)->first();
        @endphp
        <div id="nilaiModal{{ $item->id }}" class="modal fade" tabindex="-1"
            role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">PENILAIAN PEMBIMBING DARI DUNIA USAHA / INDUSTRI / INSTANSI
                        </h4>
                        <button class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form action="{{ $penilaian ? url('/penilaian/' . $penilaian->id) : url('/penilaian') }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                <a class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" href="#pills-home{{ $item->id }}" role="tab" aria-controls="pills-home" aria-selected="true">Penilaian</a>
                                </li>
                                <li class="nav-item">
                                <a class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" href="#pills-profile{{ $item->id }}" role="tab" aria-controls="pills-profile" aria-selected="false">Ketentuan Penilaian</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-home{{ $item->id }}" role="tabpanel" aria-labelledby="pills-home-tab">
                                    <input type="hidden" name="id_siswa" value="{{ $item->id }}">
                                    <div class="table-responsive mb-4">
                                        <table style="width: 100%">
                                            @forelse ($kategori_penilaian as $data)
                                                @php
                                                    $nilai = Penilaian::where('id_siswa',$item->id)->where('id_kategori_penilaian',$data->id)->value('nilai');
                                                    $nilai = $nilai ?? '';
                                                @endphp
                                                <tr>
                                                    <td>{{ $data->kategori }}</td>
                                                    <td>:</td>
                                                    <td>
                                                        <input type="number" name="nilai[{{ $data->id }}]" value="{{ $nilai }}" id="" class="form-control" placeholder="Masukan Nilai..." required>
                                                        <input type="hidden" name="id_kategori_penilaian[]" value="{{ $data->id }}">
                                                    </td>
                                                </tr>
                                            @empty
                                                Tidak Ada Kategori Penilaian
                                            @endforelse
                                        </table>
                                        <div class="col-md-12 mb-1">
                                            <div class="form-group">
                                                <label for=""
                                                    class="col-form-label">Saran dari pembimbing Industri/Dinas/Perusahaan</label>
                                                <textarea name="saran" id="" cols="30" rows="3" class="form-control">{{ $penilaian ? $penilaian->saran : ''  }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <button style="width: 100%" type="submit" class="btn btn-primary">{{ $penilaian ? "Ubah Penilaian" : "Simpan Penilaian" }}</button>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-profile{{ $item->id }}" role="tabpanel" aria-labelledby="pills-profile-tab">
                                    <h5>Kesetaraan predikat dengan nilai:</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Predikat</th>
                                                <th class="text-center">Nilai</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>A: Baik Sekali</td>
                                                <td>86-100</td>
                                            </tr>
                                            <tr>
                                                <td>B: Baik</td>
                                                <td>75-85</td>
                                            </tr>
                                            <tr>
                                                <td>C: Cukup</td>
                                                <td>55-74</td>
                                            </tr>
                                            <tr>
                                                <td>D: Kurang</td>
                                                <td>30-54</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    @endforeach
    @endif

    {{-- Hasil Nilai Modal --}}
    @foreach ($siswa as $item)
        @php
            $monitoring = Monitoring::where('id_siswa',$item->id)->first();
            $industri = Industri::where('id',$monitoring->id_industri)->first();
            $penilaian = Penilaian::where('id_siswa',$item->id)->with('kategori_penilaian')->get();
        @endphp
        <div id="hasilNilaiModal{{ $item->id }}" class="modal fade" tabindex="-1"
            role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">PENILAIAN PEMBIMBING DARI DUNIA USAHA / INDUSTRI / INSTANSI
                        </h4>
                        <button class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table style="width: 100%" class="mb-4">
                                <tr>
                                    <td>Nama Tempat Prakerin</td>
                                    <td>:</td>
                                    <td>{{ $industri->name }}</td>
                                </tr>
                                <tr>
                                    <td>Nama Siswa/i</td>
                                    <td>:</td>
                                    <td>{{ $item->name }}</td>
                                </tr>
                                <tr>
                                    <td>Nomor Induk Siswa/1</td>
                                    <td>:</td>
                                    <td>{{ $item->nisn }}</td>
                                </tr>
                            </table>
                            <table style="width: 100%" class="table table-bordered">

                                @if ($penilaian)
                                    <tr>
                                        <th>NO</th>
                                        <th>KOMPONEN YANG DINILAI</th>
                                        <th>NILAI</th>
                                        <th>KET.</th>
                                    </tr>
                                    @foreach ($penilaian as $key => $item)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $item->kategori_penilaian->kategori }}</td>
                                            <td>{{ $item->nilai }}</td>
                                            <td>
                                                @if ($item->nilai >= 86 && $item->nilai <= 100)
                                                    Baik Sekali
                                                @elseif ($item->nilai >= 75 && $item->nilai <= 85)
                                                    Baik
                                                @elseif ($item->nilai >= 55 && $item->nilai <= 74)
                                                    Cukup
                                                @elseif ($item->nilai >= 30 && $item->nilai <= 54)
                                                    Kurang
                                                @else
                                                    Tidak Memadai
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    {{-- <tr>
                                        <td>1</td>
                                        <td>Team Work</td>
                                        <td>{{ $penilaian->tw }}</td>
                                        <td>
                                            @if ($penilaian->tw >= 86 && $penilaian->tw <= 100)
                                                Baik Sekali
                                            @elseif ($penilaian->tw >= 75 && $penilaian->tw <= 85)
                                                Baik
                                            @elseif ($penilaian->tw >= 55 && $penilaian->tw <= 74)
                                                Cukup
                                            @elseif ($penilaian->tw >= 30 && $penilaian->tw <= 54)
                                                Kurang
                                            @else
                                                Tidak Memadai
                                            @endif
                                        </td>
                                    </tr> --}}
                                    {{-- <tr>
                                        <td>2</td>
                                        <td>Implementadi Kerja</td>
                                        <td>{{ $penilaian->i }}</td>
                                        <td>
                                            @if ($penilaian->i >= 86 && $penilaian->i <= 100)
                                                Baik Sekali
                                            @elseif ($penilaian->i >= 75 && $penilaian->i <= 85)
                                                Baik
                                            @elseif ($penilaian->i >= 55 && $penilaian->i <= 74)
                                                Cukup
                                            @elseif ($penilaian->i >= 30 && $penilaian->i <= 54)
                                                Kurang
                                            @else
                                                Tidak Memadai
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>komunikasi</td>
                                        <td>{{ $penilaian->k }}</td>
                                        <td>
                                            @if ($penilaian->k >= 86 && $penilaian->k <= 100)
                                                Baik Sekali
                                            @elseif ($penilaian->k >= 75 && $penilaian->k <= 85)
                                                Baik
                                            @elseif ($penilaian->k >= 55 && $penilaian->k <= 74)
                                                Cukup
                                            @elseif ($penilaian->k >= 30 && $penilaian->k <= 54)
                                                Kurang
                                            @else
                                                Tidak Memadai
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>Inisiatif & Kreatif</td>
                                        <td>{{ $penilaian->ik }}</td>
                                        <td>
                                            @if ($penilaian->ik >= 86 && $penilaian->ik <= 100)
                                                Baik Sekali
                                            @elseif ($penilaian->ik >= 75 && $penilaian->ik <= 85)
                                                Baik
                                            @elseif ($penilaian->ik >= 55 && $penilaian->ik <= 74)
                                                Cukup
                                            @elseif ($penilaian->ik >= 30 && $penilaian->ik <= 54)
                                                Kurang
                                            @else
                                                Tidak Memadai
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>Tanggung Jawab</td>
                                        <td>{{ $penilaian->tj }}</td>
                                        <td>
                                            @if ($penilaian->tj >= 86 && $penilaian->tj <= 100)
                                                Baik Sekali
                                            @elseif ($penilaian->tj >= 75 && $penilaian->tj <= 85)
                                                Baik
                                            @elseif ($penilaian->tj >= 55 && $penilaian->tj <= 74)
                                                Cukup
                                            @elseif ($penilaian->tj >= 30 && $penilaian->tj <= 54)
                                                Kurang
                                            @else
                                                Tidak Memadai
                                            @endif
                                        </td>
                                    </tr> --}}
                                @else
                                    Belum ada penilaian
                                @endif
                            </table>
                            <div class="col-md-12 mb-1">
                                <div class="form-group">
                                    <label for=""
                                        class="col-form-label">Saran dari pembimbing Industri/Dinas/Perusahaan</label>
                                    <textarea id="" cols="30" rows="3" class="form-control" readonly>{{ $item->saran ? $item->saran : ''  }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    @endforeach
@endsection


