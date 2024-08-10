<form action="javascript:submitForm()" method="post" id="frmsetting" class="form-horizontal well">
  <div class="row-fluid">
        <div class="span6">
        <h3 class="heading">Common Settings</h3>
        <div class="control-group">
          <label for="nama" class="control-label">Nama</label>
          <div class="controls">
            <input type="text" class="validate[required]" value="{$setting.nama}" id="nama" name="nama">
          </div>
        </div>
        <div class="control-group">
          <label for="pengumuman" class="control-label">Pengumuman</label>
          <div class="controls">
            <textarea id="pengumuman" class="" name="pengumuman">{$setting.pengumuman}</textarea>
          </div>
        </div>
        <div class="control-group">
          <label for="maintenance" class="control-label">Status Website</label>
          <div class="controls">
            <select id="maintenance" name="maintenance">
              <option value="online" {if $setting.maintenance == "online"} selected="selected" {/if}>Website Online</option>
              <option value="offline" {if $setting.maintenance == "offline"} selected="selected" {/if}>Maintenance</option>
            </select>
          </div>
        </div>        
        <!--<div style="display:;" class="control-group">
          <label for="path_user" class="control-label">Template</label>
          <div class="controls">
           <select id="path_user" name="path_user">
             <option selected="selected" value="001">001</option>
           </select>
          </div>
        </div> -->
        <div class="control-group">
          <label for="favico" class="control-label">Favico {$baseurlroot}</label>
          <div class="controls">
              <input type="text" value="{$setting.favico}"  class="favico" id="favico" name="favico">
              <a href="javascript:browseImage('favico');" class="btn btn-small"><i class="splashy-image_cultured"></i></a>
              <!--<div class="row-fluid"><img style="width:50px; height:50px;" title="view-favico" id="view-favico" src="../images/favico.png" class="img-polaroid"></div> -->
          </div>
        </div>
                        
        <div class="control-group">
          <label for="logo" class="control-label">Logo</label>
          <div class="controls">
          <input type="text" value="{str_replace('[baseurlroot]', $baseurlroot, $setting.logo)}" class="logo" id="logo" name="logo">
          <a href="javascript:browseImage('logo');" class="btn btn-small"><i class="splashy-image_cultured"></i></a>
          <!--<div class="row-fluid"><img style="width:100px; height:100px;" title="view-logo" id="view-logo" src="../images/banner4.jpg" class="img-polaroid"></div> -->
          </div>
        </div>
        
        <div class="control-group">
          <label for="metakey" class="control-label">Meta Keyword</label>
          <div class="controls">
            <textarea id="metakey" class="validate[]" name="metakey">{$setting.metakey}</textarea>
          </div>
        </div>
        <div class="control-group">
          <label for="metadesc" class="control-label">Meta Description</label>
          <div class="controls">
            <textarea id="metadesc" class="validate[]" name="metadesc">{$setting.metadesc}</textarea>
          </div>
        </div>
        <div class="control-group">
          <label for="metatitle" class="control-label">Meta Title</label>
          <div class="controls">
            <textarea id="metatitle" class="validate[required]" name="metatitle">{$setting.metatitle}</textarea>
          </div>
        </div>
        <div class="control-group">
          <label for="setadd" class="control-label">Additional Image</label>
          <div class="controls">
            <label for="setadd_1" class="radio"><input type="radio" name="setadd" id="setadd_1" value="1" {if $setting.setadd == 1} checked="checked" {/if} /> Ya</label>
            <label for="setadd_0" class="radio"><input type="radio" name="setadd" id="setadd_0" value="0" {if $setting.setadd == 0} checked="checked" {/if} /> Tidak</label>
          </div>
        </div>
        </div>
        
        <div class="span6">
        <h3 class="heading">Contact Information</h3>
        <div class="control-group">
          <label for="alamat" class="control-label">Alamat</label>
          <div class="controls">
            <textarea id="alamat" name="alamat">{$setting.alamat}</textarea>
          </div>
        </div>
        <div class="control-group">
          <label for="kota" class="control-label">Kota</label>
          <div class="controls">
            <input type="text" value="{$setting.kota}" id="kota" name="kota" class="validate[]">
          </div>
        </div>
        <div class="control-group">
          <label for="email" class="control-label">Email</label>
          <div class="controls">
            <input type="text" value="{$setting.email}" id="email" name="email" class="validate[custom[email]]">
          </div>
        </div>
        <div class="control-group">
          <label for="telpon" class="control-label">Telpon</label>
          <div class="controls">
            <input type="text" value="{$setting.telpon}" class="validate[required]" id="telpon" name="telpon">
          </div>
        </div>
        
        <div class="control-group">
          <label for="facebook" class="control-label">Facebook</label>
          <div class="controls">
            <input type="text" value="{$setting.facebook}" class="validate[]" id="facebook" name="facebook">
          </div>
        </div>
        <div class="control-group">
          <label for="twitter" class="control-label">Twitter</label>
          <div class="controls">
            <input type="text" value="{$setting.twitter}" class="" id="twitter" name="twitter">
          </div>
        </div>
        
        <!--<div class="control-group">
          <label for="twitter" class="control-label">Wechat</label>
          <div class="controls">
            <input type="text" value="{$setting.wechat}" class="validate[]" id="wechat" name="wechat">
          </div>
        </div>
        <div class="control-group">
          <label for="twitter" class="control-label">Line</label>
          <div class="controls">
            <input type="text" value="{$setting.line}" class="validate[]" id="line" name="line">
          </div>
        </div>
        <div class="control-group">
          <label for="twitter" class="control-label">YM1</label>
          <div class="controls">
            <input type="text" value="{$setting.ym1}" class="" id="ym1" name="ym1">
          </div>
        </div>
        
        <div class="control-group">
          <label for="twitter" class="control-label">YM2</label>
          <div class="controls">
            <input type="text" value="{$setting.ym2}" class="span10" id="ym2" name="ym2">
          </div>
        </div>
        
        <div class="control-group">
          <label for="twitter" class="control-label">Pin BB</label>
          <div class="controls">
            <input type="text" value="{$setting.bb}" class="" id="bb" name="bb">
          </div>
        </div>
        
        <div class="control-group">
          <label for="twitter" class="control-label">Skype</label>
          <div class="controls">
            <input type="text" value="{$setting.skype}" class="" id="skype" name="skype">
          </div>
        </div>
        
        <div class="control-group">
          <label for="twitter" class="control-label">Whatsapp</label>
          <div class="controls">
            <input type="text" value="{$setting.whatsapp}" class="validate[]" id="whatsapp" name="whatsapp">
          </div>
        </div> -->
        
    <div class="control-group">
      <div class="controls">
        <button class="btn btn-primary" type="submit">Simpan</button>
        <span style="display:none;" class="loader-form">Loading, please wait ...</span>
      </div>
    </div>        
        </div>
  </div>
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