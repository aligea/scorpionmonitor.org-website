<!DOCTYPE html>
<html lang="en">
    <head>
        
        <meta charset="utf-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>IZYSTORE | ADMIN PAGE</title>
    
        <!-- Bootstrap framework -->
            <link rel="stylesheet" href="{$baseurl}/assets/bootstrap/css/bootstrap.min.css?" />
            <link rel="stylesheet" href="{$baseurl}/assets/bootstrap/css/bootstrap-responsive.min.css" />
        <!-- blue theme-->
            <link rel="stylesheet" href="{$baseurl}/assets/css/eastern_blue.css" id="link_theme" />
        <!-- breadcrumbs-->
            <link rel="stylesheet" href="{$baseurl}/assets/lib/jBreadcrumbs/css/BreadCrumb.css" />
        <!-- tooltips-->
            <link rel="stylesheet" href="{$baseurl}/assets/lib/qtip2/jquery.qtip.min.css" />
        <!-- code prettify -->
            <link rel="stylesheet" href="{$baseurl}/assets/lib/google-code-prettify/prettify.css" />    
        <!-- notifications -->
            <link rel="stylesheet" href="{$baseurl}/assets/lib/sticky/sticky.css" />    
        <!-- splashy icons -->
            <link rel="stylesheet" href="{$baseurl}/assets/img/splashy/splashy.css" />
		
        <link rel="stylesheet" href="{$baseurl}/assets/lib/jquery-ui/css/Aristo/Aristo.css" />
        
        <!-- colorbox -->
            <link rel="stylesheet" href="{$baseurl}/assets/lib/colorbox/colorbox.css" />
        
        <!-- main styles -->
            <link rel="stylesheet" href="{$baseurl}/assets/css/style.css" />
			
            <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=PT+Sans" />
	
        <!-- Favicon -->
            <link rel="shortcut icon" href="{$baseurl}/assets/favicon.ico" />
            
        <script src="{$baseurl}/assets/js/jquery-1.10.2.min.js"></script>
        
        <script src="{$baseurl}/assets/js/jquery-migrate-1.2.1.min.js"></script>
<!-- smart resize event -->
<script src="{$baseurl}/assets/js/jquery.debouncedresize.min.js"></script>
<!-- hidden elements width/height -->
<script src="{$baseurl}/assets/js/jquery.actual.min.js"></script>
<!-- js cookie plugin -->
<script src="{$baseurl}/assets/js/jquery.roti.min.js"></script>
<!-- main bootstrap js -->
<script src="{$baseurl}/assets/bootstrap/js/bootstrap.min.js"></script>
<!-- lightbox -->
<script src="{$baseurl}/assets/lib/colorbox/jquery.colorbox.min.js"></script>
<!-- fix for ios orientation change -->
<script src="{$baseurl}/assets/js/ios-orientationchange-fix.js"></script>
<!-- scrollbar -->
<script src="{$baseurl}/assets/lib/antiscroll/antiscroll.js"></script>
<script src="{$baseurl}/assets/lib/antiscroll/jquery-mousewheel.js"></script>
<!-- common functions -->
<script src="{$baseurl}/assets/js/gebo_common.js"></script>

<script src="{$baseurl}/assets/lib/jquery-ui/jquery-ui-1.8.20.custom.min.js"></script>
<!-- touch events for jquery ui-->
<script src="{$baseurl}/assets/js/forms/jquery.ui.touch-punch.min.js"></script>

<script src="{$baseurl}/assets/lib/qtip2/jquery.qtip.min.js"></script>

<script src="{$baseurl}/assets/js/validate/languages/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="{$baseurl}/assets/js/validate/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<link rel="stylesheet" href="{$baseurl}/assets/css/validate/validationEngine.jquery.css" type="text/css"/>

<script src="{$baseurl}/assets/js/jquery.number.js"></script>
<script src="{$baseurl}/assets/js/numeral.min.js"></script>

<!-- notification -->
<script src="{$baseurl}/assets/plugins/toastr/toastr.min.js"></script>
<link rel="stylesheet" type="text/css" href="{$baseurl}/assets/plugins/toastr/toastr.min.css" />

