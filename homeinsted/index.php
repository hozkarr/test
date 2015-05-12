<html lang="en">
<?php
/*ini_set("session.gc_maxlifetime","1400000");
session_start();
if(!session_is_registered(myusername)){
    header("location:index.php"); }
*/
include 'php/dbconnect.php';
mysql_select_db("cdr", $con);
mysql_query('SET NAMES UTF-8');

if (isset($_GET["m"])) {
    $mes_log = htmlspecialchars($_GET["m"]);
    $anio_log = htmlspecialchars($_GET["a"]);
} else {
    $mes_log = date(n);
    $anio_log = date(Y);
}


$meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");



?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Home Instead mobile</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/AW.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="offcanvas.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]>
    <script src="assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="//code.jquery.com/jquery-latest.min.js"></script>
</head>

<body>
<nav class="navbar navbar-fixed-top navbar-inverse">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar" style="margin-top: 33px">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <img src="img/logo.gif" style="margin-top: 4px;margin-left: 5px;">
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#">Inicio</a></li>
                <li><a href="#about">Staff</a></li>
                <li><a href="#contact">Pacientes</a></li>
                <li><a href="#contact">Turnos</a></li>
                <li><a href="#contact">Monitoreo</a></li>
                <li class="active"><a href="#contact">Historial CDR</a></li>
            </ul>
        </div>
        <!-- /.nav-collapse -->
    </div>
    <!-- /.container -->
</nav>
<!-- /.navbar -->

<div class="container">

<div class="row row-offcanvas row-offcanvas-right">
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">HISTORIAL DE LLAMADAS - CDR</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="col-sm-9 ">
<p class="pull-right visible-xs">
    <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Archivo</button>
</p>
<div class="jumbotron">

<div id="content">

<h3><?php echo $meses[$mes_log - 1] ?>, <?php echo $anio_log ?></h3>
<ul id="tabs" class="nav nav-pills" data-tabs="tabs">
    <li class="active"><a href="#detalle" data-toggle="tab">Detalle</a></li>
    <li><a href="#msj1" data-toggle="tab">Buzón 1</a></li>
    <li><a href="#msj2" data-toggle="tab">Buzón 2</a></li>

</ul>
<div id="my-tab-content" class="tab-content">
<div class="tab-pane active" id="detalle">
    <div class="table-responsive">
        <table class="table table-striped">
            <?php
            $query = "SELECT id ,call_start_time,call_end_time,caller_id_number,call_duration,
                                  call_for FROM call_detail
						          WHERE (access_number = '528185261009' OR access_number = '528185261014')
								  AND YEAR(call_start_time) = '" . $anio_log . "'
								  AND MONTH(call_start_time) = '" . $mes_log . "'
								  ORDER BY id DESC";
            $result = mysql_query($query) or die(mysql_error());
            while ($row = mysql_fetch_array($result)) {
                ?>
                <tr>
                    <td id="hide_this_td">
                        <img src="img/IVR.png" width="100px" height="22px">
                    </td>
                    <td id="small-td">
                        <?php if ($row['call_for'] == "HI") { ?>
                        <div
                            style="background-color: #78399C; color: white; height: 20%; width: 100%; text-align: center; margin-top: -5px;">
                            <?php } else if ($row['call_for'] == "VID"){ ?>
                            <div
                                style="background-color: #22B14C; color: white; height: 20%; width: 100%; text-align: center; margin-top: -4px;">
                                <?php } else { ?>
                                <div
                                    style="height: 20%; width: 100%; text-align: center; margin-top: -5px;">
                                    <?php } ?>
                                    <?php echo $row['call_for']; ?>
                                </div>
                    </td>
                    <td id="small-td">
                        <i class="fa fa-phone"></i> <?php echo $row['caller_id_number'] ?><br><a
                            href=""><i
                                class="fa fa-clock-o"></i> <?php echo gmdate("H:i:s", $row['call_duration']); ?>
                        </a>
                    </td>
                    <td id="small-td">
                        Inicio: <?php echo $row['call_start_time'] ?> <br>Fin: &nbsp; &nbsp;
                        &nbsp; <?php echo $row['call_end_time'] ?>
                    </td>
                </tr>
            <?php
            }
            ?>
        </table>
    </div>
</div>
<div class="tab-pane" id="msj1">

    <?php
    $path = "/var/www/html/homeinsted/voicemail/10000/";
    $fp = popen("ls -t -1 --file-type " . $path, "r");

    $path10001 = "/var/www/html/homeinsted/voicemail/10001/";
    $fp10001 = popen("ls -t -1 --file-type " . $path10001, "r");

    $vm_file_list = array();
    $i = 0;
    while ($rec = fgets($fp)) {
        $vm_file_list[$i]['date'] = date('Y-m-d H:i:s', filectime($path . trim($rec)));
        $vm_file_list[$i]['file'] = trim("10000::" . $rec);
        $i++;
    }

    while ($rec10001 = fgets($fp10001)) {
        $vm_file_list[$i]['date'] = date('Y-m-d H:i:s', filectime($path10001 . trim($rec10001)));
        $vm_file_list[$i]['file'] = trim("10001::" . $rec10001);
        $i++;
    }
    foreach ($vm_file_list as $key => $row) {
        $date[$key] = $row['date'];
    }


    array_multisort($date, SORT_DESC, $vm_file_list);

    ?>
    <div class="table-responsive">
        <table class="table table-striped">        <?php
            for ($i = 0; $i < count($vm_file_list); $i++) {
                $explode_vm_file_list = explode("::", $vm_file_list[$i]['file']);
                ?>
                <tr>
                    <td width="20%" style="text-align:center;" id="small-td">
                        <?php
                        echo substr($vm_file_list[$i]['date'], -8) . '</br>';
                        echo substr($vm_file_list[$i]['date'], 0, 10);
                        ?>
                    </td>

                    <td width="20%">
                        <?php if ($explode_vm_file_list[0] == '10000') { ?>
                            <div
                                style="background-color: #78399C; color: white; height: 22px; width: 80%; text-align: center; margin-top: -5px;">
                                HI
                            </div>
                        <?php } else { ?>
                            <div
                                style="background-color: #22B14C; color: white; height: 22px; width: 80%; text-align: center; margin-top: -5px;">
                                VID
                            </div>
                        <?php } ?>
                    </td>
                    <td style="vertical-align:none !important;" width="50%" style="text-align:center">

                        <?php
                        $filepath = "voicemail/$explode_vm_file_list[0]/" . $explode_vm_file_list[1];
                        ?>
                        <audio controls preload="none" style="width: 100%;">
                            <source src='<?php echo $filepath; ?>' type="audio/wav">
                        </audio>

                    </td>

                </tr>

            <?php
            }
            ?>
        </table>
    </div>
