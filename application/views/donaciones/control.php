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
                        <h1> Donaciones </h1>
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
                        <span class="active">Control</span>
                    </li>
                </ul>
                <div class="invoice-content-2 animated fadeIn">
                    <div class="row invoice-head">
                        <div class="col-sm-4 col-xs-12">
                            <div class="invoice-logo">
                                <h1 class="uppercase">N° <?echo $donacion['id_dnc'];?></h1>
                            </div>
                        </div>
                        <div class="col-sm-8 col-xs-12">
                            <div class="row">
                                <div class="col-sm-4 col-xs-12">
                                    <h2 class="invoice-title uppercase font-green-turquoise">Responsable</h2>
                                    <p class="invoice-desc"><?echo $donacion['usuario'];?></p>
                                </div>
                                <div class="col-sm-4 col-xs-12">
                                    <h2 class="invoice-title uppercase font-green-turquoise">Última Modificación</h2>
                                    <p class="invoice-desc"><?echo $donacion['fecha_act'];?></p>
                                </div>
                                <div class="col-sm-4 col-xs-12">
                                    <h2 class="invoice-title uppercase font-green-turquoise">Estado</h2>
                                    <p class="invoice-desc"><?echo $donacion['estado'];?></p>
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
                                                    <a data-toggle="modal" href="#lista_donantes_asignados" class="btn btn-link" title="Listar">
                                                        <span class="mt-icon">
                                                            <i class="icon-list"></i>
                                                        </span>
                                                    </a>
                                                <?}?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xs-12">
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
                                                    <a data-toggle="modal" href="#lista_implementos_asignados" class="btn btn-link" title="Listar">
                                                        <span class="mt-icon">
                                                            <i class="icon-list"></i>
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
                                                    <a data-toggle="modal" href="#lista_fondos_asignados" class="btn btn-link" title="Listar">
                                                        <span class="mt-icon">
                                                            <i class="icon-list"></i>
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
                                    <i class="icon-note"></i>
                                    <span class="caption-subject bold uppercase">Planificación</span>
                                </div>
                            </div>
                            <div class="portlet-body form">
                                <form id="donacion_form" action="#" role="form">
                                    <div class="form-group">
                                        <label>Observación</label>
                                        <textarea class="form-control" rows="8" readonly=""><?echo $donacion['observacion'];?></textarea>
                                        <span class="help-block"></span>
                                    </div>
                                    <div class="form-actions" style="text-align: right;">
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <a href="<?echo site_url('donacion');?>" class="btn btn-default"> Regresar </a>
                                                <a href="javascript:;" class="btn green-turquoise"> Imprimir </a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
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
                                            <?if($donacion['estado'] == 'Pendiente')
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
                <div class="modal fade bs-modal-md" id="lista_implementos_asignados" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-md">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <div class="caption font-dark">
                                    <i class="icon-list font-dark"></i>
                                    <span class="caption-subject bold uppercase">Listado de Implementos Asignados</span>
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
                                            <?if($donacion['estado'] == 'Pendiente')
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
                                            <?if($donacion['estado'] == 'Pendiente')
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
        <script src="<? echo base_url(); ?>assets/apps/scripts/donantes.js" type="text/javascript"></script>
        <script src="<? echo base_url(); ?>assets/apps/scripts/donaciones.js" type="text/javascript"></script>
        <script src="<? echo base_url(); ?>assets/apps/scripts/implementos.js" type="text/javascript"></script>
    </body>
</html>