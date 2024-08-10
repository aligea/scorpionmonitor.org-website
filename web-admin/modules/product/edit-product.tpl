<form class="form-horizontal" id="inputform" name="inputform" method="post" action="{$baseurl}/product/validate">
<input type="hidden" id="id" name="id" value="{$data.id}" />
  <fieldset class="well">
  <p class="f_legend">Edit Product</p>
  <div class="row-fluid">
    <ul class="nav nav-tabs" id="myTab">
      <li class="active"><a href="#tabUtama">Utama</a></li>
      <li><a href="#tabGambar">Gambar</a></li>
      <li><a href="#tabLainnya">Lainnya</a></li>
    </ul>
	<div class="tab-content">
      <div class="tab-pane active" id="tabUtama">
      <div class="row-fluid">
        <div class="span6">
          <div class="control-group">
            <label class="control-label" for="tanggal">Tanggal</label>
            <div class="controls">
              <input type="text" class="validate[] datepicker" name="tanggal" id="tanggal" placeholder="Format : dd-mm-yyyy" value="{date('d-m-Y', strtotime($data.tanggal))}"  />
              <a class="btn btn-small" onclick="$('#tanggal').focus();"><i class="splashy-calendar_day"></i></a>
            </div>
          </div>
        
          <div class="control-group">
            <label class="control-label" for="category">Category</label>
            <div class="controls">
              <select name="category_id" id="category_id" class="select_chosen">
              {foreach from=$datacategory item=category}
                <option value="{$category.id}" {if $category.id == $category_id} selected="selected" {/if}>{$category.parentcategory}{$category.name}</option>
              {/foreach}
              </select>
            </div>
          </div>
          
          <div class="control-group">
            <label class="control-label" for="name">Nama Produk</label>
            <div class="controls">
              <input type="text" name="name" id="name" placeholder="" class="validate[required]" value="{$data.name}" />
            </div>
          </div>
          
          <div class="control-group">
            <label class="control-label" for="merek">Merek</label>
            <div class="controls">
              <input type="text" name="merek" id="merek" placeholder="" class="validate[]" value="{$data.merek}" />
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="simple">Ringkasan Produk</label>
            <div class="controls">
              <textarea id="simple" name="simple" class="">{$data.simple}</textarea>
            </div>
          </div>
        
        </div>
        <div class="span6">
          <div class="control-group">
            <label class="control-label" for="price">Harga (Rp.)</label>
            <div class="controls">
              <input type="text" name="price" id="price" placeholder="" class="validate[] angka" value="{$data.price}" />
            </div>
          </div>
          
          <div class="control-group">
            <label class="control-label" for="special">Harga Spesial (Rp.)</label>
            <div class="controls">
              <input type="text" name="special" id="special" placeholder="" class="validate[] angka" value="{$data.spesial}" />
            </div>
          </div>
          
          <div class="control-group">
            <label class="control-label" for="berat">Berat (Kg)</label>
            <div class="controls">
              <input type="text" name="berat" id="berat" placeholder="" class="validate[] angkakoma" value="{$data.berat}" />
            </div>
          </div>
          
          <div class="control-group">
            <label class="control-label" for="disc">Diskon (%)</label>
            <div class="controls">
              <input type="text" name="disc" id="disc" placeholder="" class="validate[min[0], max[100]] angka" value="{$data.disc}" />
            </div>
          </div>
        
          <div class="control-group">
            <label class="control-label" for="qty">Qty (item)</label>
            <div class="controls">
              <input type="text" name="qty" id="qty" placeholder="" class="validate[] angka" value="{$data.qty}" />
            </div>
          </div>
        </div>
      </div>
    
      <div class="row-fluid">
        <p><span class="label label-inverse">Tulis deskripsi produk disini : </span></p>
        <textarea name="description" id="description" cols="30" rows="3" class="summernote">{str_replace('[baseurlroot]', $baseurlroot, $data.description)}</textarea>
      </div>

      </div>
      
      <div class="tab-pane" id="tabGambar" title="Gambar">
      <div class="row-fluid">
        <div class="span6">
          <div class="control-group">
            <label class="control-label" for="images">Gambar utama</label>
            <div class="controls">
              <input type="text" class="form-control validate[required]" id="images" placeholder="url gambar" name="images" onchange="document.getElementById('view-images').src = this.value;" value="{str_replace('[baseurlroot]', $baseurlroot, $data.images)}">
              <a class="btn btn-small" href="javascript:browseImage('images')" title="Browse Image"><i class="splashy-image_cultured"></i></a>
              <img id="view-images" class="img-responsive img-thumbnail thumbnail" style="width:150px;height:120px;" src="{str_replace('[baseurlroot]', $baseurlroot, $data.images)}" />
            </div>
          </div>
        </div>
        <div class="span6">
          <div class="control-group">
            <label class="control-label" for="images_additional">Gambar tambahan </label>
            <div class="controls">
              <input type="text" class="form-control validate[]" id="images_additional" placeholder="url gambar" >
              <a class="btn btn-small" href="javascript:browseImage('images_additional')" title="Browse Image"><i class="splashy-image_cultured"></i></a>
              <a id="addImages" href="javascript:tambahGambar();" class="btn btn" title="Tambahkan gambar ini"><i class="splashy-add"></i></a>
            </div>
          </div>
        
          <table class="table table-hover table-condensed ">
            <tbody id="tabelgambar">
            {$images_additional = json_decode($data.images_additional, true)}
            {$index = 1}
            {foreach from=$images_additional item=image}
              <tr id="row_a{$index}">
                <td>
                  <a class="cbox_single cboxElement" title="{str_replace('[baseurlroot]', $baseurlroot, $image)}" href="{str_replace('[baseurlroot]', $baseurlroot, $image)}">{str_replace('[baseurlroot]', $baseurlroot, $image)}</a>
                  <input type="hidden" name="imgadd[a{$index}]" id="imgadd_a{$index}" value="{str_replace('[baseurlroot]', $baseurlroot, $image)}" />
                </td>
                <td><a href="javascript:hapusGambar('a{$index}');" title="Hapus gambar ini"><i class="icon icon-remove"></i></a></td>
              </tr>
              {$index = $index + 1}
            {/foreach}  
            </tbody>
          </table>
        </div>
      </div>
      </div>
      
      <div class="tab-pane" id="tabLainnya" title="Lainnya">
      <div class="row-fluid">
        <div class="span6">
        {$atribut = json_decode($data.atribut, true)}
        {$atribut2 = json_decode($data.atribut2, true)}
        <div class="control-group">
          <label for="atribut_name" class="control-label">Nama Atribut ke 1</label>
          <div class="controls">
            <select name="atribut_name" id="atribut_name">
              <option value="" selected="selected">Tidak ada atribut</option>
            {foreach from=$dataatribut item=attr}  
              <option value="{ucfirst($attr)}" {if $atribut.name == $attr} selected="selected" {/if}>{$attr}</option>
            {/foreach}
            </select>
          </div>
        </div>
        <div class="control-group">
          <label for="atribut_data" class="control-label">Data Atribut ke 1</label>
          <div class="controls">
            <textarea name="atribut_data" id="atribut_data">{$atribut.data}</textarea>
            <span class="help-block">Gunakan tanda ' ; ' (titik koma) sebagai pemisah </span>
          </div>
        </div>
        
        <div class="control-group">
          <label for="atribut2_name" class="control-label">Nama Atribut ke 2</label>
          <div class="controls">
            <select name="atribut2_name" id="atribut2_name">
              <option value="" selected="selected">Tidak ada atribut</option>
            {foreach from=$dataatribut item=attr}  
              <option value="{ucfirst($attr)}" {if $atribut2.name == $attr} selected="selected" {/if}>{$attr}</option>
            {/foreach}
            </select>
          </div>
        </div>
        
        <div class="control-group">
          <label for="atribut2_data" class="control-label">Data Atribut ke 2</label>
          <div class="controls">
            <textarea name="atribut2_data" id="atribut2_data">{$atribut2.data}</textarea>
            <span class="help-block">Gunakan tanda ' ; ' (titik koma) sebagai pemisah </span>
          </div>
        </div>
        
        </div>
        <div class="span6">
        <div class="control-group">
          <label for="tag" class="control-label">Tag</label>
          <div class="controls">
            <textarea name="tag" id="tag">{$data.tag}</textarea>
            <span class="help-block">Gunakan tanda ' ; ' (titik koma) sebagai pemisah </span>
          </div>
        </div>

        <div class="control-group">
          <label for="setadd" class="control-label">Status</label>
          <div class="controls">
            <select name="status" id="status">
              <option value="Y" {if $data.status == 'Y'} selected="selected" {/if}>Tampilkan produk ini</option>
              <option value="N" {if $data.status == 'N'} selected="selected" {/if}>Jangan tampilkan</option>
            </select>
          </div>
        </div>
        
            <div class="control-group">
              <label for="setadd" class="control-label"></label>
              <div class="controls">
                <label for="new" class="radio"><input type="checkbox" name="new" id="new" value="Y" {if $data.new == 'Y'} checked="checked" {/if} /> New Product</label>
                <label for="featured" class="radio"><input type="checkbox" name="featured" id="featured" value="1" {if $data.featured == '1'} checked="checked" {/if} /> Featured Product</label>
                <label for="terlaris" class="radio"><input type="checkbox" name="terlaris" id="terlaris" value="1" {if $data.terlaris == '1'} checked="checked" {/if} /> Produk Terlaris</label>
              </div>
            </div>
        </div>
      </div>  
      </div>
      
    </div>
  </div>
  <div class="row-fluid">
      <div class="control-group">
        <div class="controls">
          <button type="submit" class="btn btn-primary" name="btnSubmit">Simpan</button>
          <button type="button" class="btn" onclick="ajaxpage('{$baseurl}/product', 'Data Produk')" title="View Data"><i class="splashy-view_list"></i></button>
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

