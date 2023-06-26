<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../login");
    exit;
}

// Include config file
require_once ('../config/database.config.php');

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
	<link href="../css/bootstrap.min.css" rel="stylesheet">
	<link href="../css/font-awesome.min.css" rel="stylesheet">
	<link href="../css/datepicker3.css" rel="stylesheet">
	<link href="../css/styles.css" rel="stylesheet">
	
	<!--Custom Font-->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
	<!--[if lt IE 9]>
	<script src="js/html5shiv.js"></script>
	<script src="js/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	<?php require ('../config/navbar.php'); ?>
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
				<h1 class="page-header">Agregar Hotel</h1>
			</div>
		</div><!--/.row-->
		<?php
		if (!empty($_POST)) {

		$timestamp = time();
		$nombreu = $_SESSION["username"];
		$retroname = $_POST['retro'];
		$retroname2 = $link->real_escape_string($retroname);
		$retrourl = $_POST['url'];
		$retrourl2 = $link->real_escape_string($retrourl);
				
		$sqlsdsd = "INSERT INTO retros (name, url, published)".
				"VALUES ('$retroname2', '$retrourl2', '1')";
		$result = $link->query($sqlsdsd);
		
		$sqldsd = "INSERT INTO logs (user, action, timestamp)".
			"VALUES ('$nombreu', 'Agregó el hotel $retroname2 a la lista', '$timestamp')";
		$link->query($sqldsd);
		
		?>
		<script type="text/javascript">
		window.location.href = '/panel/';
		</script>
		<?php
		} else {
		?> 
		<div class="row">
			<div class="col-md-12">			
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="col-md-12">
							<form role="form" method="post" action="" enctype="multipart/form-data">
								<div class="form-group">
									<label>Nombre</label>
									<input class="form-control" name="retro" placeholder="Ej: Habbo">
								</div>
								<div class="form-group">
									<label>URL</label>
									<input class="form-control" name="url" placeholder="Ej: habbo.es">
								</div>
								<button type="submit" class="btn btn-primary">Agregar</button>
							</form>
						</div>
					</div>
				</div>
			</div><!--/.col-->
		</div><!--/.row-->
		<?php } ?>
	</div>	<!--/.main-->
	
	<script src="../js/jquery-1.11.1.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script src="../js/chart.min.js"></script>
	<script src="../js/easypiechart.js"></script>
	<script src="../js/easypiechart-data.js"></script>
	<script src="../js/bootstrap-datepicker.js"></script>
	<script src="../js/custom.js"></script>
	
</body>
</html>