
   <div class="page-header">
     <h3>SETTINGS</h3>
   </div>

<form action="javascript:submitForm()" method="post" id="frmsetting" class="form-horizontal">
  <div class="nav-tabs-custom">  
    <ul class="nav nav-tabs" id="myTab">
      <li class="active"><a href="#tab-utama">Umum</a></li>
      <li><a href="#tab-kontak">Kontak</a></li>
      <li><a href="#tab-lainnya">Lainnya</a></li>
    </ul>
    
    <div class="tab-content">
      <div class="tab-pane active" id="tab-utama">
        <div class="row">
          <div class="col-md-6">
        <div class="form-group">
          <label for="nama" class="col-md-4 control-label">Nama</label>
          <div class="col-md-8">
            <input type="text" class="validate[required] form-control" value="{$allsettings.nama}" id="nama" name="nama">
          </div>
        </div>
        <div class="form-group">
          <label for="pengumuman" class="col-md-4 control-label">Pengumuman</label>
          <div class="col-md-8">
            <textarea id="pengumuman" class="form-control" name="pengumuman">{$allsettings.pengumuman}</textarea>
          </div>
        </div>
        <div class="form-group">
          <label for="maintenance" class="col-md-4 control-label">Status Website</label>
          <div class="col-md-8">
            <select id="maintenance" name="maintenance" class="form-control">
              <option value="online" {if $allsettings.maintenance == "online"} selected="selected" {/if}>Website Online</option>
              <option value="offline" {if $allsettings.maintenance == "offline"} selected="selected" {/if}>Maintenance</option>
            </select>
          </div>
        </div>        
        <div class="form-group">
          <label for="favico" class="col-md-4 control-label">Favico</label>
          <div class="col-md-8">
            <div class="input-group">
              <input type="text" value="{str_replace('[baseurlroot]', $baseurlroot, $allsettings.favico)}"  class="favico form-control" id="favico" name="favico">
              <span class="input-group-btn">
              	<a href="javascript:browseImage('favico');" class="btn btn-default" title="browse"><i class="fa fa-folder-open"></i></a>
              </span>
            </div>
          </div>
        </div>
                        
        <div class="form-group">
          <label for="logo" class="col-md-4 control-label">Logo</label>
          <div class="col-md-8">
          <div class="input-group">
          <input type="text" value="{str_replace('[baseurlroot]', $baseurlroot, $allsettings.logo)}" class="logo form-control" id="logo" name="logo">
          <span class="input-group-btn">
          <a href="javascript:browseImage('logo');" class="btn btn-default" title="browse"><i class="fa fa-folder-open"></i></a>
          </span>
          </div>
          </div>
        </div>
          
          </div>
          <div class="col-md-6">
        <div class="form-group">
          <label for="metatitle" class="col-md-4 control-label">Meta Title</label>
          <div class="col-md-8">
            <textarea id="metatitle" class="validate[required] form-control" name="metatitle">{$allsettings.metatitle}</textarea>
          </div>
        </div>
        <div class="form-group">
          <label for="metakey" class="col-md-4 control-label">Meta Keyword</label>
          <div class="col-md-8">
            <textarea id="metakey" class="validate[] form-control" name="metakey">{$allsettings.metakey}</textarea>
          </div>
        </div>
        <div class="form-group">
          <label for="metadesc" class="col-md-4 control-label">Meta Description</label>
          <div class="col-md-8">
            <textarea id="metadesc" class="validate[] form-control" name="metadesc">{$allsettings.metadesc}</textarea>
          </div>
        </div>
        <div class="form-group">
          <label for="setadd" class="col-md-4 control-label">Additional Image</label>
          <div class="col-md-8">
            <div class="radio">
              <label><input type="radio" name="setadd" id="setadd_1" value="1" {if $allsettings.setadd == 1} checked="checked" {/if} /> Ya</label>
            </div>
            <div class="radio">
              <label><input type="radio" name="setadd" id="setadd_0" value="0" {if $allsettings.setadd == 0} checked="checked" {/if} /> Tidak</label>
            </div>
          </div>
        </div>
          </div>
        </div>
      </div>
      <div class="tab-pane" id="tab-kontak">
        <div class="row">
          <div class="col-md-6">
        <div class="form-group">
          <label for="alamat" class="col-md-4 control-label">Alamat</label>
          <div class="col-md-8">
            <textarea id="alamat" name="alamat" class=" form-control">{$allsettings.alamat}</textarea>
          </div>
        </div>
        <div class="form-group">
          <label for="kota" class="col-md-4 control-label">Kota</label>
          <div class="col-md-8">
            <input type="text" value="{$allsettings.kota}" id="kota" name="kota" class="validate[] form-control">
          </div>
        </div>
        <div class="form-group">
          <label for="email" class="col-md-4 control-label">Email</label>
          <div class="col-md-8">
            <input type="text" value="{$allsettings.email}" id="email" name="email" class="validate[custom[email]] form-control">
          </div>
        </div>
        <div class="form-group">
          <label for="telpon" class="col-md-4 control-label">Telpon</label>
          <div class="col-md-8">
            <input type="text" value="{$allsettings.telpon}" class="validate[required] form-control" id="telpon" name="telpon">
          </div>
        </div>
        
          </div>
          <div class="col-md-6">
        <div class="form-group">
          <label for="facebook" class="col-md-4 control-label">Facebook</label>
          <div class="col-md-8">
            <input type="text" value="{$allsettings.facebook}" class="validate[] form-control" id="facebook" name="facebook">
          </div>
        </div>
        <div class="form-group">
          <label for="twitter" class="col-md-4 control-label">Twitter</label>
          <div class="col-md-8">
            <input type="text" value="{$allsettings.twitter}" class=" form-control" id="twitter" name="twitter">
          </div>
        </div>
        <div class="form-group">
          <label for="instagram" class="col-md-4 control-label">Instagram</label>
          <div class="col-md-8">
            <input type="text" value="{$allsettings.instagram}" class=" form-control" id="instagram" name="instagram">
          </div>
        </div>
          
          </div>
        </div>
      </div>
      
      
      <div class="tab-pane" id="tab-lainnya">
        <div class="row">
          <div class="col-md-6">
        <div class="form-group">
          <label for="" class="col-md-4 control-label">Ukuran gambar produk</label>
          <div class="col-md-8">
          <div class="row">
           <div class="col-xs-6">
            <input type="text" class="validate[required] form-control" name="image_product_width" id="image_product_width" placeholder="Lebar" value="{$allsettings.image_product_width}" />
           </div>
           <div class="col-xs-6"> 
            <input type="text" class="validate[required] form-control" name="image_product_height" id="image_product_height" placeholder="Tinggi" value="{$allsettings.image_product_height}" />
           </div> 
          </div>
          </div>
        </div>
        <div class="form-group">
          <label for="alamat" class="col-md-4 control-label">Ukuran gambar banner</label>
          <div class="col-md-8">
          <div class="row">
           <div class="col-xs-6"> 
            <input type="text" class="validate[required] input-mini form-control" name="image_banner_width" id="image_banner_width" placeholder="Lebar" value="{$allsettings.image_banner_width}" />
           </div>
           <div class="col-xs-6"> 
            <input type="text" class="validate[required] input-mini form-control" name="image_banner_height" id="image_banner_height" placeholder="Tinggi" value="{$allsettings.image_banner_height}" />
           </div>
          </div>
          </div>
        </div>
        <div class="form-group">
          <label for="path_user" class="col-md-4 control-label">Pilih template</label>
          <div class="col-md-8">
            <select name="path_user" id="path_user" class="form-control">
            {foreach from=$datatemplate item=namatemplate}
              <option value="{$namatemplate}">{$namatemplate}</option>
            {/foreach}  
            </select>
          </div>
        </div>
         
          </div>
          
          <div class="col-md-6">
        <div class="form-group">
          <label for="script_head" class="col-md-4 control-label">Script &lt;head&gt;</label>
          <div class="col-md-8">
            <textarea id="script_head" name="script_head" placeholder="Sisip skrip html di dalam tag head" class=" form-control">{$allsettings.script_head}</textarea>
          </div>
        </div>
        <div class="form-group">
          <label for="script_body" class="col-md-4 control-label">Script &lt;body&gt;</label>
          <div class="col-md-8">
            <textarea id="script_body" name="script_body"  placeholder="Sisip skrip html di dalam tag body" class=" form-control">{$allsettings.script_body}</textarea>
          </div>
        </div>
          </div>
        </div>
      </div>
    
    </div>
  </div>  
   
   <div class="box-footer">
    <div class="form-group">
      <div class="controls">
        <button class="btn btn-primary pull-right" type="submit">Simpan</button>
      </div>
    </div>        
   </div>
</form>

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
function browseImage(field_id){
	var url = "{$baseurl}/assets/responsive_filemanager/filemanager/dialog.php?type=1&popup=1&field_id=" + field_id;
	var browseWindow = window.open(url, 'Browse Gambar','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=900,height=500');
	browseWindow.focus();
}
</script>
<script>
$(document).ready(function(){
  $('#frmsetting').validationEngine();
  
});
function submitForm(){
  var formElm = $('#frmsetting');
  $.ajax({	
    type:'POST',
	url : '{$baseurl}/setting/query-update',
	data : formElm.serialize(),
	beforeSend : function(){
	  disableForm(formElm);
	},
	complete : function(){
	  activateForm(formElm);
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
function disableForm(formElm){
	var btnsave = $(formElm).find("[type=submit]");
	btnsave.attr('disabled', 'disabled');
	$('#loader-form').show();
}
function activateForm(formElm){
	var btnsave = $(formElm).find("[type=submit]");
	btnsave.removeAttr('disabled', 'disabled');
	$('#loader-form').hide();
}
</script>