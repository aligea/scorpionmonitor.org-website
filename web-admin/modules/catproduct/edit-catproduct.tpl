<form class="form-horizontal" id="inputform" name="inputform" method="post" action="{$baseurl}/catproduct/validate">
<input type="hidden" name="id" id="id" value="{$data.id}" />
  <fieldset class="well">
  <p class="f_legend">Edit Category Product</p>
  <div class="row-fluid">
    <div class="span6">
      <div class="control-group">
        <label class="control-label" for="jenis">Subkategory dari</label>
        <div class="controls">
          <select name="parent" id="parent">
			<option value="0" {if $data.parent_id == '0'} selected="selected" {/if}>-</option>
          {foreach from=$parentdata item=parent}
            <option value="{$parent.id}" {if $data.parent_id == $parent.id} selected="selected" {/if} >{$parent.name}</option>
          {/foreach}
          </select>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="name">Nama Kategori</label>
        <div class="controls">
          <input type="text" name="name" id="name" placeholder="" class="validate[required]" value="{$data.name}" />
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="description">Deskripsi</label>
        <div class="controls">
          <textarea id="description" name="description" class="">{$data.description}</textarea>
        </div>
      </div>
      <div class="control-group">
        <div class="controls">
          <button type="submit" class="btn btn-primary" name="btnSubmit">Simpan</button>
          <button type="button" class="btn" onclick="ajaxpage('{$baseurl}/catproduct', 'Data Kategori Produk')" title="View Data"><i class="splashy-view_list"></i></button>
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
});

function submitForm(formElm){
  var konfirm = confirm('Yakin simpan data ini?');
  if(!konfirm){
    return false;
  }  
  $.ajax({
    url : '{$baseurl}/catproduct/query-update',	
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

