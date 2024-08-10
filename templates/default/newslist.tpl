{include file = "templates/$path_user/common/header.tpl"}

<div id="content-wrapper" class="container">
    <div class="row">
    
    
  <div class="col-xs-8"> 
      <div class="panel panel-default">
        <div class="panel-heading">News {$searchtext}</div>
        <div class="panel-body"> 
        {foreach from=$datanews item=news}
          <div class="row posting-content">
            <div class="col-md-3" align="center"> 
              <a href="{$news.url_hyperlink}">
                <img class="img-responsive img-thumbnail" src="{str_replace('[baseurlroot]', $baseurl, $news.image_small)}">
              </a> 
            </div>
            <div class="col-md-9">
              <h4><a href="{$news.url_hyperlink}">{$news.title}</a></h4>
              <p>{$news.introtext}</p>
              <span class="text-muted">Posted on {date('H:i F dS, Y', strtotime($news.created))}</span>
              <a class="btn btn-default pull-right" href="{$news.url_hyperlink}">Read more...</a> </div>
          </div>
        {/foreach}
        </div>
        <div class="panel-footer">
<div id="pagination-wrapper" align="center">
<nav>
{if $statuspagination==1}
<ul class='pagination'>
	{if $InfoArray.CURRENT_PAGE !=1}
     <li><a class='pageposition' href='?page=1{$url_tambahan}'  title='First Page'>&laquo; First</a></li>
    {/if}
    
	{if $InfoArray.PREV_PAGE}
      <li><a class='pageposition' href='?page={$InfoArray.PREV_PAGE}{$url_tambahan}' title='Previous Page'>&laquo; Previous</a></li>
    {/if}

   {section name=ke loop=$InfoArray.PAGE_NUMBERS}
        {if $InfoArray.CURRENT_PAGE == $InfoArray.PAGE_NUMBERS[ke]}
         <li class="active"><a class='number current'>{$InfoArray.PAGE_NUMBERS[ke]} </a></li>
        {else}
         <li><a class='number' href='?page={$InfoArray.PAGE_NUMBERS[ke]}{$url_tambahan}'>  {$InfoArray.PAGE_NUMBERS[ke]} </a></li>
        {/if}
   {/section}
   
         {if $InfoArray.NEXT_PAGE}
         <li><a  class='pageposition' href='?page={$InfoArray.NEXT_PAGE}{$url_tambahan}' title='Next Page'>Next &raquo;</a></li>
 		 {/if}
         
   {if $InfoArray.CURRENT_PAGE != $InfoArray.TOTAL_PAGES && $InfoArray.TOTAL_PAGES <> ""}
         <li><a  class='pageposition' href='?page={$InfoArray.TOTAL_PAGES}{$url_tambahan}'   title='Last Page'> Last &raquo; </a></li>
	 
   {/if}
   </ul>
{/if}
</nav>
</div>
        </div>

      </div>
  </div>
  <div class="col-xs-4">
      {include file = "templates/$path_user/common/sideright.tpl"}
<div class="panel panel-default">
  <div class="panel-heading">Search</div>
  <div class="panel-body">
    <form class="" action="{$baseurl}/search" method="get">
        <div class="input-group">
        <input class="form-control" type="text" name="q" placeholder="Type here..." value="{$q}">
        <span class="input-group-btn">
        	<button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i></button>
        </span>
        </div>
    </form>
  </div>
</div>    
  
<div class="panel panel-default">
  <div class="panel-heading">Archived</div>
  <div class="panel-body">
    <nav class="nav" role="navigation">
      <ul class="nav nav-pills nav-stacked" role="navigation">
      {foreach from=$dataarchived key=id item=archived}
        <li><a href="{$baseurl}/newslist/{$archived.tahun}"> <i class="fa fa-caret-down"></i> {$archived.tahun}  </a>
            <ul class="nav">
            {foreach from=$archived.data item=data}
                <li>
                	<a href="{$baseurl}/newslist/{$archived.tahun}/{$data.bulan}"> <i class="fa fa-caret-right"></i> {date('F', strtotime($data.tanggal))} <!--({$data.jlhkonten})--></a>
                </li>
            {/foreach}
            </ul>
        </li>
      {/foreach}  
      </ul>
    </nav>

  </div>
</div>    
      
  </div>
        </div>
</div>

{include file = "templates/$path_user/common/footer.tpl"}


