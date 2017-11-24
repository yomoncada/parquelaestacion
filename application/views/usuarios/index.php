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
                    <div class="page-title">
                        <h1>Usuarios</h1>
                    </div>
                    <!-- END PAGE TITLE -->
                    <!-- BEGIN PAGE TOOLBAR -->
                    <div class="page-toolbar">
                        <!-- BEGIN THEME PANEL -->
                        <div class="btn-group btn-theme-panel">
                            <a href="#" onclick="add_usuario()" class="btn" title="Agregar">
                                <i class="icon-plus"></i>
                            </a>
                        </div>
                        <!-- END THEME PANEL -->
                    </div>
                    <!-- END PAGE TOOLBAR -->
                </div>
                <!-- END PAGE HEAD-->
                <!-- BEGIN PAGE BREADCRUMB -->
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <a href="<? echo site_url('index'); ?>">Inicio</a>
                        <i class="fa fa-chevron-right"></i>
                    </li>
                    <li>
                        <span class="active">Usuarios</span>
                    </li>
                </ul>
                <!-- END PAGE BREADCRUMB -->
                <!-- BEGIN PAGE BASE CONTENT -->
                <div class="row">
                    <div class="col-xs-12">
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet light bordered">
                            <div class="portlet-title">
                                <div class="caption font-dark">
                                    <i class="icon-list font-dark"></i>
                                    <span class="caption-subject bold uppercase">Listado de Usuarios</span>
                                </div>
                                <div class="tools"> </div>
                            </div>
                            <div class="portlet-body">
                                <table id="usuarios" class="table table-hover table-bordered small">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Usuario</th>
                                            <th>Nivel</th>
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
                <div class="modal fade" id="usuario-modal" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                                <div class="caption font-dark">
                                    <i id="icon" class="icon-plus font-dark"></i>
                                    <span class="caption-subject bold uppercase usuario-modal-title">Título</span>
                                </div>
                            </div>
                            <div class="modal-body">
                                <form action="#" id="usuario_form">
                                    <input type="hidden" value="" name="id_usu" autocomplete="off"/>
                            		<div class="form-group">
                                        <div class="form-group">
                                            <span class="required"> * (Campos Requeridos) </span>
                                        </div>
                                        <label>Usuario <span class="required">*</span></label>
                                        <input type="text" id="usuario" class="form-control" name="usuario" placeholder="Ingresa un usuario" title="Ej: yomoncada" autocomplete="off" onkeyup="search_usuario()" required>
                                        <span class="help-block"></span>
                                    </div>
                                    <div class="form-group">
                                    	<label>Contraseña <span class="required">*</span></label>
                                        <input type="password" class="form-control" name="contrasena" id="contrasena" placeholder="Ingresa una contraseña" title="Ej: *******" autocomplete="off" required>
                                        <span class="help-block"></span>
                                        <div id="pswd_info" class="animated fadeIn">
                                           <h1 id="pswd_title">La contraseña debería cumplir con los siguientes requerimientos:</h1>
                                           <ul>
                                              <li id="letter">Al menos debería tener <span>una letra</span>.</li>
                                              <li id="capital">Al menos debería tener <span>una letra en mayúsculas</span>.</li>
                                              <li id="number">Al menos debería tener <span>un número</span>.</li>
                                              <li id="length">Debería tener <span>8 carácteres</span> como mínimo.</li>
                                           </ul>
                                        </div>
                                   	</div>
                                   	<div class="form-group">
                                       	<label>Nivel <span class="required">*</span></label>
                                       	<select class="form-control" name="nivel" required>
                                            <option value="">--- Elige un nivel ---</option>
                                            <option>Administrador(a)</option>
                                            <option>Secretario(a)</option>
                                        </select>
                                        <span class="help-block"></span>
                                    </div>
                            	</form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="btnSave_usu" onclick="save_usuario()" class="btn green-turquoise">Guardar</button>
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
        <style type="text/css">
            #pswd_info h1, #pswd_info ul {
                font-size: 13px;
                font-weight: normal;
            }

            #pswd_info ul {
                list-style: none;
            }

            #pswd_info ul li span {
                color: #36D7B7;
            }
        </style>
        <!-- END CONTENT -->
        <script src="<? echo base_url(); ?>assets/apps/scripts/usuarios.js" type="text/javascript"></script>
    </body>
</html>