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
                    <h1>Perfil
                        <small>Accesos directos e información relevante.</small>
                    </h1>
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
                            <a href="#tab_1_2" data-toggle="tab"><i class="icon-eye"></i> Detalles </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1_1">
                            <div class="row">
                                <div class="col-md-3">
                                    <ul class="list-unstyled profile-nav">
                                        <li>
                                            <img src="<?echo base_url();?>assets/pages/img/avatar.svg" class="img-responsive pic-bordered profile_avatar" alt="Avatar"/>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-9">
                                    <div class="row">
                                        <div class="col-lg-8 profile-info">
                                            <h3 class="font-green sbold"> <?if($usuario['nombre'] == ''){ echo "Indefinido";}else{ echo $usuario['nombre'];}?> </h3>
                                            <h5 class="sbold"> @<?echo $usuario['usuario'];?> </h5>
                                            <p><?if($usuario['biografia'] == ''){ echo "Indefinida";}else{ echo $usuario['biografia'];}?>
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
                                <div class="col-md-3">
                                    <ul class="ver-inline-menu tabbable margin-bottom-10">
                                        <li class="active">
                                            <a data-toggle="tab" href="#tab_1-1">
                                                <i class="icon-user"></i> Informacion Personal
                                            </a>
                                            <span class="after"> </span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-9">
                                    <div class="tab-content">
                                        <div id="tab_1-1" class="tab-pane active">
                                            <form role="form" action="#">
                                                <div class="form-group">
                                                    <input type="hidden" name="profile_avatar" value="<?echo $profile_avatar;?>">
                                                    <label class="control-label">Nombre</label>
                                                    <input type="text" class="form-control" name="nombre" readonly=""/>
                                                    <span class="help-block"></span>
                                                </div>
                                                <div class="form-group">
                                                    <label>Usuario</label>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="usuario" readonly="">
                                                    </div>
                                                    <span class="help-block"></span>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Biografía </label>
                                                    <textarea class="form-control" name="biografia" readonly=""></textarea>
                                                    <span class="help-block"></span>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Teléfono</label>
                                                    <input type="text" class="form-control" name="telefono" readonly=""/>
                                                    <span class="help-block"></span>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Email</label>
                                                    <input type="text" class="form-control" name="email" readonly/>
                                                    <span class="help-block"></span>
                                                </div>
                                                <div class="form-group">
                                                <label class="control-label">Género</label>
                                                    <input class="form-control" name="genero" readonly=""/>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Dirección</label>
                                                    <textarea class="form-control" readonly="" name="direccion"></textarea>
                                                    <span class="help-block"></span>
                                                </div>
                                                <div class="margin-top-10">
                                                    <a href="<? echo site_url('index'); ?>" class="btn btn-default"> Volver </a>
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
        <!-- END CONTENT -->
    <script src="<? echo base_url(); ?>assets/apps/scripts/perfiles.js" type="text/javascript"></script>
    </body>
</html>