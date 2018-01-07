<!DOCTYPE html>
<html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Reporte del Servicio N° <?echo $servicio['id_ser'];?></title>
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
                                    <h3><span class="bold uppercase">Servicio Nº <?echo $servicio['id_ser'];?></span></h3>
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
                            <span class=""><?echo $servicio['usuario'];?></span>
                        </div>
                        <div class="col-xs-3">
                            <span class="bold uppercase font-green-turquoise">Fecha Asig.</span>
                            <br>
                            <span class=""><?echo $servicio['fecha_asig'];?></span>
                        </div>
                        <div class="col-xs-3">
                            <span class="bold uppercase font-green-turquoise">Hora Asig.</span>
                            <br>
                            <span class=""><?echo $servicio['hora_asig'];?></span>
                        </div>
                        <div class="col-xs-3">
                            <span class="bold uppercase font-green-turquoise">Estado</span>
                            <br>
                            <span class=""><?echo $servicio['estado'];?></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="row">
                        <div class="col-xs-12">
                            <?if($beneficiarios){?>
                            <table class="table table-bordered small">
                                </thead>
                                <thead>
                                    <tr>
                                        <th colspan="3" class="text-center">Detalles de los Beneficiarios Asignados</th>
                                    </tr>
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre</th>
                                        <th>Cédula</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?$i = 1;
                                    foreach ($beneficiarios as $beneficiario):?>
                                    <tr>
                                       <td scope="col" width="5%"><?echo $i;?></td> 
                                       <td scope="col" width="47.5%"><?echo $beneficiario->nombre;?></td> 
                                       <td scope="col"><?echo $beneficiario->cedula;?></td> 
                                    </tr>
                                    <?$i++;
                                    endforeach;?>
                                </tbody>
                            </table>
                            <?}?>
                        </div>
                    </div>
                    <?if($cabanas){?>
                    <div class="row">
                        <div class="col-xs-12">
                            <table class="table table-bordered small">
                                </thead>
                                <thead>
                                    <tr>
                                        <th colspan="3" class="text-center">Detalles de las Cabañas Asignadas</th>
                                    </tr>
                                    <tr>
                                        <th>#</th>
                                        <th>Número</th>
                                        <th>Capacidad</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?$i = 1;
                                    foreach ($cabanas as $cabana):?>
                                    <tr>
                                       <td scope="col" width="5%"><?echo $i;?></td> 
                                       <td scope="col" width="47.5%"><?echo $cabana->numero;?></td> 
                                       <td scope="col"><?echo $cabana->capacidad;?></td> 
                                    </tr>
                                    <?$i++;
                                    endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?}?>
                    <?if($canchas){?>
                    <div class="row">
                        <div class="col-xs-12">
                            <table class="table table-bordered small">
                                </thead>
                                <thead>
                                    <tr>
                                        <th colspan="4" class="text-center">Detalles de las Canchas Asignadas</th>
                                    </tr>
                                    <tr>
                                        <th>#</th>
                                        <th>Número</th>
                                        <th>Nombre</th>
                                        <th>Capacidad</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?$i = 1;
                                    foreach ($canchas as $cancha):?>
                                    <tr>
                                       <td scope="col" width="5%"><?echo $i;?></td> 
                                       <td scope="col" width="31.6%"><?echo $cancha->numero;?></td> 
                                       <td scope="col" width="31.6%"><?echo $cancha->nombre;?></td> 
                                       <td scope="col" width="31.6%"><?echo $cancha->capacidad;?></td>
                                    </tr>
                                    <?$i++;
                                    endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?}?>
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
                            <?if($invitados){?>
                            <table class="table table-bordered small">
                                </thead>
                                <thead>
                                    <tr>
                                        <th colspan="3" class="text-center">Detalles de los Invitados Asignados</th>
                                    </tr>
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre</th>
                                        <th>Cédula</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?$i = 1;
                                    foreach ($invitados as $invitado):?>
                                    <tr>
                                       <td scope="col" width="5%"><?echo $i;?></td> 
                                       <td scope="col" width="47.5%"><?echo $invitado->nombre;?></td> 
                                       <td scope="col"><?echo $invitado->cedula;?></td> 
                                    </tr>
                                    <?$i++;
                                    endforeach;?>
                                </tbody>
                            </table>
                            <?}?>
                        </div>
                    </div>
                    <?if($servicio['estado'] == 'En progreso'){?>
                    <div class="row" style="padding-top: 1.5em; padding-bottom: 2.5em">
                        <div class="col-xs-12">
                            <div class="col-xs-6 text-center">
                                <span class="bold uppercase font-dark">Firma del Responsable</span>
                                <br>
                                <br>
                                <br>
                                <span>_____________________________</span>
                                <br>
                                <span class="bold"><?echo $servicio['usuario'];?></span>
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
                    <?if($servicio['estado'] == 'Finalizado'){?>
                    <div class="row" style="padding-top: 1.5em; padding-bottom: 2.5em">
                        <div class="col-xs-12">
                            <span class="bold uppercase font-green-turquoise text-center">Observación</span>
                            <br>
                            <?if($servicio['observacion']){?>
                            <span class="text-left"><?echo $servicio['observacion'];?></span>
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
                                <span class="bold"><?echo $servicio['usuario'];?></span>
                                <br>
                                <span class="bold">Servicista</span>
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
