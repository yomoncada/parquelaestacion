<?php
// SBMD - Simple Backup Mysql Database script
date_default_timezone_set('America/Caracas');
error_reporting(E_ERROR | E_PARSE);

$lang ='en';  //indice of the "lang_...json" file with texts
$dir = 'backup/';  //folder to store the ZIP archive with SQL backup

session_start();
$html = $bmd_re ='';

//set object of backupmysql class
include 'backupmysql.class.php';
$bk = new backupmysql($lang, $dir);

$frm ='<h1>'. $bk->langTxt('msg_bmk') .'</h1>

<body class="gray-bg">
    <div class="loginColumns animated fadeInDown">
        <div class="col-lg-6 col-md-6 col-xs-6 col-lg-offset-3 col-md-offset-3 col-xs-offset-3">
            <div class="ibox-content">
                <div class="form-title">
                    <span class="form-title" style="font-size: 16px;"> <center><strong>Mantenimiento de la Base de Datos</strong></center></span>
                    <br>
                    <span class="form-subtitle"><center>Ingresa los datos de tu manejador de base de datos</center></span>
                </div>
                <form class="m-t" role="form" method="post" action="">
                    <h4>'. $bk->langTxt('msg_connect') .'</h4>'. $bk->langTxt('msg_server') .'
                    <input type="hidden" class="form-control input-extra"  name="host" value="localhost"">
                    <div class="form-group">
                        '. $bk->langTxt('msg_user') .'
                        <input type="text" class="form-control input-extra" name="user" placeholder="Usuario" required="">
                    </div>
                    <div class="form-group">
                        '. $bk->langTxt('msg_pass') .'
                        <input type="password" class="form-control input-extra " name="pass" placeholder="Contraseña" required="">
                    </div>
                    '. $bk->langTxt('msg_database') .'
                    <input type="hidden" class="form-control input-extra"  value="parque" required="true" name="dbname">
                    <button type="submit" class="btn green-turquoise btn-block btn-extra" value="'. $bk->langTxt('msg_send') .'">INGRESAR</button>
                </form>
            </div>
        </div>
    </div>
</body>';
//if not form send, set form wiith fields for connection data
    if((!isset($_POST) || count($_POST) ==0) && !isset($_SESSION['bmd_re'])){
        if(isset($_SESSION['mysql'])) unset($_SESSION['mysql']);
        if(isset($_SESSION['bmd_re'])) unset($_SESSION['bmd_re']);
        $html = $frm;
    }
    else if(isset($_POST['host']) && isset($_POST['user']) && isset($_POST['pass']) && isset($_POST['dbname'])){
        $_POST = array_map('trim', array_map('strip_tags', $_POST));
        $_SESSION['mysql'] = ['host'=>$_POST['host'], 'user'=>$_POST['user'], 'pass'=>$_POST['pass'], 'dbname'=>$_POST['dbname']];
    }

