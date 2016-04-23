function cookieaccept2RemoveParam(parameter) {
    //prefer to use l.search if you have a location/link object
	var url = window.location.href;
    var urlparts= url.split('?');   
    if (urlparts.length>=2) {

        var prefix= encodeURIComponent(parameter)+'=';
        var pars= urlparts[1].split(/[&;]/g);

        //reverse iteration as may be destructive
        for (var i= pars.length; i-- > 0;) {    
            //idiom for string.startsWith
            if (pars[i].lastIndexOf(prefix, 0) !== -1) {  
                pars.splice(i, 1);
            }
        }
        url= urlparts[0]+'?'+pars.join('&');
        window.history.pushState("", "", url);
    } else {
        window.history.pushState("", "", url);
    }
}