<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Akash <sup>365</sup></div>
    </a>

    <hr class="sidebar-divider my-0">

    <li class="nav-item {{ request()->is('dashboard') ? 'active' : ''}}">
        <a class="nav-link" href="{{ route('dashboard.index') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
    <li class="nav-item {{ request()->is('addform/list') ? 'active' : ''}}">
        <a class="nav-link" href="{{ route('addform.list') }}">
            <i class="fas fa-fw fa-plus-circle"></i>
            <span>Add Data</span></a>
    </li>

    <li class="nav-item {{ request()->is('calculate/list') ? 'active' : ''}}">
        <a class="nav-link" href="{{ route('calculate.list') }}">
            <i class="fas fa-fw fa-calculator"></i>
            <span>Calculate Data</span></a>
    </li>

    <li class="nav-item {{ request()->is('viewdata/list') ? 'active' : ''}}">
        <a class="nav-link" href="{{ route('viewdata.list') }}">
            <i class="fas fa-fw fa-eye"></i>
            <span>View Data</span></a>
    </li>

    <hr class="sidebar-divider my-0">

    <li class="nav-item {{ request()->is('adddata/list') ? 'active' : ''}}">
        <a class="nav-link" href="{{ route('adddata.list') }}">
            <i class="fas fa-fw fa-plus-circle"></i>
            <span>Add Product Data</span></a>
    </li>
    {{-- <li class="nav-item {{ request()->is('dashboard') ? 'active' : ''}}">
        <a class="nav-link" href="dashboard">
            <i class="fas fa-fw fa-box"></i>
            <span>Product Data</span></a>
    </li>
    <li class="nav-item {{ request()->is('dashboard') ? 'active' : ''}}">
        <a class="nav-link" href="dashboard">
            <i class="fas fa-fw fa-tags"></i>
            <span>Category Data</span></a>
    </li>
    <li class="nav-item {{ request()->is('dashboard') ? 'active' : ''}}">
        <a class="nav-link" href="dashboard">
            <i class="fas fa-fw fa-tag"></i>
            <span>Sub-Category Data</span></a>
    </li> --}}

    <hr class="sidebar-divider my-0">
    <li class="nav-item {{ request()->is('settax/list') ? 'active' : ''}}">
        <a class="nav-link" href="{{ route('settax.list') }}">
            <i class="fas fa-fw fa-file-invoice-dollar"></i>
            <span>Set Taxes</span></a>
    </li>
    <hr class="sidebar-divider my-0">
    <li class="nav-item {{ request()->is('dashboard') ? 'active' : ''}}">
        <a class="nav-link" href="{{ route('logout') }}">
            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
            Logout
        </a>
    </li>
</ul>