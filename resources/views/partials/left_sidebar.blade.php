left sidebar -->
<!-- ============================================================== -->
<div class="nav-left-sidebar sidebar-dark">
    <div class="menu-list">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="d-xl-none d-lg-none" href="#">Dashboard</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav flex-column">
                    <li class="nav-divider">
                        Menu
                    </li>

                    <li class="nav-item ">
                        <a class="nav-link" href="{{ route('orders.index') }}"><i class="fas fa-newspaper"></i>Dashboard <span class="badge badge-success">6</span></a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-1" aria-controls="submenu-1"><i class="fas fa-boxes"></i>Klienti</a>
                        <div id="submenu-1" class="collapse submenu">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link"  href="{{ route('clients.index') }}">Pregled klijenata</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('clients.create') }}">Kreiranje novog klijenta</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link"  href="{{ route('items.index') }}"><i class="fas fa-hospital"></i>Stavke</a>
                    </li>

                    <li class="nav-divider">
                        Izvestaji i statistika
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="pages/chart-charts.html"> <i class="fas fa-fw fa-chart-pie"></i>Pregled izvestaja</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>
<!-- ============================================================== -->
<!-- end left sidebar