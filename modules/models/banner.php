<?php
class Banner_Model{
	static function get_all_banner(){
		$sql = "SELECT * FROM tb_banner ORDER BY id DESC";
		$databanner = izy::getAll($sql);
		$allbanner = array();
		$i = 0;
		foreach ($databanner as $banner) {
			$image = str_replace('..', '', $banner['banner']);
			$image = str_replace('[baseurlroot]', baseurl, $image);
			$allbanner[$banner['jenis']][$i] = $banner;
			$allbanner[$banner['jenis']][$i]['gambar'] = $image;
			$allbanner[$banner['jenis']][$i]['url_image'] = Helper::fix_url($banner['banner']);
			$i++;
		}
		return $allbanner;
	}
}
?>