<?php
//-- router
$app->get('/courierrate', 'getview')->name('courierrate-view');
$app->post('/courierrate', 'postview')->name('courierrate-view');

$app->get('/courierrate/add', 'getadd')->name('courierrate-insert');
$app->post('/courierrate/add', 'postadd')->name('courierrate-insert');

$app->get('/courierrate/edit/:id', 'getedit')->name('courierrate-update');
$app->post('/courierrate/edit/:id', 'postedit')->name('courierrate-update');

$app->get('/courierrate/upload', 'getupload')->name('courierrate-insert');
$app->post('/courierrate/upload', 'postupload')->name('courierrate-insert');
$app->get('/courierrate/uploadedfile', 'showuploadedfile')->name('courierrate-insert');

$app->post('/courierrate/data', 'fetchdata')->name('courierrate-view-query');
$app->post('/courierrate/validate', 'validate')->name('novalidate');
$app->post('/courierrate/query-insert', 'insertdata')->name('courierrate-insert-query');
$app->post('/courierrate/query-update', 'updatedata')->name('courierrate-update-query');
$app->post('/courierrate/query-delete', 'deletedata')->name('courierrate-delete-query');
$app->post('/courierrate/query-upload', 'uploadfile')->name('courierrate-insert-query');
$app->post('/courierrate/query-saveuploaded', 'saveuploadedfile')->name('courierrate-insert-query');
$app->post('/courierrate/query-delete-selected-items', 'deleteSelectedItems')->name('courierrate-delete-query');

//-- controller
function uploadFile(){
	$target_dir = basepath.DIRECTORY_SEPARATOR."uploads";
	if(!is_dir($target_dir)){
		mkdir($target_dir);
	}

	$target_file = $target_dir.'/tarif.xls';
	if(move_uploaded_file($_FILES["myfile"]["tmp_name"], $target_file)){
		echo 'berhasil';
	}else{
		echo "Sorry, there was an error uploading your file.";
	}
}

function showuploadedfile(){
	require_once basepath.'/libraries/spreadsheet-reader-master/php-excel-reader/excel_reader2.php';
	require_once basepath.'/libraries/spreadsheet-reader-master/SpreadsheetReader.php';

	$file = basepath.DIRECTORY_SEPARATOR.'uploads/tarif.xls';
	$dataexcel = new Spreadsheet_Excel_Reader($file);

	$jumlahdata = $dataexcel->rowcount(0) - 1;

	//-- row pertama di dalam excel adalah header nya.
	$i = 2;
	$dataJson = array();
	for ($j = 1; $j <= $jumlahdata; $j++) {
	    //$data->val($row,$col,$sheet_index);
	    $dataJson[$i]['no'] = $dataexcel->value($i, 'A', 0);
	    $dataJson[$i]['provinsi'] = $dataexcel->value($i, 'B', 0);
	    $dataJson[$i]['daerah'] = $dataexcel->value($i, 'C', 0);
	    $dataJson[$i]['harga'] = $dataexcel->value($i, 'D', 0);
	    $i++;
	}

	unset($dataexcel);
	echo json_encode($dataJson);
}

function saveuploadedfile(){
	require_once basepath.'/libraries/spreadsheet-reader-master/php-excel-reader/excel_reader2.php';
	require_once basepath.'/libraries/spreadsheet-reader-master/SpreadsheetReader.php';

	
	$app = \Slim\Slim::getInstance();
	$request = $app->request();

	$file = basepath.DIRECTORY_SEPARATOR.'uploads/tarif.xls';
	$dataexcel = new Spreadsheet_Excel_Reader($file);
	$datatarif = array();

	$jumlahdata = $dataexcel->rowcount(0) - 1;

	//-- row pertama di dalam excel adalah header nya.
	$i = 2;
	$dataJson = array();
	for ($j = 1; $j <= $jumlahdata; $j++) {
		$alias = friendlyString($request->params('idKurir').$dataexcel->value($i, 'B', 0).$dataexcel->value($i, 'C', 0));
		$row = izy::getRow('SELECT id FROM tb_tarif WHERE alias=?', array($alias));

		$tarif = izy::load('tb_tarif', $row['id']);
	    $tarif->provinsi = $dataexcel->value($i, 'B', 0);
	    $tarif->daerah = $dataexcel->value($i, 'C', 0);
	    $tarif->hargaok = $dataexcel->value($i, 'D', 0);
	    $tarif->idkurir = $request->params('idKurir');
	    $tarif->alias = $alias;

	    $datatarif[] = $tarif;
	    $i++;
	}
	unset($dataexcel);
	
	$result = "";
	izy::begin();
	try {
		foreach ($datatarif as $tarif) {
			izy::store($tarif);
		}
		
		izy::commit();
		$result = 'berhasil';
	} catch(Exception $e) {
		izy::rollback();
		$result = $e->getMessage();
	}
	echo $result;
}

