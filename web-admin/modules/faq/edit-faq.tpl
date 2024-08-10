<form class="form-horizontal" id="inputform" name="inputform" method="post" action="javascript:void(0)">
<input type="hidden" id="id" name="id" value="{$data.id}" />
  <fieldset class="well">
  <p class="f_legend">Edit FAQ</p>
  <div class="row-fluid">
    <div class="span6">
      <strong>Tanya</strong>
      <div class="row-fluid">
        <textarea class="summernote" id="tanya" name="tanya">{str_replace('[baseurlroot]', $baseurlroot, $data.tanya)}</textarea>      
      </div>    

    </div>
    
    <div class="span6">
      <strong>Jawab</strong>
      <div class="row-fluid">
        <textarea class="summernote" id="jawab" name="jawab">{str_replace('[baseurlroot]', $baseurlroot, $data.jawab)}</textarea>
      </div>    

    </div>
  </div>
<div class="row-fluid">
      <div class="control-group">
        <div class="controls">
          <button type="submit" class="btn btn-primary" name="btnSubmit">Simpan</button>
          <button type="button" class="btn" onclick="ajaxpage('{$baseurl}/faq', 'Data FAQ')" title="View Data"><i class="splashy-view_list"></i></button>
          <span id="loader-form" style="display:none;">Loading, please wait...</span>
        </div>
      </div>
</div>
  
  </fieldset>
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
  $("#inputform").validationEngine();
  $('#inputform').submit(function(){
    submitForm($('#inputform'));
  });
});

function submitForm(formElm){
  var konfirm = confirm('Yakin simpan data ini?');
  if(!konfirm){
    return;
  }  
  $.ajax({
    url : '{$baseurl}/faq/query-update',	
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
		//$('.summernote').code('');
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

