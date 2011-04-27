/*! This file has *//* NOT *//*! been minimized. */


/*In minimized files, *//*! credits of reused code can be found by removing '-min' from the url. */


var SOUPGIANT = SOUPGIANT || {};

SOUPGIANT.base = function() {
	var $ = jQuery, //covers noConflict Mode
		$body, //defined later
		$html, //defined later
		
		WIN = window, //for compression
		$WIN = $(WIN),
		DOC = document,
		NUL = null,
		TRU = true,
		FALS = false,
		SG = SOUPGIANT,
		i = 0,
		loginFormPlaced = FALS;
		
	$(function(){
		$body = $('body');
		$html = $('html');
		$body.removeClass('nojs').addClass('js');
		
	});
	
	$WIN.ready(function(){
		$body.removeClass('nojswin').addClass('jswin');
	});
	
	function skipLinks($skip, focusClass){
		if ($skip == NUL) {
			$skip = '#skipLinks a';
		}
		$skip = $($skip);
		if (focusClass == NUL) {
			focusClass = 'focus';
		}
		$skip.each(function() {
			var $a = $(this);
			
			$a.focus(function() {
				$a.addClass(focusClass);
			});
			
			$a.blur(function() {
				$a.removeClass(focusClass);
			});
		});
	}
	
	function nav($nav, hoverClass, focusClass){
		if ($nav == NUL) {
			$nav = $('div.nav5');
		}
		$nav = $($nav);
		if (hoverClass == NUL) {
			hoverClass = 'hover';
		}
		if (focusClass == NUL) {
			focusClass = hoverClass;
		}
		
		$nav.find('li').each(function(){
			var $li = $(this);
			$li.hover(
				//mouse - in
				function() {
					$li.addClass(hoverClass);
				},
				//mouse - out
				function() {
					$li.removeClass(hoverClass);
				}
			);
		
			//keyboard in
			$li.find("a").each(function() {
				var $a = $(this);
				
				$a.focus(function() {
					$li.addClass(focusClass);
				});
				
				$a.blur(function() {
					$li.removeClass(focusClass);
				});
			});				
		});
		
		
	}

	function equalHeight($columns, className, media, context){
		/* ****
		DESCRIPTION
			Creates equal height columns for CSS layout
			Adds <style> to header of document, allowing media type targeting

		INPUT: 
			* $columns
				jQuery object of all columns
				default: NULL/nil
				
			* className
				name of class to add to each column (a random number is appended to this value)
				default: 'equalHeight' 
				
			* media
				css media to target
				default: 'screen, projection, handheld'
				
			* context
				css context to add to selector in <style> section
				eg context='#content' will output #content .equalHeight-xxxx {}
				default: '' (empty string)
				
		RETURN: className with random number appendix

		DEPENDENCIES:
			jQuery
			SOUPGIANT.base.createStyleRule()
		**** */
		if ($columns == NUL) {
			//function called incorrectly, exit
			return NUL;
		}
		$columns = $($columns);
		if (className == NUL) {
			className = 'equalHeight';
		}
		if (media == NUL) {
			media = 'screen, projection, handheld'; //default
		}
		if (context == NUL) {
			context = '';
		} else {
			context = ' ' + context + ' ';
		}

		var classRandom = Math.floor(Math.random()*999999),
			tallestCol = 0,classDeclaration,ie6Declaration;
		className = className + '-' + classRandom;
		$columns.each(function (){
			var $this = $(this);
			if ($this.height() > tallestCol) {
				tallestCol = $this.height();
			}
			$this.addClass(className);
		});
		
		//create css declaration
		className = '.' + className;
		classDeclaration = 'min-height: ' + tallestCol + 'px;';
		ie6Declaration = 'height: ' + tallestCol + 'px;';
		createStyleRule(context + className, classDeclaration, media);
		createStyleRule('* html ' + context + className, ie6Declaration, media);
		
		return className; //in case it's needed for later manipulation
	}
	
	function createStyleRule(selector, declaration, media){
		/* ****
		DESCRIPTION
			Adds <style> to header of document, allowing media type targeting

		INPUT: 
			* selector
				css selector
				default: NULL/nil
				
			* declaration
				css properties
				default: NULL/nill
				
			* media
				css media to target
				default: 'screen, projection, handheld'
				
				
		RETURN: NULL/nil

		DEPENDENCIES: NULL/nil
		
		CREDIT
		dynamicCSS.js v1.0 <http://www.bobbyvandersluis.com/articles/dynamicCSS.php> */
		/*! Copyright 2005 Bobby van der Sluis */
		/*! This software is licensed under the CC-GNU LGPL <http://creativecommons.org/licenses/LGPL/2.1/> *//*
		
		changes
		- added media to passed variables
		
		**** */
		if (media == NUL) {
			media = 'screen, projection, handheld';
		}
		if (!DOC.getElementsByTagName ||
		  !(DOC.createElement || DOC.createElementNS)) 
			{return;}
		var agt = navigator.userAgent.toLowerCase(),
			is_ie = ((agt.indexOf("msie") != -1) &&  (agt.indexOf("opera") == -1)),
			is_iewin = (is_ie &&  (agt.indexOf("win") != -1)),
			is_iemac = (is_ie &&  (agt.indexOf("mac") != -1));
		if (is_iemac) return; // script doesn't work properly in IE/Mac
		var head = DOC.getElementsByTagName("head")[0],
			style = (typeof DOC.createElementNS != "undefined") ?
		  DOC.createElementNS("http://www.w3.org/1999/xhtml", "style") :
		  DOC.createElement("style");
		if (!is_iewin) {
			var styleRule = DOC.createTextNode(selector + " {" + declaration + "}");
				style.appendChild(styleRule); // bugs in IE/Win
		}
			style.setAttribute("type", "text/css");
		style.setAttribute("media", media); 
		head.appendChild(style);
		if (is_iewin &&  DOC.styleSheets &&  DOC.styleSheets.length > 0) {
			var lastStyle = DOC.styleSheets[DOC.styleSheets.length - 1];
			if (typeof lastStyle.addRule == "object") {
				lastStyle.addRule(selector, declaration);
			}
		}
		
	}

	function setCookie(name, value, expire, path, domain, secure) {
		/* ****
		DESCRIPTION
			sets a cookie
			emulates the setCookie function in php
			
		INPUTS
			name
				The name of the cookie
				default: NULL/nil
				
			value
				The value of the cookie
				default: NULL/nil
				
			expire 
				The time the cookie expires. 
				This is either
					a Unix timestamp (sec since 1/1/1970)
					Javascript time object
				default: end of current session
				
			path
				The path on the server in which the cookie will be available on.
				default: '/'
			
			domain
				The domain the cookie is available on
				default: current domain
				
			secure
				Indicates that the cookie should only be transmitted over a secure HTTPS connection
				default: false (ie, insecure xmission allowed)
				
		RETURN
			false: cookie not set
			true: cookie set
			
		Credit due: based on http://techpatterns.com/downloads/javascript_cookies.php
		**** */
		
		if ((name == NUL) || (value == NUL)) {
			return FALS;
		}
		
		if (path == NUL) {
			path = '/';
		}
		
		var expires_date;
		//emulating php, so time is in seconds - change to milliseconds
		if (typeof expire == 'object') {
			//js time object
			expires_date = expire;
		}
		else if (expire != NUL) {
			//null or php time stamp
			expire = expire * 1000;
			expires_date = new Date(expire);
		}
		
		
		DOC.cookie = name + "=" +escape( value ) +
			( ( expire ) ? ";expires=" + expires_date.toGMTString() : "" ) +
			( ";path=" + path ) +
			( ( domain ) ? ";domain=" + domain : "" ) +
			( ( secure ) ? ";secure" : "" );

	}
	
	function getCookie(name) {
		/* ****
		DESCRIPTION
			sets a cookie
			emulates the setCookie function in php
			
		INPUTS
			name
				The name of the cookie
				default: NULL/nil
		
		RETURN
			value of the cookie
			
		Credit due: based on http://techpatterns.com/downloads/javascript_cookies.php
		**** */
	
		// first we'll split this cookie up into name/value pairs
		// note: DOC.cookie only returns name=value, not the other components
		var a_all_cookies = DOC.cookie.split( ';' ),
			a_temp_cookie = '',
			cookie_name = '',
			cookie_value = '',
			b_cookie_found = FALS,
			allCookLength = a_all_cookies.length; // set boolean t/f default f

		for ( i = 0; i < allCookLength; i++ ) {
			// now we'll split apart each name=value pair
			a_temp_cookie = a_all_cookies[i].split( '=' );


			// and trim left/right whitespace while we're at it
			cookie_name = a_temp_cookie[0].replace(/^\s+|\s+$/g, '');

			// if the extracted name matches passed name
			if ( cookie_name == name ) {
				b_cookie_found = TRU;
				// we need to handle case where cookie has no value but exists (no = sign, that is):
				if ( a_temp_cookie.length > 1 ) {
					cookie_value = unescape( a_temp_cookie[1].replace(/^\s+|\s+$/g, '') );
				}
				// note that in cases where cookie is initialized but no value, null is returned
				return cookie_value;
				break;
			}
			a_temp_cookie = NUL;
			cookie_name = '';
		}
		if ( !b_cookie_found ) {
			return NUL;
		}
	
	}

	function popup(event,href,width,height,popupId,scrollbars,locationBar,toolbar,statusBar,resizable) {
		/* ****
		DESCRIPTION
			Ultra basic popup window
			- if stopped by popup blocker, send main window to page
			- bring popup into focus
			
		INPUTS
			event
				passed so jQuery can prevent the defaut event
				
			href
				Page to go to
				default: NULL/nil (exits if no value passed)
				
			width: window width (default: 500)
			height: popup height (default: 320)
			popupId: name of popup window (default: SGpopup)
			scrollbars: show scrollbars (default: yes) 
			locationBar: show location input (default: no)
			toolbar: show toolbar (default: no)
			statusBar: show status bar (default: no)
			resizable: allow user to resize (default: yes)
		RETURN
			NULL/nil
		**** */
		if (!href) {
			href = "/";
		}
		if (!width) {
			width = 500;
		}
		if (!height) {
			height = 320;
		}
		if (!popupId) {
			popupId = "SGpopup";
		}
		if (!scrollbars) {
			scrollbars = "yes";
		}
		if (!locationBar) {
			locationBar = "no";
		}
		if (!toolbar) {
			toolbar = "no";
		}
		if (!statusBar) {
			statusBar = "no";
		}
		if (!resizable) {
			resizable = "yes";
		}

		var idPopup = WIN.open(href,popupId,"width="+width+",height="+height+",scrollbars="+scrollbars+",location="+locationBar+",toolbar="+toolbar+",status="+statusBar+",resizable="+resizable);

		if (idPopup != NUL) {
			if (WIN.focus) {
				idPopup.focus();
			}
			event.preventDefault();
		}
		return NUL;
	}	
	
	function createLoginForm(){
		if (loginFormPlaced == TRU) {
			// no need to place again
			return;
		}
		
		loginFormPlaced = TRU;
		$('#pageWrap').append(SG.wp_login_form);
		var $form = $('#wp-login-form')
		$form.css({
			display: 'none'
		});
		var $overlay = $("<div id=\"wp-login-form-overlay\" />");
		$overlay.css({
			display: 'none',
			width: $html.outerWidth(),
			height: $html.outerHeight(),
			top: 0,
			left: 0
		});
		$body.append($overlay);
		
		//now the form is created, events can be added
		$('#wp-cancel, #wp-login-form-overlay').click(function(){closeLoginForm();});
		$WIN.resize(function(){positionLoginForm($form,$overlay)}).scroll(function(){positionLoginForm($form,$overlay)});
		$(DOC).keydown(function(e){
			if (e.keyCode == 27) {
				closeLoginForm();
			}
		});
	}
	
	function positionLoginForm($form,$overlay){
		var $form = $($form),
			$overlay = $($overlay),
			formWidth = $form.outerWidth(),
			formHeight = $form.outerHeight(),
			formPositionTop = $WIN.scrollTop() + (($WIN.height() - formHeight)/2),
			formPositionLeft = $WIN.scrollLeft() + (($WIN.width() - formWidth)/2);
			
		$form.offset({
			top: formPositionTop,
			left: formPositionLeft			
		});
		$overlay.css({
			width: $(DOC).width(),
			height: $(DOC).height()
		});
		
	}
	
	function displayLoginForm(e){
		e.preventDefault();
		createLoginForm();
		var $form = $('#wp-login-form'),
			$overlay = $('#wp-login-form-overlay');
			
		$form.css({
			display: 'block'
		});
		
		$overlay.css({
			display: 'block'
		});
		
		positionLoginForm($form,$overlay);
		
	}
	
	function closeLoginForm(){
		var $form = $('#wp-login-form'),
			$overlay = $('#wp-login-form-overlay');
			
		$form.css({
			display: 'none'
		});
		$overlay.css({
			display: 'none'
		});
	}

	function compactForm($form){
		if ($form == NUL) {
			return;
		}
		$form = $($form);
		$form.each(function(){
			// find each label
			$('label', this).each(function(){
				if ((typeof this.htmlFor == 'string') && (trim(this.htmlFor) != '')){
					var $label = $(this),
						$field = $('#' + this.htmlFor);
					function fieldFocus($label) {
						$label.addClass('active').removeClass('inactive');
					}
					function fieldBlur($field,$label) {
						if ($field[0].value == '') {
							$label.removeClass('active').addClass('inactive');
						}
					}
					
					$field.focus(function(){fieldFocus($label);});
					$field.blur(function(){fieldBlur($field,$label);});
					
					//once page has loaded, wait 50ms and run blur event
					$(WIN).ready(function() {
						setTimeout(function() {
							fieldBlur($field, $label);
						},50);
					});
					
				}
			});
		});
	}

	function formHightlight($forms){
		if ($forms == NUL) {
			return;
		}
		$forms = $($forms);
		
		$forms.each(function(){
			var form = this;
			$(':input:not([type="submit"])', form).each(function(){
				var $input = $(this),
					$parentSet = $input.closest('div.inputSet, fieldset.inputSet, div.form-field');
				
				$input.filter(':radio,:checkbox').click(function(){
					$(this).focus();
				});
					
				$input.focus(function(){
					$parentSet.addClass('form-highlight');					
				});
				
				$input.blur(function(){
					$parentSet.removeClass('form-highlight');					
				});
				
				
			});
		});
	}

	function setupFormValidation($forms){
		if (($forms == NUL) || (typeof $().validate != 'function')) {
			return;
		}
		
		$forms = $($forms);
		
		$forms.each(function(){
			var $form = $(this);
			
			function placeError($error, $element) {
				var placeTag = 'label', 
					$place;
					
				if ( $element.is('input[type=radio],input[type=checkbox]') ) {
					placeTag = 'legend';
				}
				$place = $element.closest('.inputSet').find(placeTag);

				$error.appendTo($place);
			}
			
			
			$form.validate({
				validateDelegate: function() { },
				onsubmit: true,
	            onkeydown: false,
	            onfocusin: false,
	            onclick: false,
				
				errorElement: "span",
				errorPlacement: placeError
			});
			$(':input.required', $form).each(function(){
				$(this).rules("add",{
			    	required: true
				});	
			});
		});
		
	}
	/**
	*
	*  Javascript trim, ltrim, rtrim
	*  http://www.webtoolkit.info/
	*
	**/

	function trim(str, chars) {
		return ltrim(rtrim(str, chars), chars);
	}

	function ltrim(str, chars) {
		chars = chars || "\\s";
		return str.replace(new RegExp("^[" + chars + "]+", "g"), "");
	}

	function rtrim(str, chars) {
		chars = chars || "\\s";
		return str.replace(new RegExp("[" + chars + "]+$", "g"), "");
	}		
	return {
		setCookie: setCookie,
		getCookie: getCookie,
		equalHeight: equalHeight,
		createStyleRule: createStyleRule,
		nav: nav,
		skipLinks: skipLinks,
		popup: popup,
		displayLoginForm:displayLoginForm,
		compactForm:compactForm,
		createLoginForm:createLoginForm,
		closeLoginForm:closeLoginForm,
		formHightlight:formHightlight,
		setupFormValidation:setupFormValidation
		
	};
}();



