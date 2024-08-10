<?php
class Produk_Model{
	static function get_all_produk(){
		$catproduk = izy::getAll("SELECT DISTINCT a.id_produk_kategori
			FROM tb_produk a LEFT JOIN tb_produk_kategori b ON a.id_produk_kategori = b.id  
			ORDER BY b.nama_kategori asc, a.nama asc");
		$result = array();
		$i = 0;
		foreach ($catproduk as $key => $row) {
			$dataproduk = izy::getAll("SELECT a.id, a.kode,  a.nama, b.nama_kategori, a.logo, a.linkpage 
				FROM tb_produk a LEFT JOIN tb_produk_kategori b ON a.id_produk_kategori = b.id  
				WHERE a.id_produk_kategori = ? 
				ORDER BY b.nama_kategori asc, a.nama asc", array($row['id_produk_kategori']));
			foreach ($dataproduk as $key => $value){				
				$dataproduk[$key]['logo'] = Helper::fix_url($dataproduk[$key]['logo']);
				$result[$i]['nama_kategori'] = $dataproduk[$key]['nama_kategori'];
			}
			$result[$i]['produk'] = $dataproduk;
			$i++;
		}

		return $result;
	}
}
?>