function postupload(){
	require_once basepath.'/libraries/smarty/Smarty.class.php';
	
	$smarty = newSmarty();
	

	$smarty->assign('datakurir', fetchCourierData());
	$smarty->display(basepath.'/modules/courierrate/upload-courierrate.tpl');
}

function getupload(){
	require_once basepath.'/libraries/smarty/Smarty.class.php';
	
	$smarty = newSmarty();

	
	$smarty->assign('datakurir', fetchCourierData());
	$smarty->assign('content', basepath.'/modules/courierrate/upload-courierrate.tpl');
	$smarty->display(basepath."/modules/main.tpl");
}

function postedit($id){
	require_once basepath.'/libraries/smarty/Smarty.class.php';
	
	$smarty = newSmarty();
	
	$data = izy::load('tb_tarif', $id);

	$smarty->assign('data', $data);
	$smarty->assign('datakurir', fetchCourierData());
	$smarty->display(basepath.'/modules/courierrate/edit-courierrate.tpl');
}

function getedit($id){
	require_once basepath.'/libraries/smarty/Smarty.class.php';
	
	$smarty = newSmarty();

	$data = izy::load('tb_tarif', $id);

	$smarty->assign('data', $data);
	$smarty->assign('datakurir', fetchCourierData());

	$smarty->assign('content', basepath.'/modules/courierrate/edit-courierrate.tpl');
	$smarty->display(basepath."/modules/main.tpl");
}

function deleteSelectedItems(){
	$app = \Slim\Slim::getInstance();
	$request = $app->request();
	izy::begin();
	try {
		$dataid = $request->params('dataid');
		foreach ($dataid as $key => $value) {
			izy::exec('delete from tb_tarif where id=?', array($value));
		}
		
		izy::commit();
		$result = 'berhasil';
	} catch(Exception $e) {
		izy::rollback();
		$result = $e->getMessage();
	}
	echo $result;
}

function deletedata(){
	$app = \Slim\Slim::getInstance();
	$request = $app->request();

	$dataid = $request->params('id');
	
	$result = "";
	izy::begin();
	try {
		izy::exec('delete from tb_tarif where id=?', array($dataid));

		izy::commit();
		$result = 'berhasil';
	} catch(Exception $e) {
		izy::rollback();
		$result = $e->getMessage();
	}
	echo $result;
}

function insertdata(){
	$app = \Slim\Slim::getInstance();
	$request = $app->request();

	$obj = izy::dispense('tb_tarif');
	$obj->idkurir = $request->params('idKurir');
	$obj->provinsi = $request->params('provinsi');
	$obj->daerah = $request->params('daerah');
	$obj->hargaok = $request->params('hargaok');


	$result = "";
	izy::begin();
	try {
		$data_id = izy::store($obj);
		
		izy::commit();
		$result = 'berhasil';
	} catch(Exception $e) {
		izy::rollback();
		$result = $e->getMessage();
	}
	echo $result;
}

function updatedata(){
	$app = \Slim\Slim::getInstance();
	$request = $app->request();

	$obj = izy::load('tb_tarif', $request->params('id'));
	$obj->idkurir = $request->params('idKurir');
	$obj->provinsi = $request->params('provinsi');
	$obj->daerah = $request->params('daerah');
	$obj->hargaok = $request->params('hargaok');
		

	$result = "";
	izy::begin();
	try {
		$data_id = izy::store($obj);
		
		izy::commit();
		$result = 'berhasil';
	} catch(Exception $e) {
		izy::rollback();
		$result = $e->getMessage();
	}
	echo $result;
}

