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
                        <h1>Áreas</h1>
                    </div>
                    <!-- END PAGE TITLE -->
                    <!-- BEGIN PAGE TOOLBAR -->
                    <div class="page-toolbar">
                        <!-- BEGIN THEME PANEL -->
                        <div class="btn-group btn-theme-panel animated fadeInRight">
                            <a href="#" onclick="add_area()" class="btn" title="Agregar">
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
                        <span class="active">Áreas</span>
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
                                    <span class="caption-subject bold uppercase">Listado de Áreas</span>
                                </div>
                                <div class="tools"> </div>
                            </div>
                            <div class="tabbable-line tabbable-full-width">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a href="#tab_1_1" data-toggle="tab"> Activas </a>
                                    </li>
                                    <li>
                                        <a href="#tab_1_2" data-toggle="tab"> Inactivas </a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab_1_1">
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <table id="areas_activas" class="table table-hover table-bordered small">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Código</th>
                                                            <th>Nombre</th>
                                                            <th>Ubicación</th>
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
                                                <table id="areas_inactivas" class="table table-hover table-bordered small">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Código</th>
                                                            <th>Nombre</th>
                                                            <th>Ubicación</th>
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
                <div class="modal fade" id="area-modal" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                                <div class="caption font-dark">
                                    <i id="icon" class="icon-plus font-dark"></i>
                                    <span class="caption-subject bold uppercase area-modal-title">Título</span>
                                </div>
                            </div>
                            <div class="modal-body">
                            	<form action="#" id="area_form">
                                    <input type="hidden" value="" name="id_are" autocomplete="off"/> 
                                    <div class="form-group">
                                        <span class="required"> * (Campos Requeridos) </span>
                                    </div>
                            		<div class="form-group">
                                        <label>Codigo <span class="required">*</span></label>
                                        <input id="codigo_are" type="text" class="form-control" placeholder="Ingresa un código" title="Ej: P3ST" name="codigo" autocomplete="off" onkeyup="search_area()" required>
                                        <span class="help-block"></span>
                                    </div>
                                    <div class="form-group">
                                        <label>Nombre <span class="required">*</span></label>
                                        <input type="text" class="form-control" placeholder="Ingresa un nombre" title="Ej: Perimetro Este" name="nombre" autocomplete="off" required>
                                        <span class="help-block"></span>
                                    </div>
                                    <div class="form-group">
                                        <label>Ubicación <span class="required">*</span></label>
                                        <textarea class="form-control" placeholder="Ingresa una ubicación" title="Ej: A XX km de XXXXX" name="ubicacion" autocomplete="off" required></textarea>
                                        <span class="help-block"></span>
                                    </div>
                                    <div class="form-group">
                                    </div>
                            	</form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="btnSave_are" onclick="save_area()" class="btn green-turquoise">Guardar</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- END PAGE BASE CONTENT -->
            </div>
            <!-- END CONTENT BODY -->
        </div>
        <!-- END CONTENT -->
        <script src="<? echo base_url(); ?>assets/apps/scripts/areas.js" type="text/javascript"></script>
    </body>
</html>