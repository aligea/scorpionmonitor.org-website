<div class="sidebar">
  <div class="antiScroll2">
    <div class="antiscroll-inner2">
      <div class="antiscroll-content">
        <div class="sidebar_inner">
          <form action="index.php?uid=1&amp;page=search_page" class="input-append" method="post" >
            <input autocomplete="off" name="query" class="search_query input-medium" size="16" type="text" placeholder="Search..." />
            <button type="submit" class="btn"><i class="icon-search"></i></button>
          </form>
          <div id="side_accordion" class="accordion">
            <div class="accordion-group">
              <div class="accordion-heading"> <a href="#collapseSettings" data-parent="#side_accordion" data-toggle="collapse" class="accordion-toggle"> <i class="icon-cog"></i> Settings </a> </div>
              <div class="accordion-body collapse" id="collapseSettings">
                <div class="accordion-inner">
                  <ul class="nav nav-list">
                    <li><a href="{$baseurl}/dashboard" title="Dashboard" class="ajaxpage">Dashboard</a></li>
                    <li><a href="{$baseurl}/profile" title="Profile" class="ajaxpage">Account Setting</a></li>
                    <li><a href="{$baseurl}/setting" title="Setting" class="ajaxpage">Setting Perusahaan</a></li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="accordion-group">
              <div class="accordion-heading"> <a href="#collapseProduk" data-parent="#side_accordion" data-toggle="collapse" class="accordion-toggle"> <i class="icon-list"></i> Produk </a> </div>
              <div class="accordion-body collapse" id="collapseProduk">
                <div class="accordion-inner">
                  <ul class="nav nav-list">
                    <li><a href="{$baseurl}/catproduct" title="Kategori Produk" class="ajaxpage">Data Kategori Produk</a></li>
                    <li><a href="{$baseurl}/product" title="Data Produk" class="ajaxpage">Data Produk</a></li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="accordion-group">
              <div class="accordion-heading"> <a href="#collapseTransaksi" data-parent="#side_accordion" data-toggle="collapse" class="accordion-toggle"> <i class="icon-shopping-cart"></i> Transaksi </a> </div>
              <div class="accordion-body collapse" id="collapseTransaksi">
                <div class="accordion-inner">
                  <ul class="nav nav-list">
                    <li><a href="{$baseurl}/customer" title="Data Customer" class="ajaxpage">Data Customer</a></li>
                    <li><a href="{$baseurl}/payment" title="Data Payment" class="ajaxpage">Data Payment</a></li>
                    <li><a href="{$baseurl}/transaction" title="Data Transaksi" class="ajaxpage">Data Transaksi</a></li>
                    <li><a href="{$baseurl}/courier" title="Data Courier" class="ajaxpage">Data Kurir</a></li>
                    <li><a href="{$baseurl}/courierrate" title="Data Courier Rate" class="ajaxpage">Data Tarif Kurir</a></li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="accordion-group">
              <div class="accordion-heading"> <a href="#collapseHalaman" data-parent="#side_accordion" data-toggle="collapse" class="accordion-toggle"> <i class="icon-list"></i> Halaman </a> </div>
              <div class="accordion-body collapse" id="collapseHalaman">
                <div class="accordion-inner">
                  <ul class="nav nav-list">
                    <li><a href="{$baseurl}/banner" title="Data Banner" class="ajaxpage">Data Banner</a></li>
                    <li><a href="{$baseurl}/page" title="Data Page" class="ajaxpage">Data Page</a></li>
                    <li><a href="{$baseurl}/article" title="Data Artikel" class="ajaxpage">Data Artikel</a></li>
                    <li><a href="{$baseurl}/faq" title="Data FAQ" class="ajaxpage">Data Faq</a></li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="accordion-group">
              <div class="accordion-heading"> <a href="#collapseOtorisasi" data-parent="#side_accordion" data-toggle="collapse" class="accordion-toggle"> <i class="icon-user"></i> Otorisasi </a> </div>
              <div class="accordion-body collapse" id="collapseOtorisasi">
                <div class="accordion-inner">
                  <ul class="nav nav-list">
                    <li><a href="{$baseurl}/user" title="Data User" class="ajaxpage">Data User</a></li> 
                    <li><a href="{$baseurl}/groupuser" title="Data Group User" class="ajaxpage">Data Grup User</a></li>
                    <li><a href="{$baseurl}/moduleitem" title="Data Module Items" class="ajaxpage">Data Module</a></li>                    
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <div class="push"></div>
        </div>
      </div>
    </div>
  </div>
</div>
<style>
.ajaxpage.external_link{
background:none;
}
</style>
<script>
  var jqxhr = null;
  $(document).ready(function(){
    $('.ajaxpage').click(function(){
	  if($(this).parent().hasClass('active')){
	    return false;
	  }
	  $('.ajaxpage').parent().removeClass('active');
	  $(this).parent().addClass('active');
	  
	  var titlePage = $(this).attr('title') + ' - IZYSTORE';
	  var urlPage = $(this).attr('href');
	  
	  ajaxpage(urlPage, titlePage)
	  
	  return false;
	});
	
	activateCurrentMenu();
	
  });
  function activateCurrentMenu(){
	//-- reset active page then activate current
	$.each($('.ajaxpage'), function(key, value){
	   $(this).parent().removeClass('active');
	   if($(this).attr('href') == document.location.href){
	     $(this).parent().addClass('active');
	   }
	});
  }
  function ajaxpage(urlPage, titlePage){
    if(jqxhr != null){
	  jqxhr.abort();
	}
	$('.formError').remove();
	  jqxhr = $.ajax({
	    type : 'POST',
		url : urlPage,
		beforeSend: function(){
		  $('#contentpage').html('<div class="row-fluid" align="center"><img src="{$baseurl}/assets/img/ajax_loader.gif" alt="Loading" /></div>');
		},
		success: function(response){
		  window.document.title = titlePage;
		  window.history.pushState(response, titlePage, urlPage);
		  $('#contentpage').html(response);
		  activateCurrentMenu();
		  initApp();
		},
		error: function(){
		  $('#contentpage').html('Error when loading page.');
		}
	  });
  }
  
window.addEventListener('popstate', function(event) {
  console.log('popstate fired!');
  window.location.reload();
  //updateContent(event.state);
});
</script>