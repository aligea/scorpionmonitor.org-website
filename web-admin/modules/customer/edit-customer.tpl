<form class="form-horizontal" id="inputform" name="inputform" method="post" action="{$baseurl}/customer/validate">
<input type="hidden" id="id" name="id" value="{$data.id}"  />
  <fieldset class="well">
  <p class="f_legend">Edit Customer</p>
  <div class="row-fluid">
    <div class="span6">
      <div class="control-group">
        <label class="control-label" for="username">Username/Email</label>
        <div class="controls">
          <input type="text" name="username" id="username" placeholder="" class="validate[required, custom[email]]" value="{$data.username}" />
        </div>
      </div>    

        <div class="control-group">
          <label for="password" class="control-label">Password</label>
          <div class="controls">
            <input type="password" id="password" name="password" class="validate[required, minSize[6]]" value="{$data.password}" />
          </div>
        </div>
        
        <div class="control-group">
          <label for="password2" class="control-label">Re-type Password</label>
          <div class="controls">
            <input type="password" id="password2" name="password2" class="validate[required, equals[password]]" value="{$data.password}" />
          </div>
        </div>

      <div class="control-group">
        <label class="control-label" for="nama">Nama</label>
        <div class="controls">
          <input type="text" name="nama" id="nama" placeholder="" class="validate[required]" value="{$data.nama}" />
        </div>
      </div>    

      <div class="control-group">
        <label class="control-label" for="telpon">Telp</label>
        <div class="controls">
          <input type="text" name="telpon" id="telpon" placeholder="" class="validate[]" value="{$data.telpon}" />
        </div>
      </div>    
          
    </div>
    
    
    <div class="span6">
    
      <div class="control-group">
        <label class="control-label" for="kota">Kota</label>
        <div class="controls">
          <input type="text" name="kota" id="kota" placeholder="" class="validate[required]" value="{$data.kota}" />
        </div>
      </div>    

      <div class="control-group">
        <label class="control-label" for="alamat">Alamat</label>
        <div class="controls">
          <textarea id="alamat" name="alamat" class="validate[required]">{$data.alamat}</textarea>
        </div>
      </div>
    
      <div class="control-group">
        <label class="control-label" for="kodepos">Kode Pos</label>
        <div class="controls">
          <input type="text" name="kodepos" id="kodepos" placeholder="" class="validate[required]" value="{$data.kodepos}" />
        </div>
      </div>    
    
      <div class="control-group">
        <div class="controls">
          <button type="submit" class="btn btn-primary" name="btnSubmit">Simpan</button>
          <button type="button" class="btn" onclick="ajaxpage('{$baseurl}/customer', 'Data Customer')" title="View Data"><i class="splashy-view_list"></i></button>
          <span id="loader-form" style="display:none;">Loading, please wait...</span>
        </div>
      </div>

    </div>
  </div>
  
  
  </fieldset>
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
});

function submitForm(formElm){
  var konfirm = confirm('Yakin simpan data ini?');
  if(!konfirm){
    return false;
  }  
  $.ajax({
    url : '{$baseurl}/customer/query-update',	
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