//if session with data for connecting to MySQL database (MySQL server, user, password, database name)
    if(isset($_SESSION['mysql'])){
        @set_time_limit(600);

$bk->setMysql($_SESSION['mysql']);  //set connection data

//if form with tables to backup, create ZIP archive with backup. Else: restore backup, or Delete ZIP
if(isset($_POST['tables']) || isset($_POST['bmd_zip'])){
    if(isset($_POST['tables'])) {
$tables = array_map('strip_tags', $_POST['tables']);  //store tables in object
$bmd_re = $bk->saveBkZip($tables);
}
else if(isset($_POST['bmd_zip'])){
    if(isset($_POST['file'])){
        $_POST['file'] = trim(strip_tags($_POST['file']));
        if($_POST['bmd_zip'] =='res_file') $bmd_re = $bk->restore($_POST['file']);
else if($_POST['bmd_zip'] =='get_file') $bmd_re = $bk->getZipFile($_POST['file']);  //when to get ZIP file
else if($_POST['bmd_zip'] =='del_file')$bmd_re = $bk->delFile($_POST['file']);  //when to delete ZIP
}
else $bmd_re = $bk->langTxt('er_sel_file');
}

//Keep response, Refresh to not send form-data again if refreshed
$_SESSION['bmd_re'] = $bmd_re;
header('Location: '. $_SERVER['REQUEST_URI']);
exit;
}

//get response after refresh, delete that session
if(isset($_SESSION['bmd_re'])){
    $bmd_re = $_SESSION['bmd_re'];
    unset($_SESSION['bmd_re']);
}

$html = '<div id="bmd_re">'. $bmd_re .'</div>';

$tables = $bk->getListTables();  //array with [f, er] (form, error)

//if not error when get to show tables, add form with checkboxes, else $frm
if($tables['er'] =='') $html .= '
<body class="gray-bg">
   <div class="loginColumns animated fadeInDown">
        <div class="portlet light portlet-custom bordered animated fadeIn">
            <div class="portlet-body portlet-body-custom">
                <div class="tabbable-line tabbable-full-width">
                    <div id="a_cd"> '. $bk->langTxt('msg_conn_other') .'<a href="'. $_SERVER['PHP_SELF'] .'" title="'. $bk->langTxt('msg_conn_other') .'" class="close" id="a_cd"></a>
                    </div>
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#tab_1_1" data-toggle="tab" id="tab_frm_cht" class="tabvi">'. $bk->langTxt('msg_show_tables') .'<i class="icon-drawer"></i> Respaldo</a>
                        </li>
                        <li>
                            <a href="#tab_1_2" data-toggle="tab" id="tab_frm_zip">'. $bk->langTxt('msg_show_files') .'<i class="icon-reload"></i> Restauración</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1_1">
                            <div class="row">
                                '. $tables['f'] . $bk->getListZip($dir).'   
                            </div>
                        </div>
                    </div>
                </div>        
            </div>
        </div>
    </div>  
</body>';

else $html ='<div id="bmd_re">'. $tables['er'] .'</div>'. $frm;
}

//set texts that will be added in JS (in bmd_lang)
$lang_js = '{
    "msg_when_del":"'. str_replace('"', '\"', $bk->langTxt('msg_when_del')) .'",
    "msg_loading":"'. str_replace('"', '\"', $bk->langTxt('msg_loading')) .'"
}';

