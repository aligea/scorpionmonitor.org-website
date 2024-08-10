<div class="page-header">
  <h3>Edit Artikel</h3>
</div>
<form class="form-horizontal" id="inputform" name="inputform" method="post" action="{$baseurl}/article/validate">
<input type="hidden" name="id" id="id" value="{$data.id}" />
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label class="control-label col-md-4" for="tanggal">Tanggal</label>
        <div class="col-md-8">
          <div class="input-group">
            <input type="text" class="validate[] datepicker form-control" name="tanggal" id="tanggal" placeholder="Format : dd-mm-yyyy" value="{date('d-m-Y', strtotime($data.publish_up))}"  />
            <span class="input-group-btn"><a class="btn btn-default" onclick="$('#tanggal').focus();"><i class="fa fa-calendar"></i></a> </span>
          </div>
        </div>
      </div>
      
      <div class="form-group">
        <label class="control-label col-md-4" for="title">Judul Artikel</label>
        <div class="col-md-8">
          <input type="text" name="title" id="title" placeholder="" class="validate[required] form-control" value="{$data.title}" />
        </div>
      </div>
      
      <div class="form-group">
        <label class="control-label col-md-4" for="introtext">Ringkasan</label>
        <div class="col-md-8">
          <textarea id="introtext" name="introtext" class="form-control">{$data.introtext}</textarea>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-md-4" for="metakey">Meta Keyword</label>
        <div class="col-md-8">
          <textarea id="metakey" name="metakey" class="form-control">{$data.metakey}</textarea>
          <p class="help-block">Untuk keperluan mesin pencari</p>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-md-4" for="metadesc">Meta Description</label>
        <div class="col-md-8">
          <textarea id="metadesc" name="metadesc" class="form-control">{$data.metadesc}</textarea>
          <p class="help-block">Untuk keperluan mesin pencari</p>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label class="control-label col-md-4" for="alias">Alias/nama halaman</label>
        <div class="col-md-8">
          <input type="text" name="alias" id="alias" placeholder="" class="validate[required] form-control" value="{$data.alias}" />
          <p class="help-block">Sebaiknya jangan diubah.</p>
        </div>
      </div>
      
      <div class="form-group">
        <label class="control-label col-md-4" for="state">Publikasi</label>
        <div class="col-md-8">
          <select id="state" name="state" class="form-control">
            <option value="1" {if $data.state == '1'} selected="selected" {/if}>Ya</option>
            <option value="0" {if $data.state == '0'} selected="selected" {/if}>Tidak. Jangan tampilkan.</option>
          </select>
        </div>
      </div>
      
      <div class="form-group">
        <label class="control-label col-md-4" for="images">Gambar</label>
        <div class="col-md-8">
          <div class="input-group">
          <input type="text" class="form-control validate[required]" id="images" placeholder="url gambar" name="images" onchange="document.getElementById('view-images').src = this.value;" value="{str_replace('[baseurlroot]', $baseurlroot, $data.images)}">
          <span class="input-group-btn"><a class="btn btn-default" href="javascript:browseImage('images')" title="Browse Image"><i class="fa fa-folder-open"></i></a> </span>
          </div>
          
          <img id="view-images" class="img-responsive img-thumbnail thumbnail" src="{str_replace('[baseurlroot]', $baseurlroot, $data.images)}" style="width:150px;height:120px;" /> 
        </div>
      </div>
      
      <div class="box-footer" align="right">
          <button type="submit" class="btn btn-primary" name="btnSubmit">Simpan</button>
          <button type="button" class="btn btn-default" onclick="ajaxpage('{$baseurl}/article', 'Data Artikel')" title="View Data"><i class="fa fa-list"></i></button>
      </div>
      
    </div>
  </div>
  <div class="row">
    <label>Tulis isi artikel disini...</label>
    <textarea name="fulltext" id="fulltext" cols="30" rows="10" class="summernote">{str_replace('[baseurlroot]', $baseurlroot, $data.fulltext)}</textarea>
  </div>
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

