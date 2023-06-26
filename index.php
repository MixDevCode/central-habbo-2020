<?php
// Include config file
require_once ('panel/config/database.config.php');

function getUserIP()
	{
    // Get real visitor IP behind CloudFlare network
    if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
              $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
              $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
    }
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }

    return $ip;
	}


$user_ip = getUserIP();

$queryvisit = mysqli_query($link, "INSERT INTO views (ip) VALUES ('$user_ip')");

if (isset($_GET['page'])) {
    $pagina = $_GET['page'];
} else {
    $pagina = 1;
}

$no_of_records_per_page = 8;
$offset = ($pagina-1) * $no_of_records_per_page; 

$total_pages_sql = "SELECT COUNT(*) FROM retros WHERE published = '1'";
$result = mysqli_query($link,$total_pages_sql);
$total_rows = mysqli_fetch_array($result)[0];
$total_pages = ceil($total_rows / $no_of_records_per_page);

$query = mysqli_query($link, "SELECT * FROM retros WHERE published= '1' ");

$totret = mysqli_num_rows($query);

$primhotel = mysqli_query($link, "SELECT id FROM retros WHERE published = '1' ORDER BY id ASC LIMIT 1");
$rowprim = mysqli_fetch_array($primhotel);
$primhotel2 = $rowprim['id'];
?>
<!DOCTYPE html>
<html lang="fr">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
	<meta charset="utf-8"/>
	<meta name="identifier-url" content="http://makehabbo.fr/"/>
	<meta name="reply-to" content="contact@universohabbo.com"/>
	<meta property="og:site_name" content="Universo Habbo"/>
	<meta property="og:title" content="Universo Habbo - Cada hotel es un mundo"/>
		
	<meta property="og:url" content="http://universohabbo.com/"/>
	<meta property="og:description" content="Universo Habbo es una central de hoteles, hecha con la finalidad de simplificar la busqueda de holos."/>
	<meta property="og:image" content='app/assets/img/meta.png'/>
	<meta name="description" content="Universo Habbo es una central de hoteles, hecha con la finalidad de simplificar la busqueda de holos."/>
	<meta name="keywords" content="comunidad, central, retro, holos, habbo hotel, hoteles habbo, universo, habbo universo, universo habbo, buscar hoteles, hoteles en español habbo, habbo español, retro español, creditos gratis, diamantes gratis, creditos infinitos, diamantes infinitos">

	<title>Universo Habbo &#8250; Cada hotel es un mundo.</title>

	<link rel="stylesheet" type="text/css" href="app/assets/css/all732d.css?LVL95"/>
	<link rel="stylesheet" type="text/css" href="app/assets/css/login732d.css?LVL95">
	<link rel='icon' type='img/ico' href='app/assets/img/favicon.ico'/>
		
