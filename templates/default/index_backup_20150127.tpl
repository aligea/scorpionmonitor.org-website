<!DOCTYPE html>
<html lang="id" xml:lang="en" prefix="og: http://ogp.me/ns#" xmlns:og="http://ogp.me/ns#" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<!--<meta name="viewport" content="width=device-width, initial-scale=1">-->
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<title>{$meta_title}</title>
<meta name="description" content="{$meta_description}" />
<meta name="keywords" content="{$meta_keyword}" />

<meta property="og:type" content="{$og.type}" />
<meta property="og:title" content="{$og.title}" />
<meta property="og:url" content="{$og.url}" />
<meta property="og:image" content="{$og.image}" />
<meta property="og:description" content="{$og.description}" />
<meta property="og:site_name" content="{$og.site_name}" />

<link rel="icon" type="image/png" href="{$favico}" />
<link rel='shortcut icon' type='image/vnd.microsoft.icon' href='{$favico}'/>
<link rel="icon" href='{$favico}' type="image/x-icon" />
<link rel="shortcut icon" href='{$favico}' type="image/x-icon" />

<link href="{$baseurl}/templates/{$path_user}/assets/bootstrap-3.3.4-dist/css/bootstrap.united.css" rel='stylesheet' type='text/css' />
<link rel="stylesheet" href="{$baseurl}/templates/{$path_user}/assets/font-awesome/css/font-awesome.css">
<link rel="stylesheet" href="{$baseurl}/templates/{$path_user}/assets/css/style.css">

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="{$baseurl}/templates/{$path_user}/assets/js/jquery-1.9.1.min.js"></script>
<script src="{$baseurl}/templates/{$path_user}/assets/bootstrap-3.3.4-dist/js/bootstrap.min.js"></script>
<script src="{$baseurl}/templates/{$path_user}/assets/js/script.js"></script>

{literal}
<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-63740629-1', 'auto');
ga('send', 'pageview');
</script>

{/literal}
</head>
<body>

<div id="header-wrapper" class="container">
<div class="row">
  <div class="col-xs-2"> 
  	<img src="{str_replace('[baseurlroot]', $baseurl, $settings.logo)}" alt="logo-scorpion" class="img-rounded" height="100"> 
  </div>
  <div class="col-xs-8">
  	<div class="tagline">
      <h1>THE WILDLIFE TRADE MONITORING GROUP</h1>
    </div>
  </div>
  <div class="col-xs-2"> 
  	<div class="tagline2">scorpionmonitor.org</div>
	<div class="hotline">
    	<i class="fa fa-phone"></i> Wildlife Hotline :
        <br/>
    	<a href="{$baseurl}/page/wildlife-crime.html">+62 812 9129 6555</a>
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
      <marquee>{$settings.pengumuman}</marquee>
    </div>
  </div>
</div>

<div id="nav-wrapper" class="container">
    <nav class="navbar navbar-default">
      <div class="container">
        <div class="navbar-header">
          <!-- The mobile navbar-toggle button can be safely removed since you do not need it in a non-responsive implementation -->
          <a class="navbar-brand" href="{$baseurl}">Scorpion Foundation</a>
        </div>
        <div id="navbar" class="">
          <ul class="nav navbar-nav">
            <li><a href="{$baseurl}/">Home</a></li>
            <li><a href="{$baseurl}/newslist">News</a></li>
            <li><a href="{$baseurl}/about.html">About Us</a></li>
            <li><a href="{$baseurl}/registration-volunteer.html">Volunteer Info</a></li>
            <li><a href="{$baseurl}/wildlife-crime.html">Wildlife Crime Hotline</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
</div>


<div id="banner-wrapper" class="container">
<script type="text/javascript" src="{$baseurl}/templates/{$path_user}/assets/plugins/Nivo-Slider-master/jquery.nivo.slider.js"></script>    
<link rel="stylesheet" type="text/css" href="{$baseurl}/templates/{$path_user}/assets/plugins/Nivo-Slider-master/nivo-slider.css"  />
<link rel="stylesheet" type="text/css" href="{$baseurl}/templates/{$path_user}/assets/plugins/Nivo-Slider-master/themes/default/default.css"  />

        <div class="slider-wrapper theme-default">
            <div id="slider" class="nivoSlider">
            {foreach from=$dataslideshow item=image}
                <img src="{$image}" data-thumb="{$image}" alt="" />
            {/foreach}
            </div>
        </div>
    <script type="text/javascript">
    $(window).load(function() {
        $('#slider').nivoSlider({
			controlNav: false,
			effect: 'random',
			animSpeed: 500, 
    		pauseTime: 3000, 
		});
    });
    </script>

   <!-- Add fancyBox -->
  <link rel="stylesheet" href="{$baseurl}/templates/{$path_user}/assets/plugins/fancyapps-fancyBox-18d1712/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
  <script type="text/javascript" src="{$baseurl}/templates/{$path_user}/assets/plugins/fancyapps-fancyBox-18d1712/source/jquery.fancybox.pack.js?v=2.1.5"></script> 

  <script>
