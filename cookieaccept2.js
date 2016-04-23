function cookieAccept2SetCookie(c_name,value,exdays) {
	var exdate=new Date();
	exdate.setDate(exdate.getDate() + exdays);
	var c_value=escape(value) + ((exdays==null) ? '' : '; expires='+exdate.toUTCString()) + '; path=/';
	document.cookie=c_name + '=' + c_value;
}
function cookieAccept2(url,jQueryIsLoaded,isDevelop){
	// jQuery object exists
	if(jQueryIsLoaded) {
		var ca2Alert = jQuery('.cookieaccept2');
		var ca2AcceptBtn = ca2Alert.find('.cookieaccept2__acceptBtn')
		ca2AcceptBtn.click(function(e){
			jQuery.ajax({
				type: 'GET',
				url: url+'?cookieaccept2=2',
			});
			cookieAccept2SetCookie('cookieaccept2','yes',365);
			ca2Alert.fadeOut('slow');
			e.preventDefault();
			if(isDevelop == 1) cookieaccept2RemoveParam('cookieaccept2');
		});
	} 
	// jQuery is not loaded (IE9+)
	else {
		var ca2Alert = document.getElementsByClassName('cookieaccept2')[0];
		var ca2AcceptBtn = ca2Alert.getElementsByClassName('cookieaccept2__acceptBtn')[0];
		ca2AcceptBtn.addEventListener('click', function(e) {
			ca2Alert.className += ' cookieaccept2--accepted';
			var request = new XMLHttpRequest();
			request.open('GET', url+'?cookieaccept2=2', true);
			request.send();
			cookieAccept2SetCookie('cookieaccept2','yes',365);
			e.preventDefault();
			if(isDevelop == 1) cookieaccept2RemoveParam('cookieaccept2');		
		}, false);
	}
	console.log(ca2AcceptBtn);
};
