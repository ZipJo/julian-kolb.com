(function() {

	// If the browser supports cookies and they are enabled
	if (navigator.cookieEnabled) {

		let cName = "screen-width";

		//only proceed if cookie not set yet
		let cValue = document.cookie.split('; ').find(row => row.startsWith(cName));
		cValue = (cValue) ? cValue.split('=')[1] : cValue;

		if (!cValue) {

			// Set the cookie for 3 days
			var date = new Date();
			date.setTime(date.getTime() + (3 * 24 * 60 * 60 * 1000));
			var expires = "; expires=" + date.toGMTString();

			// This is where we're setting the mustard cutting information.
			// In this case we're just setting screen width, but it could
			// be anything. Think http://modernizr.com/
			document.cookie = cName+"=" + window.outerWidth + expires + "; path=/";
		}

	}

}());