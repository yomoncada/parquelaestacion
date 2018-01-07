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
        <div class="page-content-wrapper">
            <div class="page-content">
                <div class="page-head">
                    <div class="page-title animated fadeInLeft">
                        <h1>Donaciones</h1>
                    </div>
                </div>
                <ul class="page-breadcrumb breadcrumb animated fadeInLeft">
                    <li>
                        <a href="<? echo site_url('index'); ?>">Inicio</a>
                        <i class="fa fa-chevron-right"></i>
                    </li>
                    <li>
                        <a href="<? echo site_url('donacion'); ?>">Donaciones</a>
                        <i class="fa fa-chevron-right"></i>
                    </li>
                    <li>
                        <span class="active">Nuevo</span>
                    </li>
                </ul>
                <div class="invoice-content-2 animated fadeIn">
                    <div class="row invoice-head">
                        <div class="col-sm-6 col-xs-12">
                            <div class="invoice-logo">
                                <h1 class="uppercase">N° <?echo $total_don+1;?></h1>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-12">
                            <div class="row">
                                <div class="col-xs-6">
                                    <h2 class="invoice-title uppercase font-green-turquoise">Responsable</h2>
                                    <p class="invoice-desc"><?echo $this->session->userdata('usuario');?></p>
                                </div>
                                <div class="col-xs-6">
                                    <h2 class="invoice-title uppercase font-green-turquoise">Fecha</h2>
                                    <p class="invoice-desc"><?echo @date('d-m-Y');?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="portlet light bordered flip-scroll animated fadeIn">
                            <div class="portlet-title">
                                <div class="caption font-dark">
                                    <i class="icon-plus"></i>
                                    <span class="caption-subject bold uppercase">Asignación de los Registros Maestros</span>
                                </div>
                                <div class="tools"> </div>
                            </div>
                            <div class="portlet-body">
                                <div class="row">
                                    <div class="col-sm-4 col-xs-12">
                                        <div class="mt-widget-3" style="margin-bottom: 1em;">
                                            <div class="mt-head bg-green">
                                                <div class="mt-head-icon">
                                                    <i class="icon-users"></i>
                                                </div>
                                                <div class="mt-head-desc" style="margin-top: 1em;">Donantes</div>
                                                <h3 id="count_donantes" class="mt-head-date"> 0 </h3>
                                            </div>
                                            <div class="mt-body-actions-icons">
                                                <div class="btn-group btn-group btn-group-justified">
                                                    <a data-toggle="modal" href="#lista_donantes" class="btn btn-link" title="Agregar">
                                                        <span class="mt-icon">
                                                            <i class="icon-plus"></i>
                                                        </span>
                                                    </a>
                                                    <a data-toggle="modal" href="#lista_donantes_asignados" class="btn btn-link" title="Listar">
                                                        <span class="mt-icon">
                                                            <i class="icon-list"></i>
                                                        </span>
                                                    </a>
                                                    <a href="javascript:;" class="btn btn-link" onclick="clear_donantes()" title="Reiniciar">
                                                        <span class="mt-icon">
                                                            <i class="icon-reload"></i>
                                                        </span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xs-12">
                                        <div class="mt-widget-3" style="margin-bottom: 1em;">
                                            <div class="mt-head bg-blue">
                                                <div class="mt-head-icon">
                                                    <i class=" icon-puzzle"></i>
                                                </div>
                                                <div class="mt-head-desc" style="margin-top: 1em;"> Implementos</div>
                                                <h3 id="count_implementos" class="mt-head-date"> 0 </h3>
                                            </div>
                                            <div class="mt-body-actions-icons">
                                                <div class="btn-group btn-group btn-group-justified">
                                                    <a data-toggle="modal" href="#lista_implementos" class="btn btn-link" title="Agregar">
                                                        <span class="mt-icon">
                                                            <i class="icon-plus"></i>
                                                        </span>
                                                    </a>
                                                    <a data-toggle="modal" href="#lista_implementos_asignados" class="btn btn-link" title="Listar">
                                                        <span class="mt-icon">
                                                            <i class="icon-list"></i>
                                                        </span>
                                                    </a>
                                                    <a href="javascript:;" class="btn btn-link" onclick="clear_implementos()" title="Reiniciar">
                                                        <span class="mt-icon">
                                                            <i class="icon-reload"></i>
                                                        </span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xs-12">
                                        <div class="mt-widget-3" style="margin-bottom: 1em;">
                                            <div class="mt-head" style="background: #3d556d;">
                                                <div class="mt-head-icon">
                                                    <i class="icon-wallet"></i>
                                                </div>
                                                <div class="mt-head-desc" style="margin-top: 1em;"> Fondos</div>
                                                <h3 class="mt-head-date"> Bs. F <span id="count_fondos">0</span> VEF </h3>
                                            </div>
                                            <div class="mt-body-actions-icons">
                                                <div class="btn-group btn-group btn-group-justified">
                                                    <a href="javascript:;" class="btn btn-link" onclick="assign_fondo()" title="Agregar">
                                                        <span class="mt-icon">
                                                            <i class="icon-plus"></i>
                                                        </span>
                                                    </a>
                                                    <a data-toggle="modal" href="#lista_fondos_asignados" class="btn btn-link" title="Listar">
                                                        <span class="mt-icon">
                                                            <i class="icon-list"></i>
                                                        </span>
                                                    </a>
                                                    <a href="javascript:;" class="btn btn-link" onclick="clear_fondos()" title="Reiniciar">
                                                        <span class="mt-icon">
                                                            <i class="icon-reload"></i>
                                                        </span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="portlet light bordered flip-scroll animated fadeIn">
                            <div class="portlet-title">
                                <div class="caption font-dark">
                                    <i class="icon-eye"></i>
                                    <span class="caption-subject bold uppercase">Declaración de Observaciones</span>
                                </div>
                            </div>
                            <div class="portlet-body form">
                                <form id="donacion_form" action="#" role="form">
                                    <div class="form-group">
                                        <label>Observación</label>
                                        <textarea class="form-control" placeholder="Ingresa una observación" title="Ej: La razón de la donación" name="observacion" rows="8" autocomplete="off" required></textarea>
                                        <span class="help-block"></span>
                                    </div>
                                    <div class="form-actions" style="text-align: right;">
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <a href="<?echo site_url('donacion');?>" class="btn btn-default"> Cancelar </a>
                                                <button id="btnSave_dnc" type="button" class="btn green-turquoise" onclick="process()"> Procesar</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade bs-modal-lg" id="lista_donantes" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                                <div class="caption font-dark">
                                    <i class="icon-list font-dark"></i>
                                    <span class="caption-subject bold uppercase">Listado de Donantes</span>
                                    <div class="btn-group">
                                        <a href="#" onclick="add_donante()" class="btn-link" style="padding: 0em 1em;" title="Agregar">
                                            <i class="icon-plus"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-body">
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
                                                    <table id="donantes_activos" class="table table-hover table-bordered small">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Rif</th>
                                                                <th>Razón Social</th>
                                                                <th>Teléfono</th>
                                                                <th>Dirección</th>
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
                                                    <table id="donantes_inactivos" class="table table-hover table-bordered small">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Rif</th>
                                                                <th>Razón Social</th>
                                                                <th>Teléfono</th>
                                                                <th>Dirección</th>
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
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal"> Cancelar </button>
                                <button type="button" class="btn green-turquoise" data-dismiss="modal"> Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal2 fade" id="donante-modal" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                                <div class="caption font-dark">
                                    <i id="icon" class="icon-plus font-dark"></i>
                                    <span class="caption-subject bold uppercase donante-modal-title">Título</span>
                                </div>
                            </div>
                            <div class="modal-body">
                                <form action="#" id="donante_form">
                                    <input type="hidden" value="" name="id_don" autocomplete="off"/>
                                    <div class="form-group">
                                        <span class="required"> * (Campos Requeridos) </span>
                                    </div>
                                    <div class="form-group">
                                        <label>Rif <span class="required">*</span></label>
                                        <input type="text" id="rif_don" class="form-control" name="rif" placeholder="Ingresa un rif" title="Ej: J-274022589" data-mask="J-99999999-9" autocomplete="off" onchange="search_donante()" required>
                                        <span class="help-block"></span>
                                    </div>
                                    <div class="form-group">
                                        <label>Razón Social <span class="required">*</span></label>
                                        <input type="text" class="form-control" name="razon_social" placeholder="Ingresa una razón social" title="Ej: Los Donantes C.A" autocomplete="off" required>
                                        <span class="help-block"></span>
                                    </div>
                                    <div class="form-group">
                                        <label>Teléfono <span class="required">*</span></label>
                                        <input type="text" class="form-control" name="telefono" placeholder="Ingresa un teléfono" title="Ej: (0000) 123-4567" data-mask="(9999) 999-9999" required autocomplete="off">
                                        <span class="help-block"></span>
                                    </div>
                                    <div class="form-group">
                                        <label>Dirección <span class="required">*</span></label>
                                        <textarea class="form-control" rows="3" name="direccion" placeholder="Ingresa una dirección" title="Ej: La Victoria, Estado Aragua" autocomplete="off" required></textarea>
                                        <span class="help-block"></span>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="btnSave_don" onclick="save_donante()" class="btn green-turquoise">Guardar</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade bs-modal-md" id="lista_donantes_asignados" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-md">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <div class="caption font-dark">
                                    <i class="icon-list font-dark"></i>
                                    <span class="caption-subject bold uppercase">Listado de Donantes Asignados</span>
                                </div>
                            </div>
                            <div class="modal-body">
                                <table id="donantes_asignados" class="table table-hover table-bordered small">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Cédula</th>
                                            <th>Nombre</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal"> Cancelar </button>
                                <button type="button" class="btn green-turquoise" data-dismiss="modal"> Guardar </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade bs-modal-lg" id="lista_implementos" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                                <div class="caption font-dark">
                                    <i class="icon-list font-dark"></i>
                                    <span class="caption-subject bold uppercase">Listado de implementos</span>
                                    <div class="btn-group">
                                        <a href="#" onclick="add_implemento()" class="btn-link" style="padding: 0em 1em;" title="Agregar">
                                            <i class="icon-plus"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-body">
                                <div class="tabbable-line tabbable-full-width">
                                    <ul class="nav nav-tabs">
                                        <li class="active">
                                            <a href="#tab_1_3" data-toggle="tab"> Activos </a>
                                        </li>
                                        <li>
                                            <a href="#tab_1_4" data-toggle="tab"> Inactivos </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab_1_3">
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <table id="implementos_activos" class="table table-hover table-bordered small">
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
                                        <div class="tab-pane" id="tab_1_4">
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <table id="implementos_inactivos" class="table table-hover table-bordered small">
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
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal"> Cancelar </button>
                                <button type="button" class="btn green-turquoise" data-dismiss="modal"> Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal2 fade" id="implemento-modal" role="dialog" aria-hidden="true">
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
                                <button type="button" id="btnSave_are" onclick="save_implemento()" class="btn green-turquoise">Guardar</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade bs-modal-md" id="lista_implementos_asignados" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-md">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <div class="caption font-dark">
                                    <i class="icon-list font-dark"></i>
                                    <span class="caption-subject bold uppercase">Listado de implementos Asignados</span>
                                </div>
                            </div>
                            <div class="modal-body">
                                <table id="implementos_asignados" class="table table-hover table-bordered small">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Código</th>
                                            <th>Nombre</th>
                                            <th>Cantidad</th>
                                            <th>Unidad</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal"> Cancelar </button>
                                <button type="button" class="btn green-turquoise" data-dismiss="modal"> Guardar </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade bs-modal-md" id="lista_fondos_asignados" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-md">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <div class="caption font-dark">
                                    <i class="icon-list font-dark"></i>
                                    <span class="caption-subject bold uppercase">Listado de Actividades Asignadas</span>
                                </div>
                            </div>
                            <div class="modal-body">
                                <table id="fondos_asignados" class="table table-hover table-bordered small">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Cantidad</th>
                                            <th>Divisa</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal"> Cancelar </button>
                                <button type="button" class="btn green-turquoise" data-dismiss="modal"> Guardar </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="<? echo base_url(); ?>assets/apps/scripts/donantes.js" type="text/javascript"></script>
        <script src="<? echo base_url(); ?>assets/apps/scripts/implementos.js" type="text/javascript"></script>
        <script src="<? echo base_url(); ?>assets/apps/scripts/donaciones.js" type="text/javascript"></script>
    </body>
</html>