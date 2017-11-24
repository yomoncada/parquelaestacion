<!DOCTYPE html>

<html lang="en">
    <!-- BEGIN HEAD -->
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
                    <h1>Perfil</h1>
                </div>
                <!-- END PAGE TITLE -->
            </div>
            <!-- END PAGE HEAD-->
            <!-- BEGIN PAGE BREADCRUMB -->
            <ul class="page-breadcrumb breadcrumb animated fadeInLeft">
                <li>
                    <a href="<? echo site_url('index'); ?>">Inicio</a>
                    <i class="fa fa-chevron-right"></i>
                </li>
                <li>
                    <span class="active">Perfil</span>
                </li>
            </ul>
            <!-- END PAGE BREADCRUMB -->
            <!-- BEGIN PAGE BASE CONTENT -->
            <div class="profile animated fadeIn">
                <div class="tabbable-line tabbable-full-width">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#tab_1_1" data-toggle="tab"><i class="icon-list"></i> Resumen </a>
                        </li>
                        <li>
                            <a href="#tab_1_2" data-toggle="tab"><i class="icon-settings"></i> Configuración </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1_1">
                            <div class="row">
                                <div class="col-md-3 col-xs-12">
                                    <ul class="list-unstyled profile-nav">
                                        <li>
                                            <img src="<?echo base_url();?>assets/pages/img/avatar.svg" class="img-responsive pic-bordered profile_avatar" alt="Avatar"/>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-9 col-xs-12">
                                    <div class="row">
                                        <div class="col-lg-8 profile-info">
                                            <h3 class="font-green sbold profile_nombre"> Nombre </h3>
                                            <h5 class="sbold profile_usuario"> Usuario </h5>
                                            <p class="profile_biografia"> Biografía
                                            </p>
                                            <ul class="list-inline">
                                                <li title="Dirección">
                                                    <i class="icon-pointer"></i> <span class="status_direccion"> Dirección </span>
                                                </li>
                                                <li title="Nivel">
                                                    <i class="icon-briefcase"></i> <span class="status_nivel"> Nivel </span>
                                                </li>
                                                <li title="Género">
                                                    <i class="icon-symbol-male"></i> <span class="status_genero"> Género </span>
                                                </li>
                                                <li title="Teléfono">
                                                    <i class="icon-screen-smartphone"></i> <span class="status_telefono"> Teléfono </span>
                                                </li>
                                                <li title="Email">
                                                    <i class="icon-envelope"></i> <span class="status_email"> Email </span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--tab_1_2-->
                        <div class="tab-pane" id="tab_1_2">
                            <div class="row profile-account">
                                <div class="col-md-3 col-xs-12">
                                    <ul class="ver-inline-menu tabbable margin-bottom-10">
                                        <li class="active">
                                            <a data-toggle="tab" href="#tab_1-1">
                                                <i class="icon-user"></i> Informacion Personal
                                            </a>
                                            <span class="after"> </span>
                                        </li>
                                        <li>
                                            <a data-toggle="tab" href="#tab_2-2">
                                                <i class="icon-picture"></i> Avatar
                                            </a>
                                        </li>
                                        <li>
                                            <a data-toggle="tab" href="#tab_3-3">
                                                <i class="icon-lock"></i> Seguridad
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-9 col-xs-12">
                                    <div class="tab-content">
                                        <div id="tab_1-1" class="tab-pane active">
                                            <form role="form" action="#" id="info-usuario_form">
                                                <input type="hidden" value="" name="id_usu" autocomplete="off"/>
                                                <div class="form-group">
                                                <spab class="required"> * (Campos Requeridos) </spab>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Nombre <span class="required">*</span></label>
                                                    <input type="text" placeholder="Ingresa un nombre" class="form-control" name="nombre" title="Ej: Yonathan Moncada" onkeyup="info_change_detected()"/>
                                                    <span class="help-block"></span>
                                                </div>
                                                <div class="form-group">
                                                    <label>Usuario</label>
                                                    <div class="form-group" id="keyInput_usu">
                                                        <input type="text" id="usuario" class="form-control" name="usuario" placeholder="Ingresa un usuario" title="Ej: yomoncada" readonly="">
                                                    </div>
                                                    <span class="help-block"></span>
                                                    <!-- /input-group -->
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Biografía </label>
                                                    <textarea  placeholder="Ingresa una biografía" class="form-control" name="biografia" onkeyup="info_change_detected()"></textarea>
                                                    <span class="help-block"></span>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Teléfono <span class="required">*</span></label>
                                                    <input type="text" placeholder="Ingresa un teléfono" data-mask="(9999) 999-9999" class="form-control" name="telefono" onkeyup="info_change_detected()"/>
                                                    <span class="help-block"></span>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Email <span class="required">*</span></label>
                                                    <input type="text" placeholder="Ingresa un email" class="form-control" name="email" onkeyup="info_change_detected()"/>
                                                    <span class="help-block"></span>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Género </label>
                                                    <select class="form-control" name="genero" onkeyup="info_change_detected()">
                                                        <option value="">--- Elige un Género ---</option>
                                                        <option value="Femenino">Femenino</option>
                                                        <option value="Masculino">Masculino</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Dirección </label>
                                                    <textarea  placeholder="Ingresa una dirección" class="form-control" name="direccion" onkeyup="info_change_detected()"></textarea>
                                                    <span class="help-block"></span>
                                                </div>
                                                <div class="margin-top-10">
                                                    <button class="btn green-turquoise" id="btnInfo_usu" onclick="update_info()" title="Este botón se activará al realizar un cambio."> Guardar </button>
                                                    <a href="<? echo site_url('index'); ?>" class="btn btn-default"> Cancelar </a>
                                                </div>
                                            </form>
                                        </div>
                                        <div id="tab_2-2" class="tab-pane">
                                            <form action="javascript:;" id="form-upload">            
                                                <div class="form-group">
                                                    <div id="file_status" class="fileinput fileinput-new" data-provides="fileinput">
                                                        <div class="fileinput-new thumbnail" style="width: 200px; height: 200px;">
                                                            <img src="<?echo base_url();?>assets/pages/img/avatar.svg" alt="" class="profile_avatar" /> </div>
                                                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 200px;"> </div>
                                                        <div>
                                                            <span class="btn default btn-file">
                                                                <span class="fileinput-new"> Seleccionar </span>
                                                                <span class="fileinput-exists"> Cambiar </span>
                                                                <input type="file" name="file"> </span>
                                                            <a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput"> Quitar </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="margin-top-10">
                                                    <button type="submit" class="btn green-turquoise" onclick="update_avatar()"> Guardar </button>
                                                    <a href="<? echo site_url('index'); ?>" class="btn btn-default"> Cancelar </a>
                                                </div>
                                            </form>
                                        </div>
                                        <div id="tab_3-3" class="tab-pane">
                                            <form role="form" action="#" id="security-usuario_form">
                                                <input type="hidden" value="" name="id_usu" autocomplete="off"/>
                                                 <div class="form-group">
                                                <label class="required"> * (Campos Requeridos) </label>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Contraseña Actual <span class="required">*</span></label>
                                                    <input type="password" placeholder="Ingresa tu contraseña actual" id="con_act" name="contrasena_actual" class="form-control" onkeyup="validate_contrasena('<?echo $this->session->userdata('usuario');?>')"/>
                                                    <span class="help-block"></span>
                                                </div>
                                                <div class="form-group">
                                                    <label for="contrasena1" class="control-label">Nueva Contraseña <span class="required">*</span></label>
                                                    <input type="password" placeholder="Ingresa una nueva contraseña" id="contrasena1" name="contrasena" class="form-control" onkeyup="validate_contrasena('<?echo $this->session->userdata('usuario');?>')"/>
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
                                                    <label class="control-label">Repetir Contraseña <span class="required">*</span></label>
                                                    <input type="password" placeholder="Repite tu nueva contrasena" id="contrasena2" name="repetir_contrasena" class="form-control" onkeyup="validate_contrasena('<?echo $this->session->userdata('usuario');?>')"/>
                                                    <span class="help-block"></span>
                                                </div>
                                                <div class="form-group">
                                                    <label>Pregunta Secreta <span class="required">*</span></label>
                                                    <select class="form-control" name="pregunta" onkeyup="security_change_detected()">
                                                        <option value="">--- Elige una pregunta ---</option>
                                                        <option>¿Cuál fue el nombre de tu primera mascota?</option>
                                                        <option>¿Cuál es la profesión de tu abuelo?</option>
                                                        <option>¿Cómo se llama tu mejor amigo de la infancia?</option>
                                                        <option>¿Cuál fue tu clase favorita en el colegio?</option>
                                                    </select>
                                                    <span class="help-block"></span>
                                                </div>
                                                <div class="form-group">
                                                        <label>Respuesta <span class="required">*</span></label>
                                                    <input type="password" class="form-control" name="respuesta" placeholder="Ingresa un respuesta" title="Ej: ¿Cuál es la profesión de tu abuelo? - Agricultor" autocomplete="off" onkeyup="security_change_detected()">
                                                    <span class="help-block"></span>
                                                </div>
                                                <div class="margin-top-10">
                                                    <button class="btn green-turquoise" id="btnSecurity_usu" onclick="update_security()"> Guardar </button>
                                                    <a href="<? echo site_url('index'); ?>" class="btn btn-default"> Cancelar </a>
                                                </div>
                                            </form>
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
    <script src="<? echo base_url(); ?>assets/apps/scripts/perfiles.js" type="text/javascript"></script>
    </body>
</html>