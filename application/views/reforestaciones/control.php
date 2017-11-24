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
                        <h1>Reforestaciones</h1>
                    </div>
                </div>
                <ul class="page-breadcrumb breadcrumb animated fadeInLeft">
                    <li>
                        <a href="<? echo site_url('index'); ?>">Inicio</a>
                        <i class="fa fa-chevron-right"></i>
                    </li>
                    <li>
                        <a href="<? echo site_url('reforestacion'); ?>">Reforestaciones</a>
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
                                <h1 class="uppercase">N° <?echo $reforestacion['id_ref'];?></h1>
                            </div>
                        </div>
                        <div class="col-sm-8 col-xs-12">
                            <div class="row">
                                <div class="col-sm-4 col-xs-12">
                                    <h2 class="invoice-title uppercase font-green-turquoise">Responsable</h2>
                                    <p class="invoice-desc"><?echo $reforestacion['usuario'];?></p>
                                </div>
                                <div class="col-sm-4 col-xs-12">
                                    <h2 class="invoice-title uppercase font-green-turquoise">Última Modificación</h2>
                                    <p class="invoice-desc"><?echo $reforestacion['fecha_act'];?></p>
                                </div>
                                <div class="col-sm-4 col-xs-12">
                                    <h2 class="invoice-title uppercase font-green-turquoise">Estado</h2>
                                    <p class="invoice-desc"><?echo $reforestacion['estado'];?></p>
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
                                                <div class="mt-head-desc" style="margin-top: 1em;">Empleados</div>
                                                <h3 id="count_empleados" class="mt-head-date"> 0 </h3>
                                            </div>
                                            <div class="mt-body-actions-icons">
                                                <div class="btn-group btn-group btn-group-justified">
                                                <?if($reforestacion['estado'] == 'Pendiente')
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
                                                <?if($reforestacion['estado'] == 'Pendiente')
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
                                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                        <div class="mt-widget-3" style="margin-bottom: 1em;">
                                            <div class="mt-head bg-blue">
                                                <div class="mt-head-icon">
                                                    <i class=" icon-puzzle"></i>
                                                </div>
                                                <div class="mt-head-desc" style="margin-top: 1em;"> Áreas</div>
                                                <h3 id="count_areas" class="mt-head-date"> 0 </h3>
                                            </div>
                                            <div class="mt-body-actions-icons">
                                                <div class="btn-group btn-group btn-group-justified">
                                                <?if($reforestacion['estado'] == 'Pendiente')
                                            	{?>
                                                    <a data-toggle="modal" href="#lista_areas" class="btn btn-link" title="Agregar">
                                                        <span class="mt-icon">
                                                            <i class="icon-plus"></i>
                                                        </span>
                                                    </a>
                                                <?}?>
                                                    <a data-toggle="modal" href="#lista_areas_asignadas" class="btn btn-link" title="Listar">
                                                        <span class="mt-icon">
                                                            <i class="icon-list"></i>
                                                        </span>
                                                    </a>
                                                <?if($reforestacion['estado'] == 'Pendiente')
                                            	{?>
                                                    <a href="javascript:;" class="btn btn-link" onclick="clear_areas()" title="Reiniciar">
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
                                                    <i class="icon-bulb"></i>
                                                </div>
                                                <div class="mt-head-desc" style="margin-top: 1em;"> Especies</div>
                                                <h3 id="count_especies" class="mt-head-date"> 0 </h3>
                                            </div>
                                            <div class="mt-body-actions-icons">
                                                <div class="btn-group btn-group btn-group-justified">
                                                <?if($reforestacion['estado'] == 'Pendiente')
                                            	{?>
                                            		<a data-toggle="modal" href="#lista_especies" class="btn btn-link" title="Agregar">
                                                        <span class="mt-icon">
                                                            <i class="icon-plus"></i>
                                                        </span>
                                                    </a>
                                                <?}?>
                                                <?if($reforestacion['estado'] == 'En progreso')
                                                {?>
                                                    <a data-toggle="modal" href="#lista_especies" class="btn btn-link" title="Controlar">
                                                        <span class="mt-icon">
                                                            <i class="icon-note"></i>
                                                        </span>
                                                    </a>
                                                <?}?>
                                                <a data-toggle="modal" href="#lista_especies_asignadas" class="btn btn-link" title="Listar">
                                                    <span class="mt-icon">
                                                        <i class="icon-list"></i>
                                                    </span>
                                                </a>
                                                <?if($reforestacion['estado'] == 'Pendiente')
                                                {?>
                                                    <a href="javascript:;" class="btn btn-link" onclick="clear_especies()" title="Reiniciar">
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
                                                <?if($reforestacion['estado'] == 'Pendiente')
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
                                                <?if($reforestacion['estado'] == 'Pendiente')
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
                                    <span class="caption-subject bold uppercase">Asignación de Actividades</span>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="mt-widget-3" style="margin-bottom: 1em;">
                                            <div class="mt-head bg-blue-chambray">
                                                <div class="mt-head-icon">
                                                    <i class="icon-check"></i>
                                                </div>
                                                <div class="mt-head-desc" style="margin-top: 1em;">Actividades</div>
                                                <h3 id="count_actividades" class="mt-head-date"> 0 </h3>
                                            </div>
                                            <div class="mt-body-actions-icons">
                                                <div class="btn-group btn-group btn-group-justified">
                                                <?if($reforestacion['estado'] == 'Pendiente')
                                                {?>
                                                    <a data-toggle="modal" href="#lista_actividades" class="btn btn-link" title="Agregar">
                                                        <span class="mt-icon">
                                                            <i class="icon-plus"></i>
                                                        </span>
                                                    </a>
                                                <?}?>
                                                <?if($reforestacion['estado'] == 'En progreso')
                                                {?>
                                                    <a data-toggle="modal" href="#lista_especies" class="btn btn-link" title="Controlar">
                                                        <span class="mt-icon">
                                                            <i class="icon-note"></i>
                                                        </span>
                                                    </a>
                                                <?}?>
                                                <a data-toggle="modal" href="#lista_actividades_asignadas" class="btn btn-link" title="Listar">
                                                    <span class="mt-icon">
                                                        <i class="icon-list"></i>
                                                    </span>
                                                </a>
                                                <?if($reforestacion['estado'] == 'Pendiente')
                                                {?>
                                                    <a href="javascript:;" class="btn btn-link" onclick="clear_actividades()" title="Reiniciar">
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
                                <form id="reforestacion_form" action="#" role="form">
                                    <?if($reforestacion['estado'] == "Pendiente")
                                    {?>
                                        <div class="form-group">
                                            <label class="control-label">Fecha <span class="required">*</span></label>
                                            <div class="input-group date date-picker" data-date-format="dd-mm-yyyy" data-date-start-date="+0d">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-icon-only green-turquoise" type="button">
                                                        <i class="icon-calendar"></i>
                                                    </button>
                                                </span>
                                                <input type="text" name="fecha" value="<?echo $reforestacion['fecha_asig'];?>" class="form-control">
                                            </div>
                                            <span class="help-block fecha"></span>
                                        </div>
                                        <span class="help-block"> </span>
                                        <div class="form-group">
                                            <label class="control-label">Hora <span class="required">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-icon-only green-turquoise" type="button">
                                                        <i class="icon-clock"></i>
                                                    </button>
                                                </span>
                                                <input type="text" name="hora" value="<?echo $reforestacion['hora_asig'];?>" class="form-control timepicker timepicker-no-seconds">
                                            </div>
                                            <span class="help-block hora"></span>
                                        </div>
                                    <?}?>
                                    <?if($reforestacion['estado'] == "En progreso" || $reforestacion['estado'] == "Finalizado")
                                    {?>
                                        <div class="form-group">
                                            <label class="control-label">Fecha</label>
                                            <div class="input-group date date-picker" data-date-format="dd-mm-yyyy" data-date-start-date="+0d">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-icon-only green-turquoise" type="button" disabled>
                                                        <i class="icon-calendar"></i>
                                                    </button>
                                                </span>
                                                <input type="text" name="fecha" value="<?echo $reforestacion['fecha_asig'];?>" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Hora</label>
                                            <div class="input-group">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-icon-only green-turquoise" type="button" disabled>
                                                        <i class="icon-clock"></i>
                                                    </button>
                                                </span>
                                                <input type="text" name="hora" value="<?echo $reforestacion['hora_asig'];?>" class="form-control timepicker timepicker-no-seconds" disabled>
                                            </div>
                                        </div>
                                    <?}?>
                                    <div class="form-actions" style="text-align: right;">
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <?if($reforestacion['estado'] == 'Pendiente')
                                                {?>
                                                    <a href="<? echo site_url('reforestacion'); ?>" class="btn btn-default"> Cancelar </a>
                                                    <button id="btnSave_ref" type="button" class="btn green-turquoise" onclick="update(<?echo $reforestacion['id_ref'];?>)" style="margin-left:0.35em;"> Actualizar</button>
                                                <?}
                                                if($reforestacion['estado'] == "En progreso")
                                                {?>
                                                    <a href="<?echo site_url('reforestacion');?>" class="btn btn-default"> Regresar </a>
                                                    <a href="javascript:;" class="btn green-turquoise"> Finalizar </a>
                                                <?}?>
                                                <?if($reforestacion['estado'] == "Finalizado")
                                                {?>
                                                    <a href="<?echo site_url('reforestacion');?>" class="btn btn-default"> Regresar </a>
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
                                <table id="empleados" class="table table-hover table-bordered small">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Cédula</th>
                                            <th>Nombre</th>
                                            <th>Cargo</th>
                                            <th>Turno</th>
                                            <?if($reforestacion['estado'] == 'Pendiente')
                                            {?>
                                                <th>Acciones</th>
                                            <?}?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
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
                                            <?if($reforestacion['estado'] == 'Pendiente')
                                            {?>
                                            	<th>Acciones</th>
                                            <?}?>
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
                <div class="modal fade bs-modal-lg" id="lista_areas" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                                <div class="caption font-dark">
                                    <i class="icon-list font-dark"></i>
                                    <span class="caption-subject bold uppercase">Listado de areas</span>
                                    <div class="btn-group">
                                        <a href="#" onclick="add_area()" class="btn-link" style="padding: 0em 1em;" title="Agregar">
                                            <i class="icon-plus"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-body">
                                <table id="areas" class="table table-hover table-bordered small">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Código</th>
                                            <th>Nombre</th>
                                            <th>Ubicación</th>
                                           	<?if($reforestacion['estado'] == 'Pendiente')
                                            {?>
                                            	<th>Acciones</th>
                                            <?}?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal"> Cancelar </button>
                                <button type="button" class="btn green-turquoise" data-dismiss="modal"> Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal2 fade" id="area-modal" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                                <div class="caption font-dark">
                                    <i id="icon" class="icon-plus font-dark"></i>
                                    <span class="caption-subject bold uppercase area-modal-title">Título</span>
                                </div>
                            </div>
                            <div class="modal-body">
                                <form action="#" id="area_form">
                                    <input type="hidden" value="" name="id_are" autocomplete="off"/> 
                                    <div class="form-group">
                                        <span class="required"> * (Campos Requeridos) </span>
                                    </div>
                                    <div class="form-group">
                                        <label>Codigo <span class="required">*</span></label>
                                        <input id="codigo_are" type="text" class="form-control" placeholder="Ingresa un código" title="Ej: P3ST" name="codigo" autocomplete="off" onkeyup="search_area()" required>
                                        <span class="help-block"></span>
                                    </div>
                                    <div class="form-group">
                                        <label>Nombre <span class="required">*</span></label>
                                        <input type="text" class="form-control" placeholder="Ingresa un nombre" title="Ej: Perimetro Este" name="nombre" autocomplete="off" required>
                                        <span class="help-block"></span>
                                    </div>
                                    <div class="form-group">
                                        <label>Ubicación <span class="required">*</span></label>
                                        <textarea class="form-control" placeholder="Ingresa una ubicación" title="Ej: A XX km de XXXXX" name="ubicacion" autocomplete="off" required></textarea>
                                        <span class="help-block"></span>
                                    </div>
                                    <div class="form-group">
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="btnSave_are" onclick="save_area()" class="btn green-turquoise">Guardar</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade bs-modal-md" id="lista_areas_asignadas" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-md">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <div class="caption font-dark">
                                    <i class="icon-list font-dark"></i>
                                    <span class="caption-subject bold uppercase">Listado de Areas Asignados</span>
                                </div>
                            </div>
                            <div class="modal-body">
                                <table id="areas_asignadas" class="table table-hover table-bordered small">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Código</th>
                                            <th>Nombre</th>
                                            <?if($reforestacion['estado'] == 'Pendiente')
                                            {?>
                                            	<th>Acciones</th>
                                            <?}?>
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
                <div class="modal fade bs-modal-lg" id="lista_especies" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                                <div class="caption font-dark">
                                    <i class="icon-list font-dark"></i>
                                    <span class="caption-subject bold uppercase">Listado de Especies</span>
                                    <div class="btn-group">
                                        <a href="#" onclick="add_especie()" class="btn-link" style="padding: 0em 1em;" title="Agregar">
                                            <i class="icon-plus"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-body">
                                <table id="especies" class="table table-hover table-bordered small">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Código</th>
                                            <th>Nombre</th>
                                            <th>Tipo</th>
                                            <th>Poblacion</th>
                                            <?if($reforestacion['estado'] == 'Pendiente')
                                            {?>
                                            	<th>Acciones</th>
                                            <?}?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal"> Cancelar </button>
                                <button type="button" class="btn green-turquoise" data-dismiss="modal"> Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal2 fade" id="especie-modal" role="dialog" aria-hidden="true">
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
                <div class="modal fade bs-modal-md" id="lista_especies_asignadas" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-md">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <div class="caption font-dark">
                                    <i class="icon-list font-dark"></i>
                                    <span class="caption-subject bold uppercase">Listado de Especies Asignados</span>
                                </div>
                            </div>
                            <div class="modal-body">
                                <table id="especies_asignadas" class="table table-hover table-bordered small">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Código</th>
                                            <th>Nombre</th>
                                            <?if($reforestacion['estado'] == 'Pendiente')
                                            {?>
                                            	<th>Acciones</th>
                                            <?}?>
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
                                <table id="implementos" class="table table-hover table-bordered small">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Código</th>
                                            <th>Nombre</th>
                                            <th>Categoría</th>
                                            <th>Stock</th>
                                            <th>Poblacion</th>
                                            <?if($reforestacion['estado'] == 'Pendiente')
                                            {?>
                                            	<th>Acciones</th>
                                            <?}?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
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
                                            <?if($reforestacion['estado'] == 'Pendiente')
                                            {?>
                                            	<th>Acciones</th>
                                            <?}?>
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
                <div class="modal fade bs-modal-lg" id="lista_actividades" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                                <div class="caption font-dark">
                                    <i class="icon-list font-dark"></i>
                                    <span class="caption-subject bold uppercase">Listado de Actividades</span>
                                    <div class="btn-group">
                                        <a href="#" onclick="add_actividad()" class="btn-link" style="padding: 0em 1em;" title="Agregar">
                                            <i class="icon-plus"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-body">
                                <table id="actividades" class="table table-hover table-bordered small">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Acción</th>
                                            <th>Tipo</th>
                                            <?if($reforestacion['estado'] == 'Pendiente')
                                            {?>
                                                <th>Acciones</th>
                                            <?}?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal"> Cancelar </button>
                                <button type="button" class="btn green-turquoise" data-dismiss="modal"> Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal2 fade" id="actividad-modal" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                                <div class="caption font-dark">
                                    <i id="icon" class="icon-plus font-dark"></i>
                                    <span class="caption-subject bold uppercase actividad-modal-title">Título</span>
                                </div>
                            </div>
                            <div class="modal-body">
                                <form action="#" id="actividad_form">
                                    <input type="hidden" value="" name="id_act" autocomplete="off"/>
                                    <div class="form-group">
                                        <span class="required"> * (Campos Requeridos) </span>
                                    </div>
                                    <div class="form-group">
                                        <label>Acción <span class="required">*</span></label>
                                        <input type="text" id="accion_act" class="form-control" name="accion" placeholder="Ingresa una acción" title="Ej: Colocar bombillo" autocomplete="off" onkeyup="search_actividad()" required>
                                        <span class="help-block"></span>
                                    </div>
                                    <div class="form-group">
                                        <label>Tipo <span class="required">*</span></label>
                                        <select class="form-control" name="tipo">
                                            <option value="">--- Elige un categoría ---</option>
                                            <option>Censo</option>
                                            <option>Mantenimiento</option>
                                            <option>Reforestación</option>
                                        </select>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="btnSave_act" onclick="save_actividad()" class="btn green-turquoise">Guardar</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade bs-modal-md" id="lista_actividades_asignadas" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
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
                                <table id="actividades_asignadas" class="table table-hover table-bordered small">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Acción</th>
                                            <th>Encargado</th>
                                            <?if($reforestacion['estado'] == 'Pendiente')
                                            {?>
                                            	<th>Acciones</th>
                                           	<?}?>
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
        <script src="<? echo base_url(); ?>assets/apps/scripts/actividades.js" type="text/javascript"></script>
        <script src="<? echo base_url(); ?>assets/apps/scripts/areas.js" type="text/javascript"></script>
        <script src="<? echo base_url(); ?>assets/apps/scripts/empleados.js" type="text/javascript"></script>
        <script src="<? echo base_url(); ?>assets/apps/scripts/especies.js" type="text/javascript"></script>
        <script src="<? echo base_url(); ?>assets/apps/scripts/implementos.js" type="text/javascript"></script>
        <script src="<? echo base_url(); ?>assets/apps/scripts/reforestaciones.js" type="text/javascript"></script>
    </body>
</html>