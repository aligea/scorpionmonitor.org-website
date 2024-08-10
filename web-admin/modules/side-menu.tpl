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
          {foreach from=$datamenu item=menumodule}
            <div class="accordion-group">
              <div class="accordion-heading"> <a href="#collapse{friendlyString($menumodule.nama)}" data-parent="#side_accordion" data-toggle="collapse" class="accordion-toggle"> <i class="{$menumodule.icon}"></i> {$menumodule.nama} </a> </div>
              <div class="accordion-body collapse" id="collapse{friendlyString($menumodule.nama)}">
                <div class="accordion-inner">
                  <ul class="nav nav-list">
                  {foreach from=$menumodule.datamodul item=datamodul}
                    <li><a href="{$baseurl}/{$datamodul.module}" title="{$datamodul.menu}" class="ajaxpage">{$datamodul.menu}</a></li>
                  {/foreach}  
                  </ul>
                </div>
              </div>
            </div>
          {/foreach}
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