<form class="form-horizontal" id="inputform" name="inputform" method="post" action="{$baseurl}/auth/validate">

  <fieldset class="well">
  <p class="f_legend">Otorisasi</p>
  <div class="row-fluid">
    <div class="span6">
    
      <div class="control-group">
        <label class="control-label" for="idgrupuser">Grup User</label>
        <div class="controls">
          <select id="idgrupuser" name="idgrupuser" onchange="loadModulAdmin()">
          {foreach from=$datagrupuser item=obj}
            <option value="{$obj.id}" {if $obj.id == $selectedgrup.id} selected="selected" {/if} >{$obj.grupuser}</option>
          {/foreach}  
          </select>
        </div>
      </div>
      
    </div>
    
    
    <div class="span6">      
      
      <div class="control-group">
        <div class="controls">
          <button type="submit" class="btn btn-primary" name="btnSubmit">Simpan</button>
          <button type="button" class="btn" onclick="ajaxpage('{$baseurl}/groupuser', 'Data Grup user')" title="View Data"><i class="splashy-view_list"></i></button>
          <span id="loader-form" style="display:none;">Loading, please wait...</span>
        </div>
      </div>
    </div>
  </div>
  
  </fieldset>
  
  <div class="row-fluid">
    <div class="table-responsive">
      <table id="view-auth-table" class="table table-hover table-bordered table-condensed">
        <thead>
          <tr>
            <th width="10">
              <label class="checkbox" title="Pilih Semua">
                <input type="checkbox" onchange="$('#view-auth-table input[type=checkbox]').prop('checked', $(this).prop('checked'));" id="checkall" />
              </label>
            </th>
            <th>Grup</th>
            <th>Module</th>
            <th width="75">
              <label class="checkbox" title="Pilih Semua - View">
                <input type="checkbox" onchange="$('.kolom-view').prop('checked', $(this).prop('checked'));">
				<b>View</b>
			  </label>
			</th>
            <th width="75">
              <label class="checkbox" title="Pilih Semua - Add">
                <input type="checkbox" onchange="$('.kolom-add').prop('checked', $(this).prop('checked'));">
				<b>Add</b>
			  </label>
			</th>
            <th width="75">
              <label class="checkbox"  title="Pilih Semua - Edit">
                <input type="checkbox" onchange="$('.kolom-edit').prop('checked', $(this).prop('checked'));">
				<b>Edit</b>
			  </label>
			</th>
            <th width="75">
              <label class="checkbox"  title="Pilih Semua - Delete">
                <input type="checkbox"  onchange="$('.kolom-delete').prop('checked', $(this).prop('checked'));">
				<b>Delete</b>
			  </label>
			</th>
          </tr>
        </thead>
        <tbody>
        {$urutbaris = 1}
        {foreach from=$datamodule item=modul}
          <tr id="baris-{$urutbaris}">
            <td>
              <label class="checkbox"><input type="checkbox" class="check-baris" onchange="$('.kolom-baris-{$urutbaris}').prop('checked', $(this).prop('checked'));" /></label>
              <input type="hidden" name="idmodul[{$modul.id}]" id="idmodul_{$modul.id}" value="{$modul.id}" />
            </td>
            <td>{$modul.groupmenu}</td>
            <td>{$modul.menu}</td>
            <td>
              <label class="checkbox" title="View - {$modul.menu}">
                <input type="checkbox" class="kolom-baris-{$urutbaris} kolom-view" value="1" name="is_can_view[{$modul.id}]" id="is_can_view_{$modul.id}" />
              </label>
            </td>
            <td>
              <label class="checkbox" title="Add - {$modul.menu}">
                <input type="checkbox" class="kolom-baris-{$urutbaris} kolom-add single_module-{$modul.id}" value="1" name="is_can_insert[{$modul.id}]" id="is_can_insert_{$modul.id}" />
              </label>
            </td>
            <td>
              <label class="checkbox"  title="Edit - {$modul.menu}">
                <input type="checkbox" class="kolom-baris-{$urutbaris} kolom-edit single_module-{$modul.id}" value="1" name="is_can_update[{$modul.id}]" id="is_can_update_{$modul.id}" />
              </label>
            </td>
            <td>
              <label class="checkbox"  title="Delete - {$modul.menu}">
                <input type="checkbox" class="kolom-baris-{$urutbaris} kolom-delete single_module-{$modul.id}" value="1" name="is_can_delete[{$modul.id}]" id="is_can_delete_{$modul.id}" />
              </label>
            </td>
          </tr>
          {$urutbaris = $urutbaris + 1}
        {/foreach}
        </tbody>
      </table>
    </div>
  </div>
</form>

<style>
#view-auth-table label{
margin-bottom:0;
}
</style>
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
  $('#checkall').change(function(){
	//console.log($(this).prop('checked')); 
  });
  loadModulAdmin();
});

function loadModulAdmin(){
  var formElm = $('#inputform');
  $.ajax({
	type : 'POST',
	url : '{$baseurl}/auth/data',
	data : {
	  'idgrupuser' : $('#idgrupuser').val()
	},
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
	  var result = $.parseJSON(response);
	  $('#view-auth-table input[type=checkbox]').prop('checked', false);
	  $.each(result.data, function(key, value){
		  $('#is_can_view_'+value.idmodul).prop('checked', (value.is_can_view == 1)? true : false);
		  $('#is_can_insert_'+value.idmodul).prop('checked', (value.is_can_insert == 1)? true : false);
		  $('#is_can_update_'+value.idmodul).prop('checked', (value.is_can_update == 1)? true : false);
		  $('#is_can_delete_'+value.idmodul).prop('checked', (value.is_can_delete == 1)? true : false);
		  
		  $('.single_module-'+value.idmodul).removeAttr('disabled', 'disabled');
		  $('.single_module-'+value.idmodul).show();
		  if(value.single_module == 1){	
		    $('.single_module-'+value.idmodul).attr('disabled', 'disabled');
			$('.single_module-'+value.idmodul).hide();
		  }
	  });
	}
  });	
}


function submitForm(formElm){
  var konfirm = confirm('Yakin simpan data ini?');
  if(!konfirm){
    return;
  }  
  $.ajax({
    url : '{$baseurl}/auth/query-update',	
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

