<?php

class ContentCtrl {

   static function view($tahun = "", $bulan = "") {
      include_once basepath . '/libraries/class/classpage.php';
      $app = \Slim\Slim::getInstance();
      $request = $app->request();

      $smarty = AppModules::init_smarty();
      $Paging = new PagedResults();
      $Paging->ResultsPerPage = 6;
      $Paging->LinksPerPage = 6;
      $Paging->PageVarName = "page";

      $url_tambahan = "";

      $endoffset = 0;
      if ($_GET['page'] > 1) {
         $endoffset = ($_GET['page'] - 1) * $Paging->ResultsPerPage;
      }

      $params = "";
      if ($tahun != "") {
         $params .= " AND YEAR(publish_up)='$tahun'";
      }
      if ($bulan != "") {
         $params .= " AND MONTH(publish_up)='$bulan'";
      }
      if ($request->params('q') != "") {
         $q = $request->params('q');
         $url_tambahan = '&q=' . $q;
         $params .= " AND A.fulltext LIKE '%$q%' ";
         $searchtext = ", related to '$q'";


         $smarty->assign('q', $q);
         $smarty->assign('searchtext', $searchtext);
      }

      $Paging->TotalResults = Content_Model::get_total_row($params);

      $datanews = Content_Model::fetch_content($endoffset, $Paging->ResultsPerPage, $params);

      $dataarchived = Content_Model::fetch_archived();
      $smarty->assign('dataarchived', $dataarchived);


      $smarty->assign("statuspagination", 1);
      $smarty->assign("InfoArray", $Paging->InfoArray());
      $smarty->assign("url_tambahan", $url_tambahan);
      $smarty->assign('datanews', $datanews);
      $smarty->display(basepath . "/templates/$smarty->path_user/newslist.tpl");
   }

   static function detail($alias = false) {
      $smarty = AppModules::init_smarty();
      $alias = str_replace('.html', '', $alias);

      $content = (!$alias) ? Content_Model::fetch_by_id($_GET['id']) : Content_Model::fetch_by_alias($alias);
      if (!$content['id']) {
         $app = \Slim\Slim::getInstance();
         $app->notFound();
      }

      //$content['fakeimage'] =  Helper::create_fake_filename($content['images']);
      //-- update perkiraan pengunjung
      Content_Model::update_hits_visitor($content['id']);

      $setting = $smarty->getTemplateVars('setting');
      $metadesc = ($content['metadesc'] != "") ? $content['metadesc'] : $setting['metadesc'];
      $metakey = ($content['metakey'] != "") ? $content['metakey'] : $setting['metakey'];

      $og = $smarty->getTemplateVars('og');


      $og['type'] = 'article';
      $og['title'] = $content['title'];
      $og['image'] = Helper::fix_url($content['images']);
      $og['description'] = $metadesc;
      $smarty->assign('og', $og);

      $smarty->assign('meta_title', $content['title'] . ' | ' . $smarty->getTemplateVars('setting')['metatitle']);
      $smarty->assign("meta_keyword", $metakey);
      $smarty->assign("meta_description", $metadesc);

      //$content = (object)$content;
      $params .= " AND A.id <> '" . $content['id'] . "' ";
      $params .= " AND MONTH(publish_up) = '" . date('m', strtotime($content['publish_up'])) . "' ";
      $params .= " AND YEAR(publish_up) = '" . date('Y', strtotime($content['publish_up'])) . "' ";
      $datanews = Content_Model::fetch_content(1, 4, $params);
      $smarty->assign('datanews', $datanews);

      $smarty->assign('content', $content);
      $smarty->display(basepath . "/templates/$smarty->path_user/content.tpl");
   }

   static function singlePage($alias = false) {
      $smarty = AppModules::init_smarty();
      $alias = str_replace('.html', '', $alias);

      $content = (!$alias) ? Content_Model::fetch_by_id($_GET['id']) : Content_Model::fetch_by_alias($alias);
      if (!$content['id']) {
         $app = \Slim\Slim::getInstance();
         $app->notFound();
      }
      $setting = $smarty->getTemplateVars('setting');
      $metadesc = ($content['metadesc'] != "") ? $content['metadesc'] : $setting['metadesc'];
      $metakey = ($content['metakey'] != "") ? $content['metakey'] : $setting['metakey'];

      $og = $smarty->getTemplateVars('og');


      $og['type'] = 'website';
      $og['title'] = $content['title'];
      $og['image'] = Helper::fix_url($content['images']);
      $og['description'] = $metadesc;
      $smarty->assign('og', $og);

      $smarty->assign('meta_title', $content['title'] . ' | ' . $smarty->getTemplateVars('setting')['metatitle']);
      $smarty->assign("meta_keyword", $metakey);
      $smarty->assign("meta_description", $metadesc);

      $smarty->assign('content', $content);
      $smarty->display(basepath . "/templates/$smarty->path_user/page.tpl");
   }

