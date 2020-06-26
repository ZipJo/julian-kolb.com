<div>
	<div ng-controller="pictureMapController" id="pictureMapControllerId">
		<script src="js/jquery-jvectormap-2.0.3.min.js"></script>
		<script src="js/jquery-jvectormap-world-mill.min.js"></script>
		<div id="worldmap"></div>
		<script>
			<?php
				// Array mit den möglichen Namen
				$countries = array("Afghanistan","Ägypten","Westsahara","Albanien","Algerien","Angola","Äquatorialguinea","Argentinien","Armenien","Aserbaidschan","Äthiopien","Australien","Bahamas","Bangladesch","Belarus","Belgien","Belize","Benin","Bhutan","Bolivien","Bosnien und Herzegowina","Botswana","Brasilien","Brunei Darussalam","Bulgarien","Burkina Faso","Burundi","Chile","China","Costa Rica","Dänemark","Deutschland","Dominikanische Republik","DR Kongo","Dschibuti","Ecuador","El Salvador","Elfenbeinküste","Eritrea","Estland","Falklandinseln","Fidschi","Finnland","Frankreich","Gabun","Gambia","Georgien","Ghana","Griechenland","Grönland","Großbritannien","Guatemala","Guinea","Guinea-Bissau","Guyana","Haiti","Honduras","Indien","Indonesien","Irak","Iran","Irland","Island","Israel","Italien","Jamaika","Japan","Jemen","Jordanien","Kambodscha","Kamerun","Kanada","Kasachstan","Katar","Kenia","Kirgisistan","Kolumbien","Kongo","Kroatien","Kuba","Kuwait","Laos","Lesotho","Lettland","Libanon","Liberia","Libyen","Litauen","Luxemburg","Madagaskar","Malawi","Malaysia","Mali","Marokko","Mauretanien","Mazedonien","Mexiko","Moldawien","Montenegro","Mongolei","Mosambik","Myanmar","Namibia","Nepal","Neukaledonien","Neuseeland","Nicaragua","Niederlande","Niger","Nigeria","Nordkorea","Norwegen","Oman","Österreich","Pakistan","Panama","Papua-Neuguinea","Paraguay","Peru","Philippinen","Polen","Portugal","Palästinensa","Puerto Rico","Ruanda","Rumänien","Russland","Salomonen","Sambia","Saudi-Arabien","Schweden","Schweiz","Senegal","Serbien","Sierra Leone","Simbabwe","Slowakei","Slowenien","Somalia","Spanien","Sri Lanka","Südafrika","Sudan","Südkorea","Süd-Sudan","Suriname","Swasiland","Syrien","Tadschikistan","Timor-Leste","Taiwan","Tansania","Thailand","Togo","Trinidad und Tobago","Tschad","Französisch-Südantarktis","Tschechien","Tunesien","Türkei","Turkmenistan","Uganda","Ukraine","Ungarn","Uruguay","USA","Usbekistan","Venezuela","Vereinigte Arabische Emirate","Kosovo","Nordzypern","Somaliland","Vanuatu","Vietnam","Zentralafrikanische Republik","Zypern");
				$codes = array("AF","EG","EH","AL","DZ","AO","GQ","AR","AM","AZ","ET","AU","BS","BD","BY","BE","BZ","BJ","BT","BO","BA","BW","BR","BN","BG","BF","BI","CL","CN","CR","DK","DE","DO","CD","DJ","EC","SV","CI","ER","EE","FK","FJ","FI","FR","GA","GM","GE","GH","GR","GL","GB","GT","GN","GW","GY","HT","HN","IN","ID","IQ","IR","IE","IS","IL","IT","JM","JP","YE","JO","KH","CM","CA","KZ","QA","KE","KG","CO","CG","HR","CU","KW","LA","LS","LV","LB","LR","LY","LT","LU","MG","MW","MY","ML","MA","MR","MK","MX","MD","ME","MN","MZ","MM","NA","NP","NC","NZ","NI","NL","NE","NG","KP","NO","OM","AT","PK","PA","PG","PY","PE","PH","PL","PT","PS","PR","RW","RO","RU","SB","ZM","SA","SE","CH","SN","RS","SL","ZW","SK","SI","SO","ES","LK","ZA","SD","KR","SS","SR","SZ","SY","TJ","TL","TW","TZ","TH","TG","TT","TD","TF","CZ","TN","TR","TM","UG","UA","HU","UY","US","UZ","VE","AE","XK","XC","XS","VU","VN","CF","CY");

				//Key-Value JS-Object erzeugen:
				$current = 0;
				$jsKVString = "let allCountries = {";
				foreach ($codes as $code) {
					$jsKVString .= $code.": '".$countries[$current]."',";
					$current++;
				}
				$jsKVString .= "};";
				

				/// Tatsächlich vorhandene Ordner finden
				$numberArray = array();

				if ($handle = opendir('content/fotos/')) {
					$blacklist = array('.', '..');
					while (false !== ($file = readdir($handle))) {
						if (!in_array($file, $blacklist)) {
							if (in_array($file, $countries)) {
								$numberArray[] = array_search($file, $countries);

							}
						}
					}
					closedir($handle);
				}

				// Durch die gefundenen Ordner Iterieren und ein JS-Array erzeugen
				$jsString = "let visitedCountries = [";
				foreach ($numberArray as $key) {
					$jsString .= "'".$codes[$key]."',";
				}
				$jsString .= "];";
				error_log( "Hello, errors!" );
				error_log( $jsKVString );
				error_log( $jsString );
				// Ausgabe der JS-Objekte
				echo "\n".$jsKVString."\n".$jsString."\n";

				/*$node->setAttribute("ng-click", "changeLocation('".$countries[$key]."')");
				$node->setAttribute("ng-mouseenter", "mouseOver(\$event,'".$countries[$key]."')");
				$node->setAttribute("ng-mouseleave", "mouseOut(\$event)");
				$node->setAttribute("style", "fill: #828180;cursor:pointer;");*/
			?>
			$('#worldmap').vectorMap({
				map: 'world_mill',
				backgroundColor: 'transparent',
				zoomMax: 10,
				regionStyle: {
					initial: {
						fill: '#e3e3e3',
						"fill-opacity": 1,
						stroke: '#e3e3e3',
						"stroke-width": 0.4,
						"stroke-opacity": 1
					},
					hover: {
						"cursor": 'default'
					},
					selected: {
						fill: 'rgb(130, 129, 128)',
						stroke: 'rgb(130, 129, 128)',
						"cursor": 'pointer'
					},
					selectedHover: {
						fill: 'rgb(191,191,191)',
					}
				},
				selectedRegions: visitedCountries,
				onRegionTipShow: function (e,tip,code){
					$(tip).text(allCountries[code]);
				},
				onRegionClick: function(e,code){
					if (visitedCountries.indexOf(code)>=0) {
						$('.jvectormap-tip').remove();
						window.location = "#/fotografie/:"+allCountries[code];
					}
				}
			});
		</script>
	</div>
</div>