</div>
<div class="tab-pane" id="msj2">
    <?php


    $path2 = "/var/www/html/homeinsted/voicemail/20000/";
    $fp2 = popen("ls -t -1 --file-type " . $path2, "r");

    $path20001 = "//var/www/html/homeinsted/voicemail/20001/";
    $fp20001 = popen("ls -t -1 --file-type " . $path20001, "r");

    $vm_file_list2 = array();
    $j = 0;
    while ($rec2 = fgets($fp2)) {
        $vm_file_list2[$j]['date'] = date('Y-m-d H:i:s', filectime($path2 . trim($rec2)));
        $vm_file_list2[$j]['file'] = trim("20000::" . $rec2);
        $j++;
    }

    $vm_file_list20001 = array();
    while ($rec20001 = fgets($fp20001)) {
// 					    $vm_file_list20001[] = trim($rec20001);
        $vm_file_list2[$j]['date'] = date('Y-m-d H:i:s', filectime($path20001 . trim($rec20001)));
        $vm_file_list2[$j]['file'] = trim("20001::" . $rec20001);
        $j++;
    }

    foreach ($vm_file_list2 as $key => $row) {
        $date2[$key] = $row['date'];
        //     $file[$key] = $row['file'];
    }

    // Sort the data with volume descending, edition ascending
    // Add $vm_file_list as the last parameter, to sort by the common key
    array_multisort($date2, SORT_DESC, $vm_file_list2);


    ?>
    <div class="table-responsive">
        <table class="table table-striped">        <?php
            for ($i = 0; $i < count($vm_file_list2); $i++) {
                $explode_vm_file_list2 = explode("::", $vm_file_list2[$i]['file']);
                ?>
                <tr>
                    <td width="20%" style="text-align:center;" id="small-td">
                        <?php  echo substr($vm_file_list2[$i]['date'], -8) . '</br>';
                        echo substr($vm_file_list2[$i]['date'], 0, 10);
                        ?>
                    </td>
                    <td width="20%">
                        <?php if ($explode_vm_file_list2[0] == '20000') { ?>
                            <div
                                style="background-color: #78399C; color: white; height: 22px; width: 80%; text-align: center; margin-top: -5px;">
                                HI
                            </div>
                        <?php } else { ?>
                            <div
                                style="background-color: #22B14C; color: white; height: 22px; width: 80%; text-align: center; margin-top: -5px;">
                                VID
                            </div>
                        <?php } ?>
                    </td>
                    <td style="vertical-align:none !important;" width="50%" style="text-align:center">
                        <?php
                        $filepath2 = "voicemail/$explode_vm_file_list2[0]/" . $explode_vm_file_list2[1];?>

                        <audio controls preload="none" style="width: 100%;">
                            <source src='<?php echo $filepath2; ?>' type="audio/wav">
                        </audio>

                    </td>
                </tr>

            <?php
            }
            ?>
        </table>
    </div>
</div>
</div>
</div>
</div>

<!--/row-->
</div>
<!--/.col-xs-12.col-sm-9-->
<div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar">
    <h3 style="margin-top: 2px;">Archivo</h3>

    <div class="list-group">
        <!--                <a href="#" class="list-group-item active">Link</a>-->
        <?php
        $query = "SELECT DISTINCT DATE_FORMAT( `call_start_time` , '%Y-%m' ) AS fecha_cdr
				      FROM `call_detail`
				      WHERE call_start_time > '2014-01-01 00:00:00'
				      ORDER BY `call_start_time` DESC
					  LIMIT 0 , 10";
        $result = mysql_query($query) or die(mysql_error());
        $i = 0;
        while ($row = mysql_fetch_array($result)) {

            $data = $row['fecha_cdr'];
            list($anio_archivo, $mes_archivo) = explode("-", $data);

            ?>
            <a href="index.php?a=<?php echo $anio_archivo ?>&m=<?php echo $mes_archivo ?>" class="list-group-item">
                <i class="fa fa-calendar"></i>  <?php echo $meses[$mes_archivo - 1] ?> <?php echo $anio_archivo ?></a>

            <?php
            $i++;
        }
        mysql_close($con);
        ?>
    </div>
</div>
<!--/.sidebar-offcanvas-->
</div>
<!--/row-->

<hr>

<footer>
    <div class="copyrights">
        ©2014: Home Instead - Senior Care | Powered by Audioweb
    </div>
</footer>

</div>
<!--/.container-->

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>

<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="assets/js/ie10-viewport-bug-workaround.js"></script>

<script src="offcanvas.js"></script>


</body>
</html>