header('Content-type: text/html; charset=utf-8');
?>
<!doctype html>
<html lang="es">
<head>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="http://localhost/parque/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="http://localhost/parque/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
    <link href="http://localhost/parque/assets/global/plugins/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="http://localhost/parque/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEIGN PAGE LEVEL PLUGINS -->
    <link href="http://localhost/parque/assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
    <link href="http://localhost/parque/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="http://localhost/parque/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
    <link href="http://localhost/parque/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
    <link href="http://localhost/parque/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css" />
    <link href="http://localhost/parque/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
    <link href="http://localhost/parque/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
    <link href="http://localhost/parque/assets/global/plugins/clockface/css/clockface.css" rel="stylesheet" type="text/css" />
    <link href="http://localhost/parque/assets/global/plugins/sweetalert/sweetalert2.css" rel="stylesheet" type="text/css"/>
    <link href="http://localhost/parque/assets/global/plugins/animate/animate.css" rel="stylesheet" type="text/css"/>
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="http://localhost/parque/assets/global/css/components.css" rel="stylesheet" id="style_components" type="text/css" />
    <link href="http://localhost/parque/assets/global/css/plugins.css" rel="stylesheet" type="text/css" />
    <!-- END THEME GLOBAL STYLES -->
    <link href="http://localhost/parque/assets/pages/css/invoice-2.css" rel="stylesheet" type="text/css" />
    <link href="http://localhost/parque/assets/pages/css/login-2.css" rel="stylesheet" type="text/css" />
    <!-- BEGIN THEME LAYOUT STYLES -->
    <link href="http://localhost/parque/assets/layouts/layout4/css/layout.css" rel="stylesheet" type="text/css" />
    <link href="http://localhost/parque/assets/layouts/layout4/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color" />
    <link href="http://localhost/parque/assets/layouts/layout4/css/custom.css" rel="stylesheet" type="text/css" />
    <!-- END THEME LAYOUT STYLES -->
    <!-- BEGIN CORE PLUGINS -->
    <script src="http://localhost/parque/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
    <script src="http://localhost/parque/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="http://localhost/parque/assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
    <script src="http://localhost/parque/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <script src="http://localhost/parque/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
    <script src="http://localhost/parque/assets/global/plugins/moment.min.js" type="text/javascript"></script>
    <script src="http://localhost/parque/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
    <script src="http://localhost/parque/assets/global/plugins/sweetalert/sweetalert2.min.js" type="text/javascript"></script>
    <!-- END CORE PLUGINS -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="http://localhost/parque/assets/global/plugins/morris/morris.min.js" type="text/javascript"></script>
    <script src="http://localhost/parque/assets/global/plugins/counterup/jquery.waypoints.min.js" type="text/javascript"></script>
    <script src="http://localhost/parque/assets/global/plugins/counterup/jquery.counterup.min.js" type="text/javascript"></script>
    <script src="http://localhost/parque/assets/global/plugins/horizontal-timeline/horozontal-timeline.min.js" type="text/javascript"></script>
    <script src="http://localhost/parque/assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
    <script src="http://localhost/parque/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
    <script src="http://localhost/parque/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript"></script>
    <script src="http://localhost/parque/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
    <script src="http://localhost/parque/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
    <script src="http://localhost/parque/assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
    <script src="http://localhost/parque/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
    <script src="http://localhost/parque/assets/global/plugins/clockface/js/clockface.js" type="text/javascript"></script>
    <script src="http://localhost/parque/assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
    <script src="http://localhost/parque/assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
    <script src="http://localhost/parque/assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL SCRIPTS -->
    <script src="http://localhost/parque/assets/global/scripts/app.min.js" type="text/javascript"></script>
    <script src="http://localhost/parque/assets/global/scripts/datatable.js" type="text/javascript"></script>
    <!-- END THEME GLOBAL SCRIPTS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="http://localhost/parque/assets/pages/scripts/components-date-time-pickers.min.js" type="text/javascript"></script>
    <script src="http://localhost/parque/assets/pages/scripts/portlet-draggable.min.js" type="text/javascript"></script>
    <script src="http://localhost/parque/assets/pages/scripts/table-datatables-managed.min.js" type="text/javascript"></script>
    <script src="http://localhost/parque/assets/pages/scripts/ecommerce-orders.min.js" type="text/javascript"></script>
    <script src="http://localhost/parque/assets/pages/scripts/login.min.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL SCRIPTS -->
    <!-- BEGIN THEME LAYOUT SCRIPTS -->
    <script src="http://localhost/parque/assets/layouts/layout4/scripts/layout.min.js" type="text/javascript"></script>
    <script src="http://localhost/parque/assets/layouts/layout4/scripts/demo.min.js" type="text/javascript"></script>
    <script src="http://localhost/parque/assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
    <!-- END THEME LAYOUT SCRIPTS -->
    <meta charset="utf-8" />
    <title>Simple Backup MySQL Database</title>
    <style>

        body {
            margin:0;
            padding:0;
            text-align: center;
        }
        h1 {
            margin:2px auto;
            text-decoration:underline;
        }
        h1 span {
            color:#0000eb;
        }

        h3 {
            color: #525E64 !important;
            font-size: 18px !important;
            font-weight: 500 !important;
            text-align: left !important;
        }

        .backup-content {
            padding: 0 !important;
            margin: 0 !important;
        }

        #frm {
            width:350px;
            margin:1em auto;
            background: #fff;
            line-height:150%;
            padding:10px 10px 10px 10px;
            -moz-border-radius: 10px;
            -webkit-border-radius: 10px;
            padding: 25px 25px 25px 25px;
        }

        #a_cd {
            display:block;
            text-align:right;
        }
        #a_cd:hover {
            text-decoration:none;
        }

        #bmd_re {
            background: none;
            padding:3px;
            color:#676a6c;
        }
        #bmd_re:empty { display:none;}
        #bmd_load {
            position:fixed;
            left:0;
            top:0;
            margin:0;
            width:100%;
            height:100%;
            background:#fff;
            opacity:.9;
            padding:15% 1% 1% 1%;
            z-index:9999;
        }
        #bmd_load span {
            background:#fff;
            border-radius:5px;
            padding:3px;
            line-height:155%;
        }

        a {
            display:inline-block;
        }

        #frm_cht {
            display:inline-block;
            padding:0 2px 5px 2px;
        }

        #frm_cht .ch_tables {
            display:inline-block;
            margin:15px 20px;
            text-align:left;
            vertical-align:top;
        }
        #frm_cht .ch_tables label {
            display:block;
        }

        #frm_zip {
            display:none;
        }
        #frm_zip label {
            display:block;
            margin:3px 1%;
            text-align:left;
        }

        #mp {
            margin:2% auto 20px auto;
        }

        .form-title {
          color: #525E64;
          font-size: 18px;
          font-weight: 500 !important;
          text-align: left;}

        .form-subtitle {
          color: #525E64;
          font-size: 14px;
          font-weight: 300 !important;
          padding-left: 0px; }

        .input-extra {
            border: none;
            background-color: #ffffff;
            border: 1px solid #ffffff;
            height: 43px;
            color: #1e1e1e;
        }

        .input-extra:active, .input-extra:focus {
            border: 1px solid #36D7B7;
        }

        .btn-extra {
            font-weight: 600;
            padding: 10px 25px !important;
        }

        .form-first-button {
            margin-left: 0 !important;
        }

        .form-action {
            margin-top: 15px;
            margin-left: 0.35em;
            padding: 9px 12px;
        }

        .mt-checkbox-span, .mt-radio-span {
          background-color: #fff !important;
        }

        /*.portlet-custom{
            padding: 20px 0px !important;
        }*/
        .portlet-body-custom{
            padding-top: 0px !important;
        }
        //-->
    </style>
