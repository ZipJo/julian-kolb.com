<div ng-controller="PictureController">
	<div id="slideshow_container" ng-click="changePicture($event)" ng-mousemove="cursorChanger($event)">
		<script type="text/javascript">
			$('img').on('dragstart', function(event) {
				event.preventDefault();
			});
		</script>
		<?php
			$folder = substr($_GET['album'], 1);

			if ($folder == "") echo "Diese Seite sollte nicht zu sehen sein";

			$searchstring = 'content/fotos/'.$folder.'/';

			if ($_COOKIE["screen-width"] < 900) {
				$searchstring = $searchstring.'mobile/';
			}
			
			$searchstring = $searchstring.'*.{jpeg,jpg,gif,png}';
			
			$files = glob($searchstring, GLOB_BRACE);
			rsort($files);

			echo '<div class="slideshow_pictures">';
			foreach ($files as $file) {
				if ($file != '.' && $file != '..') {
					echo '  <div class="slideshow_pic_container">';
					echo '    <div class="loader"></div>';
					echo '    <img class="slideshow_pic hide_pic" data-src="/'.$file.'" />';
					echo '  </div>';
				}
			}
			echo '</div>';
		?>
	</div>
</div>