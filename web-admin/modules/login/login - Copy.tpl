<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>IZYSTORE | Login Page</title>
<!-- Bootstrap framework -->
<link rel="stylesheet" href="{$baseurl}/assets/bootstrap/css/bootstrap.min.css" />
<link rel="stylesheet" href="{$baseurl}/assets/bootstrap/css/bootstrap-responsive.min.css" />
<!-- theme color-->
<link rel="stylesheet" href="{$baseurl}/assets/css/blue.css" />
<!-- tooltip -->
<link rel="stylesheet" href="{$baseurl}/assets/lib/qtip2/jquery.qtip.min.css" />
<!-- main styles -->
<link rel="stylesheet" href="{$baseurl}/assets/css/style.css" />

<!-- Favicons and the like (avoid using transparent .png) -->
<link rel="shortcut icon" href="{$baseurl}/assets/favicon.ico" />
<link href='http://fonts.googleapis.com/css?family=PT+Sans' rel='stylesheet' type='text/css'>
<!--[if lte IE 8]>
  <script src="{$baseurl}/assets/js/ie/html5.js"></script>
  <script src="{$baseurl}/assets/js/ie/respond.min.js"></script>
<![endif]-->

<script src="{$baseurl}/assets/js/jquery.min.js"></script>
<script src="{$baseurl}/assets/bootstrap/js/bootstrap.min.js"></script>

<link rel="stylesheet" type="text/css" href="{$baseurl}/assets/css/validate/validate.css">
<link rel="stylesheet" href="{$baseurl}/assets/css/validate/validationEngine.jquery.css" type="text/css"/>
<script src="{$baseurl}/assets/js/validate/languages/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="{$baseurl}/assets/js/validate/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>


<!-- toastr notification -->
<link rel="stylesheet" type="text/css" href="{$baseurl}/assets/plugins/toastr/toastr.min.css">
<script src="{$baseurl}/assets/plugins/toastr/toastr.min.js"></script>

</head>
<body class="login_page">
<div class="login_box">
  <form action="{$baseurl}/login/validate" id="frmLogin" name="frmLogin">
  <input type="hidden" name="sessionform" id="sessionform" value="{$sessionform}">
    <div class="top_b">Sign In to System</div>
    <div class="cnt_b">
      <div class="formRow">
        <div class="input-prepend"> <span class="add-on"><i class="icon-user"></i></span>
          <input type="text" class="validate[required]" id="username" name="username" placeholder="username" value="" />
        </div>
      </div>
      <div class="formRow">
        <div class="input-prepend"> <span class="add-on"><i class="icon-lock"></i></span>
          <input type="password" class="validate[required]" id="password" name="password" placeholder="password" value="" />
        </div>
      </div>
      <div class="formRow">
        <div class="input-prepend"> <span class="add-on"><i class="icon-lock"></i></span>
          <input type="text" class="validate[required]" id="textcaptcha" name="textcaptcha" style="width:125px;"  />
          <span style="padding-top:5px; padding-bottom:20px;"><img width="80" src="{$baseurl}/libraries/securimage/securimage_show.php?sid={md5(uniqid(time()))}" style="position:relative; height:28px; top:-1px;" /></span> </div>
      </div>
    </div>
    <div class="btm_b clearfix">
      <span id="myloader" style="display:none;">Loading, plase wait...</span>
      <button class="btn btn-inverse pull-right" type="submit">Sign In</button>
    </div>
  </form>
  <div style="display:none; padding:15px;" class="inforegistration"> Berhasil Login, Tunggu sejenak. Akan di Direct ke Halaman Admin. </div>
</div>

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
