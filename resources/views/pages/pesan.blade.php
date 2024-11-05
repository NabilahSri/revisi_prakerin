@php
    use Carbon\Carbon;
    use App\Models\Pesan;
    use App\Models\Siswa;

    Carbon::setLocale('id');
@endphp
@extends('component.template')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
    <li class="breadcrumb-item" aria-current="page">Pesan</li>
@endsection
@section('page_header')
    <h2 class="mb-0">Kirim Pesan</h2>
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
                                <th>Kelas</th>
                                <th class="text-start">No Telepon</th>
                                <th>Tempat Prakerin</th>
                                <th>Kirim Pesan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($monitoring as $key => $item)
                                <tr>
                                    <td class="text-start">
                                        <div class="d-inline-block align-middle">
                                            @if ($item->siswa->foto)
                                                <img src="{{ asset('storage/' . $item->siswa->foto) }}" alt="user image" class="img-radius align-top m-r-15" style="width: 40px" />
                                            @else
                                                <img src="../assets/images/user/avatar-9.jpg" alt="user image" class="img-radius align-top m-r-15" style="width: 40px" />
                                            @endif
                                            <div class="d-inline-block">
                                              <h6 class="m-b-0">{{ $item->siswa->name }}</h6>
                                              <p class="m-b-0 text-primary">{{ $item->siswa->nisn }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $item->siswa->kelas->kelas }}</td>
                                    <td class="text-start">{{ $item->siswa->telp ? $item->siswa->telp : '-' }}</td>
                                    <td>{{ $item->industri->name }}</td>
                                    <td>
                                        <a href="#" class="btn btn-light-secondary d-inline-flex" data-bs-toggle="modal" data-bs-target="#kirimPesanModal{{ $item->siswa->id_user }}"><i class="ti ti-send me-1"></i></a>
                                    </td>
                                </tr>
                                {{-- Kirim Pesan Modal --}}
                                <div id="kirimPesanModal{{ $item->siswa->id_user }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">Pesan {{ $item->siswa->id_user }}</h4>
                                                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form id="pesanForm{{ $item->siswa->id_user }}" action="/pesan/{{ $item->siswa->id_user }}" method="post" class="ajax-form">
                                                @csrf
                                                <div class="modal-body">
                                                    @php
                                                        $userId = auth()->user()->id;
                                                        $pesanUser = Pesan::where(function ($query) use ($userId, $item) {
                                                                $query->where('id_penerima', $userId)
                                                                    ->where('id_pengirim', $item->siswa->id_user);
                                                            })
                                                            ->orWhere(function ($query) use ($userId, $item) {
                                                                $query->where('id_penerima', $item->siswa->id_user)
                                                                    ->where('id_pengirim', $userId);
                                                            })
                                                            ->with(['userPengirim.siswa', 'userPenerima.siswa'])
                                                            ->get();
                                                        $namaPengirimPenerima = [];
                                                        foreach ($pesanUser as $pesan) {
                                                            if (!isset($namaPengirimPenerima[$pesan->id_pengirim])) {
                                                                $namaPengirimPenerima[$pesan->id_pengirim] = Siswa::where('id_user', $pesan->id_pengirim)->first()->name ?? 'Tidak diketahui';
                                                            }
                                                            if (!isset($namaPengirimPenerima[$pesan->id_penerima])) {
                                                                $namaPengirimPenerima[$pesan->id_penerima] = Siswa::where('id_user', $pesan->id_penerima)->first()->name ?? 'Tidak diketahui';
                                                            }
                                                        }
                                                    @endphp
                                                    <div class="pesan-container" style="overflow-y: auto; max-height: 500px;">
                                                        @forelse ($pesanUser as $pesans)
                                                        <div class="row mb-2">
                                                            <div class="col-12 mb-1 d-flex align-items-center">
                                                                @if ($pesans->id_pengirim != auth()->user()->id)
                                                                    <img src="{{ asset('storage/' . $item->siswa->foto) }}" alt="user image" class="img-radius align-top m-r-15" style="width: 40px" />
                                                                @else
                                                                    <img src="../assets/images/user/avatar-2.jpg" alt="user image" class="img-radius align-top m-r-15" style="width: 40px" />
                                                                @endif
                                                                <div class="col">
                                                                    <h6 class="mb-0">{{ $pesans->id_pengirim == auth()->user()->id ? 'Anda' : $namaPengirimPenerima[$pesans->id_pengirim]}} kepada {{ $pesans->id_penerima == auth()->user()->id ? 'anda' : $namaPengirimPenerima[$pesans->id_penerima]}}</h6>
                                                                    <small>{{ Carbon::parse($pesans->tanggal_kirim)->translatedFormat('l, d-m-Y H:i') }}</small>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <p>{{ $pesans->pesan }}</p>
                                                            </div>
                                                        </div>
                                                        @empty
                                                            <p>Belum ada pesan untuk pengguna ini.</p>
                                                        @endforelse
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                   <div class="col">
                                                       <div class="input-group">
                                                           <input type="text" class="form-control" placeholder="Masukan Pesan..." name="pesan" required>
                                                           <button class="btn btn-outline-secondary" type="submit">Kirim</button>
                                                       </div>
                                                   </div>
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
@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        $('.modal').on('shown.bs.modal', function () {
            var modalBody = $(this).find('.pesan-container'); // Dapatkan elemen kontainer pesan
            modalBody.scrollTop(modalBody[0].scrollHeight); // Gulir ke bawah
        });

        $('form.ajax-form').on('submit', function (e) {
            e.preventDefault();

            let form = $(this);
            let formData = form.serialize();
            let url = form.attr('action');
            let modalBody = form.closest('.modal-content').find('.pesan-container');

            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                success: function (response) {
                    modalBody.append(`
                        <div class="row mb-2">
                            <div class="col-12 mb-1 d-flex align-items-center">
                                <img src="../assets/images/user/avatar-2.jpg" alt="user image" class="img-radius align-top m-r-15" style="width: 40px" />
                                <div class="col">
                                    <h6 class="mb-0">Anda kepada ${response.nama_penerima}</h6>
                                    <small>${response.tanggal_kirim}</small>
                                </div>
                            </div>
                            <div class="col-12">
                                <p>${response.pesan}</p>
                            </div>
                        </div>
                    `);
                    modalBody.scrollTop(modalBody[0].scrollHeight);
                    form[0].reset();
                },
                error: function (xhr, status, error) {
                    alert('Terjadi kesalahan. Pesan tidak dapat dikirim.');
                }
            });
        });
    });
</script>
@endsection