<script src="{$baseurl}/assets/js/autocomplete/jquery.autocomplete.js"></script>
<link rel="stylesheet" type="text/css" href="{$baseurl}/assets/js/autocomplete/jquery.autocomplete.css" />

<script src="{$baseurl}/assets/lib/chosen/chosen.jquery.min.js"></script>
<link rel="stylesheet" href="{$baseurl}/assets/lib/chosen/chosen.css" type="text/css"/>


        <!--[if lte IE 8]>
            <link rel="stylesheet" href="{$baseurl}/assets/css/ie.css" />
            <script src="{$baseurl}/assets/js/ie/html5.js"></script>
			<script src="{$baseurl}/assets/js/ie/respond.min.js"></script>
			<script src="{$baseurl}/assets/lib/flot/excanvas.min.js"></script>
        <![endif]-->
		
		<script>
			//* hide all elements & show preloader
			document.documentElement.className += 'js';
		</script>

    </head>
<body>
<div id="loading_layer" style="display:none"><img src="{$baseurl}/assets/img/ajax_loader.gif" alt="" /></div>
<div id="maincontainer" class="clearfix">
  <!-- header -->
  <header>
    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid"> <a class="brand" href="{$baseurl}/"><i class="icon-home icon-white"></i> IZYSTORE </a>
          <ul class="nav user_menu pull-right">
            <li>
              <div class="nb_boxes clearfix pesanmasuk"></div>
            </li>
            <li class="hidden-phone hidden-tablet">
              <div class="nb_boxes clearfix"> <a href="#" class="label "> <i class="splashy-calendar_week"></i> Server date : <span id="waktu_server"> </span> </a> </div>
            </li>
            <li class="divider-vertical hidden-phone hidden-tablet"></li>
            <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown">Hello, {$login_admin.nama} <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="{$baseurl}/profile" class="ajaxpage">My Profile</a></li>
                <li class="divider"></li>
                <li><a href="{$baseurl}/logout">Log Out</a></li>
              </ul>
            </li>
          </ul>
          <a data-target=".nav-collapse" data-toggle="collapse" class="btn_menu"> <span class="icon-align-justify icon-white"></span> </a> 
<nav>
  <div class="nav-collapse">
    <ul class="nav">
      {foreach from=$datamenu item=menumodule}
      <li class="dropdown"> <a data-toggle="dropdown" class="dropdown-toggle" href="#"> <i class="{$menumodule.icon} icon-white"></i> {$menumodule.nama} <b class="caret"></b> </a>
        <ul class="dropdown-menu">
          {foreach from=$menumodule.datamodul item=datamodul}
          <li><a href="{$baseurl}/{$datamodul.module}" title="{$datamodul.menu}" class="ajaxpage">{$datamodul.menu}</a></li>
          {/foreach}
        </ul>
      </li>
      {/foreach}
    </ul>
  </div>
</nav>
        
        </div>
      </div>
    </div>
  </header>
  <input type="hidden" id="timestamp" name="timestamp" value="{$waktu_server}" />
  <script type="text/javascript">
	var currenttime = $('#timestamp').val();
	var montharray = new Array('Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des');
	var serverdate = new Date(currenttime);
	var dayarray = new Array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu');

	function padlength(what) {
		var output = (what.toString().length == 1) ? "0" + what : what;
		return output;
	}

	function displaytime() {
		serverdate.setSeconds(serverdate.getSeconds() + 1);
		var hari = dayarray[serverdate.getDay()];
		var tanggal = padlength(serverdate.getDate());
		var bulan = montharray[serverdate.getMonth()];
		var tahun = serverdate.getFullYear();

		//var datestring = montharray[serverdate.getMonth()] + " " + padlength(serverdate.getDate()) + ", " + serverdate.getFullYear();

		var format = 'Selasa, 12-Feb-2014 16:22:20';
		var datestring = hari + ', ' + tanggal + '-' + bulan + '-' + tahun + ' ';
		var timestring = padlength(serverdate.getHours()) + ":" + padlength(serverdate.getMinutes()) + ":" + padlength(serverdate.getSeconds());
		document.getElementById("waktu_server").innerHTML = datestring + " " + timestring;
	}

	$(function() {
		setInterval("displaytime()", 1000);
	});

