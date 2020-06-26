<?php

$pics = 0;
$skipped = 0;

$pictureDir = './test.julian-kolb.com/httpdocs/content/fotos/';
$files = scandir($pictureDir);
sort($files);
foreach ($files as $file) {
	if ($file != '.' && $file != '..' && $file != '_HomeFoto') {
		$searchPath = $pictureDir.$file."/*.jpg";

		$image_files = glob($searchPath);

		foreach($image_files as $image_file) {
			$image = new Imagick($image_file);

			// Providing 0 forces thumbnailImage to maintain aspect ratio

			$newImage = $image->getImageFilename();
			//echo $newImage."\n";
			$parts = explode("/",$newImage);
			$filename = array_pop($parts);
			$nameParts = explode(".",$filename);
			$fileExt = array_pop($nameParts);
			$newFilename = implode(".",$nameParts)."_thumb.".$fileExt;
			//echo $filename."\n";
			$newFolder = implode("/",$parts)."/mobile/";
			$newImage = $newFolder.$newFilename;
			//echo $newImage."\n";

			if (!file_exists($newFolder)) {
				mkdir($newFolder, 0777, true);
			}

			if (!file_exists($newImage)){

				$image->thumbnailImage(800,0);
				$image->writeImage($newImage);
				$pics++;
			} else {
				$skipped++;
			}
		}
	}
}
echo "\ndone!\npics processed: $pics\npics skipped: $skipped";
?>