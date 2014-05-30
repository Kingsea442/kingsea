<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	<!-- Brand and toggle get grouped for better mobile display -->
	<div class="navbar-header">
		<a class="navbar-brand" href="#">Kingsea</a>
	</div>

	<!-- Collect the nav links, forms, and other content for toggling -->
	<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		<ul class="nav navbar-nav">
			<li>
				<a href="index.html">导航</a>
			</li>

			<li>
				<a href="#">博客</a>
			</li>
			<li>
				<a href="#">记事本</a>
			</li>
		</ul>
		<ul class="nav navbar-nav navbar-right">
			<li>
				<a href="<?php echo base_url('index.php/navcontrollers/nav_controller/is_login');?>">管理</a>
			</li>
			<li>
				<a href="">
					<span class="glyphicon glyphicon-cog"></span>
				</a>
			</li>
		</ul>
	</div>

</nav>