<form class="form-horizontal" id="inputform" name="inputform" method="post" action="{$baseurl}/courierrate/validate">
<input type="hidden" id="id" name="id" value="{$data.id}">
  <fieldset class="well">
  <p class="f_legend">Edit Courier Rate</p>
  <div class="row-fluid">
    <div class="span6">
    
      <div class="control-group">
        <label class="control-label" for="idKurir">Pilih Kurir</label>
        <div class="controls">
          <select id="idKurir" name="idKurir">
          {foreach from=$datakurir item=kurir}
            <option value="{$kurir.id}" {if $kurir.id == $data.idkurir} selected="selected" {/if}>{$kurir.nama}</option>
          {/foreach}  
          </select>
        </div>
      </div>
      
      <div class="control-group">
        <label class="control-label" for="nama">Provinsi/Kota</label>
        <div class="controls">
          <input type="text" name="provinsi" id="provinsi" placeholder="" class="validate[required]" value="{$data.provinsi}" />
        </div>
      </div>
      
      <div class="control-group">
        <label class="control-label" for="daerah">Daerah</label>
        <div class="controls">
          <input type="text" name="daerah" id="daerah" placeholder="" class="validate[required]" value="{$data.daerah}" />
        </div>
      </div>
      
      <div class="control-group">
        <label class="control-label" for="hargaok">Harga</label>
        <div class="controls">
          <input type="text" name="hargaok" id="hargaok" placeholder="" class="validate[required] angka" value="{$data.hargaok}" />
        </div>
      </div>
      
      <div class="control-group">
        <div class="controls">
          <button type="submit" class="btn btn-primary" name="btnSubmit">Simpan</button>
          <button type="button" class="btn" onclick="ajaxpage('{$baseurl}/courierrate', 'Data Courier Rates')" title="View Data"><i class="splashy-view_list"></i></button>
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
    url : '{$baseurl}/courierrate/query-update',	
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

