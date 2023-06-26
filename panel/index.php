<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login/");
    exit;
}

// Include config file
require_once ('config/database.config.php');

$query = mysqli_query($link, "SELECT * FROM users WHERE user='".$_SESSION['username']."'");

if(mysqli_num_rows($query) > 0){
}else{
    header("location: login/");
	session_destroy();
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Panel de Administración</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/font-awesome.min.css" rel="stylesheet">
	<link href="css/datepicker3.css" rel="stylesheet">
	<link href="css/styles.css" rel="stylesheet">
	
	<!--Custom Font-->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
	<!--[if lt IE 9]>
	<script src="js/html5shiv.js"></script>
	<script src="js/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	<?php require ('config/navbar.php'); ?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#">
					<em class="fa fa-home"></em>
				</a></li>
				<li class="active">Panel</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Panel</h1>
			</div>
		</div><!--/.row-->
		
		<div class="panel panel-container">
			<div class="row">
				<div class="col-xs-6 col-md-4 col-lg-4 no-padding">
					<div class="panel panel-orange panel-widget border-right">
						<div class="row no-padding"><em class="fa fa-xl fa-search color-teal"></em>
							<div class="large">
							<?php 
								$sqlviews = ("SELECT * FROM views");
								$resultviews = $link->query($sqlviews);
								$rowviews = mysqli_num_rows($resultviews);
							 ?>
							<?php echo $rowviews;?></div>
							<div class="text-muted">Visitas</div>
						</div>
					</div>
				</div>
				<div class="col-xs-6 col-md-4 col-lg-4 no-padding">
					<div class="panel panel-blue panel-widget border-right">
						<div class="row no-padding"><em class="fa fa-xl fa-users color-orange"></em>
							<div class="large">
							 <?php 
								$sqladm = ("SELECT * FROM users");
								$resultadm = $link->query($sqladm);
								$rowadm = mysqli_num_rows($resultadm);
							 ?>
							<?php echo $rowadm;?>
							</div>
							<div class="text-muted">Administradores</div>
						</div>
					</div>
				</div>
				<div class="col-xs-6 col-md-4 col-lg-4 no-padding">
					<div class="panel panel-red panel-widget ">
						<div class="row no-padding"><em class="fa fa-xl fa-info-circle color-red"></em>
							<div class="large"> 
							<?php 
								$sqlretros = ("SELECT * FROM retros WHERE published = '1'");
								$resultretros = $link->query($sqlretros);
								$rowretros = mysqli_num_rows($resultretros);
							 ?>
							<?php echo $rowretros;?></div>
							<div class="text-muted">Hoteles Publicados</div>
						</div>
					</div>
				</div>
			</div><!--/.row-->
		</div>
		
		<div class="row">
			<div class="col-md-6">			
				<div class="panel panel-default">
					<div class="panel-heading">
						Últimos hoteles pendientes...
						<span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span></div>
					<div class="panel-body">
						<ul class="todo-list">
						<?php 
							$sqlret = ("SELECT * FROM retros WHERE published = '0' ORDER BY ID DESC LIMIT 5");
							$resultret = $link->query($sqlret);
							if ($rowret = mysqli_fetch_array($resultret)){ 
							do { 
								echo '<li class="todo-list-item">
										<div class="checkbox">
											<label for="checkbox-1">'.$rowret['name'].' - '.$rowret['url'].'</label>
										</div>
										<div class="pull-right action-buttons"><a href="action/publish.php?id='.$rowret['id'].'" class="trash">
											<em class="fa fa-check"></em>
										</a>
										<a href="action/trash.php?id='.$rowret['id'].'" class="trash">
											<em class="fa fa-trash"></em>
										</a></div>
									  </li>
									';	
							} while ($rowret = mysqli_fetch_array($resultret)); 
								echo "</ul>"; 
							} else {
							}
						?>
					</div>
				</div>
			</div><!--/.col-->
			
			
			<div class="col-md-6">
				<div class="panel panel-default articles">
					<div class="panel-heading">
						Historial
						<span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span></div>
					<div class="panel-body articles-container">
						<?php 
							$sqllog = ("SELECT * FROM logs ORDER BY ID DESC LIMIT 5");
							$resultlog = $link->query($sqllog);
							if ($rowlog = mysqli_fetch_array($resultlog)){ 
							do { 
								echo '<div class="article border-bottom">
										<div class="col-xs-12">
											<div class="row">
												<div class="col-xs-2 col-md-2 date">
													<div class="large">'. gmdate('d',$rowlog['timestamp']).'</div>
													<div class="text-muted">'. gmdate('M',$rowlog['timestamp']).'</div>
												</div>
												<div class="col-xs-10 col-md-10">
													<h4>'.$rowlog['user'].'</h4>
													<p>'.$rowlog['action'].'</p>
												</div>
											</div>
										</div>
										<div class="clear"></div>
									  </div>
									';	
							} while ($rowlog = mysqli_fetch_array($resultlog)); 
							} else {
							}
						?>
					</div>
				</div>
			</div><!--/.col-->
		</div><!--/.row-->
	</div>	<!--/.main-->
	
	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/chart.min.js"></script>
	<script src="js/easypiechart.js"></script>
	<script src="js/easypiechart-data.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>
	<script src="js/custom.js"></script>
	
</body>
</html>