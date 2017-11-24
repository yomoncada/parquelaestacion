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
                        <h1>Implementos</h1>
                    </div>
                    <!-- END PAGE TITLE -->
                    <!-- BEGIN PAGE TOOLBAR -->
                    <div class="page-toolbar">
                        <!-- BEGIN THEME PANEL -->
                        <div class="btn-group btn-theme-panel animated fadeInRight">
                            <a href="#" onclick="add_implemento()" class="btn" title="Agregar">
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
                        <span class="active">Implementos</span>
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
                                    <span class="caption-subject bold uppercase">Listado de Implementos</span>
                                </div>
                                <div class="tools"> </div>
                            </div>
                            <div class="portlet-body">
                                <table id="implementos" class="table table-hover table-bordered small">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Código</th>
                                            <th>Nombre</th>
                                            <th>Categoría</th>
                                            <th>Stock</th>
                                            <th>Unidad</th>
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
                <div class="modal fade" id="implemento-modal" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                                <div class="caption font-dark">
                                    <i id="icon" class="icon-plus font-dark"></i>
                                    <span class="caption-subject bold uppercase implemento-modal-title">Título</span>
                                </div>
                            </div>
                            <div class="modal-body">
                                <form action="#" id="implemento_form">
                                    <input type="hidden" value="" name="id_imp" autocomplete="off"/>
                                    <div class="form-group">
                                        <span class="required"> * (Campos Requeridos) </span>
                                    </div>
                            		<div class="form-group">
                                        <label>Código <span class="required">*</span></label>
                                        <input type="text" id="codigo_imp" class="form-control" name="codigo" placeholder="Ingresa un código" title="Ej: CC41" autocomplete="off" onkeyup="search_implemento()" required>
                                        <span class="help-block"></span>
                                    </div>
                                    <div class="form-group">
                                    	<label>Nombre <span class="required">*</span></label>
                                        <input type="text" class="form-control" name="nombre" placeholder="Ingresa un nombre" title="Ej: Botas" autocomplete="off" required>
                                        <span class="help-block"></span>
                                   	</div>
                                   	<div class="form-group">
                                       	<label>Categoría <span class="required">*</span></label>
                                       	<select class="form-control" name="categoria">
                                            <option value="">--- Elige un categoría ---</option>
                                            <?foreach ($categorias as $categoria):?>
                                            <option value="<?echo $categoria['id_cat'];?>"><?echo $categoria['categoria'];?></option>
                                            <?endforeach;?>
                                        </select>
                                        <span class="help-block"></span>
                                    </div>
                                    <div class="form-group">
                                    	<label>Stock <span class="required">*</span></label>
                                        <input type="number" class="form-control" id="stock" name="stock" onChange="validate_stock()" placeholder="Ingresa un stock" title="Ej: 50" required autocomplete="off">
                                        <span class="help-block"></span>
                                   	</div>
                                    <div class="form-group">
                                        <label>Stock Mínimo <span class="required">*</span></label>
                                        <input type="number" class="form-control" id="stock_min" name="stock_min" onChange="validate_stock()" placeholder="Ingresa un stock mínimo" title="Ej: 0" autocomplete="off" required>
                                        <span class="help-block"></span>
                                    </div>
                                    <div class="form-group">
                                        <label>Stock Máximo <span class="required">*</span></label>
                                        <input type="number" class="form-control" id="stock_max" name="stock_max" onChange="validate_stock()" placeholder="Ingresa un stock máximo" title="Ej: 100" autocomplete="off" required>
                                        <span class="help-block"></span>
                                    </div>
                                   	<div class="form-group">
                                        <label>Unidad <span class="required">*</span></label>
                                        <select class="form-control" name="unidad">
                                            <option value="">--- Elige una unidad ---</option>
                                            <option>Kilogramos</option>
                                            <option>Gramos</option>
                                            <option>Litros</option>
                                            <option>Miliitros</option>
                                            <option>Unidades</option>
                                        </select>
                                        <span class="help-block"></span>
                                    </div>
                            	</form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="btnSave_imp" onclick="save_implemento()" class="btn green-turquoise">Guardar</button>
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
        <script src="<? echo base_url(); ?>assets/apps/scripts/implementos.js" type="text/javascript"></script>
    </body>
</html>