<div class="col">
        <div class="card">
            <div class="card-body table-border-style">
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
