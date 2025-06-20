<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="#" class="brand-link">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="brand-image img-circle elevation-3" >
        <span class="brand-text font-weight" style="color: white">PANEL DE CONTROL</span>
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="true">

                <!-- ROLES Y PERMISO -->
                @can('sidebar.roles.y.permisos')
                    <li class="nav-item">
                        <a href="#" class="nav-link nav-">
                            <i class="far fa-edit"></i>
                            <p>
                                Roles y Permisos
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.roles.index') }}" target="frameprincipal" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Rol y Permisos</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('admin.permisos.index') }}" target="frameprincipal" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Usuario</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan

                @hasrole('admin')
                    <!-- Workers -->
                    <li class="nav-item">
                        <a href="{{ route('workers.index') }}" target="frameprincipal" class="nav-link">
                            <i class="nav-icon fas fa-cogs"></i>
                            <p>Web Workers</p>
                        </a>
                    </li>

                    <!-- API Geolocalización -->
                    <li class="nav-item">
                        <a href="{{ route('admin.apis') }}" target="frameprincipal" class="nav-link">
                            <i class="nav-icon fas fa-map-marked-alt"></i>
                            <p>APIs</p>
                        </a>
                    </li>
                @endhasrole

            </ul>
        </nav>
    </div>
</aside>