   static function detail_v2($_id) {
      $smarty = AppModules::init_smarty();

      $id = intval($_id);
      $content = Content_Model::fetch_by_id($id);
      if (!$content['id']) {
         $app = \Slim\Slim::getInstance();
         $app->notFound();
      }
      if (Helper::getCurrentUrl() != $content['url_hyperlink']) {
         $app = \Slim\Slim::getInstance();
         $app->redirect($content['url_hyperlink']);
      }

      //$content['fakeimage'] =  Helper::create_fake_filename($content['images']);
      //-- update perkiraan pengunjung
      Content_Model::update_hits_visitor($content['id']);

      $setting = $smarty->getTemplateVars('setting');
      $metadesc = ($content['metadesc'] != "") ? $content['metadesc'] : $setting['metadesc'];
      $metakey = ($content['metakey'] != "") ? $content['metakey'] : $setting['metakey'];

      $og = $smarty->getTemplateVars('og');


      $og['type'] = 'article';
      $og['title'] = $content['title'];
      $og['image'] = Helper::fix_url($content['images']);
      $og['description'] = $metadesc;
      $smarty->assign('og', $og);

      $smarty->assign('meta_title', $content['title'] . ' | ' . $smarty->getTemplateVars('setting')['metatitle']);
      $smarty->assign("meta_keyword", $metakey);
      $smarty->assign("meta_description", $metadesc);

      //$content = (object)$content;
      $params .= " AND A.id <> '" . $content['id'] . "' ";
      $params .= " AND MONTH(publish_up) = '" . date('m', strtotime($content['publish_up'])) . "' ";
      $params .= " AND YEAR(publish_up) = '" . date('Y', strtotime($content['publish_up'])) . "' ";
      $datanews = Content_Model::fetch_content(1, 4, $params);
      $smarty->assign('datanews', $datanews);

      $smarty->assign('content', $content);
      $smarty->display(basepath . "/templates/$smarty->path_user/content.tpl");
   }

   static function detail_v3($_title_prefix) {
      $smarty = AppModules::init_smarty();
      
      $title_prefix = str_replace('.html', '', $_title_prefix);
      $prefixes = explode('-', $title_prefix);
     
      $id = end($prefixes);   
      $content = Content_Model::fetch_by_id($id);
      if (!$content['id']) {
         $app = \Slim\Slim::getInstance();
         $app->notFound();
      }
      if (Helper::getCurrentUrl() != $content['url_hyperlink']) {
         $app = \Slim\Slim::getInstance();
         $app->redirect($content['url_hyperlink']);
      }

      //$content['fakeimage'] =  Helper::create_fake_filename($content['images']);
      //-- update perkiraan pengunjung
      Content_Model::update_hits_visitor($content['id']);

      $setting = $smarty->getTemplateVars('setting');
      $metadesc = ($content['metadesc'] != "") ? $content['metadesc'] : $setting['metadesc'];
      $metakey = ($content['metakey'] != "") ? $content['metakey'] : $setting['metakey'];
      
      $og = $smarty->getTemplateVars('og');

      $og['type'] = 'article';
      $og['title'] = $content['title'];
      $og['image'] = Helper::fix_url($content['images']);
	  $og['image'] = str_replace(' ', '%20', $og['image']);
      $og['description'] = $metadesc;
      $smarty->assign('og', $og);

      $smarty->assign('meta_title', $content['title'] . ' | ' . $smarty->getTemplateVars('setting')['metatitle']);
      $smarty->assign("meta_keyword", $metakey);
      $smarty->assign("meta_description", $metadesc);

      //$content = (object)$content;
      $params .= " AND A.id <> '" . $content['id'] . "' ";
      $params .= " AND MONTH(publish_up) = '" . date('m', strtotime($content['publish_up'])) . "' ";
      $params .= " AND YEAR(publish_up) = '" . date('Y', strtotime($content['publish_up'])) . "' ";
      $datanews = Content_Model::fetch_content(1, 4, $params);
      $smarty->assign('datanews', $datanews);

      $smarty->assign('content', $content);
      $smarty->display(basepath . "/templates/$smarty->path_user/content.tpl");
   }

}
