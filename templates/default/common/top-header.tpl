<title>{$metatitle}</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="{$metakey}" />
<meta name="description" content="{$metadesc}">

{$favico = str_replace('[baseurlroot]', $baseurl, $settings.favico)}
<link rel="icon" type="image/png" href="{$favico}" />
<link rel='shortcut icon' type='image/vnd.microsoft.icon' href='{$favico}'/>
<link rel="icon" href='{$favico}' type="image/x-icon" />
<link rel="shortcut icon" href='{$favico}' type="image/x-icon" />
<link rel="alternate" href="{$baseurl}" hreflang="en" />

<link href="{$baseurl}/assets/bootstrap-3.3.4-dist/css/bootstrap.united.css" rel='stylesheet' type='text/css' />
<link rel="stylesheet" href="{$baseurl}/assets/font-awesome/css/font-awesome.css">

<!-- Custom Theme files -->
<link href="{$baseurl}/templates/en/css/style.css" rel='stylesheet' type='text/css' />
<link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800' rel='stylesheet' type='text/css'>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="{$baseurl}/assets/js/jquery-1.9.1.min.js"></script>
<script src="{$baseurl}/assets/bootstrap-3.3.4-dist/js/bootstrap.min.js"></script>

{literal}
<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-63740629-1', 'auto');
ga('send', 'pageview');
</script>

<!--
<script type="text/javascript">var switchTo5x=true;</script>
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">
  stLight.options({
	  publisher: "33c11eb9-3b9d-42c8-ba76-9bc6629e8bed", 
	  doNotHash: true, 
	  doNotCopy: false, 
	  hashAddressBar: false
  });
</script>
<style>
.stMainServices, .stButton, .stButton_gradient  {
height:23px !important;
}
</style>
-->
{/literal}