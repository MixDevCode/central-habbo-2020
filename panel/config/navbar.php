<nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse"><span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span></button>
				<a class="navbar-brand" href="#"><span>Panel</span> UniversoHabbo</a>
			</div>
		</div><!-- /.container-fluid -->
	</nav>
	<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
		<div class="profile-sidebar">
			<div class="profile-usertitle">
				<div class="profile-usertitle-name"><?php echo $_SESSION['username']; ?></div>
				<div class="profile-usertitle-status"></span>Administrador</div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="divider"></div>
		<ul class="nav menu">
			<li><a href="/panel/"><em class="fa fa-dashboard">&nbsp;</em> Panel</a></li>
			<li class="parent "><a data-toggle="collapse" href="#retros">
				<em class="fa fa-navicon">&nbsp;</em> Hoteles <span data-toggle="collapse" href="#retros" class="icon pull-right"><em class="fa fa-plus"></em></span>
				</a>
				<ul class="children collapse" id="retros">
					<li><a class="" href="/panel/pending">
						<span class="fa fa-arrow-right">&nbsp;</span> Pendientes
					</a></li>
					<li><a class="" href="/panel/added">
						<span class="fa fa-arrow-right">&nbsp;</span> Agregados
					</a></li>
					<li><a class="" href="/panel/action/add">
						<span class="fa fa-arrow-right">&nbsp;</span> Agregar
					</a></li>
				</ul>
			</li>
			<li class="parent "><a data-toggle="collapse" href="#users">
				<em class="fa fa-navicon">&nbsp;</em> Usuarios <span data-toggle="collapse" href="#users" class="icon pull-right"><em class="fa fa-plus"></em></span>
				</a>
				<ul class="children collapse" id="users">
					<li><a class="" href="/panel/action/adduser">
						<span class="fa fa-arrow-right">&nbsp;</span> Agregar
					</a></li>
					<li><a class="" href="/panel/userlist">
						<span class="fa fa-arrow-right">&nbsp;</span> Listado
					</a></li>
				</ul>
			</li>
			<li><a href="/"><em class="fa fa-power-off">&nbsp;</em> Salir</a></li>
		</ul>
	</div><!--/.sidebar-->