<?php
//-- router
$app->get('/gallery', 'getview')->name('gallery-view');
$app->post('/gallery', 'postview')->name('gallery-view');

$app->get('/gallery/add', 'getadd')->name('gallery-insert');
$app->post('/gallery/add', 'postadd')->name('gallery-insert');

$app->get('/gallery/edit/:id', 'getedit')->name('gallery-update');
$app->post('/gallery/edit/:id', 'postedit')->name('gallery-update');

$app->post('/gallery/data', 'fetchdata')->name('gallery-view-query');
$app->post('/gallery/validate', 'validate')->name('novalidate');
$app->post('/gallery/query-insert', 'insertdata')->name('gallery-insert-query');
$app->post('/gallery/query-update', 'updatedata')->name('gallery-update-query');
$app->post('/gallery/query-delete', 'deletedata')->name('gallery-delete-query');

//-- controller
function postedit($id){
	require_once basepath.'/libraries/smarty/Smarty.class.php';
	
	$smarty = newSmarty();
	$data = izy::load('tb_gallery', $id);
	$row = izy::getRow('SELECT category_id FROM tb_gallery_catgallery WHERE gallery_id=?', array($data->id));
	
	$smarty->assign('category_id', $row['category_id']);
	$smarty->assign('data', $data);
	$smarty->assign('datacategory', fetchCategory());
	$smarty->display(basepath.'/modules/gallery/edit-gallery.tpl');
}

function getedit($id){
	require_once basepath.'/libraries/smarty/Smarty.class.php';
	
	$smarty = newSmarty();

	$data = izy::load('tb_gallery', $id);
	$row = izy::getRow('SELECT category_id FROM tb_gallery_catgallery WHERE gallery_id=?', array($data->id));
	
	$smarty->assign('category_id', $row['category_id']);
	$smarty->assign('data', $data);
	$smarty->assign('datacategory', fetchCategory());
	$smarty->assign('content', basepath.'/modules/gallery/edit-gallery.tpl');
	$smarty->display(basepath."/modules/main.tpl");
}

function postadd(){
	require_once basepath.'/libraries/smarty/Smarty.class.php';
	
	$smarty = newSmarty();
	
	$smarty->assign('datacategory', fetchCategory());
	$smarty->display(basepath.'/modules/gallery/add-gallery.tpl');
}

function getadd(){
	require_once basepath.'/libraries/smarty/Smarty.class.php';
	
	$smarty = newSmarty();
	$smarty->assign('datacategory', fetchCategory());
	$smarty->assign('content', basepath.'/modules/gallery/add-gallery.tpl');
	$smarty->display(basepath."/modules/main.tpl");
}

function deletedata(){
	$app = \Slim\Slim::getInstance();
	$request = $app->request();

	$dataid = $request->params('id');
	
	$result = "";
	izy::begin();
	try {
		izy::exec('delete from tb_gallery where id=?', array($dataid));	
		izy::exec('delete from tb_gallery_catgallery where gallery_id=?', array($dataid));
		
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

	$obj = izy::dispense('tb_gallery');
	$obj->images = str_replace(baseurlroot, '[baseurlroot]', $request->params('images'));
	$obj->name = $request->params('name');

	$result = "";
	izy::begin();
	try {
		$content_id = izy::store($obj);

		izy::exec("INSERT INTO tb_gallery_catgallery(gallery_id, category_id) VALUES (:gallery_id, :category_id)", 
			array('gallery_id'=>$obj->id, 'category_id'=>$request->params('category_id')));

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

	$obj = izy::load('tb_gallery', $request->params('id'));
	$obj->images = str_replace(baseurlroot, '[baseurlroot]', $request->params('images'));
	$obj->name = $request->params('name');

	$result = "";
	izy::begin();
	try {
		$content_id = izy::store($obj);

		izy::exec("DELETE FROM tb_gallery_catgallery WHERE gallery_id=?", array($content_id));
		izy::exec("INSERT INTO tb_gallery_catgallery(gallery_id, category_id) VALUES (:gallery_id, :category_id)", 
			array('gallery_id'=>$obj->id, 'category_id'=>$request->params('category_id')));

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
	
	$row = izy::findOne('tb_gallery', 'name=?', array($request->params('name')));
	if($row->id >0 && $row->id != $id){
		$arrayToJs[$i][0] = 'name';
		$arrayToJs[$i][1] = false;
		$arrayToJs[$i][2] = "This name is already taken.!";
	}else{
		$arrayToJs[$i][0] = 'name';
		$arrayToJs[$i][1] = true;
	}
	
	echo json_encode($arrayToJs);	
};

function fetchdata(){
	$app = \Slim\Slim::getInstance();
	$request = $app->request();

	$barisdiinginkan = $request->params('jumlahbaris');
	$filterdata = $request->params('pilihfilter');
	$halaman = $request->params('halaman');
	$cari = $request->params('cari');

	$catid = $request->params('category');
	$filter_kategory = "";
	if($catid != ''){
		$filter_kategory = " AND C.id = '$catid' ";
	}

	$limitmulai = ($halaman == 1) ? 0 : ($halaman * $barisdiinginkan) - $barisdiinginkan;
	$limit_query = "LIMIT $limitmulai," . $barisdiinginkan;
	$filter_query = ($filterdata != "") ? " AND $filterdata  LIKE  '%$cari%' " : "";

	$db = mysqliConnection();
	$sql = "SELECT A.id, A.name, A.tanggal, C.name as categoryname
	FROM tb_gallery A LEFT JOIN tb_gallery_catgallery B ON A.id = B.gallery_id LEFT JOIN tb_catgallery C ON B.category_id = C.id
	WHERE A.id IS NOT NULL $filter_query $filter_kategory
	ORDER BY C.tanggal DESC, A.id DESC ";
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

	$datacategory = fetchCategory();
	$smarty->assign('datacategory', $datacategory);
	$smarty->display(basepath.'/modules/gallery/view-gallery.tpl');
}

function getview(){
	require_once basepath.'/libraries/smarty/Smarty.class.php';
	
	$smarty = newSmarty();
	$datacategory = fetchCategory();
	$smarty->assign('datacategory', $datacategory);

	$smarty->assign('content', basepath.'/modules/gallery/view-gallery.tpl');
	$smarty->display(basepath."/modules/main.tpl");
}

function fetchCategory(){
	return izy::getAll("SELECT A.id, A.name 
		FROM tb_catgallery A ORDER BY A.name ASC");
}
?>