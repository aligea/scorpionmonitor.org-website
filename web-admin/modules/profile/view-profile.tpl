   <div class="page-header">
     <h3>EDIT PROFILE</h3>
   </div>

<form class="form-horizontal" id="inputform" name="inputform" method="post" action="{$baseurl}/profile/validate">
<input type="hidden" id="id" name="id" value="{$data.id}" />
  <div class="row">
    <div class="col-md-6">
        <div class="form-group">
          <label for="username" class="col-md-4 control-label">Username</label>
          <div class="col-md-8">
            <input type="text" id="username" name="username" class="validate[required] form-control" value="{$data.username}" />
          </div>
        </div>

        <div class="form-group">
          <label for="password" class="col-md-4 control-label">Password</label>
          <div class="col-md-8">
            <input type="password" id="password" name="password" class="validate[required, minSize[6]] form-control" value="{$data.password}" />
          </div>
        </div>
        
        <div class="form-group">
          <label for="password2" class="col-md-4 control-label">Re-type Password</label>
          <div class="col-md-8">
            <input type="password" id="password2" name="password2" class="validate[required, equals[password]] form-control" value="{$data.password}" />
          </div>
        </div>

        <div class="form-group">
          <label for="name" class="col-md-4 control-label">Nama</label>
          <div class="col-md-8">
            <input type="text" id="name" name="name" class="validate[] form-control" value="{$data.name}" />
          </div>
        </div>
        
        

      <div class="box-footer">
          <button type="submit" class="btn btn-primary pull-right" name="btnSubmit">Simpan</button>
          
      </div>
   
    </div>
    <div class="col-md-6">
    
    </div>
  </div>
</form>
<script>
$(document).ready(function(){
  $("#inputform").validationEngine({
    ajaxFormValidation : true,
	onBeforeAjaxFormValidation : function(formElm){
	  disableThisForm(formElm);
	},
	onAjaxFormComplete : function(status, form, json, options){
	  activateThisForm(form);
	  if(status === true){
	    submitForm(form);
	  }
	}
  });
  //$('#berat').number(true, 2);
  //$('#disc').number(true, 2);
});

function submitForm(formElm){
  var konfirm = confirm('Yakin simpan data ini?');
  if(!konfirm){
    return false;
  }  
  $.ajax({
    url : '{$baseurl}/profile/query-update',	
    type:'POST',
	data : $(formElm).serialize(),
	beforeSend : function(){
	  disableThisForm(formElm);
	},
	complete : function(){
	  activateThisForm(formElm);
	},
	error : function(response){
	  toastr["error"](response.statusText);
	},
	success: function(response){
	  var result = $.trim(response);
	  if(result == 'berhasil'){
	    toastr["success"]("Berhasil disimpan.");
		//$(formElm)[0].reset();
	  }else{
	  	toastr["error"](response);
	  }
	}
  });
}
function disableThisForm(formElm){
	var btnsave = $(formElm).find("[type=submit]");
	btnsave.attr('disabled', 'disabled');
	$('#loader-form').show();
}
function activateThisForm(formElm){
	var btnsave = $(formElm).find("[type=submit]");
	btnsave.removeAttr('disabled', 'disabled');
	$('#loader-form').hide();
}
</script>

