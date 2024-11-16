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
        <a href="/verification-semprojurnal">
            <div class="parent-icon"><i class='bx bx-git-pull-request'></i></div>
            <div class="menu-title">REQUEST SEMPRO JURNAL</div>
        </a>
    </li>
    <li>
        <a href="/verification-skripsi">
            <div class="parent-icon"><i class='bx bx-git-pull-request'></i></div>
            <div class="menu-title">REQUEST SKRIPSI</div>
        </a>
    </li>
    <li>
        <a href="/verification-skripsijurnal">
            <div class="parent-icon"><i class='bx bx-git-pull-request'></i></div>
            <div class="menu-title">REQUEST SKRIPSI JURNAL</div>
        </a>
    </li>
    <li>
        <a href="/verification-surat">
            <div class="parent-icon"><i class='bx bx-git-pull-request'></i></div>
            <div class="menu-title">REQUEST SURAT</div>
        </a>
    </li>
    <li>
        <a href="/verification-skpi">
            <div class="parent-icon"><i class='bx bx-git-pull-request'></i></div>
            <div class="menu-title">REQUEST SKPI</div>
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
    <li>
        <a href="/master-link">
            <div class="parent-icon"><i class='bx bx-link'></i></div>
            <div class="menu-title">MASTER LINK</div>
        </a>
    </li>
    <li>
        <a href="javascript:;" class="has-arrow">
            <div class="parent-icon"><i class='bx bx-envelope'></i>
            </div>
            <div class="menu-title">MASTER SKOR SKPI</div>
        </a>
        <ul>
            <li> <a href="/master-kategoriskpi"><i class="bx bx-right-arrow-alt"></i>KATEGORI</a>
            </li>
          
        </ul>
        <ul>
            <li> <a href="/master-unsurskpi"><i class="bx bx-right-arrow-alt"></i>UNSUR</a>
            </li>
          
        </ul>
        <ul>
            <li> <a href="/master-skor"><i class="bx bx-right-arrow-alt"></i>SUB UNSUR,TINGKAT DAN SKOR</a>
            </li>
          
        </ul>
    </li>
   
    @endif

    @if(Auth::user()->role == 'mahasiswa')
    <li class="menu-label">PENDAFTARAN PAGE</li>
    <li>
        <a href="/pendaftaransempro">
            <div class="parent-icon"><i class='bx bxs-book-open'></i></div>
            <div class="menu-title">SEMPRO</div>
        </a>
    </li>
    <li>
        <a href="/pendaftaransemprojurnal">
            <div class="parent-icon"><i class='bx bxs-book-open'></i></div>
            <div class="menu-title">SEMPRO JURNAL</div>
        </a>
    </li>
    <li>
        <a href="/pendaftaranskripsi">
            <div class="parent-icon"><i class='bx bxs-book-reader'></i></div>
            <div class="menu-title">SKRIPSI</div>
        </a>
    </li>
    <li>
        <a href="/pendaftaranskripsijurnal">
            <div class="parent-icon"><i class='bx bxs-book-reader'></i></div>
            <div class="menu-title">SKRIPSI JURNAL</div>
        </a>
    </li>
    <li>
        <a href="/pendaftaransurat">
            <div class="parent-icon"><i class='bx bxs-envelope'></i></div>
            <div class="menu-title">SURAT</div>
        </a>
    </li>
    <li>
        <a href="/pendaftaranskpi">
            <div class="parent-icon"><i class='bx bx-book-content'></i></div>
            <div class="menu-title">SKPI</div>
        </a>
    </li>
    @endif
    @if(Auth::user()->role == 'dosen')
    <li>
        <a href="/datasempro">
            <div class="parent-icon"><i class='bx bx-book-content'></i></div>
            <div class="menu-title">DATA SEMPRO</div>
        </a>
    </li>
    <li>
        <a href="/dataskripsi">
            <div class="parent-icon"><i class='bx bx-book-content'></i></div>
            <div class="menu-title">DATA SKRIPSI</div>
        </a>
    </li>
    @endif
   
</ul>
