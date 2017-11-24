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
    <body>
    <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <!-- BEGIN PAGE HEAD-->
                    <div class="page-head">
                        <!-- BEGIN PAGE TITLE -->
                        <div class="page-title animated fadeInLeft">
                            <h1>Inicio
                                <small>Accesos directos e información relevante.</small>
                            </h1>
                        </div>
                        <!-- END PAGE TITLE -->
                    </div>
                    <!-- END PAGE HEAD-->
                    <!-- BEGIN PAGE BREADCRUMB -->
                    <ul class="page-breadcrumb breadcrumb">
                        <li>
                            <span class="active">Inicio</span>
                        </li>
                    </ul>
                    <!-- END PAGE BREADCRUMB -->
                    <!-- BEGIN PAGE BASE CONTENT -->
                    <!-- BEGIN CONTENT HEADER -->
                    <div class="row margin-bottom-25 animated fadeIn">
                        <div class="col-md-12 about-header">
                            <div class="col-md-12">
                                <h1>Parque La Estación</h1>
                                <h3>Aplicación Web para el Manejo de sus Procesos Administrativos y Publicidad</h3>
                            </div>
                        </div>
                    </div>
                    <!-- END CONTENT HEADER -->
                    <!-- BEGIN CARDS -->
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-6 animated fadeInDown">
                            <div class="portlet light">
                                <div class="card-icon">
                                    <i class="icon-note font-green theme-font"></i>
                                </div>
                                <div class="card-title">
                                    <?if($this->session->userdata('nivel') == 'Administrador(a)'){?>
                                    <a href="<?echo site_url('censo');?>"> Censos </a>
                                    <?}
                                    else{?>
                                    <a href="javascript:;"> Censos </a>
                                    <?}?>
                                </div>
                                <div class="card-desc">
                                    <span class="font-green"> <?echo $censos;?> </span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-3 col-md-6 col-sm-6 animated fadeInDown">
                            <div class="portlet light">
                                <div class="card-icon">
                                    <i class="icon-heart font-blue theme-font"></i>
                                </div>
                                <div class="card-title">
                                    <?if($this->session->userdata('nivel') == 'Administrador(a)'){?>
                                    <a href="<?echo site_url('donacion');?>"> Donaciones </a>
                                    <?}
                                    else{?>
                                    <a href="javascript:;"> Donaciones </a>
                                    <?}?>
                                </div>
                                <div class="card-desc">
                                    <span class="font-blue"> <?echo $donaciones;?> </span>
                                </div>
                            </div>
                        </div>
                    
                        <div class="col-lg-3 col-md-6 col-sm-6 animated fadeInDown">
                            <div class="portlet light">
                                <div class="card-icon">
                                    <i class="icon-wrench font-blue-madison theme-font"></i>
                                </div>
                                <div class="card-title">
                                    <?if($this->session->userdata('nivel') == 'Administrador(a)'){?>
                                    <a href="<?echo site_url('mantenimiento');?>"> Mantenimientos </a>
                                    <?}
                                    else{?>
                                    <a href="javascript:;"> Mantenimientos </a>
                                    <?}?>
                                </div>
                                <div class="card-desc">
                                    <span class="font-blue-madison"> <?echo $mantenimientos;?> </span>
                                </div>
                            </div>
                        </div>


                        <div class="col-lg-3 col-md-6 col-sm-6 animated fadeInDown">
                            <div class="portlet light">
                                <div class="card-icon">
                                    <i class="icon-drop theme-font" style="color: #3d556d;"></i>
                                </div>
                                <div class="card-title">
                                    <?if($this->session->userdata('nivel') == 'Administrador(a)'){?>
                                    <a href="<?echo site_url('reforestacion');?>"> Reforestaciones </a>
                                    <?}
                                    else{?>
                                    <a href="javascript:;"> Reforestaciones </a>
                                    <?}?>
                                </div>
                                <div class="card-desc">
                                    <span style="color: #3d556d;"> <?echo $reforestaciones;?> </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END CARDS -->
                    <!-- BEGIN TEXT & VIDEO -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 animated fadeInLeft">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="portlet light about-text">
                                                <h4>
                                                    <i class="fa fa-check icon-trophy"></i> Misión 
                                                </h4>
                                                <div class="park-info-container">
                                                    <p class="park-info-description"> Buscamos el desarrollo de las obras, actividades y programas de indole cultural, educativo, ecológico, deportivo y turistico para el beneficio de todos nuestros visitantes mediante una labor de equipo con convicción y gerencia eficiente en pro de alcanzar todos los objetivos planteados y con la participacion de la ciudadania con el fin de elevar en nivel de calidad de vida.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="portlet light about-text">
                                                <h4>
                                                <i class="fa fa-check icon-eye"></i> Visión 
                                                </h4>
                                                <div class="park-info-container">
                                                    <p class="park-info-description"> Queremos hacer del parque, un punto de encuentro de referencia turistico local, regional y nacional, de sano esparcimiento donde se ofrezcan actividades que apunten hacia el desarrollo de actitudes y aptitudes que favorezcan el crecimiento integral del ser humano y siempre respetando el equilibrio ecológico, buscando mejorar y aumentar el turismo en Venezuela.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 animated fadeInRight">
                                    <div class="mt-element-list">
                                        <div class="mt-list-head list-default green-turquoise">
                                            <div class="row">
                                                <div class="col-xs-8">
                                                    <div class="list-head-title-container">
                                                        <h4 class="list-title list-header sbold"><i class="fa fa-check icon-drawer"></i> Registros Maestros</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-list-container list-default list-container">
                                            <ul>
                                                <li class="mt-list-item">
                                                    <div class="list-icon-container font-green">
                                                        <a href="javascript:;">
                                                            <i class="icon-bulb font-green"></i>
                                                        </a>
                                                    </div>
                                                    <div class="list-datetime list-count font-green"><?echo $especies;?></div>
                                                    <div class="list-item-content">
                                                        <h3 class="bold">
                                                            <a href="javascript:;">Especies</a>
                                                        </h3>
                                                        <p>Flora y Fauna.</p>
                                                    </div>
                                                </li>
                                                <li class="mt-list-item">
                                                    <div class="list-icon-container e">
                                                        <a href="javascript:;">
                                                            <i class="icon-puzzle font-blue"></i>
                                                        </a>
                                                    </div>
                                                    <div class="list-datetime list-count font-blue"><?echo $areas + $cabanas + $canchas + $edificios;?></div>
                                                    <div class="list-item-content">
                                                        <h3 class="bold">
                                                            <a href="javascript:;">Instalaciones</a>
                                                        </h3>
                                                        <p>Areas, Cabañas, Canchas y Edificios.</p>
                                                    </div>
                                                </li>
                                                <li class="mt-list-item">
                                                    <div class="list-icon-container ">
                                                        <a href="javascript:;">
                                                            <i class="icon-social-dropbox font-blue-madison"></i>
                                                        </a>
                                                    </div>
                                                    <div class="list-datetime list-count font-blue-madison"><?echo $categorias + $implementos;?></div>
                                                    <div class="list-item-content">
                                                        <h3 class="bold">
                                                            <a href="javascript:;">Inventarios</a>
                                                        </h3>
                                                        <p>Categoria e Implementos.</p>
                                                    </div>
                                                </li>
                                                <li class="mt-list-item">
                                                    <div class="list-icon-container">
                                                        <a href="javascript:;">
                                                            <i class="icon-users" style="color: #3d556d"></i>
                                                        </a>
                                                    </div>
                                                    <div class="list-datetime list-count" style="color: #3d556d"><?echo $beneficiarios + $donantes + $empleados;?></div>
                                                    <div class="list-item-content">
                                                        <h3 class="bold">
                                                            <a href="javascript:;">Personas</a>
                                                        </h3>
                                                        <p>Beneficiarios, Donantes y Empleados.</p>
                                                    </div>
                                                </li>
                                            
                                            </ul>
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
    </body>

</html>