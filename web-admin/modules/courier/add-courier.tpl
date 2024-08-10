<form class="form-horizontal" id="inputform" name="inputform" method="post" action="{$baseurl}/courier/validate">
  <fieldset class="well">
  <p class="f_legend">Add Courier</p>
  <div class="row-fluid">
    <div class="span6">
      
      <div class="control-group">
        <label class="control-label" for="nama">Nama</label>
        <div class="controls">
          <input type="text" name="nama" id="nama" placeholder="" class="validate[required]" />
        </div>
      </div>
      
      <div class="control-group">
        <label class="control-label" for="status">Status</label>
        <div class="controls">
          <select name="status" id="status">
            <option value="Y">Aktif</option>
            <option value="N">Nonaktif</option>            
          </select>
        </div>
      </div>

      <div class="control-group">
        <label class="control-label" for="keterangan">Keterangan</label>
        <div class="controls">
          <textarea name="keterangan" id="keterangan" class=""></textarea>
        </div>
      </div>
      
      <div class="control-group">
        <div class="controls">
          <button type="submit" class="btn btn-primary" name="btnSubmit">Simpan</button>
          <button type="button" class="btn" onclick="ajaxpage('{$baseurl}/courier', 'Data Courier')" title="View Data"><i class="splashy-view_list"></i></button>
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
    url : '{$baseurl}/courier/query-insert',	
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

