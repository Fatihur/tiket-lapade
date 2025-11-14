<!-- Sidebar Start -->
<aside class="left-sidebar">
  <!-- Sidebar scroll-->
  <div>
    <div class="brand-logo d-flex align-items-center justify-content-between">
      <a href="{{ route('landing') }}" class="text-nowrap logo-img">
        <h4 class="fw-bold text-primary mb-0">Tiket Wisata</h4>
      </a>
      <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
        <i class="ti ti-x fs-8"></i>
      </div>
    </div>
    <!-- Sidebar navigation-->
    <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
      <ul id="sidebarnav">
        @if(auth()->user()->isAdmin())
          <!-- Admin Menu -->
          <li class="nav-small-cap">
            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
            <span class="hide-menu">ADMIN</span>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('admin.dashboard') }}" aria-expanded="false">
              <span><i class="ti ti-layout-dashboard"></i></span>
              <span class="hide-menu">Dashboard</span>
            </a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('admin.wisata.index') }}" aria-expanded="false">
              <span><i class="ti ti-map-pin"></i></span>
              <span class="hide-menu">Kelola Wisata</span>
            </a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('admin.transaksi.index') }}" aria-expanded="false">
              <span><i class="ti ti-receipt"></i></span>
              <span class="hide-menu">Transaksi</span>
            </a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('admin.laporan.index') }}" aria-expanded="false">
              <span><i class="ti ti-file-report"></i></span>
              <span class="hide-menu">Laporan</span>
            </a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('admin.user.index') }}" aria-expanded="false">
              <span><i class="ti ti-users"></i></span>
              <span class="hide-menu">Kelola User</span>
            </a>
          </li>
        @elseif(auth()->user()->isPetugas())
          <!-- Petugas Menu -->
          <li class="nav-small-cap">
            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
            <span class="hide-menu">PETUGAS</span>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('petugas.dashboard') }}" aria-expanded="false">
              <span><i class="ti ti-layout-dashboard"></i></span>
              <span class="hide-menu">Dashboard</span>
            </a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('petugas.scan') }}" aria-expanded="false">
              <span><i class="ti ti-qrcode"></i></span>
              <span class="hide-menu">Scan Tiket</span>
            </a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('petugas.riwayat') }}" aria-expanded="false">
              <span><i class="ti ti-history"></i></span>
              <span class="hide-menu">Riwayat Scan</span>
            </a>
          </li>
        @elseif(auth()->user()->isBendahara())
          <!-- Bendahara Menu -->
          <li class="nav-small-cap">
            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
            <span class="hide-menu">BENDAHARA</span>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('bendahara.dashboard') }}" aria-expanded="false">
              <span><i class="ti ti-layout-dashboard"></i></span>
              <span class="hide-menu">Dashboard</span>
            </a>
          </li>
        @elseif(auth()->user()->isOwner())
          <!-- Owner Menu -->
          <li class="nav-small-cap">
            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
            <span class="hide-menu">OWNER</span>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('owner.dashboard') }}" aria-expanded="false">
              <span><i class="ti ti-layout-dashboard"></i></span>
              <span class="hide-menu">Dashboard</span>
            </a>
          </li>
        @endif
      </ul>
    </nav>
    <!-- End Sidebar navigation -->
  </div>
  <!-- End Sidebar scroll-->
</aside>
<!--  Sidebar End -->