// Default login form, to override just redefine the variable in custom.js
// Any changes should be reflected in functions.php output of the login form

SOUPGIANT.wp_login_form = "<div id=\"wp-login-form\"> <form name=\"loginform\" id=\"loginform\" action=\"" + SOUPGIANT_wpURLS.loginsubmit + "\" method=\"post\"> <p class=\"login-username\"> <label for=\"user_login\">Username<\/label> <input type=\"text\" name=\"log\" id=\"user_login\" class=\"input\" value=\"\" size=\"20\" tabindex=\"10\" /> <\/p> <p class=\"login-password\"> <label for=\"user_pass\">Password<\/label> <input type=\"password\" name=\"pwd\" id=\"user_pass\" class=\"input\" value=\"\" size=\"20\" tabindex=\"20\" /> <\/p> <p class=\"login-remember\"><label><input name=\"rememberme\" type=\"checkbox\" id=\"rememberme\" value=\"forever\" tabindex=\"90\" checked=\"checked\" /> Remember Me<\/label><\/p> <p class=\"login-submit\"> <input type=\"submit\" name=\"wp-submit\" id=\"wp-submit\" class=\"button-primary\" value=\"Log In\" tabindex=\"100\" /> ";

// need to add the reset button with id wp-cancel for javascript version
SOUPGIANT.wp_login_form += "<input type=\"reset\" name=\"wp-cancel\" id=\"wp-cancel\" class=\"button-primary\" value=\"Cancel\" tabindex=\"101\" /> ";

SOUPGIANT.wp_login_form += "<input type=\"hidden\" name=\"redirect_to\" value=\"" + SOUPGIANT_wpURLS.currentURL + "\" /> <\/p> <\/form><div id=\"wp-login-form-utils\"><a href=\"" + SOUPGIANT_wpURLS.lostpassword + "\" title=\"Lost your password?\" id=\"wp-login-form-lost\">Lost your password?<\/a>";

if (SOUPGIANT_wpURLS.regoEnabled == "y") {
	SOUPGIANT.wp_login_form += " <a href=\"" + SOUPGIANT_wpURLS.register + "\">Register<\/a> ";
}

SOUPGIANT.wp_login_form += "<\/div>";