<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Horego Test</div>
    </a>
    <div>
        <hr class="sidebar-divider">

        <div class="sidebar-heading">
            Menu
        </div>

        <li class="nav-item">
            <a class="nav-link" href="{{url('organization')}}">
            <i class="fas fa-fw fa-book"></i>
            <span>Organizations</span></a>
        </li>

        <?php if(Auth::user()->role_id == 1): ?>
            <li class="nav-item">
                <a class="nav-link" href="{{url('user')}}">
                <i class="fas fa-fw fa-book"></i>
                <span>Users</span></a>
            </li>
        <?php endif; ?>
    </div>
    <hr class="sidebar-divider d-none d-md-block">
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
    <hr class="sidebar-divider">
</ul>