</style>
</head>
<body>
    <?php echo $html; ?>
    <script>
// <![CDATA[
var bmd_lang = <?php echo $lang_js; ?>  //object with texts from $lang

//display loading message
function bmdLoading(){
  document.querySelector('body').insertAdjacentHTML('beforeend', '<div id="bmd_load"><span>'+ bmd_lang.msg_loading +'</span></div>');
}

//if clicked on #ch_all, check all tables in .ch_tables
var ch_all = document.getElementById('ch_all');
if(ch_all){
  var ch_btn = ch_all.querySelector('input');
  var tables = document.querySelectorAll('#frm_cht .ch_tables input');
  ch_all.addEventListener('click', function(){
    if(tables){
      for(var i=0; i<tables.length; i++) tables[i].checked = ch_btn.checked;
  }
});
}

//if #frm_zip
var frm_zip = document.getElementById('frm_zip');
if(frm_zip){
  var dir_bk = document.getElementById('dir_bk').value +'/';
  var zip_files = document.querySelectorAll('#frm_zip .zip_files');

  //get buttons in #frm_zip, register click to submit form according to button
  if(zip_files){
    var btn_zip = document.querySelectorAll('#frm_zip #res_file, #frm_zip #get_file, #frm_zip #del_file');
    for(var i=0; i<btn_zip.length; i++){
      btn_zip[i].addEventListener('click', function(e){
        for(var i2=0; i2<zip_files.length; i2++){
          if(zip_files[i2].checked === true){
            var conf_del = (e.target.id =='del_file') ? window.confirm(bmd_lang.msg_when_del) : true;
            if(conf_del){
              frm_zip['bmd_zip'].value = e.target.id;
              if(e.target.id !='get_file') bmdLoading();  //show Loading if not get_file request
              frm_zip.submit();
          }
          break;
      }
  }
});
  }
}

/* Tabs effect ( http://coursesweb.net/ ) */

var atabs = document.querySelectorAll('a');
var frm_cht = document.getElementById('frm_cht');
  // sets active tab, hides tabs content and shows content associated to current active tab
  // receives the id of active tab
  function tabsCnt(tab_id) {
    document.querySelector('a.tabvi').removeAttribute('class');
    document.getElementById(tab_id).setAttribute('class', 'tabvi');
    frm_zip.style.display = 'none';
    frm_cht.style.display = 'none';
    document.getElementById(tab_id.replace('tab_', '')).style.display = 'inline-block';
}

  // registers click for tabs
  for(var i=0; i<atabs.length; i++) atabs[i].addEventListener('click', function(){
    tabsCnt(this.id);
});

  //on submit forms, show Loading
  frm_cht.addEventListener('submit', bmdLoading);
  frm_zip.addEventListener('submit', bmdLoading);
}
// ]]>
</script>
</body>
</html>
