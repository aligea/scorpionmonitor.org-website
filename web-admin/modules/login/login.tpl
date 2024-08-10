<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{$allsettings.nama}  | Log in</title>
    
    <link rel="icon" type="image/png" href="{str_replace('[baseurlroot]', $baseurlroot, $allsettings.favico)}" />
    <link rel='shortcut icon' type='image/vnd.microsoft.icon' href='{str_replace('[baseurlroot]', $baseurlroot, $allsettings.favico)}'/>
    <link rel="icon" href='{str_replace('[baseurlroot]', $baseurlroot, $allsettings.favico)}' type="image/x-icon" />
    <link rel="shortcut icon" href='{str_replace('[baseurlroot]', $baseurlroot, $allsettings.favico)}' type="image/x-icon" />
    
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
    <!-- iCheck -->
    <link rel="stylesheet" href="{$baseurl}/assets/plugins/iCheck/square/blue.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    
    <!-- jQuery 2.1.4 -->
    <!--<script src="{$baseurl}/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>-->
    <!--<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js" integrity="sha512-jGsMH83oKe9asCpkOVkBnUrDDTp8wl+adkB2D+//JtlxO4SrLoJdhbOysIFQJloQFD+C4Fl1rMsQZF76JjV0eQ==" crossorigin="anonymous"></script>
    <script src="{$baseurl}/assets/js/jquery-migrate-1.2.1.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="{$baseurl}/assets/bootstrap/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="{$baseurl}/assets/plugins/iCheck/icheck.min.js"></script>
    
<link rel="stylesheet" href="{$baseurl}/assets/plugins/validate/css/validationEngine.jquery.css" type="text/css"/>
<link rel="stylesheet" href="{$baseurl}/assets/plugins/validate/css/validate.css" type="text/css"/>
<script src="{$baseurl}/assets/plugins/validate/jquery.validationEngine.js" type="text/javascript"></script>
<script src="{$baseurl}/assets/plugins/validate/languages/jquery.validationEngine-en.js" type="text/javascript"></script>


<!-- toastr notification -->
<link rel="stylesheet" type="text/css" href="{$baseurl}/assets/plugins/toastr/toastr.min.css">
<!--<script src="{$baseurl}/assets/plugins/toastr/toastr.min.js"></script>-->
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

  </head>
  <body class="hold-transition login-page">
    <div class="login-box box">
      <div class="login-logo">
        <a href="{$baseurl}/"><b>{$allsettings.nama}</b></a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your session. <br>  Admin Panel</p>
        <form  action="{$baseurl}/login/validate" id="frmLogin" name="frmLogin">
        <input type="hidden" name="sessionform" id="sessionform" value="{$sessionform}">
          <div class="form-group has-feedback">
            <input type="text" class="form-control validate[required]" placeholder="Username"  id="username" name="username">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control validate[required]" placeholder="Password" id="password" name="password">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          
          <div class="row">
            <div class="col-xs-6">
                <input type="text" class="form-control validate[required]" name="textcaptcha" id="textcaptcha" placeholder="Captcha">
            </div>
            <div class="col-xs-6">
              <a onClick="document.getElementById('cgambar').src = '{$baseurl}/libraries/securimage/securimage_show.php?sid=' + Math.random(); this.blur(); return false;" href="javascript:;">
                <img id="cgambar"  src="{$baseurl}/libraries/securimage/securimage_show.php?sid={md5(uniqid(time()))}" class="img-responsive" style="height:35px;" />
             </a>
            </div>
          </div>
          
          <div class="row" style="margin-top:35px;">
            <div class="col-xs-8">    
                      
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary">Sign In</button>
            </div><!-- /.col -->
          </div>
          
        </form>

	
              
              
      </div><!-- /.login-box-body -->
      <div class="overlay" id="myloader" style="display:none;"><i class="fa fa-refresh fa-spin"></i></div>
    </div><!-- /.login-box -->


<script>
$(document).ready(function(){
  $('#frmLogin').validationEngine({
	ajaxFormValidation : true,
	ajaxFormValidationMethod : 'POST',
	onBeforeAjaxFormValidation : disableForm,
	onAjaxFormComplete : function(status, form){
		enableForm(form);
		if(status){
			submitLogin(form);
		}
	}
  });
});

function submitLogin(form){
	$.ajax({
		type : "POST",
		url : "{$baseurl}/login/submit",
		data : form.serialize(),
		beforeSend : function(){
			disableForm(form);
		},
		complete : function(){
			enableForm(form);
		},
		success : function(response){
			var result = $.trim(response);
			if(result == 'success'){
				toastr["success"]("Berhasil login, akan di redirect ke halaman utama.");
				window.location.reload();
			}else{
				toastr["error"]("Invalid username/password.!");
			}
		}
	});
}


function disableForm(form) {
	var btnsave = $(form).find("[type=submit]");
	btnsave.attr('disabled', 'disabled');
	$('#myloader').show();
}
function enableForm(form){
	var btnsave = $(form).find("[type=submit]");
	btnsave.removeAttr('disabled', 'disabled');
	$('#myloader').hide();
}

</script>


  </body>
</html>
