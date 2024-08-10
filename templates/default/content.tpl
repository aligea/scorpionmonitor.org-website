{include file = "templates/$path_user/common/header.tpl"}

<div id="content-wrapper" class="container"> 
      
    <div class="row">
        <div class="col-xs-8">
        <div class="panel panel-default">
        <div class="panel-header">
            {*<ol class="breadcrumb">
              <li><a href="{$baseurl}">Home</a></li>
              <li><a href="{$baseurl}/newslist">News</a></li>
              <li><a href="{$baseurl}/newslist/{date('Y', strtotime($content.publish_up))}">{date('Y', strtotime($content.publish_up))}</a></li>
              <li><a href="{$baseurl}/newslist/{date('Y', strtotime($content.publish_up))}/{date('m', strtotime($content.publish_up))}">{date('F', strtotime($content.publish_up))}</a></li>
              <li class="active">{$content.title}</li>
            </ol>*}
            {$content.breadcrumb}
        </div>
        <div class="panel-body"> 
            <div align="center">
            {* $fakefile_url = Helper::create_fake_filename($content.images) 
            <img class="img-responsive img-thumbnail" src="{$baseurl}/img/{$fakefile_url}" alt="{$content.title}">
				*}
				<img class="img-responsive img-thumbnail" src="{Helper::fix_url($content.images)}" alt="{$content.title}">
            </div>
            <div class="page-header">
            <h3>{$content.title}</h3>
          </div>
            
            <div align="justify" id="content-news">
            <span class="text-muted">Posted on {date('H:i F dS, Y', strtotime($content.created))}</span>
            {Helper::fix_content_url($content.fulltext)}
            </div>
            {include file = "templates/$path_user/common/sharebutton.tpl"}
        </div>
      </div>
        </div>
        <div class="col-xs-4">
            
            {include file = "templates/$path_user/common/sideright.tpl"}
        </div>
    </div>
</div>

<div id="anothernews-wrapper" class="container">
<div class="row">
{foreach from=$datanews item=news}
<div class="col-xs-6">
    <div class="row">
            <div class="col-xs-4" align="center"> 
              <a href="{$news.url_hyperlink}">
                <img class="img-responsive img-thumbnail" src="{str_replace('[baseurlroot]', $baseurl, $news.image_small)}">
              </a> 
            </div>
            <div class="col-xs-8">
              <h4><a href="{$news.url_hyperlink}">{$news.title}</a></h4>
            </div>
    </div>
</div>
{/foreach}
</div>
</div>

{include file = "templates/$path_user/common/footer.tpl"}


