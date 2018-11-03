
<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of StaffController
 *
 * @author rolly
 */
class StaffController extends Controller{
    //put your code here
	public function __construct() {
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
  $data['title'] = "<i class='fa fa-user-circle'></i> <b>Staff</b>";
  $data['sub_title'] = "<i class='fa fa-users'></i> <b>Data Staff Program Studi</b>";
  if(!$this->islogin('01')){
    return $this->view->render('no-access',FALSE, $data);
}

  $data['staff'] = $this->model->getAllJoin('tbl_staff_prodi','*', "inner join programstudi on programstudi.Kode = tbl_staff_prodi.KodeProdi", null, 'tbl_staff_prodi.Nama ASC');
  return $this->view->render('staff/index',FALSE,$data);	
}

public function actionTambah()
{
  $data['title'] = "<i class='fa fa-user-circle'></i> <b>Staff</b>";
  $data['sub_title'] = "<i class='fa fa-users'></i> <b>Tambah Staff Program Studi</b>";
  if(!$this->islogin('01')){
    return $this->view->render('no-access',FALSE, $data);
}

if(isset($_POST['simpan'])){
 $input = array(
  'NIK'          => $this->post('NIK'),
  'Nama'         => $this->post('Name'),
  'JenisKelamin' => $this->post('Sex'),
  'TglLahir'     => $this->post('TglLahir'),
  'TempatLahir'  => $this->post('TempatLahir'),
  'Alamat'       => $this->post('Alamat'),
  'Phone'        => $this->post('Phone'),
  'Bagian'       => $this->post('Bagian'),
  'KodeProdi'    => $this->post('Prodi')
);
 $insert = $this->model->save('tbl_staff_prodi', $input);
 if($insert){
    echo "<script>alert('Sudah disimpan');</script>
    <script>window.location.assign('?p=Staff');</script>";
}else{
    echo "<script>alert('Gagal disimpan');</script>
    <script>window.location.assign('?p=Staff');</script>";
}
}

$data['prodi'] = $this->model->getAll('programstudi', 'Kode, Prodi', null, 'Prodi asc');
return $this->view->render('staff/form-tambah',FALSE,$data);	
}

public function actionDetail()
{
     $data['title'] = "<i class='fa fa-user-circle'></i> <b>Staff</b>";
  $data['sub_title'] = "<i class='fa fa-user'></i> <b>Detail Staff Program Studi</b>";
  if(!$this->islogin('01')){
    return $this->view->render('no-access',FALSE, $data);
}

    $ID = $this->get('id');
    $Staff = $this->model->getAllJoin('tbl_staff_prodi', '*', "inner join programstudi on programstudi.Kode = tbl_staff_prodi.KodeProdi", "IDStaff='".$ID."'");
    if(empty($Staff)){
        echo "<script>alert('Data tidak ditemukan');</script>
        <script>window.location.assign('?p=Staff');</script>";
    }

    $data['staff']=$Staff;
    return $this->view->render('staff/detail', false, $data);

}

public function actionEdit()
{
    $data['title'] = "<i class='fa fa-user-circle'></i> <b>Staff</b>";
  $data['sub_title'] = "<i class='fa fa-users'></i> <b>Edit Staff Program Studi</b>";
  if(!$this->islogin('01')){
    return $this->view->render('no-access',FALSE, $data);
}

   $ID = $this->get('id');

   $staff = $this->model->getAllJoin('tbl_staff_prodi', '*', "inner join programstudi on programstudi.Kode = tbl_staff_prodi.KodeProdi", "IDStaff='".$ID."'");
   if(empty($staff)){
      echo "<script>alert('Data tidak ditemukan');</script>
      <script>window.location.assign('?p=Staff');</script>";
  }

  $data['staff']=$staff;
  $data['prodi'] = $this->model->getAll('programstudi', 'Kode, Prodi', null, 'Prodi asc');
  return $this->view->render('staff/form-edit', false, $data);
}

public function actionSimpanEdit()
{
   if(!$this->islogin('01')){
    return $this->view->render('no-access',FALSE);
}

   if(isset($_POST['simpan'])){
      $ID = $this->post('ID');
      $input = array(
          'NIK'          => $this->post('NIK'),
          'Nama'         => $this->post('Name'),
          'JenisKelamin' => $this->post('Sex'),
          'TglLahir'     => $this->post('TglLahir'),
          'TempatLahir'  => $this->post('TempatLahir'),
          'Alamat'       => $this->post('Alamat'),
          'Phone'        => $this->post('Phone'),
          'Bagian'       => $this->post('Bagian'),
          'KodeProdi'    => $this->post('Prodi')
      );
      $update = $this->model->edit($input, "IDStaff ='".$ID."'");
      if($update){
        echo "<script>alert('Sudah diubah');</script>
        <script>window.location.assign('?p=Staff');</script>";
    }
    else{
            //echo "<script>alert('Gagal diubah');</script>";
        echo "<script>window.location.assign('?p=Staff');</script>";
    }
}else{
  echo "<script>alert('Data tidak ditemukan');</script>
  <script>window.location.assign('?p=Staff');</script>";
}
}

public function actionHapus()
{
  if(!$this->islogin('01')){
    return $this->view->render('no-access',FALSE);
}
  $ID = $this->get('id');

  $staff = $this->model->getAll('tbl_staff_prodi', "*", "IDStaff ='".$ID."'");
  if(empty($staff)){
     echo "<script>alert('Data Tidak Ditemukan');</script>
     <script>window.location.assign('?p=Staff&x=Staff');</script>";
 }else{

     $this->model->delete(array("IDStaff"=>$ID),"Staff");
		//return $this->view->render('staff/form-edit-sempro',FALSE,$data);	
 }
}

}