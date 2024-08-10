<!DOCTYPE html>
<html lang="en" xml:lang="en" prefix="og: http://ogp.me/ns#" xmlns:og="http://ogp.me/ns#" xmlns:fb="http://www.facebook.com/2008/fbml">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<meta http-equiv="X-UA-Compatible" content="IE=edge">
<!--<meta name="viewport" content="width=device-width, initial-scale=1">-->
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<title>{$meta_title}</title>
<meta name="description" content="{$meta_description}" />
<meta name="keywords" content="{str_replace('"', '', $meta_keyword)}" />
<meta name="robots" content="index, follow" />
<meta property="og:url" content="{$og.url}" />
<meta property="og:type" content="{$og.type}" />
<meta property="og:title" content="{str_replace('"', '', $og.title)}" />
<meta property="og:description" content="{str_replace('"', '',$og.description)}" />
<meta property="og:image" content="{$baseurl}/img/resize?w=1200&h=600&file={$og.image}" />
<meta property="og:site_name" content="{$og.site_name}" />

<meta name="yandex-verification" content="a3bf87ccccb0ad84" />

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="@scorpionmonitor">
<meta name="twitter:creator" content="@scorpionmonitor">
<meta name="twitter:title" content="{str_replace('"', '', $og.title)}">
<meta name="twitter:description" content="{str_replace('"', '',$og.description)}">
<meta name="twitter:image" content="{$og.image}">

<link rel="image_src" href="{$og.image}" />
<link rel="icon" type="image/png" href="{$favico}" />
<link rel='shortcut icon' type='image/vnd.microsoft.icon' href='{$favico}'/>
<link rel="icon" href='{$favico}' type="image/x-icon" />
<link rel="shortcut icon" href='{$favico}' type="image/x-icon" />

<link href="{$baseurl}/templates/{$path_user}/assets/bootstrap-3.3.4-dist/css/bootstrap.united.css" rel='stylesheet' type='text/css' />
<link rel="stylesheet" href="{$baseurl}/templates/{$path_user}/assets/font-awesome/css/font-awesome.css">
<link rel="stylesheet" href="{$baseurl}/templates/{$path_user}/assets/css/animate.css">
<link rel="stylesheet" href="{$baseurl}/templates/{$path_user}/assets/css/style.css">

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="{$baseurl}/templates/{$path_user}/assets/js/jquery-1.9.1.min.js"></script>
<script src="{$baseurl}/templates/{$path_user}/assets/bootstrap-3.3.4-dist/js/bootstrap.min.js"></script>
<script src="{$baseurl}/templates/{$path_user}/assets/js/script.js?v=1"></script>

{literal}
<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-63740629-1', 'auto');
ga('send', 'pageview');
</script>

<script>
//-- untuk mengubah link cp menjadi action nelpon kalo buka pake browser di hp;
window.mobilecheck = function() {
  var check = false;
  (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))) check = true;})(navigator.userAgent||navigator.vendor||window.opera);
  return check;
};
$(document).ready(function() {
	if(window.mobilecheck == true){
		var nomortelp = $("#cp_action").html();
		$("#cp_action").attr("href", "tel:" + nomortelp.replace(/ /g,''));
	}
});
</script>

{/literal}

{literal}
<script id="mcjs">!function(c,h,i,m,p){m=c.createElement(h),p=c.getElementsByTagName(h)[0],m.async=1,m.src=i,p.parentNode.insertBefore(m,p)}(document,"script","https://chimpstatic.com/mcjs-connected/js/users/43b7e2802ef1a3987ab879bcc/ca73a00683ab2e9671a31186d.js");</script>
{/literal}

</head>
<body>

<div id="header-wrapper" class="container">
<div class="row">
  <div class="col-xs-2"> 
  	<img src="{str_replace('[baseurlroot]', $baseurl, $settings.logo)}" alt="logo-scorpion" class="img-rounded animated fadeIn" height="100"> 
  </div>
  <div class="col-xs-8">
  	<div class="tagline animated bounceIn">
      <h1>THE WILDLIFE TRADE MONITORING GROUP</h1>
    </div>
  </div>
  <div class="col-xs-2"> 
  	<div class="tagline2">scorpionmonitor.org</div>
	<div class="hotline">
    	<i class="fa fa-phone"></i> Wildlife Hotline :
        <br/>
    	<a href="{$baseurl}/page/wildlife-crime.html" id="cp_action">+62 812 5055 109</a>
    </div> 
        <div id="top-socmed">
          <a target="_blank" href="{$settings.facebook}" title="Facebook" class="hvr-grow-shadow"><i class="fa fa-facebook"></i></a>
          <a target="_blank" href="{$settings.twitter}" title="Twitter" class="hvr-grow-shadow"><i class="fa fa-twitter"></i></a>
          <a target="_blank" href="{$settings.instagram}" title="Instagram" class="hvr-grow-shadow"><i class="fa fa-instagram"></i></a>
          <a target="_blank" href="mailto:{$settings.email}" title="Email" class="hvr-grow-shadow"><i class="fa fa-envelope"></i></a>
          <a target="_blank" href="{$baseurl}/rss" title="RSS" class="hvr-grow-shadow"><i class="fa fa-rss"></i></a>
        </div>
  
  
  </div>
  
</div>
</div>

<div id="topinfo-wrapper" class="container">
  <div class="row">
    <div class="col-xs-3">
    {literal}
<div id="google_translate_element" style="width:100%;"></div>
<script type="text/javascript">
function googleTranslateElementInit() {
  new google.translate.TranslateElement({pageLanguage: 'en', layout: google.translate.TranslateElement.InlineLayout.SIMPLE, gaTrack: true, gaId: 'UA-63740629-1'}, 'google_translate_element');
}
</script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
	{/literal}
    </div>
    <div class="col-xs-9">
      <marquee behavior="scroll">{$settings.pengumuman}</marquee>
    </div>
  </div>
</div>

<div id="nav-wrapper" class="container">
    <nav class="navbar navbar-default">
      <div class="container">
        <div class="navbar-header">
          <!-- The mobile navbar-toggle button can be safely removed since you do not need it in a non-responsive implementation -->
         <!-- <a class="navbar-brand" href="{$baseurl}">Scorpion Foundation</a>-->
        </div>
        <div id="navbar" class="">
          <ul class="nav navbar-nav">
            <li><a href="{$baseurl}/">Home</a></li>
            <li><a href="{$baseurl}/newslist">News</a></li>
            <li><a href="{$baseurl}/page/driving-force">Driving Force</a></li>
            <li><a href="{$baseurl}/page/about.html">About Us</a></li>
            <li><a href="{$baseurl}/registration-volunteer.html">Volunteer Info</a></li>
            <li><a href="{$baseurl}/page/wildlife-crime.html">Wildlife Crime Hotline</a></li>
            <li><a href="{$baseurl}/page/contact-us.html">Contact Us</a></li>
            <li><a href="{$baseurl}/page/our-supporters.html">Our Supporters</a></li>
            <!--<li><a href="{$baseurl}/page/donate-now.html">Donate Now</a></li>-->
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
</div>
