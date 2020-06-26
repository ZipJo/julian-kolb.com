function toggleMobileMenu(){
	var elem = document.getElementById('mobile_titlebar');
	var imgElem = document.getElementById('jk_logo_mobil_img');
	if (elem.classList.contains('closedmenu')){
		//Menü wird geöffnet
		elem.classList.remove('closedmenu');
		imgElem.src = "img/menu/menu-to-logo.gif";
	} else {
		//Menü wird geschlossen
		elem.classList.add('closedmenu');
		imgElem.src = "img/menu/logo-to-menu.gif";
	}
}

function send_form(){

	var form = document.getElementById("kontaktformular");
	var name = document.getElementById("name");
	var mail = document.getElementById("mail");
	var betreff = document.getElementById("betreff");
	var nachricht = document.getElementById("nachricht");
	var send_form = document.getElementById("send");
	var already_sent = document.getElementById("alreadysent");
	var errormsg = "";

	var send = true;

	if (!/^([\u00C0-\u017Fa-zA-Z'\w\s]{2,})$/.test(name.value)) {
		send = false;
		errormsg += "\nDer Name darf nur aus Buchstaben und Leerzeichen bestehen.";
	}
	if (!/^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/.test(mail.value)) {
		send = false;
		errormsg += "\nBitte eine gültige Mailadresse eingeben.";
	}
	if (!/^(.{4,})$/.test(betreff.value)) {
		send = false;
		errormsg += "\nBitte gib einen aussagekräftigen Betreff ein.";
	}
	if (!/^(.{20,})$/m.test(nachricht.value)) {
		send = false;
		errormsg += "\nBitte gib eine aussagekräftige Nachricht ein.";
	}

	if (already_sent.value === "true"){
		if(confirm('Du hast bereits eine Nachricht verschickt. Möchtest du eine weitere Nachricht senden?')){
			already_sent.value = "false";            
		} else {
			return false;
		}
	}


	if (send){
		send_form.value = "true";

		var url = "/sendMail.php"; // the script where you handle the form input.
		$.ajax({
			type: "POST",
			url: url,
			data: $("#kontaktformular").serialize(), // serializes the form's elements.
			success: function(data) {
				if (data){
					already_sent.value = "true";
					form.reset();
					alert('Deine Nachricht wurde erfolgreich verschickt.\nEine Kopie der Nachricht wurde an '+mail.value+' gesendet.');
				} else {
					// alert(data); // Nur zum Test!
				}
			}
		});

	} else {
		alert('Es gibt ein Problem mit deiner Nachricht:\n'+errormsg);
	}
}

function absorbEvent_(event) {
	var e = event || window.event;
	e.preventDefault();
	e.stopPropagation();
	e.cancelBubble = true;
	e.returnValue = false;
	return false;
}

function preventLongPressMenu(node) {
	node.ontouchstart = absorbEvent_;
	node.ontouchmove = absorbEvent_;
	node.ontouchend = absorbEvent_;
	node.ontouchcancel = absorbEvent_;
}

$(window).on("load", preventLongPressMenu(document.getElementsByTagName('body')));

// Das hier muss am Ende stehen!
(function () {
	angular.module('kolbFotografie',['ngAnimate','ngRoute'])
	.config(['$routeProvider', function ($routeProvider){
		$routeProvider
		.when('/',{
			templateUrl:'home.php',
			pagetitle : 'Julian Kolb | Kamera & Motiondesign'
		})
		.when('/fotografie',{
			templateUrl:'fotokarte.php',
			pagetitle : 'Fotografie'
		})
		.when('/fotografie/:album',{
			templateUrl: function(params) { return 'fotos.php?album='+params.album; },
			pagetitle : 'paramsalbumFoto'
		})
		.when('/film',{
			templateUrl:'film.php',
			pagetitle : 'Film'
		})
		.when('/film/:album',{
			templateUrl: function(params) { return 'film.php?album='+params.album; },
			pagetitle : 'paramsalbumFilm'
		})
		.when('/kontakt',{
			templateUrl:'kontakt.php',
			pagetitle : 'Kontakt'
		})
		.when('/impressum',{
			templateUrl:'impressum-datenschutz.php',
			pagetitle : 'Impressum'
		})
		.otherwise({ redirectTo:'/'});
	}])
	.animation('.reveal_animation', function() {
		return {
			enter: function(element, done) {
				element.fadeIn(200, done);
				return function() {
					element.stop();
				};
			},
			leave: function(element, done) {
				element.fadeOut(200, done);
				return function() {
					element.stop();
				};
			}
		};
	});
})();