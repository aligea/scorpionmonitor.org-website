<?php
class Togel_Model{
	static function keluaran_terakhir(){
		$sqltogel = "select * from tb_togel order by tanggal desc limit 1";
		$row = izy::getRow($sqltogel);
		$row['tanggal2'] = date('d-m-Y', strtotime($row['tanggal']));
		return $row;
	}
	static function fetch_togel($rowindex = 0, $rowperview= 6){
		$sql = "SELECT id, tanggal, periode, hasil, gg, bk from tb_togel order by tanggal desc
		LIMIT $rowindex, $rowperview";

		$result = izy::getAll($sql);
		return $result;
	}
	static function get_total_row(){
		$db = mysqliConnection();
		$sql = "SELECT id, tanggal, periode, hasil, gg, bk from tb_togel order by tanggal desc
		";
		$rs = $db->query($sql) or die($db->error);

		$jumlahdata = $rs->num_rows;
		$db = null;
		return $jumlahdata;
	}
}
?>