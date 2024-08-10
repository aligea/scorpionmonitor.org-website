$(document).ready(function(){
	activateCurrentMenu();
	//$.validationEngine.defaults.promptPosition = 'bottomLeft';
	//$('.angka').number(true, 0);
	$('#loader').hide();
});
function subscribeNewsletter(){
  var baseurl = decodeURIComponent(getCookie('baseurl'));
  $.ajax({
    url : baseurl+'/newsletter/register',
	type:'POST',
	data : $('#subscribeForm').serialize(),
	success : function(respon){
	  $('#subscribeForm')[0].reset();
	  alert('Thank you. You will received our recent newsletter to your email address.');
	}
  });
}

$(function(){
	$.each($('#content-news img'), function(key, value){
		$(value).addClass('img-responsive img-thumbnail');
	});
});

function fixImage(elm){
var baseurl = decodeURIComponent(getCookie('baseurl'));
  $.ajax({
    url : baseurl+'/api/fake_filename',
	type:'POST',
	data : {
	  'file' : $(elm).attr('src')
	},
	success : function(respon){
	  $(elm).attr('src', baseurl+'/img/'+respon);
	}
  });
}

function disableThisForm(formElm){
	var btnsave = $(formElm).find("[type=submit]");
	btnsave.attr('disabled', 'disabled');
	$('#loader').show();
}
function activateThisForm(formElm){
	var btnsave = $(formElm).find("[type=submit]");
	btnsave.removeAttr('disabled', 'disabled');
	$('#loader').hide();
}

function activateCurrentMenu(){
	//-- aktifkan link page menu saat ini
	$.each($('.nav li a'), function(key, value){
	   $(this).parent().removeClass('active');
	   if($(this).attr('href') == document.location.href){
	     $(this).parent().addClass('active');
	   }
	   
	});
	

}
function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
    }
    return "";
}

function checkCookie() {
    var user = getCookie("username");
    if (user != "") {
        alert("Welcome again " + user);
    } else {
        user = prompt("Please enter your name:", "");
        if (user != "" && user != null) {
            setCookie("username", user, 365);
        }
    }
}

function refreshCaptcha(elmId){
	var $elm = $('#'+elmId);
	var src = $elm.attr('src').split("?")[0];
	var uniqueMaker = new Date().getTime();
	$elm.attr('src', '');
	$elm.attr('src', src+'?_'+uniqueMaker);
}