</head>
<body class="preload">
		<noscript>
			<div class="error">
				<p>Necesitas activar Javascript para navegar por nuestra web!</p>
			</div>
		</noscript>

		<div class="errorCache">
			<div class="box">
				<div class="title">
					<span>Ooops, ocurrió un error!</span>
					<i class="croix_cec fa fa-close"></i>
				</div>
				<div class="content">
					<p></p>
				</div>
			</div>
		</div>
		<?php
		if (!empty($_POST)) {

		$name = $_POST['retro'];
		$name2 = $link->real_escape_string($name);
		
		$queryhotel = mysqli_query($link, "SELECT * FROM retros WHERE name='$name'");
		
		if(mysqli_num_rows($queryhotel) > 0) {
			echo '<div class="alert">
		<span class="closebtn">&times;</span>  
			<strong>Error!</strong> Ya existe un hotel con ese nombre en nuestra base de datos.
		</div>';
		} else {
		
			$url = $_POST['link'];
			
			if (strpos($url,'http://') !== false) { 
				$url = str_replace('http://', '', $url); 
			} else {
				if (strpos($url,'https://') !== false) { 
					$url = str_replace('https://', '', $url);
				}
			}
					
			$sqlsdsd = "INSERT INTO retros (name, url, published)".
					"VALUES ('$name2', '$url', '0')";
			$result = $link->query($sqlsdsd);
			
			echo '<div class="alert success">
			<span class="closebtn">&times;</span>  
				<strong>Hecho!</strong> La solicitud fue enviada correctamente.
			</div>';
			
		}
		}
		?> 
		

		<div class="top">
			<div class="center">
				<div class="logo">
					<img src="https://habbofont.net/font/explore_big/universo+habbo.gif"/>
				</div>
			</div>
		</div>
		<a style="color:rgba(100,100,100,0); font-size:1px;">comunidad, central, retro, holos, habbo hotel, hoteles habbo, universo, habbo universo, universo habbo, buscar hoteles, hoteles en español habbo, habbo español, retro español, creditos gratis, diamantes gratis, creditos infinitos, diamantes infinitos</a>
		<div class="page">
			<div class="left">
				<div class="news">
					<h1>Hoteles Aleatorios</h1>
					<div class="content">
						<?php
						$ret = mysqli_query($link, "SELECT * FROM retros WHERE published = '1' ORDER BY RAND() LIMIT 4");
						if ($rowret = mysqli_fetch_array($ret)){ 
						do { 
							?>
							<div class="art" onclick="window.location.href='http://<?php echo $rowret["url"];?>'" style="background-image:url('hoteles/<?php echo $rowret["id"];?>.png');">
							<div class="down">
								<h1><?php echo $rowret["name"];?></h1>
							</div>
							</div>
							<?php
						} while ($rowret = mysqli_fetch_array($ret)); 
						} else {
						}
						?>
					</div>
				</div>
			</div>
			<div class="right">
				<form name="login_form" method="post" enctype="multipart/form-data">
					<h1>Quieres agregar tu hotel?</h1>
					<label for="username">
						<p>Nombre del Hotel</p>
					</label>
					<input type="text" name="retro" id="retro" placeholder="Ej: Habbo" value=""/>
					<label for="password">
						<p>Link del Hotel</p>
					</label>
					<input type="text" name="link" id="link" placeholder="Ej: habbo.es" value=""/>
					<input type="submit" name="submit" value="Enviar Solicitud"/>
				</form>
				<a class="fb" style="background-color: white; color: black;" href="https://facebook.com/makehabbofrance" target="_blank">
					Nuestro universo tiene <?php echo $totret;?> hoteles en la lista!
				</a>
				<a class="fb" href="https://facebook.com/makehabbofrance" target="_blank">
					Síguenos en Facebook!
				</a>
			</div>
			<div class="last">
				<h1>Todos los hoteles agregados</h1>
				<div class="content">
				<?php
					$ret2 = mysqli_query($link, "SELECT * FROM retros WHERE published = '1' ORDER BY id DESC LIMIT $offset, $no_of_records_per_page");
					if ($rowret2 = mysqli_fetch_array($ret2)){ 
					do { 
						?>
						<div class="hotel" onclick="window.location.href='http://<?php echo $rowret2["url"];?>'" style="background-image:url('hoteles/<?php echo $rowret2["id"];?>.png');">
						<div class="down">
							<h1><?php echo $rowret2["name"];?></h1>
						</div>
						</div>
						<?php
					} while ($rowret2 = mysqli_fetch_array($ret2)); 
					} else {
					}
				?>
				</div>
				<center>
			<div class="pagination">
			<?php
			do {				
			$paginado = 1;
			echo '<a href="#"';if ($pagina == $paginado) { echo 'class="active"'; }?><?php echo '>'. $paginado .'</a>';
			$paginado = $paginado + 1;
			} while ($paginado == $total_pages);
			?>
			</div>
			</center>
			</div>

		<div class="footer general">
			<div class="center" style="width:980px;">
				<div class="logo">
					<img src="app/assets/img/footer.png"/>
				</div>
				<div class="links">
					<a href="help-center/cgu">Condiciones de Uso</a>
					<a href="team">Soporte</a>
					<a href="help-center">Discord</a>
				</div>
				<div class="copy">
					&copy 2020. Universo Habbo no es propiedad ni está asociado a Sulake Corp.
				</div>
			</div>
		</div>

		<script type="text/javascript">
			;site = {
				name: 'Universo Habbo',
				url: 'http://universohabbo.com/'
			}
		</script>
		<script>
		var close = document.getElementsByClassName("closebtn");
		var i;

		for (i = 0; i < close.length; i++) {
		  close[i].onclick = function(){
			var div = this.parentElement;
			div.style.opacity = "0";
			setTimeout(function(){ div.style.display = "none"; }, 600);
		  }
		}
		</script>		
		<script type="text/javascript" src="app/assets/js/jquery.min732d.js?LVL95"></script>
		<script type="text/javascript" src="app/assets/js/all.jquery732d.js?LVL95"></script>
</body>
</html>
	