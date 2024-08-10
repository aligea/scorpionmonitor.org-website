<?php
//-- router
$app->get('/catgallery', 'getview')->name('catgallery-view');
$app->post('/catgallery', 'postview')->name('catgallery-view');

$app->get('/catgallery/add', 'getadd')->name('catgallery-insert');
$app->post('/catgallery/add', 'postadd')->name('catgallery-insert');

$app->get('/catgallery/edit/:id', 'getedit')->name('catgallery-update');
$app->post('/catgallery/edit/:id', 'postedit')->name('catgallery-update');

$app->post('/catgallery/data', 'fetchdata')->name('catgallery-view-query');
$app->post('/catgallery/validate', 'validate')->name('novalidate');
$app->post('/catgallery/query-insert', 'insertdata')->name('catgallery-insert-query');
$app->post('/catgallery/query-update', 'updatedata')->name('catgallery-update-query');
$app->post('/catgallery/query-delete', 'deletedata')->name('catgallery-delete-query');

//-- controller
function postedit($id){
	require_once basepath.'/libraries/smarty/Smarty.class.php';
	
	$smarty = newSmarty();
	$data = izy::load('tb_catgallery', $id);

	$smarty->assign('parentdata', fetchParentCategory());
	$smarty->assign('data', $data);
	$smarty->display(basepath.'/modules/catgallery/edit-catgallery.tpl');
}

function getedit($id){
	require_once basepath.'/libraries/smarty/Smarty.class.php';
	
	$smarty = newSmarty();

	$data = izy::load('tb_catgallery', $id);

	$smarty->assign('parentdata', fetchParentCategory());
	$smarty->assign('data', $data);
	$smarty->assign('content', basepath.'/modules/catgallery/edit-catgallery.tpl');
	$smarty->display(basepath."/modules/main.tpl");
}

function deletedata(){
	$app = \Slim\Slim::getInstance();
	$request = $app->request();

	$dataid = $request->params('id');
	
	$result = "";
	izy::begin();
	try {
		izy::exec('delete from tb_catgallery where id=?', array($dataid));	
		izy::exec('delete from tb_gallery_catgallery where category_id=?', array($dataid));
		
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

	$obj = izy::dispense('tb_catgallery');
	$obj->parent_id = $request->params('parent');
	$obj->name = $request->params('name');
	$obj->description = $request->params('description');
	$obj->folder = friendlyString($request->params('name'));
	$obj->images = str_replace(baseurltoor, '[baseurlroot]', $request->params('images'));

	//-- create folder tsb jika belum ada
	if(!is_dir('../images/gallery')){
		mkdir('../images/gallery');
	}

	//-- create folder tsb jika belum ada
	if(!is_dir('../images/gallery/'.$obj->folder)){
		mkdir('../images/gallery/'.$obj->folder);
	}	

	$result = "";
	izy::begin();
	try {
		izy::store($obj);
		
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

	$obj = izy::load('tb_catgallery', $request->params('id'));
	$obj->parent_id = $request->params('parent');
	$obj->name = $request->params('name');
	$obj->description = $request->params('description');
	$obj->folder = friendlyString($request->params('name'));
	$obj->images = str_replace(baseurltoor, '[baseurlroot]', $request->params('images'));

	//-- create folder tsb jika belum ada
	if(!is_dir('../images/gallery')){
		mkdir('../images/gallery');
	}

	//-- create folder tsb jika belum ada
	if(!is_dir('../images/gallery/'.$obj->folder)){
		mkdir('../images/gallery/'.$obj->folder);
	}

	$result = "";
	izy::begin();
	try {
		izy::store($obj);
		
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
	$name = $request->params('name');

	$arrayToJs = array();
	$i = 0;
	
	$row = izy::findOne('tb_catgallery', 'name=?', array($name));
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

function postadd(){
	require_once basepath.'/libraries/smarty/Smarty.class.php';
	
	$smarty = newSmarty();
	
	$smarty->assign('parentdata', fetchParentCategory());
	$smarty->display(basepath.'/modules/catgallery/add-catgallery.tpl');
}

function getadd(){
	require_once basepath.'/libraries/smarty/Smarty.class.php';
	
	$smarty = newSmarty();
	
	$parentdata = fetchParentCategory();

	$smarty->assign('parentdata', $parentdata);
	$smarty->assign('content', basepath.'/modules/catgallery/add-catgallery.tpl');
	$smarty->display(basepath."/modules/main.tpl");
}

function fetchdata(){
	$app = \Slim\Slim::getInstance();
	$request = $app->request();

	$barisdiinginkan = $request->params('jumlahbaris');
	$filterdata = $request->params('pilihfilter');
	$halaman = $request->params('halaman');
	$cari = $request->params('cari');

	$limitmulai = ($halaman == 1) ? 0 : ($halaman * $barisdiinginkan) - $barisdiinginkan;
	$limit_query = "LIMIT $limitmulai," . $barisdiinginkan;
	$filter_query = ($filterdata != "") ? " AND $filterdata  LIKE  '%$cari%' " : "";

	$db = mysqliConnection();
	$sql = "SELECT A.id, A.name, IFNULL(B.name, '-') as parentname
	FROM tb_catgallery A LEFT JOIN tb_catgallery B ON A.parent_id = B.id
	WHERE A.id IS NOT NULL $filter_query
	ORDER BY B.name ASC, A.name ASC
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
	$smarty->display(basepath.'/modules/catgallery/view-catgallery.tpl');
}

function getview(){
	require_once basepath.'/libraries/smarty/Smarty.class.php';
	
	$smarty = newSmarty();
	$smarty->assign('content', basepath.'/modules/catgallery/view-catgallery.tpl');
	$smarty->display(basepath."/modules/main.tpl");
}

function fetchParentCategory(){
	return izy::getAll("select id, name from tb_catgallery where parent_id = 0 order by name asc");
}

?>