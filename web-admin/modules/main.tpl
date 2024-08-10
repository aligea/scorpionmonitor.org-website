<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    
    <link rel="icon" type="image/png" href="{str_replace('[baseurlroot]', $baseurlroot, $allsettings.favico)}" />
    <link rel='shortcut icon' type='image/vnd.microsoft.icon' href='{str_replace('[baseurlroot]', $baseurlroot, $allsettings.favico)}'/>
    <link rel="icon" href='{str_replace('[baseurlroot]', $baseurlroot, $allsettings.favico)}' type="image/x-icon" />
    <link rel="shortcut icon" href='{str_replace('[baseurlroot]', $baseurlroot, $allsettings.favico)}' type="image/x-icon" />

    <title>{$allsettings.nama} | ADMIN PAGE</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{$baseurl}/assets/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">-->
    <link rel="stylesheet" href="{$baseurl}/assets/font-awesome/css/font-awesome.min.css">
    
    <!-- Ionicons -->
    <!--<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">-->
    <!-- Theme style -->
    <link rel="stylesheet" href="{$baseurl}/assets/dist/css/AdminLTE.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{$baseurl}/assets/dist/css/skins/_all-skins.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <!-- jQuery 2.1.4 -->
   <!-- <script src="{$baseurl}/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>-->
   <!-- <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>-->
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js" integrity="sha512-jGsMH83oKe9asCpkOVkBnUrDDTp8wl+adkB2D+//JtlxO4SrLoJdhbOysIFQJloQFD+C4Fl1rMsQZF76JjV0eQ==" crossorigin="anonymous"></script>
    <script src="{$baseurl}/assets/js/jquery-migrate-1.2.1.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="{$baseurl}/assets/bootstrap/js/bootstrap.min.js"></script>

<link rel="stylesheet" href="{$baseurl}/assets/plugins/jQuery-Validation-Engine-master/css/validationEngine.jquery.css" type="text/css"/>
<script src="{$baseurl}/assets/plugins/jQuery-Validation-Engine-master/js/jquery.validationEngine.js" type="text/javascript"></script>
<script src="{$baseurl}/assets/plugins/jQuery-Validation-Engine-master/js/languages/jquery.validationEngine-en.js" type="text/javascript"></script>


<!-- toastr notification -->
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
<!--<script src="{$baseurl}/assets/plugins/toastr/toastr.min.js"></script>-->
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- SlimScroll -->
    <script src="{$baseurl}/assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="{$baseurl}/assets/plugins/fastclick/fastclick.min.js"></script>

<script src="{$baseurl}/assets/js/jquery.number.js"></script>
<script src="{$baseurl}/assets/js/numeral.min.js"></script>

<script src="{$baseurl}/assets/plugins/summernote-master/dist/summernote.custom.js"></script>
<link href="{$baseurl}/assets/plugins/summernote-master/dist/summernote.css" type="text/css" rel="stylesheet" />

<link rel="stylesheet" href="{$baseurl}/assets/plugins/jquery-ui/css/Aristo/Aristo.css" />
<script src="{$baseurl}/assets/plugins/jquery-ui/jquery-ui-1.8.20.custom.min.js"></script>

<script src="{$baseurl}/assets/plugins/chosen/chosen.jquery.min.js"></script>
<link rel="stylesheet" href="{$baseurl}/assets/plugins/chosen/chosen.css" type="text/css"/>

<style>
.table thead th {
    background-color: #eaf5f8 !important;
}
.input-150{
width:150px;
display:inline-block;
}
.input-100{
width:100px;
display:inline-block;
}
.angka, .angkakoma{
text-align:right;
}
.angka:focus, .angkakoma:focus{
text-align:left;
}
.fa-refresh{
animation-duration: 0.5s;
}
.ui-datepicker{
/* harus lebih tinggi dari z-index bootstrap = 1050 */
z-index:1051 !important;
}

