<ul class="metismenu" id="menu">
    @if(Auth::user()->role == 'admin')
    <li class="menu-label">DASHBOARD</li>
    <li>
        <a href="/dashboard-verif">
            <div class="parent-icon"><i class='bx bx-home-circle'></i></div>
            <div class="menu-title">DASHBOARD</div>
        </a>
    </li>
    @elseif(Auth::user()->role == 'dosen')
    <li class="menu-label">DASHBOARD</li>
    <li>
        <a href="/dashboard-dosen">
            <div class="parent-icon"><i class='bx bx-home-circle'></i></div>
            <div class="menu-title">DASHBOARD</div>
        </a>
    </li>
    @elseif(Auth::user()->role == 'mahasiswa')
    <li class="menu-label">DASHBOARD</li>
    <li>
        <a href="/dashboard-mahasiswa">
            <div class="parent-icon"><i class='bx bx-home-circle'></i></div>
            <div class="menu-title">DASHBOARD</div>
        </a>
    </li>
    @endif

    @if(Auth::user()->role == 'admin')
    <li class="menu-label">VERIFICATION DATA</li>
    <li>
        <a href="/verification-sempro">
            <div class="parent-icon"><i class='bx bx-git-pull-request'></i></div>
            <div class="menu-title">REQUEST SEMPRO</div>
        </a>
    </li>
    <li>
        <a href="/verification-skripsi">
            <div class="parent-icon"><i class='bx bx-git-pull-request'></i></div>
            <div class="menu-title">REQUEST SKRIPSI</div>
        </a>
    </li>
    <li class="menu-label">MASTER DATA</li>
    <li>
        <a href="/master-mahasiswa">
            <div class="parent-icon"><i class='bx bx-male' ></i></div>
            <div class="menu-title">MAHASISWA</div>
        </a>
    </li>
    <li>
        <a href="/master-dosen">
            <div class="parent-icon"><i class='bx bxs-user-badge'></i></div>
            <div class="menu-title">DOSEN</div>
        </a>
    </li>
    @endif

    @if(Auth::user()->role == 'mahasiswa')
    <li class="menu-label">MAHASISWA PAGE</li>
    <li>
        <a href="/pendaftaransempro">
            <div class="parent-icon"><i class='bx bxs-book-open'></i></div>
            <div class="menu-title">DAFTAR SEMPRO</div>
        </a>
    </li>
    <li>
        <a href="/pendaftaranskripsi">
            <div class="parent-icon"><i class='bx bxs-book-open'></i></div>
            <div class="menu-title">DAFTAR SKRIPSI</div>
        </a>
    </li>
    <li>
        <a href="/pendaftaransurat">
            <div class="parent-icon"><i class='bx bxs-book-open'></i></div>
            <div class="menu-title">DAFTAR SURAT</div>
        </a>
    </li>
    @endif
   
</ul>
