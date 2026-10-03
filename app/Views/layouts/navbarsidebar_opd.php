<!-- Menu -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="/home" class="app-brand-link">

            <img src="<?= base_url(); ?>/assets/img/icons/logo.png" class="circle-img" alt="logo">

            <span class="app-brand-text menu-text fw-bolder ms-1">SiRuang</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item lidashboard">
            <a href="/home" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Transaksi</span>
        </li>
        <li class="menu-item active-menu-user">
            <a href="#" class="menu-link">
                <i class="menu-icon tf-icons bx bx-pencil"></i>
                <div data-i18n="Analytics">Pengajuan Peminjaman</div>
            </a>
        </li>
        <li class="menu-item active-menu-user">
            <a href="#" class="menu-link">
                <i class="menu-icon tf-icons bx bx-calendar"></i>
                <div data-i18n="Analytics">Kalender Pinjam Ruang</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Laporan</span>
        </li>
        <li class="menu-item">
            <a href="#" class="menu-link">
                <i class="menu-icon tf-icons bx bx-chart"></i>
                <div data-i18n="Analytics">Lap. Peminjaman Ruang</div>
            </a>
        </li>        

    </ul>
</aside>
<!-- / Menu -->