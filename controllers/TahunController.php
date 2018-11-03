<?php
class TahunController extends Controller{
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
  	 $data['title'] = "<i class='fa fa-calendar'></i> <b>Tahun Akademik</b>";
        $data['sub_title'] = "<i class='fa fa-calendar-check-o'></i> <b>Tahun Akademik Skripsi</b>";
        if(!$this->islogin('01')){
    return $this->view->render('no-access',FALSE);
}

  	$data['tahun'] = $this->model->getAll();

    return $this->view->render('tahun/index',FALSE,$data);
  }

   public function actiontambahtahun()
  {
  	$data['title'] = "<i class='fa fa-calendar'></i> <b>Tahun Akademik</b>";
        $data['sub_title'] = "<i class='fa fa-calendar-plus-o'></i> <b>Tambah Tahun Akademik Skripsi</b>";
        if(!$this->islogin('01')){
    return $this->view->render('no-access',FALSE);
}

    return $this->view->render('tahun/form-tambah',FALSE,$data);
  }

  public function actionaddtahun()
  {
  	if(!$this->islogin('01')){
    return $this->view->render('no-access',FALSE);
}

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
  	$data['title'] = "<i class='fa fa-calendar'></i> <b>Tahun Akademik</b>";
        $data['sub_title'] = "<i class='fa fa-edit'></i> <b>Edit Tahun Akademik Skripsi</b>";
        if(!$this->islogin('01')){
    return $this->view->render('no-access',FALSE);
}

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
  	if(!$this->islogin('01')){
    return $this->view->render('no-access',FALSE);
}

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
  			echo "<script>window.location.assign('?p=Tahun');</script>";
  		}
  	}else{
    		echo "<script>window.location.assign('?p=Tahun');</script>";  		
  	}
  }

  public function actionhapus()
  {
  	if(!$this->islogin('01')){
    return $this->view->render('no-access',FALSE);
}

  	$ID= $this->get('id');
  	//cek tahun
  	$tahun = $this->model->getByID($ID);
  	if(!$tahun){
  		echo "<script>alert('Data tidak ditemukan');</script>
    		<script>window.location.assign('?p=Tahun');</script>";
  	}else{
  	$this->model->delete(array("id_ta"=>$ID),"Tahun");
}
  }

}
