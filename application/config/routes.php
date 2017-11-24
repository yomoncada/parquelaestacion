<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['area'] = 'area';
$route['bitacora'] = 'bitacora';
$route['basededatos'] = 'basededatos';
$route['beneficiario'] = 'beneficiario';
$route['cabana'] = 'cabana';
$route['cancha'] = 'cancha';
$route['cargo'] = 'cargo';
$route['categoria'] = 'categoria';
$route['censo'] = 'censo';
$route['censo/control/(:any)'] = 'censo/control/$1';
$route['censo/new'] = 'censo/create';
$route['donacion'] = 'donacion';
$route['donacion/control/(:any)'] = 'donacion/control/$1';
$route['donacion/new'] = 'donacion/create';
$route['donante'] = 'donante';
$route['edificio'] = 'edificio';
$route['empleado'] = 'empleado';
$route['especie'] = 'especie';
$route['home'] = 'sistema/home';
$route['implemento'] = 'implemento';
$route['login'] = 'sistema/login';
$route['logout'] = 'sistema/logout';
$route['perfil'] = 'perfil';
$route['perfil/view/(:any)'] = 'perfil/view/$1';
$route['mantenimiento'] = 'mantenimiento';
$route['mantenimiento/control/(:any)'] = 'mantenimiento/control/$1';
$route['mantenimiento/new'] = 'mantenimiento/create';
$route['reforestacion'] = 'reforestacion';
$route['downloads'] = 'reporte';
$route['reforestacion/control/(:any)'] = 'reforestacion/control/$1';
$route['reforestacion/new'] = 'reforestacion/create';
$route['servicio'] = 'servicio';
$route['servicio/control/(:any)'] = 'servicio/control/$1';
$route['servicio/new'] = 'servicio/create';
$route['upload'] = 'upload';
$route['usuario'] = 'usuario';

$route['default_controller'] = 'index';
$route['(:any)'] = 'index/$1';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

