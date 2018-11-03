<?php
class BahasaController extends Controller{
  public function __construct()
  {
    parent::__construct();
  }

  public function islogin($level)
  {
    if(!Session::get('islogin')){
      echo "<script>window.location.assign('?p=index');</script>";
    }

      //cek level
    $sess_level = Session::get('level');
    $ceklevel = strpos($level, "$sess_level");
    return $ceklevel;
  }

  public function index()
  {
   $data['title'] = "<i class='fa fa-code'></i> <b>Bahasa Pemrograman</b>";
   $data['sub_title'] = "<i class='fa fa-code'></i> <b>Bahasa Pemrograman</b>";
   if(!$this->islogin('01')){
    return $this->view->render('no-access',FALSE, $data);
  }

  $data['bahasa'] = $this->model->getAll();

  return $this->view->render('bahasa/index',FALSE,$data);
}

public function actionTambah()
{  	
  $data['title'] = "<i class='fa fa-code'></i> <b>Bahasa Pemrograman</b>";
  $data['sub_title'] = "<i class='fa fa-plus'></i> <b>Tambah Bahasa Pemrograman</b>";
  if(!$this->islogin('01')){
    return $this->view->render('no-access',FALSE, $data);
  }

  return $this->view->render('bahasa/form-tambah',FALSE,$data);
}

public function actionAddBahasa()
{
 if(!$this->islogin('01')){
  return $this->view->render('no-access',FALSE, $data);
}

if(isset($_POST['submit'])){

  $data_input = array(
   'nama' => $this->post('Nama')
 );
  		//insert
  $insert = $this->model->save('tbl_bahasa', $data_input);
  if($insert){
    echo "<script>alert('Bahasa Pemrograman sudah disimpan');</script>
    <script>window.location.assign('?p=Bahasa');</script>";
  }else{
   echo "<script>alert('Bahasa Pemrograman gagal disimpan');</script>
   <script>window.location.assign('?p=Bahasa');</script>";
 }
}else{
  echo "<script>window.location.assign('?p=Bahasa');</script>";
}
}

public function actionEditBahasa()
{  	
  $data['title'] = "<i class='fa fa-code'></i> <b>Bahasa Pemrograman</b>";
  $data['sub_title'] = "<i class='fa fa-edit'></i> <b>Edit Bahasa Pemrograman</b>";
  if(!$this->islogin('01')){
    return $this->view->render('no-access',FALSE, $data);
  }
  $ID= $this->get('id');
  	//cek tahun
  $bahasa = $this->model->getByID($ID);
  if(!$bahasa){
    echo "<script>alert('Data tidak ditemukan');</script>
    <script>window.location.assign('?p=Bahasa');</script>";
  }

  $data['input'] = $bahasa;
  return $this->view->render('bahasa/form-edit',FALSE,$data);
}

public function actionEdit()
{
 if(!$this->islogin('01')){
  return $this->view->render('no-access',FALSE, $data);
}

if(isset($_POST['submit'])){
  $ID = $this->post('textID');
  $data_input = array(
   'nama' => $this->post('Nama')
 );
  $update = $this->model->edit($data_input, "id =".$ID);
  if($update){
   echo "<script>alert('Bahasa sudah diedit');</script>
   <script>window.location.assign('?p=Bahasa');</script>";
 }else{
   echo "<script>alert('Bahasa gagal diedit');</script>
   <script>window.location.assign('?p=Bahasa');</script>";
 }
}else{
  echo "<script>window.location.assign('?p=Bahasa');</script>";  		
}
}

public function actionHapus()
{
 if(!$this->islogin('01')){
  return $this->view->render('no-access',FALSE, $data);
}

$ID= $this->get('id');
  	//cek tahun
$tahun = $this->model->getByID($ID);
if(!$tahun){
  echo "<script>alert('Data tidak ditemukan');</script>
  <script>window.location.assign('?p=Bahasa');</script>";
}else{
 $this->model->delete(array("id"=>$ID),"Bahasa");
}
}

}
