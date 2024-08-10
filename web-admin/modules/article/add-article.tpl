<div class="page-header">
  <h3>Tambah Artikel</h3>
</div>


<form class="form-horizontal" id="inputform" name="inputform" method="post" action="{$baseurl}/article/validate">
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label class="control-label col-md-4" for="tanggal">Tanggal</label>
        <div class="col-md-8">
          <div class="input-group">
            <input type="text" class="validate[] datepicker form-control" name="tanggal" id="tanggal" placeholder="Format : dd-mm-yyyy" value="{date('d-m-Y')}"  />
            <span class="input-group-btn"><a class="btn btn-default" onclick="$('#tanggal').focus();"><i class="fa fa-calendar"></i></a> </span>
          </div>
        </div>
      </div>
      
      <div class="form-group">
        <label class="control-label col-md-4" for="title">Judul Artikel</label>
        <div class="col-md-8">
          <input type="text" name="title" id="title" placeholder="" class="validate[required] form-control" />
        </div>
      </div>
      
      <div class="form-group">
        <label class="control-label col-md-4" for="introtext">Ringkasan</label>
        <div class="col-md-8">
          <textarea id="introtext" name="introtext" class="form-control"></textarea>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label class="control-label col-md-4" for="images">Gambar</label>
        <div class="col-md-8">
          <div class="input-group">
          <input type="text" class="form-control validate[required]" id="images" placeholder="url gambar" name="images" onchange="document.getElementById('view-images').src = this.value;">
          <span class="input-group-btn"><a class="btn btn-default" href="javascript:browseImage('images')" title="Browse Image"><i class="fa fa-folder-open"></i></a> </span>
          </div>
          
          <img id="view-images" class="img-responsive img-thumbnail thumbnail" style="width:150px;height:120px;" /> 
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
    <textarea name="fulltext" id="fulltext" cols="30" rows="10" class="summernote"></textarea>
  </div>
</form>
<script>
var activeEditor = {};
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
    url : '{$baseurl}/article/query-insert',	
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
		$('#view-images').attr('src', '');
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