$(document).ready(function() {
	$(".fancybox").fancybox({
		'padding'		: 0,
		openEffect	: 'elastic',
		closeEffect	: 'elastic'
	});
});
</script>   
 </div>

<div id="content-wrapper" class="container"> 
  <div class="row">
    <div class="col-xs-4"> 
<div id="sideleft-wrapper">    
<div class="panel panel-default hidden">

  <div class="panel-heading">Navigation</div>
  <div class="panel-body">
    <nav class="nav" role="navigation">
      <ul class="nav nav-pills nav-stacked" role="navigation">
        <li class="{$nav_index}"><a href="{$baseurl}/"><i class="fa fa-caret-right"></i> Home </a></li>
        <li class="{$nav_newslist}"><a href="{$baseurl}/newslist"><i class="fa fa-caret-right"></i> News </a></li>
        <li class="{$nav_newslist2}"><a href="{$baseurl}/page/about.html"><i class="fa fa-caret-right"></i> About Us </a></li>
        <li class="{$nav_volunteer}"><a href="{$baseurl}/registration-volunteer.html"><i class="fa fa-caret-right"></i> Volunteer Info </a></li>
		<li class="{$nav_wildlifecrime}"><a href="{$baseurl}/page/wildlife-crime.html"><i class="fa fa-caret-right"></i> Wildlife Crime Hotline </a></li>
      </ul>
    </nav>
  </div>
</div>

<div class="panel panel-default">
  <div class="panel-heading">Search</div>
  <div class="panel-body">
    <form class="" action="javascript:void(0);">
    <input class="form-control" type="text" name="q" placeholder="Type here...">
    </form>
  </div>
</div>    

<div class="panel panel-default">
  <div class="panel-heading">Find Us</div>
  <div class="panel-body">
    <ul class="nav nav-pills">
      <li><a href="{$settings.facebook}" target="_blank" title="Facebook Page"><i class="fa fa-facebook fa-2x"></i></a></li>
      <li><a href="{$settings.twitter}" target="_blank" title="Twitter"><i class="fa fa-twitter fa-2x"></i></a></li>
      <li><a href="{$settings.instagram}" target="_blank" title="Instagram"><i class="fa fa-instagram fa-2x"></i></a></li>
      <li><a href="mailto:{$settings.email}" title="Email"><i class="fa fa-envelope fa-2x"></i></a></li>
    </ul>
</div>
</div>

<div class="panel panel-default">
  <div class="panel-heading">Facebook Page</div>
  <div class="panel-body">
  <div id="fb-root"></div>

{literal}
<script>
(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/id_ID/sdk.js#xfbml=1&version=v2.4";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

</script>
{/literal}

  

  <div class="fb-page" data-href="https://www.facebook.com/scorpionmonitor" data-small-header="true" data-adapt-container-width="true" data-hide-cover="true" data-show-facepile="true" data-show-posts="false"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/scorpionmonitor"><a href="https://www.facebook.com/scorpionmonitor">SCORPION Wildlife Trade Monitoring Group</a></blockquote></div></div>

    

  </div>

</div>

<div class="panel panel-default">
  <div class="panel-body">
  {literal}

            <a class="twitter-timeline"  href="https://twitter.com/scorpionmonitor" data-widget-id="630000492152619011">Tweets by @scorpionmonitor</a>

            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

            {/literal}
  </div>
</div>
</div>
    </div>
    
    <div class="col-xs-8">
    <div class="sideright-wrapper">
      <div class="panel panel-default">
        <div class="panel-heading"> Latest News </div>
        <div class="panel-body"> 
        {foreach from=$recentnews item=news}
          <div class="row posting-content">
            <div class="col-xs-3 " align="center"> 
              <a href="{$baseurl}/{$news.alias}.html">
                <img class="img-responsive img-thumbnail" src="{str_replace('[baseurlroot]', $baseurl, $news.image_small)}">
              </a> 
            </div>
            <div class="col-xs-9 ">
              <h4><a href="{$baseurl}/{$news.alias}.html">{$news.title}</a></h4>
              <p>{$news.introtext}</p>
              <span class="text-muted">Posted on {date('H:i F dS, Y', strtotime($news.created))}</span>
              <a class="btn btn-default pull-right" href="{$baseurl}/{$news.alias}.html">Read more...</a> </div>
          </div>
        {/foreach}
                     <a href="{$baseurl}/newslist" class="btn btn-link">View all news ...</a>

        </div>
            <div class="panel-footer social-button">
            <span class='st_facebook_hcount' displayText='Facebook'></span>
            <span class='st_twitter_hcount' displayText='Tweet'></span>
            <span class='st_email_hcount' displayText='Email'></span>
            </div>
      </div>
    </div>

    </div>
    
  </div>
</div>


<div class="footer_bottom">
  <div class="container">
    <div class="copy">
      <p>&copy;2015 <a href="http://www.scorpionmonitor.org">SCORPIONMONITOR.ORG</a> </p>
    </div>
  </div>
</div>

</body>
</html>
