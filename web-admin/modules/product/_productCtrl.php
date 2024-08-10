<?php
//-- router
$app->get('/product', 'getview')->name('product-view');
$app->post('/product', 'postview')->name('product-view');

$app->get('/product/add', 'getadd')->name('product-insert');
$app->post('/product/add', 'postadd')->name('product-insert');

$app->get('/product/edit/:id', 'getedit')->name('product-update');
$app->post('/product/edit/:id', 'postedit')->name('product-update');

$app->post('/product/data', 'fetchdata')->name('product-view-query');
$app->post('/product/validate', 'validate')->name('novalidate');
$app->post('/product/query-insert', 'insertdata')->name('product-insert-query');
$app->post('/product/query-update', 'updatedata')->name('product-update-query');
$app->post('/product/query-delete', 'deletedata')->name('product-delete-query');

//-- controller
function postedit($id){
	require_once basepath.'/libraries/smarty/Smarty.class.php';
	
	$smarty = newSmarty();
	
	$data = izy::load('tb_products', $id);
	$row = izy::getRow('SELECT category_id FROM tb_products_catproducts WHERE product_id=?', array($data->id));


	$smarty->assign('category_id', $row['category_id']);
	$smarty->assign('data', $data);
	$smarty->assign('datacategory', fetchCategory());
	$smarty->assign('dataatribut', fetchAttributeData());
	$smarty->display(basepath.'/modules/product/edit-product.tpl');
}

function getedit($id){
	require_once basepath.'/libraries/smarty/Smarty.class.php';
	
	$smarty = newSmarty();

	$data = izy::load('tb_products', $id);
	$row = izy::getRow('SELECT category_id FROM tb_products_catproducts WHERE product_id=?', array($data->id));
	$smarty->assign('category_id', $row['category_id']);
	$smarty->assign('data', $data);
	$smarty->assign('datacategory', fetchCategory());
	$smarty->assign('dataatribut', fetchAttributeData());
	$smarty->assign('content', basepath.'/modules/product/edit-product.tpl');
	$smarty->display(basepath."/modules/main.tpl");
}

