<div class="panel panel-default">

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