<style>
.tab-content{
overflow:hidden;
}
.nav-tabs{
border:1px thin #000;;
}
</style>
<script>
  $('#myTab a').click(function(e) {
	e.preventDefault();
	$(this).tab('show');
  });
</script>


<script>
var autoId = 1;

function hapusGambar(rowId){
  var konfirm = confirm("Yakin hapus gambar ini ?");
  if(!konfirm){
    return;
  }
  $('#row_'+rowId).remove();
}

function tambahGambar(){
  var urlgambar = $('#images_additional').val();
  var tr = document.createElement('tr');
  
  if(urlgambar == ""){
    toastr["error"]("Harap isi url gambar terlebih dahulu.");
	return;
  }
  
  tr.id = 'row_' + autoId;
  tr.innerHTML += '<td><a class="cbox_single cboxElement" title="'+urlgambar+'" href="'+urlgambar+'">'+urlgambar+'</a><input type="hidden" name="imgadd['+autoId+']" id="imgadd_'+autoId+'" value="'+urlgambar+'" /></td>';
  tr.innerHTML += '<td><a href="javascript:hapusGambar(\''+autoId+'\');" title="Hapus gambar ini"><i class="icon icon-remove"></i></a></td>';
  autoId++;
  $('#tabelgambar').append(tr);
  $('#images_additional').val(null);
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
    url : '{$baseurl}/product/query-update',	
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

