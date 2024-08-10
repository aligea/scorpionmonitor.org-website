<?php
class Bank_Model {
	static function available_bank(){
		$data = izy::getAll("SELECT DISTINCT nama FROM tb_bank ORDER BY nama ASC");
		return $data;
	}
	static function get_all_bank(){
		$data = izy::getAll("SELECT * from tb_bank ORDER by nama ASC");
		return $data;
	}
}
?>