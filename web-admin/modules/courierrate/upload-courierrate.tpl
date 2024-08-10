<form class="form-horizontal" id="inputform" name="inputform" method="post" action="javascript:submitForm($('#inputform'))" enctype="multipart/form-data">
  <fieldset class="well">
  <p class="f_legend">Upload data tarif</p>
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
        <label class="control-label" for="nama">Pilih file</label>
        <div class="controls">
          <input type="file" id="myfile"  name="myfile" accept=".xls,.csv" >
        </div>
      </div>
      
      <div class="control-group">
        <div class="controls">
          <button type="submit" class="btn btn-primary" name="btnSubmit">Simpan</button>
          <button type="button" class="btn" onclick="ajaxpage('{$baseurl}/courierrate', 'Data Courier Rates')" title="View Data"><i class="splashy-view_list"></i></button>
          <span id="loader-form" style="display:none;">Loading, please wait...</span>
          <span id="loader-upload" style="display:none;">Harap tunggu, file sedang di upload ...</span>
        </div>
      </div>

    </div>
    
    
    <div class="span6">
      <p>
        Instruksi : 
        <ul>
          <li>Dowload contoh file <a href="{$baseurl}/uploads/temp-tarif.xls">disini</a>.</li>
        </ul>
      </p>
    </div>
  </div>
  
  </fieldset>
</form>
<div class="row-fluid">
<div class="responsive-table">
<table id="table-data" class="table table-responsive table-bordered table-striped">
  <thead>
  	<tr>
    	<th width="1">No.</th>
        <th>Provinsi/Kota</th>
        <th>Daerah</th>
        <th>Harga</th>
    </tr>
  </thead>
  <tbody>
  </tbody>
  <tfoot>
  </tfoot>
</table>
</div>
</div>



<link rel="stylesheet" type="text/css" href="{$baseurl}/assets/plugins/DataTables-1.10.7/media/css/jquery.dataTables.min.css">
<script type="text/javascript" charset="utf8" src="{$baseurl}/assets/plugins/DataTables-1.10.7/media/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function(){
		$('#table-data').dataTable({
			'destroy' : true,
			'data' : {}
		});

	$('#myfile').change(handleFileSelect);
});

function handleFileSelect(event) {
  var selectedFile = event.target.files[0];
  //console.log(selectedFile);
  if(selectedFile.type != 'application/vnd.ms-excel'){
  	$('#inputform')[0].reset();
    alert('File harus ber ekstensi .xls (Ms.Excel 97-2003)');
	return false;
  }
  
	var formData = new FormData();
	formData.append("myfile", selectedFile);
	
	$.ajax({
	  url: "{$baseurl}/courierrate/query-upload",
	  type: "POST",
	  data: formData,
	  processData: false,  // tell jQuery not to process the data
	  contentType: false,   // tell jQuery not to set contentType
	  beforeSend : function(){
	    $('#loader-upload').show();
	  },
	  complete: function(){
	    $('#loader-upload').hide();
	  },
	  success: function(response){
	  	var result = $.trim(response);
		if(result == 'berhasil'){
		  showUploadedFile();
		}else{
		  toastr["error"](response);
		}
	  }
	});
}
function showUploadedFile(){
  $.ajax({
    url: "{$baseurl}/courierrate/uploadedfile",
	type: "GET",
	beforeSend: function(){
	  $('#loader-form').show();
	},
	complete: function(){
	  $('#loader-form').hide();
	},
	error: function(){
	  toastr["error"]('Error when loading data.');
	},
	success: function(response){
	  var result = JSON.parse(response);
	  var objects = [];
	  for (index in result){
		var obj = result[index];
		var row = [obj.no, obj.provinsi, obj.daerah, obj.harga];
		objects.push(row);
	  }
	 
	  $('#table-data').dataTable({
		'destroy' : true,
		'data' : objects
	  });
	}	
  });
}
</script>

<script>
$(document).ready(function(){
  $("#inputform").validationEngine({
    ajaxFormValidation : false,
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
  var konfirm = confirm('Yakin simpan data ini ('+$("#idKurir option:selected").text()+') ?');
  if(!konfirm){
    return;
  }  
  $.ajax({
    url : '{$baseurl}/courierrate/query-saveuploaded',	
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
		$('#table-data').dataTable({
			'destroy' : true,
			'data' : {}
		});
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