function validate(){
	$app = \Slim\Slim::getInstance();
	$request = $app->request();

	$id = $request->params('id');


	$arrayToJs = array();
	$i = 0;
	
	$row = izy::findOne('tb_kurir', 'nama=?', array($request->params('nama')));
	if($row->id >0 && $row->id != $id){
		$arrayToJs[$i][0] = 'nama';
		$arrayToJs[$i][1] = false;
		$arrayToJs[$i][2] = "This name is already taken.!";
	}else{
		$arrayToJs[$i][0] = 'nama';
		$arrayToJs[$i][1] = true;
	}
	
	echo json_encode($arrayToJs);	
};

function postadd(){
	require_once basepath.'/libraries/smarty/Smarty.class.php';
	
	$smarty = newSmarty();	

	$smarty->assign('datakurir', fetchCourierData());

	$smarty->display(basepath.'/modules/courierrate/add-courierrate.tpl');
}

function getadd(){
	require_once basepath.'/libraries/smarty/Smarty.class.php';
	
	$smarty = newSmarty();

	$smarty->assign('datakurir', fetchCourierData());
	
	$smarty->assign('content', basepath.'/modules/courierrate/add-courierrate.tpl');
	$smarty->display(basepath."/modules/main.tpl");
}

function fetchdata(){
	$app = \Slim\Slim::getInstance();
	$request = $app->request();

	$barisdiinginkan = $request->params('jumlahbaris');
	$filterdata = $request->params('pilihfilter');
	$halaman = $request->params('halaman');
	$cari = $request->params('cari');


	$catid = $request->params('idKurir');
	$filter_kategory = "";
	if($catid != ''){
		$filter_kategory = " AND A.idKurir = '$catid' ";
	}


	$limitmulai = ($halaman == 1) ? 0 : ($halaman * $barisdiinginkan) - $barisdiinginkan;
	$limit_query = "LIMIT $limitmulai," . $barisdiinginkan;
	$filter_query = ($filterdata != "") ? " AND $filterdata  LIKE  '%$cari%' " : "";

	$db = mysqliConnection();
	$sql = "SELECT A.id, A.hargaok, A.provinsi, A.daerah, B.nama
	FROM tb_tarif A INNER JOIN tb_kurir B ON A.idKurir = B.id
	WHERE A.id IS NOT NULL $filter_query $filter_kategory
	ORDER BY B.nama ASC, A.provinsi ASC, A.daerah ASC
	";
	$rs = $db->query($sql) or die($db->error);

	$jumlahdata = $rs->num_rows;
	$jumlahhalaman = ceil($jumlahdata / $barisdiinginkan);

	$databody = izy::getAll($sql.$limit_query);
	$datasetting["jumlahdata"] = $jumlahdata;
	$datasetting["jumlahhalaman"] = $jumlahhalaman;

	$result = array();
	$result['datahead'] = array();
	$result['databody'] = $databody;
	$result['datasetting'] = $datasetting;
	echo json_encode($result);
}

function postview(){
	require_once basepath.'/libraries/smarty/Smarty.class.php';
	
	$smarty = newSmarty();
	
	$smarty->assign('datakurir', fetchCourier());
	$smarty->assign('dataprovinsi', fetchProvinsi());
	$smarty->display(basepath.'/modules/courierrate/view-courierrate.tpl');
}

function getview(){
	require_once basepath.'/libraries/smarty/Smarty.class.php';
	
	$smarty = newSmarty();
	$smarty->assign('datakurir', fetchCourier());
	$smarty->assign('dataprovinsi', fetchProvinsi());
	$smarty->assign('content', basepath.'/modules/courierrate/view-courierrate.tpl');
	$smarty->display(basepath."/modules/main.tpl");
}

function fetchCourier(){
	return izy::getAll("SELECT DISTINCT A.idKurir, B.nama 
		FROM tb_tarif A INNER JOIN tb_kurir B ON A.idKurir = B.id 
		ORDER BY B.nama ASC");
}

function fetchProvinsi(){
	return izy::getAll("SELECT DISTINCT provinsi 
		FROM tb_tarif 
		ORDER BY provinsi ASC");
}
function fetchCourierData(){
	return izy::getAll("SELECT * 
		FROM tb_kurir 
		WHERE status = 'Y' 
		ORDER BY nama ASC");
}

?>