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

if (isset($_GET['page'])) {
    $pagina = $_GET['page'];
} else {
    $pagina = 1;
}

$no_of_records_per_page = 8;
$offset = ($pagina-1) * $no_of_records_per_page; 

$total_pages_sql = "SELECT COUNT(*) FROM retros WHERE published = '0'";
$result = mysqli_query($link,$total_pages_sql);
$total_rows = mysqli_fetch_array($result)[0];
$total_pages = ceil($total_rows / $no_of_records_per_page);
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
				<h1 class="page-header">Pendientes</h1>
			</div>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-md-12">			
				<div class="panel panel-default">
					<div class="panel-body">
						<table class="table table-bordered">
						´	<thead>
								<tr>
								  <th scope="col">#</th>
								  <th scope="col">Nombre</th>
								  <th scope="col">URL</th>
								  <th scope="col">Acciones</th>
								</tr>
							</thead>
							<tbody>
								<?php 
									$sqlpen = ("SELECT * FROM retros WHERE published = '0' ORDER BY id DESC LIMIT $offset, $no_of_records_per_page");
									$resultpen = $link->query($sqlpen);
									if ($rowpen = mysqli_fetch_array($resultpen)){ 
									do { 
										echo '<tr>
												  <th scope="row">'.$rowpen['id'].'</th>
												  <td>'.$rowpen['name'].'</td>
												  <td>'.$rowpen['url'].'</td>
												  <td>
												  <div class="pull-center action-buttons">
												  <a href="action/publish.php?id='.$rowpen['id'].'" class="trash">
													<em class="fa fa-check"></em>
												  </a>
												  <a href="action/trash.php?id='.$rowpen['id'].'" class="trash">
													<em class="fa fa-trash"></em>
												  </a>
												  </div>
												  </td>
												</tr>
											';	
									} while ($rowpen = mysqli_fetch_array($resultpen)); 
										echo "</tbody>"; 
									} else {
									}
								?>
						</table>
						<center>
						<nav aria-label="...">
						  <ul class="pagination">
							<li class="<?php if($pagina <= 1){ echo 'disabled'; } ?>"><a href="<?php if($pagina <= 1){ echo '#'; } else { echo "/panel/pending.php?page=".($pagina - 1); } ?>" aria-label="Anterior"><span aria-hidden="true">&laquo;</span></a></li>
							<?php
							do {				
							$paginado = 1;
							echo '<li><a href="#">'. $paginado .'<span class="sr-only"></span></a></li>';
							$paginado = $paginado + 1;
							} while ($paginado == $total_pages);
							?>
							<li class="<?php if($pagina >= $total_pages){ echo 'disabled'; } ?>"><a href="<?php if($pagina <= 1){ echo '#'; } else { echo "/panel/pending.php?page=".($pagina + 1); } ?>" aria-label="Siguiente"><span aria-hidden="true">&raquo;</span></a></li>
						  </ul>
						</nav>
						</center>
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