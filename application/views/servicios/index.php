<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Aplicación Web del Parque La Estación</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
    </head>
    <body>
    <!-- BEGIN CONTENT -->
        <div class="page-content-wrapper">
            <!-- BEGIN CONTENT BODY -->
            <div class="page-content">
                <!-- BEGIN PAGE HEAD-->
                <div class="page-head">
                    <!-- BEGIN PAGE TITLE -->
                    <div class="page-title animated fadeInLeft">
                        <h1>Servicios</h1>
                    </div>
                    <!-- END PAGE TITLE -->
                    <!-- BEGIN PAGE TOOLBAR -->
                    <div class="page-toolbar">
                        <!-- BEGIN THEME PANEL -->
                        <div class="btn-group btn-theme-panel animated fadeInRight">
                            <a href="<? echo site_url('servicio/new'); ?>" class="btn dropdown-toggle">
                                <i class="icon-plus"></i>
                            </a>
                        </div>
                        <!-- END THEME PANEL -->
                    </div>
                    <!-- END PAGE TOOLBAR -->
                </div>
                <!-- END PAGE HEAD-->
                <!-- BEGIN PAGE BREADCRUMB -->
                <ul class="page-breadcrumb breadcrumb animated fadeInLeft">
                    <li>
                        <a href="<? echo site_url('index'); ?>">Inicio</a>
                        <i class="fa fa-chevron-right"></i>
                    </li>
                    <li>
                        <span class="active">Servicios</span>
                    </li>
                </ul>
                <!-- END PAGE BREADCRUMB -->
                <!-- BEGIN PAGE BASE CONTENT -->
                <div class="row">
                    <div class="col-xs-12">
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet light bordered animated fadeIn">
                            <div class="portlet-title">
                                <div class="caption font-dark">
                                    <i class="icon-list font-dark"></i>
                                    <span class="caption-subject bold uppercase">Listado de servicios</span>
                                </div>
                                <div class="tools"> </div>
                            </div>
                            <div class="tabbable-line tabbable-full-width">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a href="#tab_1_1" data-toggle="tab"> Pendiente </a>
                                    </li>
                                    <li>
                                        <a href="#tab_1_2" data-toggle="tab"> En Progreso </a>
                                    </li>
                                    <li>
                                        <a href="#tab_1_3" data-toggle="tab"> Finalizado </a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab_1_1">
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <table id="servicios_pendientes" class="table table-hover table-bordered small">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Número</th>
                                                            <th>Responsable</th>
                                                            <th>Fecha Asignada</th>
                                                            <th>Hora Asignada</th>
                                                            <th>Última Modificación</th>
                                                            <th>Estado</th>
                                                            <th>Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab_1_2">
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <table id="servicios_en_progresos" class="table table-hover table-bordered small">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Número</th>
                                                            <th>Responsable</th>
                                                            <th>Fecha Asignada</th>
                                                            <th>Hora Asignada</th>
                                                            <th>Última Modificación</th>
                                                            <th>Estado</th>
                                                            <th>Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab_1_3">
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <table id="servicios_finalizados" class="table table-hover table-bordered small">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Número</th>
                                                            <th>Responsable</th>
                                                            <th>Fecha Asignada</th>
                                                            <th>Hora Asignada</th>
                                                            <th>Última Modificación</th>
                                                            <th>Estado</th>
                                                            <th>Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END PAGE BASE CONTENT -->
            </div>
            <!-- END CONTENT BODY -->
        </div>
        <!-- END CONTENT -->
        <script src="<? echo base_url(); ?>assets/apps/scripts/servicios.js" type="text/javascript"></script>
    </body>
</html>