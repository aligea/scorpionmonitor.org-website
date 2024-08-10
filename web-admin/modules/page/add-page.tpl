<div class="page-header">
  <h3>Add Pages</h3>
</div>

<form class="form-horizontal" id="inputform" name="inputform" method="post" action="{$baseurl}/page/validate">
  <div class="row">
    <div class="col-md-6">

      <div class="form-group">
        <label class="col-md-4 control-label" for="page">Module Page</label>
        <div class="col-md-8 ">
          <input type="text" name="alias" id="alias" class="form-control validate[required]"  placeholder="Page"/>
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-4 control-label" for="title">Judul</label>
        <div class="col-md-8 ">
          <input type="text" name="title" id="title" placeholder="Judul" class="form-control validate[required]" />
        </div>
      </div>

      <div class="form-group">
        <label class="control-label col-md-4" for="metakey">Meta Keyword</label>
        <div class="col-md-8">
          <textarea id="metakey" name="metakey" class="form-control">{$data.metakey}</textarea>
          <p class="help-block">Untuk keperluan mesin pencari</p>
        </div>
      </div>
    </div>

    <div class="col-md-6">

      <div class="form-group">
        <label class="control-label col-md-4" for="metadesc">Meta Description</label>
        <div class="col-md-8">
          <textarea id="metadesc" name="metadesc" class="form-control">{$data.metadesc}</textarea>
          <p class="help-block">Untuk keperluan mesin pencari</p>
        </div>
      </div>

    </div>


  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="box-footer" align="right">
          <button type="submit" class="btn btn-primary" name="btnSubmit">Simpan</button>
          <button type="button" class="btn btn-default" onclick="ajaxpage('{$baseurl}/page', 'Data Page')" title="View Data"><i class="fa fa-list"></i></button>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <p><span class="label label-inverse">Tulis isi halaman disini : </span></p>
      <textarea name="fulltext" id="fulltext" cols="30" rows="10" class="summernote"></textarea>
    </div>
  </div>
</form>

<script>
var activeEditor = {};
$(document).ready(function(){
  $('.summernote').summernote({
      height: 200,
	  onImageUpload: function(files) {
        sendFile(files[0], $(this));
      },
	  onFocus: function(event){
	    activeEditor = $(this);
	  }
  });
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
    url : '{$baseurl}/page/query-insert',	
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
		$(formElm)[0].reset();
		$('.summernote').code('');
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

