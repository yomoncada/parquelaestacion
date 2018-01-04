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
                        <h1>Servicios</h1>
                    </div>
                </div>
                <ul class="page-breadcrumb breadcrumb animated fadeInLeft">
                    <li>
                        <a href="<? echo site_url('index'); ?>">Inicio</a>
                        <i class="fa fa-chevron-right"></i>
                    </li>
                    <li>
                        <a href="<? echo site_url('servicio'); ?>">Servicios</a>
                        <i class="fa fa-chevron-right"></i>
                    </li>
                    <li>
                        <span class="active">Control</span>
                    </li>
                </ul>
                <div class="invoice-content-2 animated fadeIn">
                    <div class="row invoice-head">
                        <div class="col-sm-4 col-xs-12">
                            <div class="invoice-logo">
                                <h1 class="uppercase">N° <?echo $servicio['id_ser'];?></h1>
                            </div>
                        </div>
                        <div class="col-sm-8 col-xs-12">
                            <div class="row">
                                <div class="col-sm-4 col-xs-12">
                                    <h2 class="invoice-title uppercase font-green-turquoise">Responsable</h2>
                                    <p class="invoice-desc"><?echo $servicio['usuario'];?></p>
                                </div>
                                <div class="col-sm-4 col-xs-12">
                                    <h2 class="invoice-title uppercase font-green-turquoise">Última Modificación</h2>
                                    <p class="invoice-desc"><?echo $servicio['fecha_act'];?></p>
                                </div>
                                <div class="col-sm-4 col-xs-12">
                                    <h2 class="invoice-title uppercase font-green-turquoise">Estado</h2>
                                    <p class="invoice-desc"><?echo $servicio['estado'];?></p>
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
                                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                        <div class="mt-widget-3" style="margin-bottom: 1em;">
                                            <div class="mt-head bg-green">
                                                <div class="mt-head-icon">
                                                    <i class="icon-users"></i>
                                                </div>
                                                <div class="mt-head-desc" style="margin-top: 1em;">Beneficiarios</div>
                                                <h3 id="count_beneficiarios" class="mt-head-date"> 0 </h3>
                                            </div>
                                            <div class="mt-body-actions-icons">
                                                <div class="btn-group btn-group btn-group-justified">
                                                <?if($servicio['estado'] == 'Pendiente')
                                            	{?>
                                            		<a data-toggle="modal" href="#lista_beneficiarios" class="btn btn-link" title="Agregar">
                                                        <span class="mt-icon">
                                                            <i class="icon-plus"></i>
                                                        </span>
                                                    </a>
                                                <?}?>
                                                    <a data-toggle="modal" href="#lista_beneficiarios_asignados" class="btn btn-link" title="Listar">
                                                        <span class="mt-icon">
                                                            <i class="icon-list"></i>
                                                        </span>
                                                    </a>
                                                <?if($servicio['estado'] == 'Pendiente')
                                            	{?>
                                                    <a href="javascript:;" class="btn btn-link" onclick="clear_beneficiarios()" title="Reiniciar">
                                                        <span class="mt-icon">
                                                            <i class="icon-reload"></i>
                                                        </span>
                                                    </a>
                                                <?}?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                        <div class="mt-widget-3" style="margin-bottom: 1em;">
                                            <div class="mt-head bg-blue">
                                                <div class="mt-head-icon">
                                                    <i class=" icon-puzzle"></i>
                                                </div>
                                                <div class="mt-head-desc" style="margin-top: 1em;"> Cabañas</div>
                                                <h3 id="count_cabanas" class="mt-head-date"> 0 </h3>
                                            </div>
                                            <div class="mt-body-actions-icons">
                                                <div class="btn-group btn-group btn-group-justified">
                                                <?if($servicio['estado'] == 'Pendiente')
                                            	{?>
                                                   <a data-toggle="modal" href="#lista_cabanas" class="btn btn-link" title="Agregar">
                                                        <span class="mt-icon">
                                                            <i class="icon-plus"></i>
                                                        </span>
                                                    </a>
                                                <?}?>
                                                    <a data-toggle="modal" href="#lista_cabanas_asignadas" class="btn btn-link" title="Listar">
                                                        <span class="mt-icon">
                                                            <i class="icon-list"></i>
                                                        </span>
                                                    </a>
                                                <?if($servicio['estado'] == 'Pendiente')
                                            	{?>
                                                    <a href="javascript:;" class="btn btn-link" onclick="clear_cabanas()" title="Reiniciar">
                                                        <span class="mt-icon">
                                                            <i class="icon-reload"></i>
                                                        </span>
                                                    </a>
                                                <?}?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                        <div class="mt-widget-3" style="margin-bottom: 1em;">
                                            <div class="mt-head bg-blue-madison">
                                                <div class="mt-head-icon">
                                                    <i class="icon-puzzle"></i>
                                                </div>
                                                <div class="mt-head-desc" style="margin-top: 1em;"> Canchas Deportivas</div>
                                                <h3 id="count_canchas" class="mt-head-date"> 0 </h3>
                                            </div>
                                            <div class="mt-body-actions-icons">
                                                <div class="btn-group btn-group btn-group-justified">
                                                <?if($servicio['estado'] == 'Pendiente')
                                            	{?>
                                            		<a data-toggle="modal" href="#lista_canchas" class="btn btn-link" title="Agregar">
                                                        <span class="mt-icon">
                                                            <i class="icon-plus"></i>
                                                        </span>
                                                    </a>
                                                <?}?>
                                                    <a data-toggle="modal" href="#lista_canchas_asignadas" class="btn btn-link" title="Listar">
                                                        <span class="mt-icon">
                                                            <i class="icon-list"></i>
                                                        </span>
                                                    </a>
                                                <?if($servicio['estado'] == 'Pendiente')
                                                {?>
                                                    <a href="javascript:;" class="btn btn-link" onclick="clear_canchas()" title="Reiniciar">
                                                        <span class="mt-icon">
                                                            <i class="icon-reload"></i>
                                                        </span>
                                                    </a>
                                                <?}?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                        <div class="mt-widget-3" style="margin-bottom: 1em;">
                                            <div class="mt-head" style="background: #3d556d;">
                                                <div class="mt-head-icon">
                                                    <i class="icon-social-dropbox"></i>
                                                </div>
                                                <div class="mt-head-desc" style="margin-top: 1em;"> Implementos</div>
                                                <h3 id="count_implementos" class="mt-head-date"> 0 </h3>
                                            </div>
                                            <div class="mt-body-actions-icons">
                                                <div class="btn-group btn-group btn-group-justified">
                                                <?if($servicio['estado'] == 'Pendiente')
                                                {?>
                                                    <a data-toggle="modal" href="#lista_implementos" class="btn btn-link" title="Agregar">
                                                        <span class="mt-icon">
                                                            <i class="icon-plus"></i>
                                                        </span>
                                                    </a>
                                                <?}?>
                                                    <a data-toggle="modal" href="#lista_implementos_asignados" class="btn btn-link" title="Listar">
                                                        <span class="mt-icon">
                                                            <i class="icon-list"></i>
                                                        </span>
                                                    </a>
                                                <?if($servicio['estado'] == 'Pendiente')
                                                {?>
                                                    <a href="javascript:;" class="btn btn-link" onclick="clear_implementos()" title="Reiniciar">
                                                        <span class="mt-icon">
                                                            <i class="icon-reload"></i>
                                                        </span>
                                                    </a>
                                                <?}?>
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
                    <div class="col-sm-6 col-xs-12">
                        <div class="portlet light bordered flip-scroll animated fadeIn">
                            <div class="portlet-title">
                                <div class="caption font-dark">
                                    <i class="icon-plus"></i>
                                    <span class="caption-subject bold uppercase">Control de Supervisión y Entrada</span>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="row">
                                    <div class="col-sm-6 col-xs-12">
                                        <div class="mt-widget-3" style="margin-bottom: 1em;">
                                            <div class="mt-head bg-blue-chambray">
                                                <div class="mt-head-icon">
                                                    <i class="icon-users"></i>
                                                </div>
                                                <div class="mt-head-desc" style="margin-top: 1em;">Empleados</div>
                                                <h3 id="count_empleados" class="mt-head-date"> 0 </h3>
                                            </div>
                                            <div class="mt-body-actions-icons">
                                                <div class="btn-group btn-group btn-group-justified">
                                                <?if($servicio['estado'] == 'Pendiente')
                                                {?>
                                                    <a data-toggle="modal" href="#lista_empleados" class="btn btn-link" title="Agregar">
                                                        <span class="mt-icon">
                                                            <i class="icon-plus"></i>
                                                        </span>
                                                    </a>
                                                <?}?>
                                                    <a data-toggle="modal" href="#lista_empleados_asignados" class="btn btn-link" title="Listar">
                                                        <span class="mt-icon">
                                                            <i class="icon-list"></i>
                                                        </span>
                                                    </a>
                                                <?if($servicio['estado'] == 'Pendiente')
                                                {?>
                                                    <a href="javascript:;" class="btn btn-link" onclick="clear_empleados()" title="Reiniciar">
                                                        <span class="mt-icon">
                                                            <i class="icon-reload"></i>
                                                        </span>
                                                    </a>
                                                <?}?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-xs-12">
                                        <div class="mt-widget-3" style="margin-bottom: 1em;">
                                            <div class="mt-head bg-dark">
                                                <div class="mt-head-icon">
                                                    <i class="icon-notebook"></i>
                                                </div>
                                                <div class="mt-head-desc" style="margin-top: 1em;">Invitados</div>
                                                <h3 id="count_invitados" class="mt-head-date">0 </h3>
                                            </div>
                                            <div class="mt-body-actions-icons">
                                                <div class="btn-group btn-group btn-group-justified">
                                                <?if($servicio['estado'] == 'Pendiente')
                                                {?>
                                                    <a data-toggle="modal" onclick="add_invitado()" class="btn btn-link" title="Agregar">
                                                        <span class="mt-icon">
                                                            <i class="icon-plus"></i>
                                                        </span>
                                                    </a>
                                                <?}?>
                                                        <a data-toggle="modal" href="#lista_invitados_asignados" class="btn btn-link" title="Listar">
                                                        <span class="mt-icon">
                                                            <i class="icon-list"></i>
                                                        </span>
                                                    </a>
                                                <?if($servicio['estado'] == 'Pendiente')
                                                {?>
                                                    <a href="javascript:;" onclick="clear_invitados()" class="btn btn-link" title="Reiniciar">
                                                        <span class="mt-icon">
                                                            <i class="icon-reload"></i>
                                                        </span>
                                                    </a>
                                                <?}?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xs-12">
                        <div class="portlet light bordered flip-scroll animated fadeIn">
                            <div class="portlet-title">
                                <div class="caption font-dark">
                                    <i class="icon-note"></i>
                                    <span class="caption-subject bold uppercase">Planificación</span>
                                </div>
                            </div>
                            <div class="portlet-body form">
                                <form id="servicio_form" action="#" role="form">
                                    <?if($servicio['estado'] == "Pendiente")
                                    {?>
                                        <div class="form-group">
                                            <label class="control-label">Fecha <span class="required">*</span></label>
                                            <div class="input-group date date-picker" data-date-format="dd-mm-yyyy" data-date-start-date="+0d">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-icon-only green-turquoise" type="button">
                                                        <i class="icon-calendar"></i>
                                                    </button>
                                                </span>
                                                <input type="text" name="fecha" value="<?echo $servicio['fecha_asig'];?>" class="form-control">
                                            </div>
                                            <span class="help-block fecha"></span>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Hora <span class="required">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-icon-only green-turquoise" type="button">
                                                        <i class="icon-clock"></i>
                                                    </button>
                                                </span>
                                                <input type="text" name="hora" value="<?echo $servicio['hora_asig'];?>" class="form-control timepicker timepicker-no-seconds">
                                            </div>
                                            <span class="help-block hora"></span>
                                        </div>
                                    <?}?>
                                    <?if($servicio['estado'] == "En progreso" || $servicio['estado'] == "Finalizado")
                                    {?>
                                        <div class="form-group">
                                            <label>Observación</label>
                                            <textarea class="form-control" rows="6" name="observacion"><?echo $servicio['observacion'];?></textarea>
                                            <span class="help-block"></span>
                                        </div>
                                    <?}?>
                                    <div class="form-actions" style="text-align: right;">
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <?if($servicio['estado'] == 'Pendiente')
                                                {?>
                                                    <a href="<? echo site_url('servicio'); ?>" class="btn btn-default"> Cancelar </a>
                                                    <button id="btnSave_ser" type="button" class="btn green-turquoise" onclick="update(<?echo $servicio['id_ser'];?>)" style="margin-left:0.35em;"> Actualizar</button>
                                                <?}
                                                if($servicio['estado'] == "En progreso")
                                                {?>
                                                    <a href="<?echo site_url('servicio');?>" class="btn btn-default"> Regresar </a>
                                                    <a href="javascript:;" class="btn green-turquoise" onclick="end(<?echo $servicio['id_ser'];?>)"> Finalizar </a>
                                                <?}?>
                                                <?if($servicio['estado'] == "Finalizado")
                                                {?>
                                                    <a href="<?echo site_url('servicio');?>" class="btn btn-default"> Regresar </a>
                                                    <a href="javascript:;" class="btn green-turquoise"> Imprimir </a>
                                                <?}?>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade bs-modal-lg" id="lista_empleados" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                                <div class="caption font-dark">
                                    <i class="icon-list font-dark"></i>
                                    <span class="caption-subject bold uppercase">Listado de Empleados</span>
                                    <div class="btn-group">
                                        <a href="#" onclick="add_empleado()" class="btn-link" style="padding: 0em 1em;" title="Agregar">
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
                                                    <table id="empleados_activos" class="table table-hover table-bordered small">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Cédula</th>
                                                                <th>Nombre</th>
                                                                <th>Cargo</th>
                                                                <th>Turno</th>
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
                                                    <table id="empleados_inactivos" class="table table-hover table-bordered small">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Cédula</th>
                                                                <th>Nombre</th>
                                                                <th>Cargo</th>
                                                                <th>Turno</th>
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
                <div class="modal2 fade" id="empleado-modal" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                                <div class="caption font-dark">
                                    <i id="icon" class="icon-plus font-dark"></i>
                                    <span class="caption-subject bold uppercase empleado-modal-title">Título</span>
                                </div>
                            </div>
                            <div class="modal-body">
                                <form action="#" id="empleado_form">
                                    <input type="hidden" value="" name="id_emp" autocomplete="off"/>
                                    <div class="form-group">
                                        <span class="required"> * (Campos Requeridos) </span>
                                    </div>
                                    <div class="form-group">
                                        <label>Cédula <span class="required">*</span></label>
                                            <input type="text" id="cedula_emp" class="form-control" name="cedula" placeholder="Ingresa una cédula" title="Ej: V-27402258" data-mask="V-99999999" autocomplete="off" onchange="search_empleado()" required>
                                        <span class="help-block"></span>
                                    </div>
                                    <div class="form-group">
                                        <label>Nombre <span class="required">*</span></label>
                                        <input type="text" class="form-control" name="nombre" placeholder="Ingresa un nombre" title="Ej: Pedro Pérez" autocomplete="off" required>
                                        <span class="help-block"></span>
                                    </div>
                                    <div class="form-group">
                                        <label>Cargo <span class="required">*</span></label>
                                        <select class="form-control" name="cargo">
                                            <option value="">--- Elige un cargo ---</option>
                                            <?foreach ($cargos as $cargo):?>
                                            <option value="<?echo $cargo['id_car'];?>"><?echo $cargo['cargo'];?></option>
                                            <?endforeach;?>
                                        </select>
                                        <span class="help-block"></span>
                                    </div>
                                    <div class="form-group">
                                        <label>Turno <span class="required">*</span></label>
                                        <select class="form-control" name="turno">
                                            <option value="">--- Elige un turno ---</option>
                                            <option>Diurno</option>
                                            <option>Nocturno</option>
                                        </select>
                                        <span class="help-block"></span>
                                    </div>
                                    <div class="form-group">
                                        <label>Teléfono <span class="required">*</span></label>
                                        <input type="text" class="form-control" name="telefono" placeholder="Ingresa un teléfono" title="Ej: (0000) 123-4567" data-mask="(9999) 999-9999" required autocomplete="off">
                                        <span class="help-block"></span>
                                    </div>
                                    <div class="form-group">
                                        <label>Email </label>
                                        <input type="email" class="form-control" name="email" placeholder="Ingresa un email" title="Ej: email@email.com" autocomplete="off" >
                                        <span class="help-block"></span>
                                    </div>
                                    <div class="form-group">
                                        <label>Dirección </label>
                                        <textarea class="form-control" rows="3" name="direccion" placeholder="Ingresa una dirección" title="Ej: La Victoria, Estado Aragua" autocomplete="off" required></textarea>
                                        <span class="help-block"></span>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="btnSave_emp" onclick="save_empleado()" class="btn green-turquoise">Guardar</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade bs-modal-md" id="lista_empleados_asignados" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-md">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <div class="caption font-dark">
                                    <i class="icon-list font-dark"></i>
                                    <span class="caption-subject bold uppercase">Listado de Empleados Asignados</span>
                                </div>
                            </div>
                            <div class="modal-body">
                                <table id="empleados_asignados" class="table table-hover table-bordered small">
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
                <div class="modal fade bs-modal-lg" id="lista_beneficiarios" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                                <div class="caption font-dark">
                                    <i class="icon-list font-dark"></i>
                                    <span class="caption-subject bold uppercase">Listado de beneficiarios</span>
                                    <div class="btn-group">
                                        <a href="#" onclick="add_beneficiario()" class="btn-link" style="padding: 0em 1em;" title="Agregar">
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
                                                    <table id="beneficiarios_activos" class="table table-hover table-bordered small">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Cédula</th>
                                                                <th>Nombre</th>
                                                                <th>Cargo</th>
                                                                <th>Turno</th>
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
                                                    <table id="beneficiarios_inactivos" class="table table-hover table-bordered small">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Cédula</th>
                                                                <th>Nombre</th>
                                                                <th>Cargo</th>
                                                                <th>Turno</th>
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
                <div class="modal2 fade" id="beneficiario-modal" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                                <div class="caption font-dark">
                                    <i id="icon" class="icon-plus font-dark"></i>
                                    <span class="caption-subject bold uppercase beneficiario-modal-title">Título</span>
                                </div>
                            </div>
                            <div class="modal-body">
                                <form action="#" id="beneficiario_form">
                                    <input type="hidden" value="" name="id_ben" autocomplete="off"/>
                                    <div class="form-group">
                                        <span class="required">* (Campos Requeridos)</span>
                                    </div>
                                    <div class="form-group">
                                        <label>Cédula <span class="required">*</span></label>
                                        <input type="text" id="cedula_ben" class="form-control" name="cedula" placeholder="Ingresa una cédula" title="Ej: V-27402258" data-mask="V-99999999" autocomplete="off" onchange="search_beneficiario()" required>
                                        <span class="help-block"></span>
                                    </div>
                                    <div class="form-group">
                                        <label>Nombre <span class="required">*</span></label>
                                        <input type="text" class="form-control" name="nombre" placeholder="Ingresa un nombre" title="Ej: Pedro Pérez" autocomplete="off" required>
                                        <span class="help-block"></span>
                                    </div>
                                    <div class="form-group">
                                        <label>Teléfono <span class="required">*</span></label>
                                        <input type="text" class="form-control" name="telefono" placeholder="Ingresa un teléfono" title="Ej: (0000) 123-4567" data-mask="(9999) 999-9999" required autocomplete="off">
                                        <span class="help-block"></span>
                                    </div>
                                    <div class="form-group">
                                        <label>Dirección <span class="required">*</span></label>
                                        <textarea class="form-control" rows="3" name="direccion" placeholder="Ingresa una dirección" title="Ej: La Victoria, Estado Aragua" required autocomplete="off"></textarea>
                                        <span class="help-block"></span>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="btnSave_ben" onclick="save_beneficiario()" class="btn green-turquoise">Guardar</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade bs-modal-md" id="lista_beneficiarios_asignados" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-md">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <div class="caption font-dark">
                                    <i class="icon-list font-dark"></i>
                                    <span class="caption-subject bold uppercase">Listado de Beneficiarios Asignados</span>
                                </div>
                            </div>
                            <div class="modal-body">
                                <table id="beneficiarios_asignados" class="table table-hover table-bordered small">
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
                <div class="modal fade bs-modal-lg" id="lista_cabanas" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                                <div class="caption font-dark">
                                    <i class="icon-list font-dark"></i>
                                    <span class="caption-subject bold uppercase">Listado de cabanas</span>
                                    <div class="btn-group">
                                        <a href="#" onclick="add_cabana()" class="btn-link" style="padding: 0em 1em;" title="Agregar">
                                            <i class="icon-plus"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-body">
                                <div class="tabbable-line tabbable-full-width">
                                    <ul class="nav nav-tabs">
                                        <li class="active">
                                            <a href="#tab_1_5" data-toggle="tab"> Activos </a>
                                        </li>
                                        <li>
                                            <a href="#tab_1_6" data-toggle="tab"> Inactivos </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab_1_5">
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <table id="cabanas_activas" class="table table-hover table-bordered small">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Número</th>
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
                                        <div class="tab-pane" id="tab_1_6">
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <table id="cabanas_inactivas" class="table table-hover table-bordered small">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Número</th>
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
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal"> Cancelar </button>
                                <button type="button" class="btn green-turquoise" data-dismiss="modal"> Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal2 fade" id="cabana-modal" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                                <div class="caption font-dark">
                                    <i id="icon" class="icon-plus font-dark"></i>
                                    <span class="caption-subject bold uppercase cabana-modal-title">Título</span>
                                </div>
                            </div>
                            <div class="modal-body">
                                <form action="#" id="cabana_form">
                                    <input type="hidden" value="" name="id_cab" autocomplete="off"/> 
                                    <div class="form-group">
                                        <span class="required"> * (Campos Requeridos) </span>
                                    </div>
                                    <div class="form-group">
                                        <label>Número <span class="required">*</span></label>
                                        <input type="text" id="numero_cab" class="form-control" name="numero" placeholder="Ingresa un número de cabaña" title="Ej: 1" autocomplete="off" onkeyup="search_cabana()" required>
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
                                <button type="button" id="btnSave_can" onclick="save_cabana()" class="btn green-turquoise">Guardar</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade bs-modal-md" id="lista_cabanas_asignadas" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-md">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <div class="caption font-dark">
                                    <i class="icon-list font-dark"></i>
                                    <span class="caption-subject bold uppercase">Listado de cabanas Asignados</span>
                                </div>
                            </div>
                            <div class="modal-body">
                                <table id="cabanas_asignadas" class="table table-hover table-bordered small">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Número</th>
                                            <th>Capacidad</th>
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
                <div class="modal fade bs-modal-lg" id="lista_canchas" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                                <div class="caption font-dark">
                                    <i class="icon-list font-dark"></i>
                                    <span class="caption-subject bold uppercase">Listado de canchas</span>
                                    <div class="btn-group">
                                        <a href="#" onclick="add_cancha()" class="btn-link" style="padding: 0em 1em;" title="Agregar">
                                            <i class="icon-plus"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-body">
                                <div class="tabbable-line tabbable-full-width">
                                    <ul class="nav nav-tabs">
                                        <li class="active">
                                            <a href="#tab_1_7" data-toggle="tab"> Activos </a>
                                        </li>
                                        <li>
                                            <a href="#tab_1_8" data-toggle="tab"> Inactivos </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab_1_7">
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
                                        <div class="tab-pane" id="tab_1_8">
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
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal"> Cancelar </button>
                                <button type="button" class="btn green-turquoise" data-dismiss="modal"> Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal2 fade" id="cancha-modal" role="dialog" aria-hidden="true">
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
                    </div>
                </div>
                <div class="modal fade bs-modal-md" id="lista_canchas_asignadas" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-md">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <div class="caption font-dark">
                                    <i class="icon-list font-dark"></i>
                                    <span class="caption-subject bold uppercase">Listado de canchas Asignados</span>
                                </div>
                            </div>
                            <div class="modal-body">
                                <table id="canchas_asignadas" class="table table-hover table-bordered small">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Número</th>
                                            <th>Capacidad</th>
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
                                            <a href="#tab_1_9" data-toggle="tab"> Activos </a>
                                        </li>
                                        <li>
                                            <a href="#tab_1_10" data-toggle="tab"> Inactivos </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab_1_9">
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
                                        <div class="tab-pane" id="tab_1_10">
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
                                <button type="button" id="btnSave_imp" onclick="save_implemento()" class="btn green-turquoise">Guardar</button>
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
                <div class="modal fade" id="invitado-modal" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                                <div class="caption font-dark">
                                    <i id="icon" class="icon-plus font-dark"></i>
                                    <span class="caption-subject bold uppercase invitado-modal-title">Título</span>
                                </div>
                            </div>
                            
                            <div class="modal-body">
                                <form action="#" id="invitado_form">
                                    <div class="form-group">
                                        <span class="required"> * (Campos Requeridos) </span>
                                    </div>
                                    <div class="form-group">
                                        <label>Cédula <span class="required">*</span></label>
                                        <input type="text" id="cedula" class="form-control" name="cedula" data-mask="V-99999999" placeholder="Ingresa una cédula" title="Ej: V-27402258">
                                    </div>
                                    <div class="form-group">
                                        <label>Nombre <span class="required">*</span></label>
                                        <input type="text" id="nombre" class="form-control" name="nombre" placeholder="Ingresa un nombre" title="Ej: Yonathan Moncada">
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="btnSave_inv" onclick="assign_invitado()" class="btn green-turquoise">Guardar</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade bs-modal-md" id="lista_invitados_asignados" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-md">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <div class="caption font-dark">
                                    <i class="icon-list font-dark"></i>
                                    <span class="caption-subject bold uppercase">Listado de invitados Asignados</span>
                                </div>
                            </div>
                            <div class="modal-body">
                                <table id="invitados_asignados" class="table table-hover table-bordered small">
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
            </div>
        </div>
        <script src="<? echo base_url(); ?>assets/apps/scripts/beneficiarios.js" type="text/javascript"></script>
        <script src="<? echo base_url(); ?>assets/apps/scripts/cabanas.js" type="text/javascript"></script>
        <script src="<? echo base_url(); ?>assets/apps/scripts/canchas.js" type="text/javascript"></script>
        <script src="<? echo base_url(); ?>assets/apps/scripts/empleados.js" type="text/javascript"></script>
        <script src="<? echo base_url(); ?>assets/apps/scripts/implementos.js" type="text/javascript"></script>
        <script src="<? echo base_url(); ?>assets/apps/scripts/servicios.js" type="text/javascript"></script>
    </body>
</html>