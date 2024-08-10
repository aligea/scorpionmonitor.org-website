{include file = "templates/$path_user/common/header.tpl"}

<div id="content-wrapper" class="container">       
<div class="row">
    <div class="col-xs-8"><div class="panel panel-default">
        
        <div class="panel-body"> 
          <div class="page-header">
            <h1>{$content.title}</h1>
          </div>

            <div align="justify" id="content-news">

            {str_replace('[baseurlroot]', $baseurl, $content.fulltext)}
            </div>
            <script>
            $(function(){
              $('#content-news img').addClass('img-responsive img-thumbnail');
            });
            </script>
<script src="{$baseurl}/assets/js/validate/js/jquery.validationEngine.js"></script>
<script src="{$baseurl}/assets/js/validate/js/languages/jquery.validationEngine-en.js"></script>
<link href="{$baseurl}/assets/js/validate/css/validationEngine.jquery.css" rel='stylesheet' type='text/css' />
            <style>
.overlay-loader {
	background: rgba(255, 255, 255, 0.7) none repeat scroll 0 0;
    border-radius: 3px;
    z-index: 50;
	height: 100%;
    width: 100%;
	position:absolute;
}
.overlay-loader i{
	position: fixed;
	text-align:center;
	left:45%;
	top:45%;
	font-size: 10em;
}
</style>
<script>
$(document).ready(function(){
	$.validationEngine.defaults.promptPosition = 'topLeft';
	initRegistrationForm();
});

function initRegistrationForm(){
  $("#frm1").validationEngine({
    ajaxFormValidation : true,
	ajaxFormValidationMethod : 'POST',
	onBeforeAjaxFormValidation : function(formElm){
	  $('#loader').show();
	},
	onAjaxFormComplete : function(status, form, json, options){
	  $('#loader').hide();
	  if(status === true){
	    submitRegistration();
	  }
	}
  });
}

function submitRegistration(){
  $.ajax({
    type : 'POST',
    url : '{$baseurl}/volunteer/insert',
    data : $('#frm1').serialize(),
    beforeSend : function(){
      $('#loader').show();
    },
    complete : function(){
      $('#loader').hide();
    },
    success : function(response){
      var result = $.trim(response);
      if(result == 'berhasil'){
        $('#frm1').slideUp();
        $('#submit-success').fadeIn();
      }else{
        alert('Something wrong.!');
      }
      
    }
  });
};
</script>
<div class="page-header">
    <h3>Registration Form to be  Volunteer.</h3>
  </div>
  
	<div class="overlay-loader" id="loader" style="display:none;"><i class="fa fa-refresh fa-spin"></i></div>

  <form action="{$baseurl}/volunteer/validate" method="post" id="frm1" class="form-horizontal">
    <div class="row">
      <div class="col-xs-6">
        <div class="form-group">
          <label for="email" class="col-xs-4 control-label">Email <span class="text-danger">(*)</span></label>
          <div class="col-xs-8">
            <input type="text" class="validate[required, custom[email]] form-control" id="email" name="email" placeholder="Your email address...">
          </div>
        </div>
        <div class="form-group">
          <label for="nama" class="col-xs-4 control-label">Name <span class="text-danger">(*)</span></label>
          <div class="col-xs-8">
            <input type="text" class="validate[required] form-control" id="nama" name="nama" placeholder="Yout full name...">
          </div>
        </div>
        <div class="form-group">
          <label for="kelamin" class="col-xs-4 control-label">Gender <span class="text-danger">(*)</span></label>
          <div class="col-xs-8">
            <label style="margin-right:5px;">
              <input type="radio" name="kelamin" id="kelamin_1" value="pria" checked>
              Male
            </label>

            <label>
              <input type="radio" name="kelamin" id="kelamin_2" value="wanita">
              Woman
            </label>

          </div>
        </div>
        <div class="form-group">
          <label for="kota" class="col-xs-4 control-label">City <span class="text-danger">(*)</span></label>
          <div class="col-xs-8">
            <input type="text" class="validate[required] form-control" id="kota" name="kota" placeholder="City/town...">
          </div>
        </div>

        </div>
      <div class="col-xs-6"> 
        <div class="form-group">
          <label for="alamat" class="col-xs-4 control-label">Full Address <span class="text-danger">(*)</span></label>
          <div class="col-xs-8">
            <textarea class="validate[required] form-control" id="alamat" name="alamat" placeholder="Your address..."></textarea>
          </div>
        </div>
        <div class="form-group">
          <label for="telp" class="col-xs-4 control-label">Phone <span class="text-danger">(*)</span></label>
          <div class="col-xs-8">
            <input type="text" class="validate[required] form-control" id="telp" name="telp" placeholder="You phone...">
          </div>
        </div>
        <div class="form-group">
          <label for="info" class="col-xs-4 control-label">Message</label>
          <div class="col-xs-8">
            <textarea class="validate[required] form-control" id="info" name="info" placeholder="Write a message if necessary..,"></textarea>
          </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-8">
              <button type="submit" class="btn btn-primary">Register</button>
            </div>
          </div>
      
      </div>
    </div>
  </form>

  <div id="submit-success" class="bg-success"  style="display:none;">Thank you for your participating, please check your email. We will contact you soon.</div>        </div>
        <div class="panel-footer social-button">
            <span class='st_facebook_hcount' displayText='Facebook'></span>
            <span class='st_twitter_hcount' displayText='Tweet'></span>
            <span class='st_email_hcount' displayText='Email'></span>
        </div>
      </div></div>
    <div class="col-xs-4">{include file = "templates/$path_user/common/sideright.tpl"}</div>
</div>
</div>

{include file = "templates/$path_user/common/footer.tpl"}
