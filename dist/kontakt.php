<?php session_start(); ?>
<div id="contact_wrapper">
	<div class="contact_div">
		<img src="/img/contact.jpg" />
		<p>
			<?php include 'content/kontakt.htm';?>
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
				if (in_array("already_sent", $_SESSION) && $_SESSION['already_sent'] == 'true') {
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