<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="https://web.smk-ypc.sch.id/" class="b-brand text-primary">
                <!-- ========   Change your logo from here   ============ -->
                <img src="https://web.smk-ypc.sch.id/wp-content/uploads/2022/02/Logo-we.png" alt="logo image"
                    height="35" width="200" />
            </a>
        </div>
        @if (auth()->user()->level == 'admin')
            <div class="navbar-content">
                <ul class="pc-navbar">
                    <li class="pc-item {{ request()->is('dashboard*') ? 'active' : '' }}">
                        <a href="/dashboard" class="pc-link">
                            <span class="pc-micon">
                                <i class="ph-duotone ph-layout"></i>
                            </span>
                            <span class="pc-mtext">Dashboard</span>
                        </a>
                    </li>

                    <li class="pc-item pc-caption">
                        <label>manajemen</label>
                        <i class="ph-duotone ph-buildings"></i>
                    </li>
                    <li class="pc-item {{ request()->is('kelas*') ? 'active' : '' }}">
                        <a href="/kelas" class="pc-link">
                            <span class="pc-micon">
                                <i class="ph-duotone ph-house-line"></i>
                            </span>
                            <span class="pc-mtext">Kelas</span></a>
                    </li>
                    <li class="pc-item pc-hasmenu {{ request()->is('pengguna*') ? 'active' : '' }}">
                        <a href="#!" class="pc-link">
                            <span class="pc-micon">
                                <i class="ph-duotone ph-user-circle"></i>
                            </span>
                            <span class="pc-mtext">Pengguna</span><span class="pc-arrow"><i
                                    data-feather="chevron-right"></i></span></a>
                        <ul class="pc-submenu">
                            <li class="pc-item"><a class="pc-link" href="/pengguna/admin">Admin</a></li>
                            <li class="pc-item"><a class="pc-link" href="/pengguna/siswa">Siswa</a></li>
                            <li class="pc-item"><a class="pc-link" href="/pengguna/pemonitor">Pemonitor</a>
                            </li>
                            <li class="pc-item"><a class="pc-link" href="/pengguna/industri">Industri</a>
                            </li>
                        </ul>
                    </li>
                    <li class="pc-item {{ request()->is('monitoring*') ? 'active' : '' }}">
                        <a href="/monitoring" class="pc-link">
                            <span class="pc-micon">
                                <i class="ph-duotone ph-chalkboard-teacher"></i>
                            </span>
                            <span class="pc-mtext">Monitoring</span></a>
                    </li>
                    <li class="pc-item {{ request()->is('kategori_penilaian*') ? 'active' : '' }}">
                        <a href="/kategori-penilaian" class="pc-link">
                            <span class="pc-micon">
                                <i class="ph-duotone ph-notepad"></i>
                            </span>
                            <span class="pc-mtext">Kategori Penilaian</span></a>
                    </li>

                    <li class="pc-item pc-caption">
                        <label>Aplikasi Mobile</label>
                        <i class="ph-duotone ph-buildings"></i>
                    </li>
                    <li class="pc-item {{ request()->is('banners*') ? 'active' : '' }}">
                        <a href="/banner" class="pc-link">
                            <span class="pc-micon">
                                <i class="ph-duotone ph-newspaper"></i>
                            </span>
                            <span class="pc-mtext">Spanduk</span></a>
                    </li>
                    <li class="pc-item {{ request()->is('kehadiran*') ? 'active' : '' }}">
                        <a href="/kehadiran" class="pc-link">
                            <span class="pc-micon">
                                <i class="ph-duotone ph-fingerprint-simple"></i>
                            </span>
                            <span class="pc-mtext">Kehadiran & Kegiatan</span></a>
                    </li>

                    <li class="pc-item pc-caption">
                        <label>Lainnya</label>
                        <i class="ph-duotone ph-buildings"></i>
                    </li>
                    <li class="pc-item pc-hasmenu {{ request()->is('laporan*') ? 'active' : '' }}">
                        <a href="#!" class="pc-link">
                            <span class="pc-micon">
                                <i class="ph-duotone ph-printer"></i>
                            </span>
                            <span class="pc-mtext">Laporan</span><span class="pc-arrow"><i
                                    data-feather="chevron-right"></i></span></a>
                        <ul class="pc-submenu">
                            <li class="pc-item"><a class="pc-link" href="/laporan/kehadiran">Kehadiran</a></li>
                            <li class="pc-item"><a class="pc-link" href="/laporan/kegiatan">Kegiatan</a></li>
                            </li>
                        </ul>
                    </li>
                    <li class="pc-item {{ request()->is('pesan*') ? 'active' : '' }}">
                        <a href="/pesan" class="pc-link">
                            <span class="pc-micon">
                                <i class="ph-duotone ph-messenger-logo"></i>
                            </span>
                            <span class="pc-mtext">Kirim Pesan</span></a>
                    </li>
                    <li class="pc-item {{ request()->is('penilaian*') ? 'active' : '' }}">
                        <a href="/penilaian" class="pc-link">
                            <span class="pc-micon">
                                <i class="ph-duotone ph-notepad"></i>
                            </span>
                            <span class="pc-mtext">Hasil Penilaian</span></a>
                    </li>
                    <li class="pc-item {{ request()->is('log_aktivitas*') ? 'active' : '' }}">
                        <a href="/log_aktivitas" class="pc-link">
                            <span class="pc-micon">
                                <i class="ph-duotone ph-activity"></i>
                            </span>
                            <span class="pc-mtext">Log Aktivitas</span></a>
                    </li>
                    {{--  <li class="pc-item {{ request()->is('pengaturan_apk*') ? 'active' : '' }}">
                        <a href="/pengaturan_aplikasi" class="pc-link">
                            <span class="pc-micon">
                                <i class="ph-duotone ph-gear-six"></i>
                            </span>
                            <span class="pc-mtext">Pengaturan Aplikasi</span></a>
                    </li>  --}}
                </ul>
                {{--  <div class="card nav-action-card bg-brand-color-4">
                    <div class="card-body" style="background-image: url('../assets/images/layout/nav-card-bg.svg')">
                        <h5 class="text-dark">Help Center</h5>
                        <p class="text-dark text-opacity-75">Please contact us for more questions.</p>
                        <a href="https://phoenixcoded.support-hub.io/" class="btn btn-primary" target="_blank">Go
                            to help Center</a>
                    </div>
                </div>  --}}
            </div>
        @elseif (auth()->user()->level =='pemonitor')
            <div class="navbar-content">
                <ul class="pc-navbar">
                    <li class="pc-item {{ request()->is('dashboard*') ? 'active' : '' }}">
                        <a href="/dashboard" class="pc-link">
                            <span class="pc-micon">
                                <i class="ph-duotone ph-layout"></i>
                            </span>
                            <span class="pc-mtext">Dashboard</span>
                        </a>
                    </li>

                    <li class="pc-item pc-caption">
                        <label>manajemen</label>
                        <i class="ph-duotone ph-buildings"></i>
                    </li>
                    <li class="pc-item pc-hasmenu {{ request()->is('pengguna*') ? 'active' : '' }}">
                        <a href="#!" class="pc-link">
                            <span class="pc-micon">
                                <i class="ph-duotone ph-user-circle"></i>
                            </span>
                            <span class="pc-mtext">Pengguna</span><span class="pc-arrow"><i
                                    data-feather="chevron-right"></i></span></a>
                        <ul class="pc-submenu">
                            <li class="pc-item"><a class="pc-link" href="/pengguna/siswa">Siswa</a></li>
                            <li class="pc-item"><a class="pc-link" href="/pengguna/industri">Industri</a>
                            </li>
                        </ul>
                    </li>
                    <li class="pc-item {{ request()->is('monitoring*') ? 'active' : '' }}">
                        <a href="/monitoring" class="pc-link">
                            <span class="pc-micon">
                                <i class="ph-duotone ph-chalkboard-teacher"></i>
                            </span>
                            <span class="pc-mtext">Monitoring</span></a>
                    </li>

                    <li class="pc-item pc-caption">
                        <label>Aplikasi Mobile</label>
                        <i class="ph-duotone ph-buildings"></i>
                    </li>
                    <li class="pc-item {{ request()->is('kehadiran*') ? 'active' : '' }}">
                        <a href="/kehadiran" class="pc-link">
                            <span class="pc-micon">
                                <i class="ph-duotone ph-fingerprint-simple"></i>
                            </span>
                            <span class="pc-mtext">Kehadiran & Kegiatan</span></a>
                    </li>

                    <li class="pc-item pc-caption">
                        <label>Lainnya</label>
                        <i class="ph-duotone ph-buildings"></i>
                    </li>
                    <li class="pc-item {{ request()->is('pesan*') ? 'active' : '' }}">
                        <a href="/pesan" class="pc-link">
                            <span class="pc-micon">
                                <i class="ph-duotone ph-messenger-logo"></i>
                            </span>
                            <span class="pc-mtext">Kirim Pesan</span></a>
                    </li>
                    <li class="pc-item {{ request()->is('penilaian*') ? 'active' : '' }}">
                        <a href="/penilaian" class="pc-link">
                            <span class="pc-micon">
                                <i class="ph-duotone ph-notepad"></i>
                            </span>
                            <span class="pc-mtext">Hasil Penilaian</span></a>
                    </li>
                    <li class="pc-item pc-hasmenu {{ request()->is('laporan*') ? 'active' : '' }}">
                        <a href="#!" class="pc-link">
                            <span class="pc-micon">
                                <i class="ph-duotone ph-printer"></i>
                            </span>
                            <span class="pc-mtext">Laporan</span><span class="pc-arrow"><i
                                    data-feather="chevron-right"></i></span></a>
                        <ul class="pc-submenu">
                            <li class="pc-item"><a class="pc-link" href="/laporan/kehadiran">Kehadiran</a></li>
                            <li class="pc-item"><a class="pc-link" href="/laporan/kegiatan">Kegiatan</a></li>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            @elseif (auth()->user()->level =='siswa')
            <div class="navbar-content">
                <ul class="pc-navbar">
                    <li class="pc-item {{ request()->is('dashboard*') ? 'active' : '' }}">
                        <a href="/dashboard" class="pc-link">
                            <span class="pc-micon">
                                <i class="ph-duotone ph-layout"></i>
                            </span>
                            <span class="pc-mtext">Dashboard</span>
                        </a>
                    </li>
                    <li class="pc-item {{ request()->is('kehadiran*') ? 'active' : '' }}">
                        <a href="/kehadiran" class="pc-link">
                            <span class="pc-micon">
                                <i class="ph-duotone ph-notepad"></i>
                            </span>
                            <span class="pc-mtext">Kehadiran</span></a>
                    </li>
                    <li class="pc-item {{ request()->is('kegiatan*') ? 'active' : '' }}">
                        <a href="/kegiatan" class="pc-link">
                            <span class="pc-micon">
                                <i class="ph-duotone ph-activity"></i>
                            </span>
                            <span class="pc-mtext">Kegiatan</span></a>
                        </li>
                </ul>
            </div>
            @else
            <div class="navbar-content">
                <ul class="pc-navbar">
                    <li class="pc-item {{ request()->is('dashboard*') ? 'active' : '' }}">
                        <a href="/dashboard" class="pc-link">
                            <span class="pc-micon">
                                <i class="ph-duotone ph-layout"></i>
                            </span>
                            <span class="pc-mtext">Dashboard</span>
                        </a>
                    </li>
                    <li class="pc-item pc-caption">
                        <label>manajemen</label>
                        <i class="ph-duotone ph-buildings"></i>
                    </li>
                    <li class="pc-item pc-hasmenu {{ request()->is('pengguna*') ? 'active' : '' }}">
                        <a href="#!" class="pc-link">
                            <span class="pc-micon">
                                <i class="ph-duotone ph-user-circle"></i>
                            </span>
                            <span class="pc-mtext">Pengguna</span><span class="pc-arrow"><i
                                    data-feather="chevron-right"></i></span></a>
                        <ul class="pc-submenu">
                            <li class="pc-item"><a class="pc-link" href="/pengguna/siswa">Siswa</a></li>
                            </li>
                        </ul>
                    </li>
                    <li class="pc-item {{ request()->is('penilaian*') ? 'active' : '' }}">
                        <a href="/penilaian" class="pc-link">
                            <span class="pc-micon">
                                <i class="ph-duotone ph-notepad"></i>
                            </span>
                            <span class="pc-mtext">Penilaian</span></a>
                    </li>
                    <li class="pc-item pc-caption">
                        <label>Aplikasi Mobile</label>
                        <i class="ph-duotone ph-buildings"></i>
                    </li>
                    <li class="pc-item {{ request()->is('kehadiran*') ? 'active' : '' }}">
                        <a href="/kehadiran" class="pc-link">
                            <span class="pc-micon">
                                <i class="ph-duotone ph-fingerprint-simple"></i>
                            </span>
                            <span class="pc-mtext">Kehadiran & Kegiatan</span></a>
                    </li>
                    <li class="pc-item pc-caption">
                        <label>Lainnya</label>
                        <i class="ph-duotone ph-buildings"></i>
                    </li>
                    <li class="pc-item pc-hasmenu {{ request()->is('laporan*') ? 'active' : '' }}">
                        <a href="#!" class="pc-link">
                            <span class="pc-micon">
                                <i class="ph-duotone ph-note-pencil"></i>
                            </span>
                            <span class="pc-mtext">Token</span><span class="pc-arrow"><i
                                    data-feather="chevron-right"></i></span></a>
                        <ul class="pc-submenu">
                            <li class="pc-item"><a class="pc-link" href="/token/masuk">Token Masuk</a></li>
                            <li class="pc-item"><a class="pc-link" href="/token/keluar">Token Keluar</a></li>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        @endif
        <div class="card pc-user-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <img src="../assets/images/user/avatar-1.jpg" alt="user-image"
                            class="user-avtar wid-45 rounded-circle" />
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <div class="dropdown">
                            <a href="#" class="arrow-none dropdown-toggle" data-bs-toggle="dropdown"
                                aria-expanded="false" data-bs-offset="0,20">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 me-2">
                                        <h6 class="mb-0">{{ Auth::user()->username }}</h6>
                                        <small>{{ Auth::user()->level }}</small>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <div class="btn btn-icon btn-link-secondary avtar">
                                            <i class="ph-duotone ph-windows-logo"></i>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-menu">
                                <ul>
                                    @if (auth()->user()->level == 'admin')
                                        <li>
                                            <a class="pc-user-links" href="/edit-akun">
                                                <i class="ph-duotone ph-user"></i>
                                                <span>Akun</span>
                                            </a>
                                        </li>
                                    @else
                                    @if (auth()->user()->level != 'siswa')
                                        <li>
                                            <a class="pc-user-links" href="/edit-profil">
                                                <i class="ph-duotone ph-user"></i>
                                                <span>Profil</span>
                                            </a>
                                        </li>
                                    @endif
                                    @endif
                                    <li>
                                        <a class="pc-user-links" href="/logout">
                                            <i class="ph-duotone ph-power"></i>
                                            <span>Keluar</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
