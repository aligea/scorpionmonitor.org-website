{include file = "templates/$path_user/common/header.tpl"}

<div id="content-wrapper" class="container"> 
      

<div class="row">
    <div class="col-xs-8">
        <div class="panel panel-default">
        
        <div class="panel-body"> 
            
            <div class="page-header">
            <h3>{$content.title}</h3>
            
          </div>
			
            <div align="justify" id="content-news">
            {Helper::fix_content_url($content.fulltext)}
            </div>
            <script>
            $(function(){
              $('#content-news img').addClass('img-responsive img-thumbnail');
            });
            </script>
            {include file = "templates/$path_user/common/sharebutton.tpl"}
        </div>

      </div></div>
    <div class="col-xs-4">{include file = "templates/$path_user/common/sideright.tpl"}</div>
</div>

</div>

{include file = "templates/$path_user/common/footer.tpl"}


