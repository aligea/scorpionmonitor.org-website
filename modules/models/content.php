<?php

class Content_Model {

   static function artikel_terakhir($jumlah_item = 4) {
      $sql = "SELECT id, images, title, introtext, alias, created, publish_up 
	      FROM tb_content A
	      WHERE type='news' AND state=1
	      ORDER BY created DESC
		  LIMIT $jumlah_item";

      $result = izy::getAll($sql);

      foreach ($result as $key => $value) {
         $image = str_replace('..', '', $result[$key]['images']);
         $image = str_replace('[baseurlroot]', baseurl, $image);
         $result[$key]['url_gambar'] = Helper::fix_url($image);
         $result[$key]['url_hyperlink'] = self::createHyperlink($value);
      }

      return $result;
   }

   static function fetch_content($rowindex = 0, $rowperview = 6, $params = "") {
      $sql = "SELECT id, images, title, introtext, alias, created, publish_up 
	      FROM tb_content A
	      WHERE type='news' AND state=1 $params
	      ORDER BY created DESC
		  LIMIT $rowindex, $rowperview";

      $result = izy::getAll($sql);
      foreach ($result as $key => $value) {
         $image = str_replace('..', '', $result[$key]['images']);
         $image = str_replace('[baseurlroot]', baseurl, $image);
         $result[$key]['url_gambar'] = Helper::fix_url($image);
         $result[$key]['fakefilename'] = Helper::create_fake_filename($image);
         $result[$key]['image_small'] = baseurl . '/img/resize?w=200&h=150&file=' . $result[$key]['images'];
         $result[$key]['url_hyperlink'] = self::createHyperlink($value);
      }

      return $result;
   }

   static function fetch_by_alias($alias) {
      $sql = "SELECT * FROM tb_content WHERE alias=?";
      $row = izy::getRow($sql, array($alias));
      $row['images'] = Helper::fix_url($row['images']);
      $row['fulltext'] = Helper::fix_content_url($row['fulltext']);
      $row['url_hyperlink'] = self::createHyperlink($row);
      return $row;
   }

   static function fetch_archived() {
      $rows = izy::getAll("SELECT DISTINCT CONCAT(YEAR(publish_up), '_', MONTH(publish_up)) as uniqcol, YEAR(publish_up) as tahun, MONTH(publish_up) as bulan,publish_up,
		(SELECT COUNT(id) 
		 FROM tb_content z 
		 WHERE z.type='news' AND z.state=1 
		 AND YEAR(z.publish_up) = YEAR(A.publish_up)
		 AND MONTH(z.publish_up) = MONTH(A.publish_up)
		    ) as jlhkonten
		FROM tb_content A
		WHERE type='news' AND state=1
		ORDER BY publish_up DESC");

      $data = array();
      foreach ($rows as $key => $value) {
         $obj = (object) $value;
         $data[$obj->tahun]['tahun'] = $obj->tahun;
         $data[$obj->tahun]['data'][$obj->bulan]['bulan'] = $obj->bulan;
         $data[$obj->tahun]['data'][$obj->bulan]['jlhkonten'] = $obj->jlhkonten;
         $data[$obj->tahun]['data'][$obj->bulan]['tanggal'] = $obj->publish_up;
      }

      return $data;
   }

   static function get_total_row($params = "") {
      $db = mysqliConnection();
      $sql = "SELECT id, images, title, introtext, alias, created, publish_up 
        FROM tb_content A
        WHERE type='news' AND state=1 $params
        ORDER BY created DESC
		";
      $rs = $db->query($sql) or die($db->error);

      $jumlahdata = $rs->num_rows;
      $db = $rs = null;
      return $jumlahdata;
   }

   static function fetch_by_id($id) {
      $sql = "SELECT * FROM tb_content WHERE id=?";
      $row = izy::getRow($sql, array($id));
      $row['images'] = Helper::fix_url($row['images']);
      $row['description'] = Helper::fix_content_url($row['description']);
      $row['url_hyperlink'] = self::createHyperlink($row);
      $row['breadcrumb'] = self::createBreadcrumb($row);
      return $row;
   }

   static function update_hits_visitor($content_id) {
      if ($_SESSION[session_id()]['hits'][$content_id] == "") {
         $_SESSION[session_id()]['hits'][$content_id] = $content_id;
         izy::exec('update tb_content set hits=hits+1 where id=?', array($content_id));
      }
   }

   static function fetch_featured_news() {
      $params .= " publish_up ";
      $data = Content_Model::fetch_content(1, 4, $params);
   }

   /**
    * 
    * @param array $content row of tb_content
    */
   private static function createHyperlink($content, $oldsttyle = false) {
      if ($oldsttyle == true) {
         return self::createHyperlink_old($content);
      }
      $ptitle = Helper::friendlyString($content['title']);

      # fixed url
      if (substr($ptitle, -1) == '-') {
         $ptitle = substr($ptitle, 0, strlen($ptitle) - 1);
      }

      $url = baseurl . '/news/' . $ptitle . '-' . $content['id'] . '.html';
      $output = strtolower($url);

      
      return $output;
   }

   private static function createHyperlink_old($content) {
      $type = ($content['type'] == '') ? 'news' : $content['type'];
      $url = baseurl . '/content/' . $content['id'] . '/' . $type . '/' . Helper::friendlyString($content['title']);
      $output = strtolower($url);

      # fixed url
      if (substr($output, -1) == '-') {
         $output = substr($output, 0, strlen($output) - 1);
      }

      return $output;
   }

   private static function createBreadcrumb($content) {
      $items = array();

      $year = date('Y', strtotime($content['publish_up']));
      $month = date('m', strtotime($content['publish_up']));
      $month_name = date('F', strtotime($content['publish_up']));
      //$title = substr($content['title'], 0, 20);

      $items[] = array("title" => "Home", "url_hyperlink" => baseurl);
      $items[] = array("title" => "News", "url_hyperlink" => baseurl . '/newslist');
      $items[] = array("title" => $year, "url_hyperlink" => baseurl . '/newslist/' . $year);
      $items[] = array("title" => $month_name, "url_hyperlink" => baseurl . '/newslist/' . $year . '/' . $month);
      $items[] = array("title" => $title, "url_hyperlink" => self::createHyperlink($content));

      $breadcrumb = '<ol class="breadcrumb">';
      foreach ($items as $key => $value) {
         $class = '';
         if (intval($key) + 1 == count($items)) {
            $class = 'class="active"';
         }
         $breadcrumb .= '<li ' . $class . '><a href="' . $value['url_hyperlink'] . '">' . $value['title'] . '</a></li>';
      }
      $breadcrumb .= '</ol>';
      return $breadcrumb;
   }

}
