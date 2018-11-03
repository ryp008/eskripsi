<?php
class BaController extends Controller{
  public function __construct()
  {
    parent::__construct();
  }

  public function islogin()
    {
    	if(!Session::get('islogin') and Session::get('level') != 1){
    		echo "<script>window.location.assign('?p=index');</script>";
    	}
    }

  public function index()
  {
  	$this->islogin();
  	$data['title'] ='no-title';
  	$data['sub_title'] = 'Master Bahasa Pemrograman';

  	$data['bahasa'] = $this->model->getAll();

    return $this->view->render('bahasa/index',FALSE,$data);
  }

   public function actiontambahtahun()
  {
  	$this->islogin();

  	$data['title'] ='no-title';
  	$data['sub_title'] = 'Tambah Tahun Akademik Skripsi';

    return $this->view->render('tahun/form-tambah',FALSE,$data);
  }

  public function actionaddtahun()
  {
  	$this->islogin();

  	if(isset($_POST['submit'])){

  		$data_input = array(
  					'kode' => $this->post('Kode'),
  					'tahun' => $this->post('TA'),
  					'aktif' => $this->post('Status'),
  					'ket' => $this->post('Ket')
  				);
  		//insert
  		$insert = $this->model->save('tbl_ta', $data_input);
  		if($insert){
    		echo "<script>alert('Tahun sudah disimpan');</script>
    		<script>window.location.assign('?p=Tahun');</script>";
  		}else{
  			echo "<script>alert('Tahun gagal disimpan');</script>
    		<script>window.location.assign('?p=Tahun');</script>";
  		}
  	}else{
    		echo "<script>window.location.assign('?p=Tahun');</script>";

  	}
  }

  public function actionedittahun()
  {
  	$this->islogin();

  	$data['title'] ='no-title';
  	$data['sub_title'] = 'Tambah Tahun Akademik Skripsi';

  	$ID= $this->get('id');
  	//cek tahun
  	$tahun = $this->model->getByID($ID);
  	if(!$tahun){
  		echo "<script>alert('Data tidak ditemukan');</script>
    		<script>window.location.assign('?p=Tahun');</script>";
  	}

  	$data['input'] = $tahun;
    return $this->view->render('tahun/form-edit',FALSE,$data);
  }

  public function actionedit()
  {
  	$this->islogin();

  	if(isset($_POST['submit'])){
  		$ID = $this->post('textID');
  		$data_input = array(
  					'kode' => $this->post('Kode'),
  					'tahun' => $this->post('TA'),
  					'aktif' => $this->post('Status'),
  					'ket' => $this->post('Ket')
  				);
  		$update = $this->model->edit($data_input, "id_ta =".$ID);
  		if($update){
  			echo "<script>alert('Tahun sudah diedit');</script>
    		<script>window.location.assign('?p=Tahun');</script>";
  		}else{
  			echo "<script>alert('Tahun gagal diedit');</script>
    		<script>window.location.assign('?p=Tahun');</script>";
  		}
  	}else{
    		echo "<script>window.location.assign('?p=Tahun');</script>";  		
  	}
  }

  public function actionhapus()
  {
  	$this->islogin();

  	$ID= $this->get('id');
  	//cek tahun
  	$tahun = $this->model->getByID($ID);
  	if(!$tahun){
  		echo "<script>alert('Data tidak ditemukan');</script>
    		<script>window.location.assign('?p=Tahun');</script>";
  	}

  	$this->model->delete(array("id_ta"=>$ID),"Tahun");

  }

}
