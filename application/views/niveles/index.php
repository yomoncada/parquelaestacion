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
                        <h1>Niveles</h1>
                    </div>
                    <!-- END PAGE TITLE -->
                    <!-- BEGIN PAGE TOOLBAR -->
                    <div class="page-toolbar">
                        <!-- BEGIN THEME PANEL -->
                        <div class="btn-group btn-theme-panel animated fadeInRight">
                            <a href="#" onclick="add_nivel()" class="btn" title="Agregar">
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
                        <span class="active">Niveles</span>
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
                                    <span class="caption-subject bold uppercase">Listado de Cabañas</span>
                                </div>
                                <div class="tools"> </div>
                            </div>
                            <div class="tabbable-line tabbable-full-width">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a href="#tab_1_1" data-toggle="tab"> Activos </a>
                                    </li>
                                    <li>
                                        <a href="#tab_1_2" data-toggle="tab"> Inactivos </a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab_1_1">
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <table id="niveles_activos" class="table table-hover table-bordered small">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Nombre</th>
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
                                                <table id="niveles_inactivos" class="table table-hover table-bordered small">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Nombre</th>
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
                <div class="modal fade" id="nivel-modal" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                                <div class="caption font-dark">
                                    <i id="icon" class="icon-plus font-dark"></i>
                                    <span class="caption-subject bold uppercase nivel-modal-title">Título</span>
                                </div>
                            </div>
                            <div class="modal-body">
                                <form action="#" id="nivel_form">
                                    <input type="hidden" value="" name="id_niv" autocomplete="off"/>
                                    <div class="form-group">
                                        <span class="required"> * (Campos Requeridos) </span>
                                    </div>
                            		<div class="form-group">
                                        <label>Nombre <span class="required">*</span></label>
                                        <input type="text" id="nombre_niv" class="form-control" name="nivel" placeholder="Ingresa un nombre" title="Ej: Administrador" onkeyup="search_nivel()" autocomplete="off" required>
                                        <span class="help-block"></span>
                                    </div>
                                    <label>Privilegios</label>
                                    <div class="form-group">
                                        <label class="col-xs-12 control-label">Registros Maestros</label>
                                        <div class="col-xs-12">
                                            <div class="form-group col-xs-4">
                                                <label>Áreas <span class="required">*</span></label>
                                                <select class="form-control" name="are_access">
                                                    <option value="">-- Selecciona --</option>
                                                    <option value="1">Sí</option>
                                                    <option value="0">No</option>
                                                </select>
                                                <span class="help-block"></span>
                                            </div>
                                            <div class="form-group col-xs-4">
                                                <label>Beneficiarios <span class="required">*</span></label>
                                                <select class="form-control" name="ben_access">
                                                    <option value="">-- Selecciona --</option>
                                                    <option value="1">Sí</option>
                                                    <option value="0">No</option>
                                                </select>
                                                <span class="help-block"></span>
                                            </div>
                                            <div class="form-group col-xs-4">
                                                <label>Cabañas <span class="required">*</span></label>
                                                <select class="form-control" name="cab_access">
                                                    <option value="">-- Selecciona --</option>
                                                    <option value="1">Sí</option>
                                                    <option value="0">No</option>
                                                </select>
                                                <span class="help-block"></span>
                                            </div>
                                            <div class="form-group col-xs-4">
                                                <label>Canchas <span class="required">*</span></label>
                                                <select class="form-control" name="can_access">
                                                    <option value="">-- Selecciona --</option>
                                                    <option value="1">Sí</option>
                                                    <option value="0">No</option>
                                                </select>
                                                <span class="help-block"></span>
                                            </div>
                                            <div class="form-group col-xs-4">
                                                <label>Cargos <span class="required">*</span></label>
                                                <select class="form-control" name="car_access">
                                                    <option value="">-- Selecciona --</option>
                                                    <option value="1">Sí</option>
                                                    <option value="0">No</option>
                                                </select>
                                                <span class="help-block"></span>
                                            </div>
                                            <div class="form-group col-xs-4">
                                                <label>Categorías <span class="required">*</span></label>
                                                <select class="form-control" name="cat_access">
                                                    <option value="">-- Selecciona --</option>
                                                    <option value="1">Sí</option>
                                                    <option value="0">No</option>
                                                </select>
                                                <span class="help-block"></span>
                                            </div>
                                            <div class="form-group col-xs-4">
                                                <label>Edificios <span class="required">*</span></label>
                                                <select class="form-control" name="edi_access">
                                                    <option value="">-- Selecciona --</option>
                                                    <option value="1">Sí</option>
                                                    <option value="0">No</option>
                                                </select>
                                                <span class="help-block"></span>
                                            </div>
                                            <div class="form-group col-xs-4">
                                                <label>Donantes <span class="required">*</span></label>
                                                <select class="form-control" name="don_access">
                                                    <option value="">-- Selecciona --</option>
                                                    <option value="1">Sí</option>
                                                    <option value="0">No</option>
                                                </select>
                                                <span class="help-block"></span>
                                            </div>
                                            <div class="form-group col-xs-4">
                                                <label>Edificios <span class="required">*</span></label>
                                                <select class="form-control" name="edi_access">
                                                    <option value="">-- Selecciona --</option>
                                                    <option value="1">Sí</option>
                                                    <option value="0">No</option>
                                                </select>
                                                <span class="help-block"></span>
                                            </div>
                                            <div class="form-group col-xs-4">
                                                <label>Empleados <span class="required">*</span></label>
                                                <select class="form-control" name="emp_access">
                                                    <option value="">-- Selecciona --</option>
                                                    <option value="1">Sí</option>
                                                    <option value="0">No</option>
                                                </select>
                                                <span class="help-block"></span>
                                            </div>
                                            <div class="form-group col-xs-4">
                                                <label>Especies <span class="required">*</span></label>
                                                <select class="form-control" name="esp_access">
                                                    <option value="">-- Selecciona --</option>
                                                    <option value="1">Sí</option>
                                                    <option value="0">No</option>
                                                </select>
                                                <span class="help-block"></span>
                                            </div>
                                            <div class="form-group col-xs-4">
                                                <label>Implementos <span class="required">*</span></label>
                                                <select class="form-control" name="imp_access">
                                                    <option value="">-- Selecciona --</option>
                                                    <option value="1">Sí</option>
                                                    <option value="0">No</option>
                                                </select>
                                                <span class="help-block"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-xs-12 control-label">Procesos</label>
                                        <div class="col-xs-12">
                                            <div class="form-group col-xs-4">
                                                <label>Censos <span class="required">*</span></label>
                                                <select class="form-control" name="cen_access">
                                                    <option value="">-- Selecciona --</option>
                                                    <option value="1">Sí</option>
                                                    <option value="0">No</option>
                                                </select>
                                                <span class="help-block"></span>
                                            </div>
                                            <div class="form-group col-xs-4">
                                                <label>Donaciones <span class="required">*</span></label>
                                                <select class="form-control" name="dnc_access">
                                                    <option value="">-- Selecciona --</option>
                                                    <option value="1">Sí</option>
                                                    <option value="0">No</option>
                                                </select>
                                                <span class="help-block"></span>
                                            </div>
                                            <div class="form-group col-xs-4">
                                                <label>Mantenimientos <span class="required">*</span></label>
                                                <select class="form-control" name="man_access">
                                                    <option value="">-- Selecciona --</option>
                                                    <option value="1">Sí</option>
                                                    <option value="0">No</option>
                                                </select>
                                                <span class="help-block"></span>
                                            </div>
                                            <div class="form-group col-xs-4">
                                                <label>Reforestaciones <span class="required">*</span></label>
                                                <select class="form-control" name="ref_access">
                                                    <option value="">-- Selecciona --</option>
                                                    <option value="1">Sí</option>
                                                    <option value="0">No</option>
                                                </select>
                                                <span class="help-block"></span>
                                            </div>
                                            <div class="form-group col-xs-4">
                                                <label>Servicios <span class="required">*</span></label>
                                                <select class="form-control" name="ser_access">
                                                    <option value="">-- Selecciona --</option>
                                                    <option value="1">Sí</option>
                                                    <option value="0">No</option>
                                                </select>
                                                <span class="help-block"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-xs-12 control-label">Mantenimiento</label>
                                        <div class="col-xs-12">
                                            <div class="form-group col-xs-4">
                                                <label>Base de Datos <span class="required">*</span></label>
                                                <select class="form-control" name="bd_access">
                                                    <option value="">-- Selecciona --</option>
                                                    <option value="1">Sí</option>
                                                    <option value="0">No</option>
                                                </select>
                                                <span class="help-block"></span>
                                            </div>
                                            <div class="form-group col-xs-4">
                                                <label>Bitácora <span class="required">*</span></label>
                                                <select class="form-control" name="bit_access">
                                                    <option value="">-- Selecciona --</option>
                                                    <option value="1">Sí</option>
                                                    <option value="0">No</option>
                                                </select>
                                                <span class="help-block"></span>
                                            </div>
                                            <div class="form-group col-xs-4">
                                                <label>Niveles <span class="required">*</span></label>
                                                <select class="form-control" name="niv_access">
                                                    <option value="">-- Selecciona --</option>
                                                    <option value="1">Sí</option>
                                                    <option value="0">No</option>
                                                </select>
                                                <span class="help-block"></span>
                                            </div>
                                            <div class="form-group col-xs-4">
                                                <label>Usuarios <span class="required">*</span></label>
                                                <select class="form-control" name="usu_access">
                                                    <option value="">-- Selecciona --</option>
                                                    <option value="1">Sí</option>
                                                    <option value="0">No</option>
                                                </select>
                                                <span class="help-block"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Descripción</label>
                                        <textarea class="form-control" rows="3" name="descripcion" placeholder="Ingresa una descripción" title="Ej: El máximo poder" required autocomplete="off"></textarea>
                                        <span class="help-block"></span>
                                    </div>
                            	</form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="btnSave_niv" onclick="save_nivel()" class="btn green-turquoise">Guardar</button>
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
        <script src="<? echo base_url(); ?>assets/apps/scripts/niveles.js" type="text/javascript"></script>
    </body>
</html>