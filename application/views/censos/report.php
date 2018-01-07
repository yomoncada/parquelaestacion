<!DOCTYPE html>
<html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Reporte del Censo N° <?echo $censo['id_cen'];?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
    </head>
    <body style="background: white;">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="row">
                                <div class="col-xs-3">
                                    <img src="<? echo base_url();?>/assets/pages/img/isotype.svg" width="100" height="100" alt="">
                                </div>
                                <div class="col-xs-9" style="margin-top: 2.5em;">
                                    <h4><span class="bold uppercase font-green-turquoise">Parque La Estación</span></h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="row">
                                <div class="col-xs-6 col-xs-offset-6 text-right" style="margin-top: 1.5em;">
                                    <h3><span class="bold uppercase">Censo Nº <?echo $censo['id_cen'];?></span></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-7 col-xs-offset-3">
                    <div class="row" style="padding: 2.5em 0em">
                        <div class="col-xs-3">
                            <span class="bold uppercase font-green-turquoise">Responsable</span>
                            <br>
                            <span class=""><?echo $censo['usuario'];?></span>
                        </div>
                        <div class="col-xs-3">
                            <span class="bold uppercase font-green-turquoise">Fecha Asig.</span>
                            <br>
                            <span class=""><?echo $censo['fecha_asig'];?></span>
                        </div>
                        <div class="col-xs-3">
                            <span class="bold uppercase font-green-turquoise">Hora Asig.</span>
                            <br>
                            <span class=""><?echo $censo['hora_asig'];?></span>
                        </div>
                        <div class="col-xs-3">
                            <span class="bold uppercase font-green-turquoise">Estado</span>
                            <br>
                            <span class=""><?echo $censo['estado'];?></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="row">
                        <div class="col-xs-12">
                            <?if($empleados){?>
                            <table class="table table-bordered small">
                                </thead>
                                <thead>
                                    <tr>
                                        <th colspan="3" class="text-center">Detalles de los Empleados Asignados</th>
                                    </tr>
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre</th>
                                        <th>Cédula</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?$i = 1;
                                    foreach ($empleados as $empleado):?>
                                    <tr>
                                       <td scope="col" width="5%"><?echo $i;?></td> 
                                       <td scope="col" width="47.5%"><?echo $empleado->nombre;?></td> 
                                       <td scope="col"><?echo $empleado->cedula;?></td> 
                                    </tr>
                                    <?$i++;
                                    endforeach;?>
                                </tbody>
                            </table>
                            <?}?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <?if($areas){?>
                            <table class="table table-bordered small">
                                </thead>
                                <thead>
                                    <tr>
                                        <th colspan="3" class="text-center">Detalles de las Áreas Asignadas</th>
                                    </tr>
                                    <tr>
                                        <th>#</th>
                                        <th>Código</th>
                                        <th>Nombre</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?$i = 1;
                                    foreach ($areas as $area):?>
                                    <tr>
                                       <td scope="col" width="5%"><?echo $i;?></td> 
                                       <td scope="col" width="47.5%"><?echo $area->codigo;?></td> 
                                       <td scope="col"><?echo $area->area;?></td> 
                                    </tr>
                                    <?$i++;
                                    endforeach;?>
                                </tbody>
                            </table>
                            <?}?>
                        </div>
                    </div>
                    <div class="row">
                        <?if($censo['estado'] == 'En progreso'){?>
                        <div class="col-xs-12">
                            <table class="table table-bordered small">
                                </thead>
                                <thead>
                                    <tr>
                                        <th colspan="3" class="text-center">Detalles de las Especies Asignadas</th>
                                    </tr>
                                    <tr>
                                        <th>#</th>
                                        <th>Código</th>
                                        <th>Nombre</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?$i = 1;
                                    foreach ($especies as $especie):?>
                                    <tr>
                                       <td scope="col" width="5%"><?echo $i;?></td> 
                                       <td scope="col" width="47.5%"><?echo $especie->codigo;?></td> 
                                       <td scope="col"><?echo $especie->nom_cmn;?></td> 
                                    </tr>
                                    <?$i++;
                                    endforeach;?>
                                </tbody>
                            </table>
                        </div>
                        <?}?>
                        <?if($censo['estado'] == 'Finalizado'){?>
                        <div class="col-xs-12">
                            <?if($especies){?>
                            <table class="table table-bordered small">
                                </thead>
                                <thead>
                                    <tr>
                                        <th colspan="4" class="text-center">Detalles de las Especies Censadas</th>
                                    </tr>
                                    <tr>
                                        <th>#</th>
                                        <th>Código</th>
                                        <th>Nombre</th>
                                        <th>Poblacion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?$i = 1;
                                    foreach ($especies as $especie):?>
                                    <tr>
                                       <td scope="col" width="5%"><?echo $i;?></td> 
                                       <td scope="col" width="31.6%"><?echo $especie->codigo;?></td> 
                                       <td scope="col" width="31.6%"><?echo $especie->nom_cmn;?></td> 
                                       <td scope="col" width="31.6%"><?echo $especie->poblacion;?></td> 
                                    </tr>
                                    <?$i++;
                                    endforeach;?>
                                </tbody>
                            </table>
                            <?}?>
                        </div>
                        <?}?>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <?if($implementos){?>
                            <table class="table table-bordered small">
                                </thead>
                                <thead>
                                    <tr>
                                        <th colspan="5" class="text-center">Detalles de los Implementos</th>
                                    </tr>
                                    <tr>
                                        <th>#</th>
                                        <th>Código</th>
                                        <th>Nombre</th>
                                        <th>Cantidad</th>
                                        <th>Unidad</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?$i = 1;
                                    foreach ($implementos as $implemento):?>
                                    <tr>
                                       <td scope="col" width="5%"><?echo $i;?></td> 
                                       <td scope="col" width="23.75%"><?echo $implemento->codigo;?></td> 
                                       <td scope="col" width="23.75%"><?echo $implemento->nombre;?></td> 
                                       <td scope="col" width="23.75%"><?echo $implemento->cantidad;?></td> 
                                       <td scope="col" width="23.75%"><?echo $implemento->unidad;?></td> 
                                    </tr>
                                    <?$i++;
                                    endforeach;?>
                                </tbody>
                            </table>
                            <?}?>
                        </div>
                    </div>
                    <div class="row">
                        <?if($censo['estado'] == 'En progreso'){?>
                        <div class="col-xs-12">
                            <table class="table table-bordered small">
                                </thead>
                                <thead>
                                    <tr>
                                        <th colspan="2" class="text-center">Detalles de las Actividades Asignadas</th>
                                    </tr>
                                    <tr>
                                        <th>#</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?$i = 1;
                                    foreach ($actividades as $actividad):?>
                                    <tr>
                                       <td scope="col" width="5%"><?echo $i;?></td> 
                                       <td scope="col" width="47.5%"><?echo $actividad->accion;?></td> 
                                    </tr>
                                    <?$i++;
                                    endforeach;?>
                                </tbody>
                            </table>
                        </div>
                        <?}?>
                        <?if($censo['estado'] == 'Finalizado'){?>
                        <div class="col-xs-12">
                            <table class="table table-bordered small">
                                </thead>
                                <thead>
                                    <tr>
                                        <th colspan="3" class="text-center">Detalles de las Actividades Realizadas</th>
                                    </tr>
                                    <tr>
                                        <th>#</th>
                                        <th>Acción</th>
                                        <th>Encargado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?$i = 1;
                                    foreach ($actividades as $actividad):?>
                                    <tr>
                                       <td scope="col" width="5%"><?echo $i;?></td> 
                                       <td scope="col" width="47.5%"><?echo $actividad->accion;?></td> 
                                       <td scope="col"><?echo $actividad->encargado;?></td> 
                                    </tr>
                                    <?$i++;
                                    endforeach;?>
                                </tbody>
                            </table>
                        </div>
                        <?}?>
                    </div>
                    <?if($censo['estado'] == 'En progreso'){?>
                    <div class="row" style="padding-top: 1.5em; padding-bottom: 2.5em">
                        <div class="col-xs-12">
                            <div class="col-xs-6 text-center">
                                <span class="bold uppercase font-dark">Firma del Responsable</span>
                                <br>
                                <br>
                                <br>
                                <span>_____________________________</span>
                                <br>
                                <span class="bold"><?echo $censo['usuario'];?></span>
                                <br>
                                <span class="bold">Censista</span>
                            </div>
                            <div class="col-xs-6 text-center">
                                <span class="bold uppercase font-dark">Firma del Supervisor General</span>
                                <br>
                                <br>
                                <br>
                                <span>_____________________________</span>
                                <br>
                                <span class="bold">Iván Mora</span>
                                <br>
                                <span class="bold">C.I: 12.345.678</span>
                            </div>
                        </div>
                    </div>
                    <?}?>
                    <?if($censo['estado'] == 'Finalizado'){?>
                    <div class="row" style="padding-top: 1.5em; padding-bottom: 2.5em">
                        <div class="col-xs-12">
                            <span class="bold uppercase font-green-turquoise text-center">Observación</span>
                            <br>
                            <?if($censo['observacion']){?>
                            <span class="text-left"><?echo $censo['observacion'];?></span>
                            <?}else{?>
                            <span class="text-left">No hay observaciones.</span>
                            <
                            <?}?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="col-xs-6 text-center">
                                <span class="bold uppercase font-dark">Firma del Responsable</span>
                                <br>
                                <br>
                                <br>
                                <span>_____________________________</span>
                                <br>
                                <span class="bold"><?echo $censo['usuario'];?></span>
                                <br>
                                <span class="bold">Censista</span>
                            </div>
                            <div class="col-xs-6 text-center">
                                <span class="bold uppercase font-dark">Firma del Supervisor General</span>
                                <br>
                                <br>
                                <br>
                                <span>_____________________________</span>
                                <br>
                                <span class="bold">Iván Mora</span>
                                <br>
                                <span class="bold">C.I: 12.345.678</span>
                            </div>
                        </div>
                    </div>
                    <?}?>
                </div>
            </div>
        </div>
    </body>
    <script type="text/javascript">
    $(document).ready(function (){
        window.print();
    });
    </script>
</html>
