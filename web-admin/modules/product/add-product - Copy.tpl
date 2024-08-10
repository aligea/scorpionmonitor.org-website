<form class="form-horizontal" id="inputform" name="inputform" method="post" action="{$baseurl}/product/validate">
  <fieldset class="well">
  <p class="f_legend">Add Product</p>
  <div class="row-fluid">
    <div class="span6">
      <div class="control-group">
        <label class="control-label" for="tanggal">Tanggal</label>
        <div class="controls">
          <input type="text" class="validate[] datepicker" name="tanggal" id="tanggal" placeholder="Format : dd-mm-yyyy" value="{date('d-m-Y')}"  />
          <a class="btn btn-small" onclick="$('#tanggal').focus();"><i class="splashy-calendar_day"></i></a>
        </div>
      </div>
    
      <div class="control-group">
        <label class="control-label" for="category">Category</label>
        <div class="controls">
          <select name="category_id" id="category_id" class="select_chosen">
          {foreach from=$datacategory item=category}
            <option value="{$category.id}">{$category.parentcategory}{$category.name}</option>
          {/foreach}
          </select>
        </div>
      </div>
      
      <div class="control-group">
        <label class="control-label" for="name">Nama Produk</label>
        <div class="controls">
          <input type="text" name="name" id="name" placeholder="" class="validate[required]" />
        </div>
      </div>
      
      <div class="control-group">
        <label class="control-label" for="merek">Merek</label>
        <div class="controls">
          <input type="text" name="merek" id="merek" placeholder="" class="validate[]" />
        </div>
      </div>
      
      <div class="control-group">
        <label class="control-label" for="price">Harga (Rp.)</label>
        <div class="controls">
          <input type="text" name="price" id="price" placeholder="" class="validate[] angka" />
        </div>
      </div>
      
      <div class="control-group">
        <label class="control-label" for="special">Harga Spesial (Rp.)</label>
        <div class="controls">
          <input type="text" name="special" id="special" placeholder="" class="validate[] angka" />
        </div>
      </div>
      
      <div class="control-group">
        <label class="control-label" for="berat">Berat (Kg)</label>
        <div class="controls">
          <input type="text" name="berat" id="berat" placeholder="" class="validate[] angkakoma" />
        </div>
      </div>
      
      <div class="control-group">
        <label class="control-label" for="disc">Diskon (%)</label>
        <div class="controls">
          <input type="text" name="disc" id="disc" placeholder="" class="validate[] angkakoma" />
        </div>
      </div>

      <div class="control-group">
        <label class="control-label" for="simple">Introtext / simple desc</label>
        <div class="controls">
          <textarea id="simple" name="simple" class=""></textarea>
        </div>
      </div>
      
    </div>
    <div class="span6">
        <div class="control-group">
          <label for="setadd" class="control-label">Status</label>
          <div class="controls">
            <select name="status" id="status">
              <option value="Y">Tampilkan produk ini</option>
              <option value="N">Jangan tampilkan</option>
            </select>
          </div>
        </div>
    
        
      <div class="control-group">
        <label class="control-label" for="images">Gambar</label>
        <div class="controls">
          <input type="text" class="form-control validate[required]" id="images" placeholder="url gambar" name="images" onchange="document.getElementById('view-images').src = this.value;">
          <a class="btn btn-small" href="javascript:browseImage('images')" title="Browse Image"><i class="splashy-image_cultured"></i></a>
          <img id="view-images" class="img-responsive img-thumbnail thumbnail" style="width:150px;height:120px;" />
        </div>
      </div>
      
      
      
    
        <div class="control-group">
          <label for="setadd" class="control-label"></label>
          <div class="controls">
            <label for="new" class="radio"><input type="checkbox" name="new" id="new" value="Y"  /> New Product</label>
            <label for="featured" class="radio"><input type="checkbox" name="featured" id="featured" value="1" /> Featured Product</label>
            <label for="terlaris" class="radio"><input type="checkbox" name="terlaris" id="terlaris" value="1" /> Produk Terlaris</label>
          </div>
        </div>
    
    
      <div class="control-group">
        <div class="controls">
          <button type="submit" class="btn btn-primary" name="btnSubmit">Simpan</button>
          <button type="button" class="btn" onclick="ajaxpage('{$baseurl}/product', 'Data Produk')" title="View Data"><i class="splashy-view_list"></i></button>
          <span id="loader-form" style="display:none;">Loading, please wait...</span>
        </div>
      </div>

    </div>
  </div>
  
  <div class="row-fluid">
    <p><span class="label label-inverse">Tulis deskripsi disini : </span></p>
    <textarea name="description" id="description" cols="30" rows="10"></textarea>
  </div>
  </fieldset>
</form>

<link href="{$baseurl}/assets/plugins/CLEditor1_4_5/jquery.cleditor.css" type="text/css" rel="stylesheet" />
<script src="{$baseurl}/assets/plugins/CLEditor1_4_5/jquery.cleditor.min.js"></script>
<script src="{$baseurl}/assets/plugins/CLEditor1_4_5/jquery.cleditor.fullscreen.js"></script>
<script src="{$baseurl}/assets/plugins/CLEditor1_4_5/jquery.cleditor.rfm.js"></script>
<script>
$(document).ready(function(){
  $.cleditor.set_rfm('{$baseurl}/assets/responsive_filemanager/filemanager');
  $('#description').cleditor();
});
</script>

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
  //$('#berat').number(true, 2);
  //$('#disc').number(true, 2);
});

function submitForm(formElm){
  var konfirm = confirm('Yakin simpan data ini?');
  if(!konfirm){
    return false;
  }  
  $.ajax({
    url : '{$baseurl}/catproduct/query-insert',	
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

