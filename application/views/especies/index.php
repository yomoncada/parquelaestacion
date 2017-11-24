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
                        <h1>Especies</h1>
                    </div>
                    <!-- END PAGE TITLE -->
                    <!-- BEGIN PAGE TOOLBAR -->
                    <div class="page-toolbar animated fadeInRight">
                        <!-- BEGIN THEME PANEL -->
                        <div class="btn-group btn-theme-panel">
                            <a href="#" onclick="add_especie()" class="btn" title="Agregar">
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
                        <a href="<? echo site_url('home'); ?>">Inicio</a>
                        <i class="fa fa-chevron-right"></i>
                    </li>
                    <li>
                        <span class="active">Especies</span>
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
                                    <span class="caption-subject bold uppercase">Listado de Especies</span>
                                </div>
                                <div class="tools"> </div>
                            </div>
                            <div class="portlet-body">
                                <table id="especies" class="table table-hover table-bordered small">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Código</th>
                                            <th>Nombre Común</th>
                                            <th>Tipo</th>
                                            <th>Población</th>
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
                <div class="modal fade" id="especie-modal" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                                <div class="caption font-dark">
                                    <i id="icon" class="icon-plus font-dark"></i>
                                    <span class="caption-subject bold uppercase especie-modal-title">Título</span>
                                </div>
                            </div>
                            <div class="modal-body">
                                <form action="#" id="especie_form">
                                    <input type="hidden" value="" name="id_esp" autocomplete="off"/> 
                                    <div class="form-group">
                                        <span class="required"> * (Campos Requeridos) </span>
                                    </div>
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label>Código <span class="required">*</span></label>
                                            <input name="codigo" id="codigo_esp" placeholder="Ingresa un codigo" title="Ej: AA10" class="form-control" type="text" autocomplete="off" onkeyup="search_especie()" required>
                                            <span class="help-block"></span>
                                        </div>
                                        <div class="form-group">
                                            <label>Nombre Común <span class="required">*</span></label>
                                            <input name="nom_cmn" placeholder="Ingresa un nombre común" class="form-control" type="text" autocomplete="off" required>
                                            <span class="help-block"></span>
                                        </div>
                                        <div class="form-group">
                                            <label>Nombre Cientifico <span class="required">*</span></label>
                                            <input type="text" class="form-control" placeholder="Ingresa un nombre" title="Ej: Tebebuia Rosea" name="nom_cntfc" required>
                                            <span class="help-block"></span>
                                        </div>
                                        <div class="form-group">
                                            <label>Familia <span class="required">*</span> </label>
                                            <input type="text" class="form-control" placeholder="Ingresa un nombre" title="Ej: Bignoniaceae" name="flia" required>
                                            <span class="help-block"></span>
                                        </div>
                                        <div class="form-group">
                                            <label>Tipo <span class="required">*</span></label>
                                            <select class="form-control" name="tipo" required>
                                                <option value="">--- Elige un tipo ---</option>
                                                <option>Fauna</option>
                                                <option>Flora</option>
                                            </select>
                                            <span class="help-block"></span>
                                        </div>
                                        <div class="form-group">
                                            <label>Población <span class="required">*</span></label>
                                            <input type="number" id="poblacion" onChange="validate_poblacion()" class="form-control" placeholder="Ingresa una población" title="Ej: 50" name="poblacion" required>
                                            <span class="help-block"></span>
                                        </div>
                                        <div class="form-group">
                                            <label>Riesgo <span class="required">*</span></label>
                                            <input type="number" id="riesgo" onChange="validate_poblacion()" class="form-control" placeholder="Ingresa un rango de riesgo" title="Ej: 15" name="riesgo" required>
                                            <span class="help-block"></span>
                                        </div>
                                        <div class="form-group">
                                            <label>Extinción <span class="required">*</span></label>
                                            <input type="number" id="extincion" onChange="validate_poblacion()" class="form-control" placeholder="Ingresa un rango de extinción" title="Ej: 0" name="extincion" required>
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="btnSave_esp" onclick="save_especie()" class="btn green-turquoise">Guardar</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END PAGE BASE CONTENT -->
            </div>
            <!-- END CONTENT BODY -->
        </div>
        <!-- END CONTENT -->
        <script src="<? echo base_url(); ?>assets/apps/scripts/especies.js" type="text/javascript"></script>
    </body>
</html>