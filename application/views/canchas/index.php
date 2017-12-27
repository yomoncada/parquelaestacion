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
                        <h1>Canchas Deportivas</h1>
                    </div>
                    <!-- END PAGE TITLE -->
                    <!-- BEGIN PAGE TOOLBAR -->
                    <div class="page-toolbar">
                        <!-- BEGIN THEME PANEL -->
                        <div class="btn-group btn-theme-panel animated fadeInRight">
                            <a href="#" onclick="add_cancha()" class="btn" title="Agregar">
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
                        <span class="active">Canchas Deportivas</span>
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
                                    <span class="caption-subject bold uppercase">Listado de Canchas Deportivas</span>
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
                                                <table id="canchas_activas" class="table table-hover table-bordered small">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Número</th>
                                                            <th>Nombre</th>
                                                            <th>Área</th>
                                                            <th>Capacidad</th>
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
                                                <table id="canchas_inactivas" class="table table-hover table-bordered small">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Número</th>
                                                            <th>Nombre</th>
                                                            <th>Área</th>
                                                            <th>Capacidad</th>
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
                <div class="modal fade" id="cancha-modal" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                                <div class="caption font-dark">
                                    <i id="icon" class="icon-plus font-dark"></i>
                                    <span class="caption-subject bold uppercase cancha-modal-title">Título</span>
                                </div>
                            </div>
                            <div class="modal-body">
                                <form action="#" id="cancha_form">
                                    <input type="hidden" value="" name="id_can" autocomplete="off"/>
                                    <div class="form-group">
                                    <span class="required"> * (Campos Requeridos) </span>
                                    </div>
                                    <div class="form-group">
                                        <label>Número <span class="required">*</span></label>
                                        <input type="text" id="numero_can" class="form-control" name="numero" placeholder="Ingresa un número" title="Ej: Cancha de Fútbol" autocomplete="off" onkeyup="search_cancha()" required>
                                        <span class="help-block"></span>
                                    </div>
                                    <div class="form-group">
                                        <label>Nombre <span class="required">*</span></label>
                                        <input type="text" class="form-control" name="nombre" placeholder="Ingresa un nombre" title="Ej: Cancha de Fútbol" autocomplete="off" required>
                                        <span class="help-block"></span>
                                    </div>
                                    <div class="form-group">
                                        <label>Área <span class="required">*</span></label>
                                        <select class="form-control" name="area">
                                            <option value="">--- Elige un área ---</option>
                                            <?foreach ($areas as $area):?>
                                            <option value="<?echo $area['id_are'];?>"><?echo $area['area'];?></option>
                                            <?endforeach;?>
                                        </select>
                                        <span class="help-block"></span>
                                    </div>
                                    <div class="form-group">
                                        <label>Capacidad <span class="required">*</span></label>
                                        <input type="number" class="form-control" name="capacidad" placeholder="Ingresa un número de capacidad máxima" title="Ej: 50" autocomplete="off" required>
                                        <span class="help-block"></span>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="btnSave_can" onclick="save_cancha()" class="btn green-turquoise">Guardar</button>
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
        <script src="<? echo base_url(); ?>assets/apps/scripts/canchas.js" type="text/javascript"></script>
    </body>
</html>