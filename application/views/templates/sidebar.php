<!-- BEGIN SIDEBAR -->
            <div class="page-sidebar-wrapper">
                <!-- BEGIN SIDEBAR -->
                <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                <div class="page-sidebar navbar-collapse collapse">
                    <!-- BEGIN SIDEBAR MENU -->
                    <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
                    <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
                    <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
                    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                    <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
                    <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                    <ul class="page-sidebar-menu   " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
                        <li class="nav-item start active open">
                            <a href="<? echo site_url('home'); ?>" class="nav-link nav-toggle">
                                <i class="icon-home"></i>
                                <span class="title">Inicio</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="heading">
                            <h3 class="uppercase">Registros Maestros</h3>
                        </li>
                        <li class="nav-item">
                            <a href="<? echo site_url('especie'); ?>" class="nav-link nav-toggle">
                                <i class="icon-bulb"></i>
                                <span class="title">Especies</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="icon-puzzle"></i>
                                <span class="title">Instalaciones</span>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item">
                                    <a href="<? echo site_url('area'); ?>" class="nav-link ">
                                        <span class="title">Áreas</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<? echo site_url('cabana'); ?>" class="nav-link ">
                                        <span class="title">Cabañas</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<? echo site_url('cancha'); ?>" class="nav-link ">
                                        <span class="title">Canchas Deportivas</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<? echo site_url('edificio'); ?>"class="nav-link ">
                                        <span class="title">Edificios</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="icon-social-dropbox"></i>
                                <span class="title">Inventario</span>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item">
                                    <a href="<? echo site_url('categoria'); ?>" class="nav-link ">
                                        <span class="title">Categorías</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<? echo site_url('implemento'); ?>" class="nav-link ">
                                        <span class="title">Implementos</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="icon-users"></i>
                                <span class="title">Personas</span>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item">
                                    <a href="<? echo site_url('beneficiario'); ?>" class="nav-link ">
                                        <span class="title">Beneficiarios</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<? echo site_url('cargo'); ?>" class="nav-link ">
                                        <span class="title">Cargos</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<? echo site_url('donante'); ?>" class="nav-link ">
                                        <span class="title">Donantes</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<? echo site_url('empleado'); ?>" class="nav-link ">
                                        <span class="title">Empleados</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="heading">
                            <h3 class="uppercase">Procesos</h3>
                        </li>
                        <li class="nav-item">
                            <a href="<? echo site_url('censo'); ?>">
                                <i class="icon-note"></i>
                                <span class="title">Censos</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<? echo site_url('donacion'); ?>">
                                <i class="icon-heart"></i>
                                <span class="title">Donaciones</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<? echo site_url('mantenimiento'); ?>">
                                <i class="icon-wrench"></i>
                                <span class="title">Mantenimientos</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<? echo site_url('reforestacion'); ?>">
                                <i class="icon-drop"></i>
                                <span class="title">Reforestaciones</span>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a href="<? echo site_url('servicio'); ?>">
                                <i class="icon-grid"></i>
                                <span class="title">Servicios</span>
                            </a>
                        </li>
                        <li class="heading">
                            <h3 class="uppercase">Mantenimiento</h3>
                        </li>
                        <li class="nav-item">
                            <a href="<? echo site_url('basededatos'); ?>">
                                <i class="icon-layers"></i>
                                <span class="title">Base de Datos</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<? echo site_url('bitacora'); ?>">
                                <i class="icon-compass"></i>
                                <span class="title">Bitacora</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<? echo site_url('usuario'); ?>">
                                <i class="icon-user"></i>
                                <span class="title">Usuarios</span>
                            </a>
                        </li>
                        <li class="heading">
                            <h3 class="uppercase">Documentación</h3>
                        </li>
                        <li class="nav-item">
                            <a href="">
                                <i class="icon-info"></i>
                                <span class="title">Guía de Usuario</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="">
                                <i class="icon-question"></i>
                                <span class="title">Preguntas Frecuentes</span>
                            </a>
                        </li>
                    </ul>
                    <!-- END SIDEBAR MENU -->
                </div>
                <!-- END SIDEBAR -->
            </div>
            <!-- END SIDEBAR -->