</style>
  </head>
  <body class="hold-transition skin-blue sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">

      <header class="main-header">
        <!-- Logo -->
        <a href="{$baseurl}" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini">Web</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>Web</b>Admin</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="{str_replace('[baseurlroot]', $baseurlroot, $allsettings.logo)}" class="user-image" alt="User Image">
                  <span class="hidden-xs">Hello, {$login_admin.username}</span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="{str_replace('[baseurlroot]', $baseurlroot, $allsettings.logo)}" class="img-circle" alt="User Image">
                    <p>
                      {$login_admin.name} - {$login_admin.username}
                      <small>{$login_admin.grupuser}</small>
                    </p>
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="{$baseurl}/profile" class="btn btn-default btn-flat">Profile</a>
                    </div>
                    <div class="pull-right">
                      <a href="{$baseurl}/logout" class="btn btn-default btn-flat">Sign out</a>
                    </div>
                  </li>
                </ul>
              </li>
              <!-- Control Sidebar Toggle Button -->
              <li>
                <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
              </li>
            </ul>
          </div>
        </nav>
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

      <!-- Left side column. contains the sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="{str_replace('[baseurlroot]', $baseurlroot, $allsettings.logo)}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
              <p>{$login_admin.name}</p>
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>
          <!-- search form -->
          <form action="#" method="get" class="sidebar-form" style="text-align:center;color:#fff;background:#000;">
            <div id="waktu_server"></div>
          </form>
          <!-- /.search form -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
			<li class="treeview">
              <a href="#">
                <i class="fa fa-cog"></i> <span>Settings</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu" style="display: none;">
                <li class=""><a href="{$baseurl}/dashboard" title="Dashboard" class="ajaxpage"><i class="fa fa-chevron-right"></i> Dashboard </a></li>
                <li><a href="{$baseurl}/profile" title="Profile" class="ajaxpage"><i class="fa fa-chevron-right"></i> Profile </a></li>
                <li><a href="{$baseurl}/setting" title="Setting Website" class="ajaxpage"><i class="fa fa-chevron-right"></i> Settings </a></li>
              </ul>
            </li>            
            
            <li class="treeview">
              <a href="#">
                <i class="fa fa-th"></i> <span>Halaman</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu" style="display: none;">
                <li><a class="ajaxpage" title="Data Artikel" href="{$baseurl}/article"><i class="fa fa-chevron-right"></i> Data Artikel </a></li>
                <li><a class="ajaxpage" title="Data Banner" href="{$baseurl}/banner"><i class="fa fa-chevron-right"></i> Data Banner </a></li>
                <li><a class="ajaxpage" title="Data Page" href="{$baseurl}/page"><i class="fa fa-chevron-right"></i> Data Page </a></li>
              </ul>
            </li>            
            
            
            {foreach from=$datamenu item=menumodule}
            <li class="treeview">
              <a href="#">
                <i class="fa {str_replace('icon', 'fa', $menumodule.icon)}"></i> <span>{$menumodule.nama}</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
              {foreach from=$menumodule.datamodul item=datamodul}
                <li><a class="ajaxpage"  title="{$datamodul.menu}" href="{$baseurl}/{$datamodul.module}"><i class="fa fa-chevron-right"></i> {$datamodul.menu} </a></li>
              {/foreach}  
              </ul>
            </li>
            {/foreach}
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>

      <!-- =============================================== -->

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">

          <!-- Default box -->
          <div class="box container">
            <div class="box-body" id="contentpage" style="min-height:565px;">
              {include file = "$content"}
            </div><!-- /.box-body -->
            <div class="overlay" id="loader-form" style="display:none;"><i class="fa fa-refresh fa-spin"></i></div>
            <div class="overlay" id="loader" style="display:none;"><i class="fa fa-refresh fa-spin"></i></div>
          </div><!-- /.box -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Version</b> 2.3.0
        </div>
        <strong>Copyright &copy; 2015 <a target="_blank" href="{$baseurlroot}">{$allsettings.nama}</a>.</strong> All rights reserved.
      </footer>

      <!-- Control Sidebar -->
      <aside class="control-sidebar control-sidebar-dark">
        <!-- Create the tabs -->
        
        <!-- Tab panes -->
        <div class="tab-content">
          <!-- Home tab content -->
          <div class="tab-pane" id="control-sidebar-home-tab">
          </div><!-- /.tab-pane -->
          
        </div>
      </aside><!-- /.control-sidebar -->
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->

    <!-- AdminLTE App -->
    <script src="{$baseurl}/assets/dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{$baseurl}/assets/dist/js/demo.js"></script>



<script>
  var jqxhr = null;
  var activeEditor = null;
  $(document).ready(function(){
    $('.ajaxpage').click(function(){
	  if($(this).parent().hasClass('active')){
	    return false;
	  }
	  $('.ajaxpage').parent().removeClass('active');
	  $(this).parent().addClass('active');
	  
	  var titlePage = $(this).attr('title') + ' - IZYSTORE';
	  var urlPage = $(this).attr('href');
	  
	  ajaxpage(urlPage, titlePage)
	  
	  return false;
	});
	
	activateCurrentMenu();
	initEditor();
	initApp();
  });
  function activateCurrentMenu(){
	//-- reset active page then activate current
	$.each($('.ajaxpage'), function(key, value){
	   $(this).parent().removeClass('active');
	   if($(this).attr('href') == document.location.href){
	     $(this).parent().addClass('active');
	   }
	});
  }
  function ajaxpage(urlPage, titlePage){
    if(jqxhr != null){
	  jqxhr.abort();
	}
	$('.formError').remove();
	  jqxhr = $.ajax({
	    type : 'POST',
		url : urlPage,
		beforeSend: function(){
		  $('#contentpage').html('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
		},
		success: function(response){
		  window.document.title = titlePage;
		  $('#title-page').html(titlePage);
		  window.history.pushState(response, titlePage, urlPage);
		  $('#contentpage').html(response);
		  $('html, body').animate({
		  	scrollTop:0
		  }, 'fast');
		  activateCurrentMenu();
		  initApp();
		},
		error: function(){
		  $('#contentpage').html('Error when loading page.');
		}
	  });
  }
  
window.addEventListener('popstate', function(event) {
  console.log('popstate fired!');
  window.location.reload();
  //updateContent(event.state);
});

function initEditor(){
  $('.summernote').summernote({
	  height: 350,
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
	var tinggi = 500;
	var lebar = 900;
	var left = (screen.width / 2) - (lebar / 2);
	var top = (screen.height / 2) - (tinggi / 2);
	var browseWindow = window.open(url, 'Browse Gambar','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width='+lebar+',height='+tinggi+'top='+top+', left='+left);
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

function initApp(){
  changeposition('topLeft');
	
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

//-- validation engine
function changeposition(wo) {
			jQuery('input').attr('data-prompt-position',wo);
			jQuery('input').data('promptPosition',wo);
			jQuery('textarea').attr('data-prompt-position',wo);
			jQuery('textarea').data('promptPosition',wo);
			jQuery('select').attr('data-prompt-position',wo);
			jQuery('select').data('promptPosition',wo);
}
</script>
  </body>
</html>
