@php
    use Carbon\Carbon;
    use App\Models\Kegiatan;

    Carbon::setLocale('id');
@endphp
    <div class="col">
        <div class="card">
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
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
