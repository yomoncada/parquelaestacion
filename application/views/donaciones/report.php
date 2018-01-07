<!DOCTYPE html>
<html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Reporte de la Donación N° <?echo $donacion['id_dnc'];?></title>
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
                                    <h3><span class="bold uppercase">Donacion Nº <?echo $donacion['id_dnc'];?></span></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-7 col-xs-offset-3">
                    <div class="row" style="padding: 2.5em 0em">
                        <div class="col-xs-4">
                            <span class="bold uppercase font-green-turquoise">Responsable</span>
                            <br>
                            <span class=""><?echo $donacion['usuario'];?></span>
                        </div>
                        <div class="col-xs-4">
                            <span class="bold uppercase font-green-turquoise">Fecha y Hora</span>
                            <br>
                            <span class=""><?echo $donacion['fecha_act'];?></span>
                        </div>
                        <div class="col-xs-4">
                            <span class="bold uppercase font-green-turquoise">Estado</span>
                            <br>
                            <span class=""><?echo $donacion['estado'];?></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <?if($donantes){?>
                    <div class="row">
                        <div class="col-xs-12">
                            <table class="table table-bordered small">
                                </thead>
                                <thead>
                                    <tr>
                                        <th colspan="3" class="text-center">Detalles de los Donantes Asignados</th>
                                    </tr>
                                    <tr>
                                        <th>#</th>
                                        <th>Razón Social</th>
                                        <th>RIF</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?$i = 1;
                                    foreach ($donantes as $donante):?>
                                    <tr>
                                       <td scope="col" width="5%"><?echo $i;?></td> 
                                       <td scope="col" width="47.5%"><?echo $donante->razon_social;?></td> 
                                       <td scope="col"><?echo $donante->rif;?></td> 
                                    </tr>
                                    <?$i++;
                                    endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?}?>
                    <?if($implementos){?>
                    <div class="row">
                        <div class="col-xs-12">
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
                        </div>
                    </div>
                    <?}?>
                    <?if($fondos){?>
                    <div class="row">
                        <div class="col-xs-12">
                            <table class="table table-bordered small">
                                </thead>
                                <thead>
                                    <tr>
                                        <th colspan="3" class="text-center">Detalles de los Fondos Asignados</th>
                                    </tr>
                                    <tr>
                                        <th>#</th>
                                        <th>Cantidad</th>
                                        <th>Divisa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?$i = 1;
                                    foreach ($fondos as $fondo):?>
                                    <tr>
                                       <td scope="col" width="5%"><?echo $i;?></td> 
                                       <td scope="col" width="47.5%"><?echo $fondo->cantidad;?></td> 
                                       <td scope="col"><?echo $fondo->divisa;?></td> 
                                    </tr>
                                    <?$i++;
                                    endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?}?>
                    <div class="row" style="padding-top: 1.5em; padding-bottom: 2.5em">
                        <div class="col-xs-12">
                            <span class="bold uppercase font-green-turquoise text-center">Observación</span>
                            <br>
                            <?if($donacion['observacion']){?>
                            <span class="text-left"><?echo $donacion['observacion'];?></span>
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
                                <span class="bold"><?echo $donacion['usuario'];?></span>
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
