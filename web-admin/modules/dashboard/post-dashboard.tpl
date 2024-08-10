<div class="page-header">
<h1>{$allsettings.nama} - {$allsettings.metatitle}</h1>
</div>

<div class="row">
	<div class="col-md-6">
    	<h3>Artikel / Berita</h3>
        <button type="button" class="btn" onclick="ajaxpage('{$baseurl}/article/add', 'Add Article')"> <i class="fa fa-plus"></i> Tambah data artikel/berita</button>
        <button type="button" class="btn" onclick="ajaxpage('{$baseurl}/article/add', 'Add Article')"> <i class="fa fa-search"></i> Lihat data artikel/berita</button>
    </div>
    <div class="col-md-6">
    <h3>File / Gambar</h3>
    	<button type="button" class="btn" onclick="openFilemanager()"> <i class="fa fa-image"></i> Buka file gambar slideshow</button>
    </div>
	
</div>

<script>

function openFilemanager(){
	var url = "{$baseurl}/assets/responsive_filemanager/filemanager/dialog.php?type=1&popup=1&fldr=slideshow";
	var tinggi = 500;
	var lebar = 900;
	var left = (screen.width / 2) - (lebar / 2);
	var top = (screen.height / 2) - (tinggi / 2);
	var browseWindow = window.open(url, 'Browse Gambar','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width='+lebar+',height='+tinggi+'top='+top+', left='+left);
	browseWindow.focus();
}
</script>