function deletedata(){
	$app = \Slim\Slim::getInstance();
	$request = $app->request();

	$dataid = $request->params('id');
	
	$result = "";
	izy::begin();
	try {
		izy::exec('delete from tb_products where id=?', array($dataid));	
		izy::exec('delete from tb_products_catproducts where product_id=?', array($dataid));
		
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

	$obj = izy::dispense('tb_products');
	$obj->name = $request->params('name');
	$obj->merek = $request->params('merek');
	$obj->tanggal = date('Y-m-d', strtotime($request->params('tanggal')));
	$obj->simple = $request->params('simple');
	$obj->description = str_replace(baseurlroot, '[baseurlroot]', $request->params('description'));
	$obj->price = $request->params('price');
	$obj->spesial = $request->params('special');
	$obj->images = str_replace(baseurlroot, '[baseurlroot]', $request->params('images'));
	$obj->images_large = str_replace(baseurlroot, '[baseurlroot]', $request->params('images'));
	$obj->status = $request->params('status');
	$obj->disc = $request->params('disc');
	$obj->new = ($request->params('new') == "")? 'N' : $request->params('new');
	$obj->terlaris = ($request->params('terlaris') == "")? '0' : $request->params('terlaris');
	$obj->featured = ($request->params('featured') == "")? 'N' : $request->params('featured');
	$obj->berat = $request->params('berat');
	$obj->tag = $request->params('tag');
	$obj->atribut = json_encode(array(
		'name'=>$request->params('atribut_name'),
		'data'=>$request->params('atribut_data')
		));
	$obj->atribut2 = json_encode(array(
		'name'=>$request->params('atribut2_name'),
		'data'=>$request->params('atribut2_data')
		));
	$obj->alias = friendlyString($obj->name);

	//-- setel gambar additional (masukkan juga sebagai add1, add2, add3)
	$additional = $request->params('imgadd');
	$images_additional = array();
	if(count($request->params('imgadd')) > 0){
		$index = 1;
		foreach ($additional as $key => $value) {
			$images = str_replace(baseurlroot, '[baseurlroot]', $value);
			if($index == 1){
				$obj->add1 = $images;
			}
			if($index == 2){
				$obj->add2 = $images;
			}
			if($index == 3){
				$obj->add3 = $images;
			}
			$images_additional[] = $images;
			$index++;
		}
		$obj->images_additional = json_encode($images_additional);
	}

	$result = "";
	izy::begin();
	try {
		$product_id = izy::store($obj);

		izy::exec("INSERT INTO tb_products_catproducts(product_id, category_id) VALUES (:product_id, :category_id)", 
			array('product_id'=>$product_id, 'category_id'=>$request->params('category_id')));
		
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

	$obj = izy::load('tb_products', $request->params('id'));
	$obj->name = $request->params('name');
	$obj->merek = $request->params('merek');
	$obj->tanggal = date('Y-m-d', strtotime($request->params('tanggal')));
	$obj->simple = $request->params('simple');
	$obj->description = $request->params('description');
	$obj->price = $request->params('price');
	$obj->spesial = $request->params('special');
	$obj->images = str_replace(baseurlroot, '[baseurlroot]', $request->params('images'));
	$obj->images_large = str_replace(baseurlroot, '[baseurlroot]', $request->params('images'));
	$obj->status = $request->params('status');
	$obj->disc = $request->params('disc');
	$obj->new = ($request->params('new') == "")? 'N' : $request->params('new');
	$obj->terlaris = ($request->params('terlaris') == "")? '0' : $request->params('terlaris');
	$obj->featured = ($request->params('featured') == "")? 'N' : $request->params('featured');
	$obj->berat = $request->params('berat');
	$obj->tag = $request->params('tag');
	$obj->atribut = json_encode(array(
		'name'=>$request->params('atribut_name'),
		'data'=>$request->params('atribut_data')
		));
	$obj->atribut2 = json_encode(array(
		'name'=>$request->params('atribut2_name'),
		'data'=>$request->params('atribut2_data')
		));
	$obj->alias = friendlyString($obj->name);


	//-- setel gambar additional (masukkan juga sebagai add1, add2, add3)
	$additional = $request->params('imgadd');
	$images_additional = array();
	if(count($request->params('imgadd')) > 0){
		$index = 1;
		foreach ($additional as $key => $value) {
			$images = str_replace(baseurlroot, '[baseurlroot]', $value);
			if($index == 1){
				$obj->add1 = $images;
			}
			if($index == 2){
				$obj->add2 = $images;
			}
			if($index == 3){
				$obj->add3 = $images;
			}
			$images_additional[] = $images;
			$index++;
		}
		$obj->images_additional = json_encode($images_additional);
	}
	

	$result = "";
	izy::begin();
	try {
		$product_id = izy::store($obj);

		izy::exec("DELETE FROM tb_products_catproducts WHERE product_id=?", array($product_id));
		izy::exec("INSERT INTO tb_products_catproducts(product_id, category_id) VALUES (:product_id, :category_id)", 
			array('product_id'=>$product_id, 'category_id'=>$request->params('category_id')));
		
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
	
	$row = izy::findOne('tb_products', 'name=?', array($request->params('id')));
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
	
	$smarty->assign('datacategory', fetchCategory());
	$smarty->assign('dataatribut', fetchAttributeData());
	$smarty->display(basepath.'/modules/product/add-product.tpl');
}

function getadd(){
	require_once basepath.'/libraries/smarty/Smarty.class.php';
	
	$smarty = newSmarty();
	$smarty->assign('datacategory', fetchCategory());
	$smarty->assign('dataatribut', fetchAttributeData());
	$smarty->assign('content', basepath.'/modules/product/add-product.tpl');
	$smarty->display(basepath."/modules/main.tpl");
}

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
	$sql = "SELECT A.price, A.name, A.id, C.name as categoryname
	FROM tb_products A LEFT JOIN tb_products_catproducts B ON A.id = B.product_id LEFT JOIN tb_catproducts C ON B.category_id = C.id
	WHERE A.id IS NOT NULL $filter_query $filter_kategory
	ORDER BY C.name ASC, A.name ASC ";
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
	$smarty->display(basepath.'/modules/product/view-product.tpl');
}

function getview(){
	require_once basepath.'/libraries/smarty/Smarty.class.php';
	
	$smarty = newSmarty();
	$datacategory = fetchCategory();
	$smarty->assign('datacategory', $datacategory);

	$smarty->assign('content', basepath.'/modules/product/view-product.tpl');
	$smarty->display(basepath."/modules/main.tpl");
}

function fetchCategory(){
	return izy::getAll("SELECT A.id, A.name, A.parent_id, CONCAT(B.name, ' - ') as parentcategory
		FROM tb_catproducts A LEFT JOIN tb_catproducts B ON A.parent_id = B.id
		WHERE (SELECT COUNT(C.id) FROM tb_catproducts C WHERE A.id = C.parent_id ) = 0
		ORDER BY B.name ASC, A.name ASC");
}

function fetchAttributeData(){
	return array('Warna', 'Ukuran', 'Kelas');
}
?>