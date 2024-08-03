<!-- Sidebar -->
<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
            <a href="{{ url('/') }}" class="logo">
                <img src="admin/assets/img/kaiadmin/logo_light.svg" alt="navbar brand" class="navbar-brand"
                    height="20" />
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
        <!-- End Logo Header -->
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                <li class="nav-item {{ Request::path() == 'dashboard' ? 'active' : '' }}">
                    <a href="{{ url('dashboard') }}">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Menu</h4>
                </li>
                <li class="nav-item {{ Request::path() == 'product' ? 'active' : '' }}">
                    <a href="{{ url('product') }}">
                        <i class="fas fa-layer-group"></i>
                        <p>Product</p>
                    </a>
                </li>
                <li class="nav-item {{ Request::path() == 'order' ? 'active' : '' }}">
                    <a href="{{ url('order') }}">
                        <i class="fas fa-shopping-cart"></i>
                        <p>Order</p>
                    </a>
                </li>
                <li class="nav-item {{ Request::path() == 'riwayat' ? 'active' : '' }}">
                    <a href="{{ url('riwayat') }}">
                        <i class="fas fa-book"></i>
                        <p>Riwayat</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- End Sidebar -->

<!-- Include jQuery and other necessary scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="admin/assets/js/your-sidebar-script.js"></script> <!-- Ensure you have your sidebar scripts included -->

<!-- Add your custom script -->
<script>
    $(document).ready(function() {
        $('.toggle-sidebar').on('click', function() {
            $('.sidebar').toggleClass('collapsed');
        });

        $('.sidenav-toggler').on('click', function() {
            $('.sidebar').toggleClass('collapsed');
        });

        $('.topbar-toggler').on('click', function() {
            $('.sidebar').toggleClass('collapsed');
        });
    });
</script>
