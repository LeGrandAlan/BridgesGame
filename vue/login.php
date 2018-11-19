<?php

Class Vuelogin{

	public function login(){

?>

	<html>
		<body>
		<br/>
		<br/>
			<form method="post" action="index.php">
				<input type="text" name="pseudo"/>
				<input type="password" name="motdepasse"/>
				</br>
				<input type="submit" name="seconnecter" value="connection"/>
			</form>
		</body>
	</html>

<?php

	}
}

?>
