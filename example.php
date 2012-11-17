<!DOCTYPE html>
<html lang="en">
<head>
<title>Gist PHP Example</title>

<!-- loads a custom theme -->
<link rel="stylesheet" href="themes/solorized/theme.css" />

</head>
<body>
	<?php
		include 'lib/gist.php';

		$gist = new Gist('1510818', 'search_params.php');

		echo $gist->render();
	?>
</body>
</html>