</script>
  <!-- main content -->
  <div id="contentwrapper">
    <div class="main_content" id="contentpage">
    {include file = "$content"}
    </div>
  </div>
  <!-- header -->
  <!-- sidebar -->
  <a href="javascript:void(0)" class="sidebar_switch on_switch ttip_r" title="Hide Sidebar">Sidebar switch</a>
  {include file = "{$basepath}/modules/side-menu.tpl"}
 
</div>

 
  <!-- fix modalpopup -->
<style>
.modal, #popup{
margin-bottom:20px; 
max-height:500px; 
overflow:auto;
}
</style>

<!-- fix input form-->
<style>
textarea{
  resize:both;
}

.chzn-container{
width:220px !important;
}
.angka, .angkakoma{
text-align:right;
}
input:focus{
text-align:left;
}
.table-responsive{
overflow-y:auto;	
}

.note-toolbar{
    background-color: #f5f5f5;
    border-color: #ddd;
    color: #333;
}

.note-toolbar .fix-height{
  height:200px !important;
}
.note-toolbar .full-height{
  height:1000px;
}
</style>

<script src="{$baseurl}/assets/plugins/summernote-master/dist/summernote.custom.js"></script>
<link href="{$baseurl}/assets/plugins/summernote-master/dist/summernote.css" type="text/css" rel="stylesheet" />
<link href="{$baseurl}/assets/lib/font-awesome-4.4.0/css/font-awesome.min.css" type="text/css" rel="stylesheet" />
<script>
var activeEditor = null;
$(document).ready(function(){
	initEditor();
});

function initEditor(){
  $('.summernote').summernote({
	  height: 200,
  	  maxHeight: document.body.clientHeight,
	  onImageUpload: function(files) {
        sendFile(files[0], $(this));
      },
	  onFocus: function(event){
	    activeEditor = $(this);
	  }
  });
  $('[data-event="fullscreen"]').click(function(){
    $('.note-editable').css({
		//'height' : document.body.clientHeight+'px'  
	});
  });

}

function browseImage(field_id){
	var url = "{$baseurl}/assets/responsive_filemanager/filemanager/dialog.php?type=1&popup=1&field_id=" + field_id;
	var browseWindow = window.open(url, 'Browse Gambar','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=900,height=500');
	browseWindow.focus();
}
function responsive_filemanager_callback(field_id){
	var url = $('#'+field_id).val();	
	if(activeEditor == null){
	  return;
	}
	if($('.note-image-dialog').hasClass('in')){
		$(activeEditor).summernote("insertImage", url, 'filename');
		$('.modal').modal('hide');
	}
}
function sendFile(file, editor) {
    data = new FormData();
    data.append("file", file);
    $.ajax({
        data: data,
        type: "POST",
        url: "{$baseurl}/uploadimage",
        cache: false,
        contentType: false,
        processData: false,
        success: function(url) {
		  $(editor).summernote("insertImage", url, 'filename');
        }
    });
}  
</script>

<script>
$(document).ready(function() {
  //* show all elements & remove preloader
  setTimeout('$("html").removeClass("js")',1000);
  initApp();
});
function initApp(){
  $('.datepicker').datepicker({
    dateFormat : "dd-mm-yy"
  });
  $('.select_chosen').chosen({
	search_contains : true
  });
  $('.select_chosen').trigger('chosen:updated');
  $('.select_chosen').trigger('chzn:updated');	
  $('.angka').number(true, 0);
  $('.angkakoma').number(true, 2);
  $('input').on('click', function(){
    //$(this).select();
  });
  $('.cboxElement img').on('load', function(){
    $(this).parent().attr('title', $(this).attr('src')); 
	$(this).parent().attr('href', $(this).attr('src'));        
  });
}
				
</script>

</body>
</html>
