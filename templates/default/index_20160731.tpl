{include file = "templates/$path_user/common/header.tpl"}

<div id="banner-wrapper" class="container">
<script type="text/javascript" src="{$baseurl}/templates/{$path_user}/assets/plugins/Nivo-Slider-master/jquery.nivo.slider.js"></script>    
<link rel="stylesheet" type="text/css" href="{$baseurl}/templates/{$path_user}/assets/plugins/Nivo-Slider-master/nivo-slider.css"  />
<link rel="stylesheet" type="text/css" href="{$baseurl}/templates/{$path_user}/assets/plugins/Nivo-Slider-master/themes/default/default.css"  />

        <div class="slider-wrapper theme-default">
            <div id="slider" class="nivoSlider">
            {foreach from=$dataslideshow item=image}
                <img src="{$image}" data-thumb="{$image}" alt="{$image}" />
            {/foreach}
            </div>
        </div>
    <script type="text/javascript">
    $(window).load(function() {
        $('#slider').nivoSlider({
			controlNav: false,
			/*effect: 'random',
			animSpeed: 2000, 
    		pauseTime: 3000,*/
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
      <div class="panel panel-default">
        <div class="panel-heading"> Latest News </div>
        <div class="panel-body"> 
        {foreach from=$recentnews item=news}
          <div class="row posting-content">
            <div class="col-xs-3 " align="center"> 
              <a href="{$baseurl}/content/news/{$news.alias}.html">
                <img class="img-responsive img-rounded" src="{$baseurl}/img/resize?file={$news.fakefilename}&w=200&h=150" alt="{$news.title}">
              </a> 
            </div>
            <div class="col-xs-9 ">
              <h4><a href="{$baseurl}/content/news/{$news.alias}.html">{$news.title}</a></h4>
              <p>{$news.introtext}</p>
              <span class="text-muted">Posted on {date('H:i F dS, Y', strtotime($news.created))}</span>
              <a class="btn btn-default pull-right" href="{$baseurl}/content/news/{$news.alias}.html">Read more...</a> </div>
          </div>
        {/foreach}
                     <a href="{$baseurl}/newslist" class="btn btn-link">View all news ...</a>

        </div>
            
      </div>
</div>

<div id="socialfeed" class="container" align="center">
<div class="row">
	<div class="col-xs-4">
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

  <div class="fb-page" data-href="https://www.facebook.com/scorpionmonitor" data-small-header="true" data-adapt-container-width="true" data-hide-cover="true" data-show-facepile="true" data-show-posts="true"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/scorpionmonitor"><a href="https://www.facebook.com/scorpionmonitor">SCORPION Wildlife Trade Monitoring Group</a></blockquote></div></div>
    </div>
    <div class="col-xs-4">
  {literal}

            <a class="twitter-timeline"  href="https://twitter.com/scorpionmonitor" data-widget-id="630000492152619011">Tweets by @scorpionmonitor</a>

            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

            {/literal}
    </div>
    <div class="col-xs-4" align="left">
    
        <div class="panel panel-default">
          <div class="panel-heading">Newsletter</div>
          <div class="panel-body">
            <form class="form-horizontal" action="javascript:subscribeNewsletter();" method="get" id="subscribeForm">
                <input  type="email"  class="form-control" name="email" id="email" placeholder="write your email address ..."  required="required">
                <button type="submit" class="btn btn-primary" style="margin-top:5px;">Subscribe</button>
            </form>
          </div>
        </div>
         
    </div>
</div>
</div>


{include file = "templates/$path_user/common/footer.tpl"}
