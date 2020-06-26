<div id="film_container">
	<?php
		$currentCategorie = array_key_exists('album', $_GET) ? substr($_GET['album'], 1) : "";
		$ccEmpty = ($currentCategorie == "");

		$row = 0;
		$filmcsv = 'content/filme.csv';
		if (($handle = fopen($filmcsv, "r")) !== FALSE) {
			while (($data = fgetcsv($handle, 0, ";", '"', '"')) !== FALSE) {
				if ($row > 0){
					if (!$ccEmpty && $data[0] !== $currentCategorie) continue;

					$class = $ccEmpty?" overview":"";
					

					$videoProvider = $data[1];
					$link = $data[2];
					$thumbnail = getVideoThumbnail($videoProvider, $link);

					if ($videoProvider == "" || $link == "" || $thumbnail == "") continue;

					$h3 = $data[3];
					$h4 = $data[4];
					$description = array_key_exists(5, $data) ? $data[5] : "";
					$src = getVideoSource($videoProvider, $link);

					echo '      <div class="filmframe'.$class.'" data-featherlight="#lightbox'.$row.'">';
					echo '          <div><img id="videoThumbnail'.$row.'" src="'.$thumbnail.'" alt="Thumbnail '.$h3.'" /></div>';
					echo '          <h3>'.$h3.'</h3>';
					echo '          <h4>'.$h4.'</h4>';
					if (!$ccEmpty) echo '           <p>'.$description.'</p>';
					echo '      </div>';
					if (strtolower($videoProvider) == "vimeo" || strtolower($videoProvider) == "youtube"){
						echo '      <iframe id="lightbox'.$row.'" class="filmframe_lb" src="'.$src.'" scrolling="no"></iframe>';
					} else {
						echo '      <video id="lightbox'.$row.'" class="filmframe_lb" controls poster="'.$thumbnail.'" preload="none"><source src="'.$src.'" type="video/mp4"></video>';
					}

				}
				$row++;
			}
			fclose($handle);
		}
	?>
	<!--"Ghost"-Frames for Flexbox -->
	<div class="filmframe"></div>
	<div class="filmframe"></div>
	<div class="filmframe"></div>
	<div class="filmframe"></div>
	<div class="filmframe"></div>
	<script src="js/featherlight.min.js" type="text/javascript" charset="utf-8"></script>
</div>

<?php 
	function getVideoThumbnail($vProv, $link){
		$retValue = "";
		switch(strtolower($vProv)){
			case "lokal":
				preg_match('/(.*?)\.mp4/i', $link, $vidIdArray);
				$vidName = $vidIdArray[1];
				$retValue = "content/film/$vidName.png";
				break;

			case "vimeo":
				preg_match('/vimeo.com\/([\d]+)/i', $link, $vidIdArray);
				$vidId = $vidIdArray[1];
				$retValue = getVimeoThumb($vidId);
				break;

			case "youtube":
				preg_match('/\?v=([\w\d-]+)/i', $link, $vidIdArray);
				$vidId = $vidIdArray[1];
				$retValue = "https://img.youtube.com/vi/$vidId/mqdefault.jpg";
				break;

			case "ard":
				preg_match('/&documentId=([\d]+)/i', $link, $vidIdArray);
				$vidId = $vidIdArray[1];
				$source = file_get_contents("https://www.ardmediathek.de/play/media/$vidId");
				preg_match('/"_previewImage":"(.*?)"/i', $source, $prevImage);
				$retValue = $prevImage[1];
				break;
		}
		return $retValue;
	}

	function getVideoSource($vProv, $link){
		$retValue = "";
		switch(strtolower($vProv)){
			case "lokal":
				$retValue = "content/film/$link";
				break;

			case "vimeo":
				preg_match('/vimeo.com\/([\d]+)/i', $link, $vidIdArray);
				$vidId = $vidIdArray[1];
				$retValue = "https://player.vimeo.com/video/$vidId";
				break;

			case "youtube":
				preg_match('/\?v=([\w\d-]+)/i', $link, $vidIdArray);
				$vidId = $vidIdArray[1];
				$retValue = "https://www.youtube.com/embed/$vidId";
				break;

			case "ard":
				preg_match('/&documentId=([\d]+)/i', $link, $vidIdArray);
				$vidId = $vidIdArray[1];
				$source = file_get_contents("http://www.ardmediathek.de/play/media/$vidId");
				preg_match('/"_quality":3,"_stream":\["(.*?)",/i', $source, $mp4Video);
				$retValue = "https:$mp4Video[1]";
				break;
		}
		return $retValue;
	}

	function getVimeoThumb($id){
		$vimeo = unserialize(file_get_contents("https://vimeo.com/api/v2/video/$id.php"));
		return $vimeo[0]['thumbnail_large'];
	}
?>