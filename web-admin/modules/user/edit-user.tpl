<form class="form-horizontal" id="inputform" name="inputform" method="post" action="{$baseurl}/user/validate">
<input type="hidden" id="id" name="id" value="{$data.id}" />
  <fieldset class="well">
  <p class="f_legend">Edit User</p>
  <div class="row-fluid">
    <div class="span6">
        <div class="control-group">
          <label for="grupuser" class="control-label">Grup user</label>
          <div class="controls">
            <select name="grupuser" id="grupuser" class="validate[required]">
              <option value="">--Pilih Grupuser</option>
            {foreach from=$datagrupuser item=grup}  
              <option value="{$grup.grupuser}" {if $data.grupuser == $grup.grupuser} selected="selected" {/if}>{$grup.grupuser}</option>
            {/foreach}
            </select>
          </div>
        </div>
        
        <div class="control-group">
          <label for="username" class="control-label">Username</label>
          <div class="controls">
            <input type="text" id="username" name="username" class="validate[required]" value="{$data.username}" />
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
          <label for="nama" class="control-label">Nama</label>
          <div class="controls">
            <input type="text" id="nama" name="nama" class="validate[]" value="{$data.nama}" />
          </div>
        </div>
        
        <div class="control-group">
          <label for="telp" class="control-label">Telp</label>
          <div class="controls">
            <input type="text" id="telp" name="telp" class="validate[]" value="{$data.telp}" />
          </div>
        </div>

      <div class="control-group">
        <div class="controls">
          <button type="submit" class="btn btn-primary" name="btnSubmit">Simpan</button>
          <button type="button" class="btn" onclick="ajaxpage('{$baseurl}/user', 'Data User')" title="View Data"><i class="splashy-view_list"></i></button>
          <span id="loader-form" style="display:none;">Loading, please wait...</span>
        </div>
      </div>
   
    </div>
    <div class="span6">
    
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
  //$('#berat').number(true, 2);
  //$('#disc').number(true, 2);
});

function submitForm(formElm){
  var konfirm = confirm('Yakin simpan data ini?');
  if(!konfirm){
    return false;
  }  
  $.ajax({
    url : '{$baseurl}/user/query-update',	
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

