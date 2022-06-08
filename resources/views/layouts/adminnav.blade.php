<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center bg-light" href="{{ url('/') }}">
        <!-- <div class="sidebar-brand-icon">
            <i class="fas fa-user"></i>
        </div> -->
        <div class="sidebar-brand-text mx-3 text-dark">
          <img src='{{ asset("media/logo/logo-blue-m.png") }}' class="logo" style="width: 100%;"></img>
        </div>
    </a>

    <li class="nav-item">
        <a class="sidebar-brand d-flex align-items-center justify-content-start" href="{{ url('/') }}">
            @if(Auth()->user()->userDetails->image_path == null)
                <div class="sidebar-brand-icon">
                    <i class="fas fa-user"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Hi, {{ Auth()->user()->userDetails->last_name }}</div>
            @else
                <div class="sidebar-brand-icon text-center">
                    <img class="img-circle elevation-2" src="{{ asset('/agent_images/'.Auth()->user()->userDetails->image_path) }}" style="width: 30px;height: 30px; border-radius: 100%;" alt="User profile picture"/>
                </div>
                <div class="sidebar-brand-text mx-3">Hi, {{ Auth()->user()->userDetails->last_name }}</div>
            @endif
        </a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-concierge-bell"></i>
            <span>Home</span>
        </a>
    </li>
    <hr class="sidebar-divider">
    <li class="nav-item">
        <a href="{{ route('admin.salesindex') }}" class="nav-link">
            <i class="fas fa-bell"></i>
                <span>Deals</span></a>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('admin.agents') }}" class="nav-link">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Agents</span></a>
        </a>
    </li>
    <!-- <li class="nav-item">
        <a href="{{ route('admin.addagent') }}" class="nav-link">
          <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Add Agent</span></a>
        </a>
    </li> -->
    <li class="nav-item">
        <a href="{{ route('admin.inviteagent') }}" class="nav-link">
            <i class="fas fa-network-wired"></i>
            <span>Recruits</span></a>
        </a>
    </li>
    
    <!-- <li class="nav-item">
        <a href="{{ route('admin.sales.new') }}" class="nav-link">
          <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Add Sales</span></a>
        </a>
    </li> -->
    <li class="nav-item">
        <a href="{{ route('admin.transactions') }}" class="nav-link">
            <i class="fas fa-list"></i>
            <span>Transactions</span></a>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('admin.withdrawals') }}" class="nav-link">
            <i class="fas fa-list"></i>
            <span>Withdrawals</span></a>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('admin.inspections') }}" class="nav-link">
            <i class="fas fa-paper-plane"></i>
            <span>Inspections</span></a>
        </a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <li class="nav-item">
        <a href="{{ route('threads.create') }}" class="nav-link">
            <i class="fas fa-newspaper"></i>
            <span>Add Post</span></a>
        </a>
    </li>
    <!-- Nav Item - Pages Collapse Menu -->
</ul>