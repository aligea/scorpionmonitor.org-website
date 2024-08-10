<form class="form-horizontal" id="inputform" name="inputform" method="post" action="{$baseurl}/payment/validate">
  <fieldset class="well">
  <p class="f_legend">Add Payment Methode</p>
  <div class="row-fluid">
    <div class="span6">
    
      <div class="control-group">
        <label class="control-label" for="jenis">Pilih Jenis</label>
        <div class="controls">
          <select id="jenis" name="jenis">
          {foreach from=$datajenis item=obj}
            <option value="{$obj.value}">{$obj.text}</option>
          {/foreach}  
          </select>
        </div>
      </div>
      
      <div class="control-group">
        <label class="control-label" for="nama">Nama</label>
        <div class="controls">
          <input type="text" name="nama" id="nama" placeholder="" class="validate[required]" />
        </div>
      </div>
      
      <div class="control-group">
        <label class="control-label" for="rekening">No.Rekening</label>
        <div class="controls">
          <input type="text" name="rekening" id="rekening" placeholder="" class="validate[required]" />
        </div>
      </div>
      
      <div class="control-group">
        <label class="control-label" for="atas_nama">Atas Nama</label>
        <div class="controls">
          <input type="text" name="atas_nama" id="atas_nama" placeholder="" class="validate[required]" />
        </div>
      </div>

    </div>
    
    
    <div class="span6">
      <div class="control-group">
        <label class="control-label" for="logo">Logo</label>
        <div class="controls">
          <input type="text" class="form-control validate[]" id="logo" placeholder="url gambar" name="logo" onchange="document.getElementById('view-logo').src = this.value;">
          <a class="btn btn-small" href="javascript:browseImage('logo')" title="Browse Image"><i class="splashy-image_cultured"></i></a>
          <img id="view-logo" class="img-responsive img-thumbnail thumbnail" style="width:150px;height:120px;" />
        </div>
      </div>
      
      <div class="control-group">
        <div class="controls">
          <button type="submit" class="btn btn-primary" name="btnSubmit">Simpan</button>
          <button type="button" class="btn" onclick="ajaxpage('{$baseurl}/payment', 'Data Payment Methode')" title="View Data"><i class="splashy-view_list"></i></button>
          <span id="loader-form" style="display:none;">Loading, please wait...</span>
        </div>
      </div>
    </div>
  </div>
  
  
  </fieldset>
</form>
<script>
function browseImage(field_id){
	var url = "{$baseurl}/assets/responsive_filemanager/filemanager/dialog.php?type=1&popup=1&field_id=" + field_id;
	var browseWindow = window.open(url, 'Browse Gambar','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=900,height=500');
	browseWindow.focus();
}
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
    url : '{$baseurl}/payment/query-insert',	
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

