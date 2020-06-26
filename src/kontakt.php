<div id="contact_wrapper">
	<div class="contact_div">
		<img src="/img/contact.jpg" />
		<p>Ich bin ein weltoffener und belastbarer junger Kameramann, der stetig seinen Erfahrungshorizont erweitern möchte. Ich arbeite ruhig und genau, bleibe dabei aber flexibel und neugierig. Draußen filme ich am liebsten - auch mal an exotischen Orten wie der Wüste Gobi - bin aber auch gerne am Rechner mit Motivation bei der Sache.<br /><br />
Studium an der Hochschule für Medien, Kommunikation und Wirtschaft in Köln mit Bachelorabschluss im Fachbereich „Grafikdesign und visuelle Kommunikation“ 2018. Vor und während des Studiums freie Mitarbeit bei luckfilm und a&o büro und dafür in den Niederlanden, Luxemburg und der Mongolei unterwegs.<br /><br />Seit 2018 Mitarbeit an mehreren Filmen der Dokumentarfilmserie "Wildes Deutschland".<br /><br />
		<a href="mailto:hello@julian-kolb.com">Mail: hello@julian-kolb.com</a>
		<a href="tel:+491634141429">Phone: +49 163 41 41 429</a>
		</p>
	</div>
	<div class="contact_div">
	<!--<h1 class="contact_title">KONTAKT</h1>-->
		<form id="kontaktformular">
			<input type="text" id="name" name="name" placeholder="Name" />
			<input type="email" id="mail" name="mail" placeholder="E-Mail" />
			<input type="text" id="betreff" name="betreff" placeholder="Betreff" />
			<textarea id="nachricht" name="nachricht" cols="20" rows="5" placeholder="Nachricht"></textarea>
			<input id="send" type="hidden" name="send" value="false" />
			<?php
				if ($_SESSION['already_sent'] == 'true') {
					echo '<input id="alreadysent" type="hidden" name="alreadysent" value="true" />';
				} else {
					echo '<input id="alreadysent" type="hidden" name="alreadysent" value="false" />';
				}
			?>
			<button type="button" onclick="send_form();">Senden</button>
		</form>
	</div>
	<!--<div class="contact_div">
		<h1>DATEN</h1>
		<p>Julian Kolb<br />
		Landmannstraße 35<br />
		50825 Köln<br />
		Deutschland<br /><br />
			Mail: <span class="data_tab">hello@julian-kolb.com</span><br />
			Phone: <span class="data_tab">+49 163 41 41 429</span>
		</p>
	</div>-->
<p class = "impressum"><a href="#/impressum">Impressum und Datenschutzerklärung</a></p>
</div>