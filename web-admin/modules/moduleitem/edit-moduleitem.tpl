<form class="form-horizontal" id="inputform" name="inputform" method="post" action="{$baseurl}/moduleitem/validate">
<input type="hidden" name="id" id="id" value="{$data.id}" />
  <fieldset class="well">
  <p class="f_legend">Edit Modulte Item</p>
  <div class="row-fluid">
    <div class="span6">
    
      <div class="control-group">
        <label class="control-label" for="groupmenu">Group Menu</label>
        <div class="controls">
          <select id="groupmenu" name="groupmenu">
          {foreach from=$datagroupmenu item=obj}
            <option value="{$obj.nama}" {if $obj.nama == $data.groupmenu} selected="selected" {/if} >{$obj.nama}</option>
          {/foreach}  
          </select>
        </div>
      </div>
      
      <div class="control-group">
        <label class="control-label" for="module">Module</label>
        <div class="controls">
          <input type="text" name="module" id="module" placeholder="" class="validate[required]" value="{$data.module}" />
        </div>
      </div>
      
      <div class="control-group">
        <label class="control-label" for="menu">Nama Menu</label>
        <div class="controls">
          <input type="text" name="menu" id="menu" placeholder="" class="validate[required]" value="{$data.menu}" />
        </div>
      </div>
      
      <div class="control-group">
        <label class="control-label" for="single_module">Modul Tunggal ?</label>
        <div class="controls">
          <select name="single_module" id="single_module">
            <option value="1" {if $data.single_module == 0} selected="selected" {/if}>Ya</option>
            <option value="0" {if $data.single_module == 0} selected="selected" {/if}>Tidak, ada sub (view-add-edit-delete)</option>
          </select>
        </div>
      </div>

    </div>
    
    
    <div class="span6">
      <div class="control-group">
        <label class="control-label" for="is_menu">Tampilkan sbg menu</label>
        <div class="controls">
          <select name="is_menu" id="is_menu">
            <option value="1" {if $data.is_menu == 1} selected="selected" {/if} >Ya</option>	
            <option value="0" {if $data.is_menu == 0} selected="selected" {/if} >Tidak</option>
          </select>
        </div> 
      </div>
      
      <div class="control-group">
        <label class="control-label" for="urut">Urutan</label>
        <div class="controls">
          <input type="text" name="urut" id="urut" placeholder="" class="validate[required] angka" value="{$data.urut}" />
        </div>
      </div>
      
      <div class="control-group">
        <label class="control-label" for="deskripsi">Deskripsi</label>
        <div class="controls">
          <textarea id="deskripsi" name="deskripsi">{$data.deskripsi}</textarea>
        </div>
      </div>
      
      
      <div class="control-group">
        <div class="controls">
          <button type="submit" class="btn btn-primary" name="btnSubmit">Simpan</button>
          <button type="button" class="btn" onclick="ajaxpage('{$baseurl}/moduleitem', 'Data Module Item')" title="View Data"><i class="splashy-view_list"></i></button>
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
    return;
  }  
  $.ajax({
    url : '{$baseurl}/moduleitem/query-update',	
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

