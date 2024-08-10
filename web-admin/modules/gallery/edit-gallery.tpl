<form class="form-horizontal" id="inputform" name="inputform" method="post" action="{$baseurl}/gallery/validate">
<input type="hidden" name="id" id="id" value="{$data.id}" />
  <fieldset class="well">
  <p class="f_legend">Edit Gallery</p>
  <div class="row-fluid">
    <div class="span6">
      <div class="control-group">
        <label class="control-label" for="category">Category</label>
        <div class="controls">
          <select name="category_id" id="category_id" class="select_chosen">
          {foreach from=$datacategory item=category}
            <option value="{$category.id}" {if $category.id == $category_id} selected="selected" {/if}>{$category.parentcategory}{$category.name}</option>
          {/foreach}
          </select>
        </div>
      </div>
      
      <div class="control-group">
        <label class="control-label" for="name">Judul / Nama</label>
        <div class="controls">
          <input type="text" name="name" id="name" placeholder="" class="validate[required]" value="{$data.name}" />
        </div>
      </div>    

    </div>
    <div class="span6">
      <div class="control-group">
        <label class="control-label" for="images">Gambar</label>
        <div class="controls">
          <input type="text" class="form-control validate[required]" id="images" placeholder="url gambar" name="images" onchange="document.getElementById('view-images').src = this.value;" value="{str_replace('[baseurlroot]', $baseurlroot, $data.images)}">
          <a class="btn btn-small" href="javascript:browseImage('images')" title="Browse Image"><i class="splashy-image_cultured"></i></a>
          <img id="view-images" class="img-responsive img-thumbnail thumbnail" style="width:150px;height:120px;" src="{str_replace('[baseurlroot]', $baseurlroot, $data.images)}" />
        </div>
      </div>
      
    
      <div class="control-group">
        <div class="controls">
          <button type="submit" class="btn btn-primary" name="btnSubmit">Simpan</button>
          <button type="button" class="btn" onclick="ajaxpage('{$baseurl}/gallery', 'Data Gallery')" title="View Data"><i class="splashy-view_list"></i></button>
          <span id="loader-form" style="display:none;">Loading, please wait...</span>
        </div>
      </div>

    </div>
  </div>
  
  </fieldset>
</form>

<script>
$(document).ready(function(){
  initEditor();
});
</script>

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
    url : '{$baseurl}/gallery/query-update',	
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

