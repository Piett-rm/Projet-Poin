<div class="navbar">
	<div class="navbar-inner">
		<div class="container">
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>

			<div class="nav-collapse">
				<ul class="nav">




					<?php
					if (isset($_SESSION['type'])) {
					?>

						<li><a href="./index.php">Acceuil</a></li>
						<li><a href="./missions.php">Missions</a></li>
						<li><a href="#">Récompenses</a></li>
						<li><a href="./mon_compte.php">Mon compte</a></li>
						<li><a href="./planing.php">Planning</a></li>
						<li><a href="./historique.php">Historique</a></li>

						<?php
						if ($_SESSION['type'] == "administrateur") {
						?>


							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">Administration</a>
								<ul class="dropdown-menu">
									<li><a href="#">lien 1</a></li>
									<li><a href="#">lien 2</a></li>
									<li><a href="#">lien 3</a></li>


								</ul>
							</li>

					<?php
						}
					}
					?>





				</ul>

			</div><!-- /.nav-collapse -->
		</div>
	</div><!-- /navbar-inner -->
</div>