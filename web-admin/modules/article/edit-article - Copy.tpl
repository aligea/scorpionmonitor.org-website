<form class="form-horizontal" id="inputform" name="inputform" method="post" action="{$baseurl}/article/validate">
<input type="hidden" name="id" id="id" value="{$data.id}" />
  <fieldset class="well">
  <p class="f_legend">Edit Article</p>
  <div class="row-fluid">
    <div class="span6">
      <div class="control-group">
        <label class="control-label" for="tanggal">Tanggal</label>
        <div class="controls">
          <input type="text" class="validate[] datepicker" name="tanggal" id="tanggal" placeholder="Format : dd-mm-yyyy" value="{date('d-m-Y', strtotime($data.tanggal))}"  />
          <a class="btn btn-small" onclick="$('#tanggal').focus();"><i class="splashy-calendar_day"></i></a>
        </div>
      </div>
    
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
        <label class="control-label" for="name">Judul Artikel</label>
        <div class="controls">
          <input type="text" name="name" id="name" placeholder="" class="validate[required]" value="{$data.name}" />
        </div>
      </div>    

      <div class="control-group">
        <label class="control-label" for="simple">Ringkasan</label>
        <div class="controls">
          <textarea id="simple" name="simple" class="">{$data.simple}</textarea>
        </div>
      </div>
      
      <div class="control-group">
        <label class="control-label" for="keyword">Seo Meta Keyword</label>
        <div class="controls">
          <textarea id="keyword" name="keyword" class="">{$data.keyword}</textarea>
        </div>
      </div>
      
      <div class="control-group">
        <label class="control-label" for="metadesc">SEO Meta Description</label>
        <div class="controls">
          <textarea id="metadesc" name="metadesc" class="">{$data.metadesc}</textarea>
        </div>
      </div>
      
      
    </div>
    <div class="span6">
        <div class="control-group">
          <label for="setadd" class="control-label">Status</label>
          <div class="controls">
            <select name="status" id="status">
              <option value="1" {if $data.status == '1'} selected="selected" {/if}>Publikasikan</option>
              <option value="0" {if $data.status == '0'} selected="selected" {/if}>Jangan dipublikasi</option>
            </select>
          </div>
        </div>
    
        
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
          <button type="button" class="btn" onclick="ajaxpage('{$baseurl}/article', 'Data Artikel')" title="View Data"><i class="splashy-view_list"></i></button>
          <span id="loader-form" style="display:none;">Loading, please wait...</span>
        </div>
      </div>

    </div>
  </div>
  
  <div class="row-fluid">
    <p><span class="label label-inverse">Tulis deskripsi disini : </span></p>
    <textarea name="description" id="description" cols="30" rows="10" class="summernote">{str_replace('[baseurlroot]', $baseurlroot, $data.description)}</textarea>
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
    url : '{$baseurl}/article/query-update',	
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

