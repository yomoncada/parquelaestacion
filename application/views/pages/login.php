<!DOCTYPE html>
<!-- 
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.6
Version: 4.6
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
Renew Support: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title>Aplicación Web del Parque La Estación</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
    </head>
    <body class="login">
        <!-- BEGIN LOGO -->
        <div class="logo animated fadeIn">
            <a class="link-logo" href="<?echo site_url('login');?>">
	        	<img src="<? echo base_url();?>/assets/pages/img/isotype.svg" width="100">
                <h2 class="logo-default">PARQUE LA ESTACIÓN</h2>
            </a>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN LOGIN -->
        <div class="content">
            <!-- BEGIN LOGIN FORM -->
            <form action="javascript:;" method="post" id="login_form" class="animated fadeIn">
                <div class="form-title">
                    <span class="form-title"> Inicio de Sesión </span>
                    <br>
                    <span class="form-subtitle">Bienvenido a la aplicación web, ingresa tus datos</span>
                </div>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">Usuario</label>
                    <input class="form-control form-control-solid placeholder-no-fix" id="usuario" type="text" autocomplete="off" placeholder="Usuario" name="usuario" />
                    <span class="help-block"></span>
                </div>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">Contraseña</label>
                    <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="Contraseña" name="contrasena" />
                    <span class="help-block"></span>
                </div>
                    <button id="btnLogin" onclick="validate_usuario()" class="btn green-turquoise btn-block uppercase">Ingresar</button>
                <div class="form-actions">
                    <div class="pull-right forget-password-block">
                        <a href="javascript:;" class="forget-password" onclick="forget_form()">¿Olvidaste tu contraseña?</a>
                    </div>
                </div>
            </form>
            <!-- END LOGIN FORM -->
            <!-- BEGIN FORGOT PASSWORD FORM -->
            <form action="javascript:;" method="post" id="forget_form" class="animated fadeIn">
                <div class="form-title">
                    <span class="form-title">Recuperación de Contraseña</span>
                    <br>
                    <span class="form-subtitle">Ingresa los siguientes datos para verificar tu identidad:</span>
                </div>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">Usuario</label>
                    <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Usuario" name="usuario"/>
                    <span class="help-block"></span>
                </div>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">Pregunta</label>
                    <select class="form-control" name="pregunta">
                        <option value="">--- Eige una pregunta secreta ---</option>
                        <option>¿Cuál fue el nombre de tu primera mascota?</option>
                        <option>¿Cuál es la profesión de tu abuelo?</option>
                        <option>¿Cómo se llama tu mejor amigo de la infancia?</option>
                        <option>¿Cuál fue tu clase favorita en el colegio?</option>
                    </select>
                    <span class="help-block"></span>
                </div>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">Respuesta</label>
                    <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Respuesta" name="respuesta"/>
                    <span class="help-block"></span>
                </div>
                <div class="form-actions">
                    <button id="btnForget" class="btn green-turquoise uppercase pull-right" onclick="recover_password()">Recuperar</button>
                    <a id="back-btn" class="btn btn-default" onclick="login_form()">Volver</a>
                </div>
            </form>
            <div class="invoice-content-2 animated fadeIn" id="temporal_password">
                <div class="row invoice-head">
                    <div class="col-sm-12 col-xs-12">
                        <div class="row">
                            <div class="col-xs-12">
                                <h2 class="invoice-title uppercase font-green-turquoise">Contraseña Temporal</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xs-12">
                        <div class="invoice-logo">
                            <h1 class="uppercase" id="random_password">0</h1>
                        </div>
                    </div>
                    <div class="form-actions">
                        <a id="back-btn" class="btn btn-default" onclick="login_form()">Volver</a>
                    </div>
                </div>
            </div>
            <!-- END FORGOT PASSWORD FORM -->
        </div>
        <div class="copyright font-grey-mint animated fadeIn">2017 &copy; Parque La Estación. Adaptado por
                <a target="_blank" href="">LMY Development</a>. </div>
        <script src="<? echo base_url(); ?>assets/apps/scripts/sistema.js" type="text/javascript"></script>
        <style type="text/css">
            .invoice-content-2 
            {
                text-align: center;
            }
            .invoice-logo > h1
            {
                margin-top: 0 !important;
                float: none !important;
            }
            .form-title 
            {
                text-align: center;
            }
        </style>
    </body>
</html>