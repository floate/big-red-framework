/*! This file has *//* NOT *//*! been minimized. */


/*In minimized files, *//*! credits of reused code can be found by removing '-min' from the url. */


var SOUPGIANT = SOUPGIANT || {};

SOUPGIANT.client = function() {
	var $ = jQuery,
		SG = SOUPGIANT,
		SGb = SG.base,
		
		$body, //defined later
		$html; //defined later
		
	$(function(){
		//document ready (html,css,js - no img)
		$body = $('body');
		$html = $('html');
		SGb.nav('#navWrap,#footNavWrap');
		SGb.skipLinks();
		$('body');
		$('#commentsList a.comment-reply-login, #respond p.must-log-in > a').click(function(e){SGb.displayLoginForm(e);});
		
		SGb.formHightlight('form');
		SGb.setupFormValidation('form');
	});
	
	$(window).ready(function(){
		//window ready (html,css,js - no img)
	});
}();



