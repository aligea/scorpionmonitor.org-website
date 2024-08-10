<form class="form-horizontal" id="inputform" name="inputform" method="post" action="{$baseurl}/catcontent/validate">
<input type="hidden" id="id" name="id" value="{$data.id}" />
  <fieldset class="well">
  <p class="f_legend">Edit Category Content</p>
  <div class="row-fluid">
    <div class="span6">
      <div class="control-group">
        <label class="control-label" for="jenis">Subkategory dari</label>
        <div class="controls">
          <select name="parent" id="parent">
			<option value="0" selected="selected">-</option>
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
          <button type="button" class="btn" onclick="ajaxpage('{$baseurl}/catcontent', 'Data Kategori Produk')" title="View Data"><i class="splashy-view_list"></i></button>
          <span id="loader-form" style="display:none;">Loading, please wait...</span>
        </div>
      </div>
    </div>
    <div class="span6">
      <div class="control-group">
        <label for="images" class="control-label">Gambar</label>
        <div class="controls">
          <input type="text" onchange="document.getElementById('view-images').src = this.value;" name="images" placeholder="url gambar" id="images" class="form-control validate[]" value="{str_replace('[baseurlroot]', $baseurlroot, $data.images)}">
          <a title="Browse Image" href="javascript:browseImage('images')" class="btn btn-small"><i class="splashy-image_cultured"></i></a>
          <img style="width:150px;height:120px;" class="img-responsive img-thumbnail thumbnail" id="view-images" src="{str_replace('[baseurlroot]', $baseurlroot, $data.images)}">
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
    url : '{$baseurl}/catcontent/query-update',	
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

