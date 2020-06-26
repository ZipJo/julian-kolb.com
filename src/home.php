<?php

	$path = "content/fotos/_HomeFoto";
	$rFile = random_pic($path);
	$lcr = getPosition($rFile);
	echo '      <div id="home_background" style="background-image: url(\'/'.$rFile.'\'); background-position-x: '.$lcr.';" onclick="toggleMobileMenu()"></div>';
	function random_pic($dir) {
		$files = glob($dir . '/*.*');
		$file = array_rand($files);
		return $files[$file];
	}
	function getPosition($filepath) {
		$firstChar = strtolower(end(explode('/', $filepath))[0]);
		if ($firstChar == "r") return "right";
		if ($firstChar == "c") return "center";
		return "left";
	}
?>