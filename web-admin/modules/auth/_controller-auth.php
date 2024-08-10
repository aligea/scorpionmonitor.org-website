<?php
//-- router
$app->get('/auth', 'getview')->name('auth-view');
$app->post('/auth', 'postview')->name('auth-view');

$app->get('/auth/add', 'getview')->name('auth-insert');
$app->post('/auth/add', 'postview')->name('auth-insert');

$app->get('/auth/edit/:id', 'getview')->name('auth-update');
$app->post('/auth/edit/:id', 'postview')->name('auth-update');

$app->post('/auth/data', 'fetchdata')->name('auth-view-query');
$app->post('/auth/validate', 'validate')->name('novalidate');
$app->post('/auth/query-insert', 'simpandata')->name('auth-single-query');
$app->post('/auth/query-update', 'simpandata')->name('auth-single-query');
$app->post('/auth/query-delete', 'simpandata')->name('auth-single-query');

//-- controller
function simpandata(){
	$app = \Slim\Slim::getInstance();
	$request = $app->request();

	$idgrupuser = $request->params('idgrupuser');

	$datamoduladmin = array();
	foreach ($request->params('idmodul') as $key => $idmodul) {
		$obj = izy::dispense('tb_otorisasi_admin');
		$obj->idgrupuser = $idgrupuser;
		$obj->idmodul = $idmodul;
		$obj->is_can_view = ($request->params('is_can_view')[$idmodul]) ? 1 : 0;
		$obj->is_can_insert = ($request->params('is_can_insert')[$idmodul]) ? 1 : 0;
		$obj->is_can_update = ($request->params('is_can_update')[$idmodul]) ? 1 : 0;
		$obj->is_can_delete = ($request->params('is_can_delete')[$idmodul]) ? 1 : 0;

		$datamoduladmin[] = $obj;
	}


	$result = "";
	izy::begin();
	try {
		izy::exec("DELETE FROM tb_otorisasi_admin WHERE idgrupuser=?", array($idgrupuser));
		foreach ($datamoduladmin as $obj) {
			izy::store($obj);
		}

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
	
	$row = izy::findOne('tb_otorisasi_module_item', 'module=?', array($request->params('module')));
	if($row->id >0 && $row->id != $id){
		$arrayToJs[$i][0] = 'module';
		$arrayToJs[$i][1] = false;
		$arrayToJs[$i][2] = "This name is already taken.!";
	}else{
		$arrayToJs[$i][0] = 'module';
		$arrayToJs[$i][1] = true;
	}
	
	echo json_encode($arrayToJs);	
};


function fetchdata(){
	$app = \Slim\Slim::getInstance();
	$request = $app->request();

	$idgrupuser = $request->params('idgrupuser');

	//-- tarik data otorisasi grup user tsb
	$dataotorisasi = izy::getAll("SELECT A.*, B.single_module 
		FROM tb_otorisasi_admin A INNER JOIN tb_otorisasi_module_item B ON A.idmodul = B.id
		WHERE A.idgrupuser=?", array($idgrupuser));

	/*
	//-- Tarik data module
	$datamodule = izy::getAll("SELECT A.id, A.groupmenu, A.menu 
		FROM tb_otorisasi_module_item A INNER JOIN tb_otorisasi_groupmenu B ON A.groupmenu = B.nama
		ORDER BY B.urut ASC, A.urut ASC");

	//-- gabungkan data modul dan otorisasi
	$admin_modul = array();
	foreach ($datamodule as $module) {
		$admin_modul[$module['id']]['idmodul'] = $module['id'];
		$admin_modul[$module['id']]['groupmenu'] = $module['groupmenu'];
		$admin_modul[$module['id']]['menu'] = $module['menu'];
		$admin_modul[$module['id']]['is_can_view'] = $admin_modul[$module['id']]['is_can_insert'] = $admin_modul[$module['id']]['is_can_update'] = $admin_modul[$module['id']]['is_can_delete'] = 0;

		foreach ($dataotorisasi as $otorisasi) {
			if($otorisasi['idmodul'] == $module['id']){
				$admin_modul[$module['id']]['is_can_view'] = $otorisasi['is_can_view'];
				$admin_modul[$module['id']]['is_can_insert'] = $otorisasi['is_can_insert'];
				$admin_modul[$module['id']]['is_can_update'] = $otorisasi['is_can_update'];
				$admin_modul[$module['id']]['is_can_delete'] = $otorisasi['is_can_delete'];
			}
		}

	}
	*/

	$result = array();
	$result['data'] = $dataotorisasi;

	echo json_encode($result);
}

function postview(){
	require_once basepath.'/libraries/smarty/Smarty.class.php';
	
	$app = \Slim\Slim::getInstance();
	$request = $app->request();

	$smarty = newSmarty();

	$idgrup = $request->params('id');
	$selectedgrup = izy::load('tb_grupuser', $idgrup);

	$smarty->assign('datamodule', getAllModul());
	$smarty->assign('datagrupuser', getAllGrupuser());
	$smarty->assign('selectedgrup', $selectedgrup);

	$smarty->display(basepath.'/modules/auth/view-auth.tpl');
}

function getview(){
	require_once basepath.'/libraries/smarty/Smarty.class.php';
	
	$app = \Slim\Slim::getInstance();
	$request = $app->request();

	$smarty = newSmarty();

	$idgrup = $request->params('id');
	$selectedgrup = izy::load('tb_grupuser', $idgrup);

	$smarty->assign('datamodule', getAllModul());
	$smarty->assign('datagrupuser', getAllGrupuser());
	$smarty->assign('selectedgrup', $selectedgrup);
	$smarty->assign('content', basepath.'/modules/auth/view-auth.tpl');
	$smarty->display(basepath."/modules/main.tpl");
}

function getAllGrupuser(){
	return izy::getAll("SELECT * 
	FROM tb_grupuser
	ORDER BY grupuser ASC");	
}
function getAllModul(){
	return izy::getAll("SELECT A.id, A.groupmenu, A.menu 
		FROM tb_otorisasi_module_item A INNER JOIN tb_otorisasi_groupmenu B ON A.groupmenu = B.nama
		ORDER BY B.urut ASC, A.urut ASC");
}
?>