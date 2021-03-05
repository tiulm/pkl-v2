<aside class="main-sidebar sidebar-dark-primary elevation-4 nav-compact">
  <!-- Brand Logo -->
  <a href="#" class="brand-link">
    <img src="/assets/dist/img/Logo-Unlam.png" class="brand-image img-circle elevation-3">
    <span class="brand-text"><b>S</b>IMON</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
      <img src="/public/image/{{ Auth::user()->image_profile }}" class="img-circle">
      </div>
      @if(Auth::user()->isStudent())
      <div class="info py-0">
        <a class="text-capitalize">
          <b>{{ Auth::user()->InternshipStudent->name }}</b>
          <br>
          <p>{{ Auth::user()->InternshipStudent->nim }}</p>
        </a>
      </div>
      @endif
      @if(Auth::user()->isCoordinator() || Auth::user()->isAdmin())
      <div class="info">
        <a>
          <b class="text-uppercase">{{ Auth::user()->username }}</b>
        </a>
      </div>
      @endif
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      @if(Auth::user()->isStudent())
        <li class="nav-header font-weight-bold">PKL-PK</li>
        <li class="nav-item">
          <a href="{{ url('mahasiswa/home')}}" class="{{(request()->is('mahasiswa/home')) ? 'active' : ''}} nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>
        @if(Auth::user()->isVerifiedGroupProject() > 0)
        <li class="nav-item">
          <a href="{{ url('mahasiswa/pk')}}" class="{{(request()->is('mahasiswa/pk')) ? 'active' : ''}} nav-link">
            <i class="nav-icon fas fa-users"></i>
            <p>
              Proyek Kelompok
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ url('mahasiswa/pkl')}}" class="{{(request()->is('mahasiswa/pkl')) ? 'active' : ''}} nav-link">
            <i class="nav-icon fas fa-user"></i>
            <p>
              Praktek Kerja Lapangan
            </p>
          </a>
        </li>
        @endif
        <li class="nav-header font-weight-bold">Mahasiswa</li>
        <li class="nav-item">
          <a href="{{ url('mahasiswa/seminar')}}" class="{{(request()->is('mahasiswa/seminar')) ? 'active' : ''}} nav-link">
            <i class="nav-icon fas fa-calendar-alt"></i>
            <p>
              Agenda Seminar PKL dan PK
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ url ('mahasiswa/sertifikat') }}" class="{{(request()->is('mahasiswa/sertifikat')) ? 'active' : ''}} nav-link">
            <i class="nav-icon fas fa-certificate"></i>
              Riwayat Seminar PKL dan PK
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ url ('mahasiswa/rekomendasi') }}" class="{{(request()->is('mahasiswa/rekomendasi')) ? 'active' : ''}} nav-link">
            <i class="nav-icon fab fa-get-pocket"></i>
              Rekomendasi PKL dan PK
          </a>
        </li>

        @endif
        @if(Auth::user()->isCoordinator())
        <li class="nav-header font-weight-bold">Koordinator PKL dan PK</li>
        <li class="nav-item">
          <a href="{{ url ('koor/dashboard') }}" class="{{(request()->is('koor/dashboard')) ? 'active' : ''}} nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ url ('koor/mahasiswa') }}" class="{{(request()->is('koor/mahasiswa')) ? 'active' : ''}} nav-link">
            <i class="nav-icon fas fa-users"></i>
              Mahasiswa PKL dan PK
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ url ('koor/bimbingan') }}" class="{{(request()->is('koor/bimbingan')) ? 'active' : ''}} nav-link">
            <i class="nav-icon fas fa-paste"></i>
              Bimbingan PKL dan PK
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ url ('koor/seminar') }}" class="{{(request()->is('koor/seminar')) ? 'active' : ''}} nav-link">
            <i class="nav-icon fas fa-calendar-alt"></i>
              Seminar PKL dan PK
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ url ('koor/arsip-pk') }}" class="{{(request()->is('koor/arsip-pk')) ? 'active' : ''}} nav-link">
            <i class="nav-icon fas fa-book"></i>
              Pasca Seminar PKL dan PK
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ url ('koor/rekomendasi') }}" class="{{(request()->is('koor/rekomendasi')) ? 'active' : ''}} nav-link">
            <i class="nav-icon fab fa-get-pocket"></i>
              Rekomendasi PKL dan PK
          </a>
        </li>
        </li>
        @endif
        @if(Auth::user()->isAdmin())
        <li class="nav-header font-weight-bold">Data</li>
        <li class="nav-item">
          <a href="{{ url ('admin/mahasiswa') }}" class="{{(request()->is('admin/mahasiswa')) ? 'active' : ''}} nav-link">
            <i class="nav-icon fas fa-users"></i>
              Data Mahasiswa
          </a>
        </li>
        <li class="nav-item">
        <a href="{{ url ('admin/dosen') }}" class="{{(request()->is('admin/dosen')) ? 'active' : ''}} nav-link">
            <i class="nav-icon fas fa-user-tie"></i>
              Data Dosen
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ url ('admin/jobdesc') }}" class="{{(request()->is('admin/jobdesc')) ? 'active' : ''}} nav-link">
            <i class="nav-icon fas fa-user-tag"></i>
              Data Jobdesc
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ url ('admin/arsip-pk') }}" class="{{(request()->is('admin/arsip-pk')) ? 'active' : ''}} nav-link">
            <i class="nav-icon fas fa-book"></i>
              Data PKL dan PK
          </a>
        </li>
        @endif
        <li class="nav-header font-weight-bold">Lainnya</li>
        <li class="nav-item">
        <a href="{{ url ('downloads') }}" class="{{(request()->is('downloads')) ? 'active' : ''}} nav-link">
            <i class="nav-icon fas fa-cloud-download-alt"></i>
              Unduhan
          </a>
        </li>
        <li class="nav-item">
        <a href="{{ url ('faq') }}" class="{{(request()->is('faq')) ? 'active' : ''}} nav-link">
            <i class="nav-icon fas fa-question-circle"></i>
              FAQ
          </a>
        </li>
        <li class="nav-header font-weight-bold">Profil</li>
        <li class="nav-item">
        <a href="{{ url ('profil') }}" class="{{(request()->is('profil')) ? 'active' : ''}} nav-link">
            <i class="nav-icon fas fa-user-cog"></i>
              Profil Saya
          </a>
        </li>
        <li class="nav-item">
        <a href="{{ url ('changePassword') }}" class="{{(request()->is('changePassword')) ? 'active' : ''}} nav-link">
            <i class="nav-icon fas fa-key"></i>
              Ganti Password
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>