<div class="logo">
			<img src="./logo.png" alt="Logo de green wifi corp">
		</div>

		<div class="login">
			<?php
			if (!isset($_SESSION['IdPersonne'])) {	?>
				<!--il faut mettre du js pr refresh la page qd on se co -->
				<form action="./index.php" method=get>
					<label for="login">login :</label>
					<input type="text" id="login" name="login"><br><br>

					<label for="mdp">Mot de passe :</label>
					<input type="password" id="mdp" name="mdp"><br><br>
					<input type="submit" value="Envoyer">
				<?php
			} else {
				echo 'Connecté en tant que : ' .  $_SESSION['Prenom'] . ' ' . $_SESSION['Nom'] . '<br>';
				echo '<br><a href="./index.php?logout=1">Se deconnecter</a><br><br>';

			}
				?>
				</form>
		</div>