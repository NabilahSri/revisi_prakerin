@extends('component.template');
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
    {{-- <li class="breadcrumb-item"><a href="javascript: void(0)">Laporan</a></li> --}}
    <li class="breadcrumb-item" aria-current="page">Edit Profil</li>
@endsection
@section('page_header')
    <h2 class="mb-0">Edit Profil</h2>
@endsection
@section('content')
    <div class="row d-flex justify-content-center">
        <div class="col-xl-8 col-lg-7">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4>Informasi Pengguna</h4>
                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#editModal{{ $user->id }}"><i class="ti ti-edit"></i> Edit</button>
                </div>
                <div class="card-body">
                    <div class="col">
                            <div class="row">
                                @if (auth()->user()->level == 'pemonitor')
                                    <div class="form-group col-md-6">
                                        <label class="col-form-label">NIP:</label>
                                        <input type="text" class="form-control" value="{{ $pengguna->nip }}" readonly>
                                    </div>
                                    <div class="form-group col-md-6">
                                            <label class="col-form-label">Nama:</label>
                                            <input type="text" class="form-control" value="{{ $pengguna->name }}" readonly>
                                    </div>
                                    <div class="form-group col-md-6">
                                            <label class="col-form-label">Username:</label>
                                            <input type="text" class="form-control" value="{{ $user->username }}" readonly>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="col-form-label" for="lname">Password:</label>
                                        <input type="text" class="form-control" value="........." readonly>
                                    </div>
                                    <div class="form-group col-md-6">
                                            <label class="col-form-label">Email:</label>
                                            <input type="text" class="form-control" value="{{ $pengguna->email }}" readonly>
                                    </div>
                                    <div class="form-group col-md-6">
                                            <label class="col-form-label">No Telepon:</label>
                                            <input type="text" class="form-control" value="{{ $pengguna->telp }}" readonly>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="col-form-label" for="add1">Role:</label>
                                        <input type="text" class="form-control" value="{{ $user->level }}" readonly>
                                    </div>
                                    <div class="form-group col-md-6">
                                            <label class="col-form-label">Alamat:</label>
                                            <input type="text" class="form-control" value="{{ $pengguna->alamat }}" readonly>
                                    </div>
                                @elseif (auth()->user()->level == 'industri')
                                    <div class="form-group col-md-6">
                                        <label class="col-form-label">Nama Perusahaan:</label>
                                        <input type="text" class="form-control" value="{{ $pengguna->name }}" readonly>
                                    </div>
                                    <div class="form-group col-md-6">
                                            <label class="col-form-label">Pimpinan:</label>
                                            <input type="text" class="form-control" value="{{ $pengguna->ceo }}" readonly>
                                    </div>
                                    <div class="form-group col-md-6">
                                            <label class="col-form-label">Username:</label>
                                            <input type="text" class="form-control" value="{{ $user->username }}" readonly>
                                        </div>
                                    <div class="form-group col-md-6">
                                        <label class="col-form-label" for="lname">Password:</label>
                                        <input type="text" class="form-control" value="........." readonly>
                                    </div>
                                    <div class="form-group col-md-6">
                                            <label class="col-form-label">Email:</label>
                                            <input type="text" class="form-control" value="{{ $pengguna->email }}" readonly>
                                    </div>
                                    <div class="form-group col-md-6">
                                            <label class="col-form-label">No Telepon:</label>
                                            <input type="text" class="form-control" value="{{ $pengguna->telp }}" readonly>
                                    </div>
                                    {{-- <div class="form-group col-md-6">
                                            <label class="col-form-label">Latitude:</label>
                                            <input type="text" class="form-control" value="{{ $pengguna->lat }}" readonly>
                                    </div>
                                    <div class="form-group col-md-6">
                                            <label class="col-form-label">Longitude:</label>
                                            <input type="text" class="form-control" value="{{ $pengguna->long }}" readonly>
                                    </div> --}}
                                    <div class="form-group col-md-6">
                                        <label class="col-form-label" for="add1">Role:</label>
                                        <input type="text" class="form-control" value="{{ $user->level }}" readonly>
                                    </div>
                                    <div class="form-group col-md-6">
                                            <label class="col-form-label">Alamat:</label>
                                            <input type="text" class="form-control" value="{{ $pengguna->alamat }}" readonly>
                                    </div>
                                @endif
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Edit Modal --}}
    <div id="editModal{{ $user->id }}" class="modal fade" tabindex="-1"
        role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Edit Data user
                    </h4>
                    <button class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form action="/edit-profil/{{ $user->id }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            @if (auth()->user()->level == 'pemonitor')
                                    <div class="form-group col-md-6">
                                        <label class="col-form-label">NIP:</label>
                                        <input type="text" class="form-control" value="{{ $pengguna->nip }}" name="nip">
                                    </div>
                                    <div class="form-group col-md-6">
                                            <label class="col-form-label">Nama:</label>
                                            <input type="text" class="form-control" value="{{ $pengguna->name }}" name="name">
                                    </div>
                                    <div class="form-group col-md-6">
                                            <label class="col-form-label">Username:</label>
                                            <input type="text" class="form-control" value="{{ $user->username }}" name="username">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="col-form-label" for="lname">Password:</label>
                                        <input type="text" class="form-control" value="........." name="">
                                    </div>
                                    <div class="form-group col-md-6">
                                            <label class="col-form-label">Email:</label>
                                            <input type="text" class="form-control" value="{{ $pengguna->email }}" name="email">
                                    </div>
                                    <div class="form-group col-md-6">
                                            <label class="col-form-label">No Telepon:</label>
                                            <input type="text" class="form-control" value="{{ $pengguna->telp }}" name="telp">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="col-form-label" for="add1">Role:</label>
                                        <input type="text" class="form-control" value="{{ $user->level }}" name="level" readonly>
                                    </div>
                                    <div class="form-group col-md-6">
                                            <label class="col-form-label">Alamat:</label>
                                            <input type="text" class="form-control" value="{{ $pengguna->alamat }}" name="alamat">
                                    </div>
                            @elseif (auth()->user()->level == 'industri')
                                    <div class="form-group col-md-6">
                                        <label class="col-form-label">Nama Perusahaan:</label>
                                        <input type="text" class="form-control" value="{{ $pengguna->name }}" name="name">
                                    </div>
                                    <div class="form-group col-md-6">
                                            <label class="col-form-label">Pimpinan:</label>
                                            <input type="text" class="form-control" value="{{ $pengguna->ceo }}" name="ceo">
                                    </div>
                                    <div class="form-group col-md-6">
                                            <label class="col-form-label">Username:</label>
                                            <input type="text" class="form-control" value="{{ $user->username }}" name="username">
                                        </div>
                                    <div class="form-group col-md-6">
                                        <label class="col-form-label" for="lname">Password:</label>
                                        <input type="text" class="form-control" value="........." name="password">
                                    </div>
                                    <div class="form-group col-md-6">
                                            <label class="col-form-label">Email:</label>
                                            <input type="text" class="form-control" value="{{ $pengguna->email }}" name="email">
                                    </div>
                                    <div class="form-group col-md-6">
                                            <label class="col-form-label">No Telepon:</label>
                                            <input type="text" class="form-control" value="{{ $pengguna->telp }}" name="telp">
                                    </div>
                                    {{-- <div class="form-group col-md-12">
                                        <label class="col-form-label">Pilih Lokasi di Peta:</label>
                                        <div id="map" style="height: 400px;"></div>
                                    </div>
                                    <div class="form-group col-md-6">
                                            <label class="col-form-label">Latitude:</label>
                                            <input type="text" class="form-control" id="lat" value="{{ $pengguna->lat }}" name="lat">
                                    </div>
                                    <div class="form-group col-md-6">
                                            <label class="col-form-label">Longitude:</label>
                                            <input type="text" class="form-control" id="long" value="{{ $pengguna->long }}" name="long">
                                    </div> --}}
                                    <div class="form-group col-md-6">
                                        <label class="col-form-label" for="add1">Role:</label>
                                        <input type="text" class="form-control" value="{{ $user->level }}" name="level" readonly>
                                    </div>
                                    <div class="form-group col-md-6">
                                            <label class="col-form-label">Alamat:</label>
                                            <input type="text" class="form-control" value="{{ $pengguna->alamat }}" name="alamat">
                                    </div>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan
                            Perubahan</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection
{{-- @section('script')
    <script>
        $('#editModal{{ $user->id }}').on('shown.bs.modal', function () {
            // Inisialisasi peta
            var map = L.map('map').setView([{{ $pengguna->lat }}, {{ $pengguna->long }}], 13);

            // Tambahkan tile layer
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Tambahkan marker dan set posisi awal
            var marker = L.marker([{{ $pengguna->lat }}, {{ $pengguna->long }}], {
                draggable: true // Membuat marker bisa dipindahkan (drag)
            }).addTo(map).bindPopup('Geser marker ini untuk memilih lokasi.').openPopup();;

            // Event listener untuk memperbarui nilai latitude dan longitude ketika marker dipindahkan
            marker.on('moveend', function(e) {
                var latLng = e.target.getLatLng();
                document.getElementById('lat').value = latLng.lat;
                document.getElementById('long').value = latLng.lng;
            });

            // Juga bisa memperbarui ketika peta diklik
            map.on('click', function(e) {
                marker.setLatLng(e.latlng);
                document.getElementById('lat').value = e.latlng.lat;
                document.getElementById('long').value = e.latlng.lng;
            });

            // Event listener untuk input latitude dan longitude
            document.getElementById('lat').addEventListener('input', function() {
                var lat = parseFloat(this.value);
                var lng = parseFloat(document.getElementById('long').value);
                if (!isNaN(lat) && !isNaN(lng)) {
                    marker.setLatLng([lat, lng]);
                    map.setView([lat, lng], map.getZoom()); // Menyelaraskan tampilan peta dengan marker
                }
            });

            document.getElementById('long').addEventListener('input', function() {
                var lat = parseFloat(document.getElementById('lat').value);
                var lng = parseFloat(this.value);
                if (!isNaN(lat) && !isNaN(lng)) {
                    marker.setLatLng([lat, lng]);
                    map.setView([lat, lng], map.getZoom()); // Menyelaraskan tampilan peta dengan marker
                }
            });

            // Pastikan peta di-resize setelah modal terbuka
            setTimeout(function() {
                map.invalidateSize();
            }, 10);
        });
    </script>
@endsection --}}
