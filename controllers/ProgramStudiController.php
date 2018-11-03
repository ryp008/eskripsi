<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProgramStudiController
 *
 * @author rolly
 */
class ProgramStudiController extends Controller{
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

  public function index(){
    $data['title'] ="<i class='fa fa-bank'></i> <b>Program Studi</b>";
    $data['sub_title'] ="<i class='fa fa-bank'></i> <b>Program Studi</b>";

    if(!$this->islogin('01')){
      return $this->view->render('no-access',FALSE, $data);
    }
    $data['prodi']=$this->model->find();
    return $this->view->render('programstudi/index',FALSE,$data);
  }

  public function actionDetail(){
    if(!$this->islogin('01')){
    return $this->view->render('no-access',FALSE, $data);
  }
    $data=$this->model->findOne(
      "*",
      "IDProdi=".$this->get('id')
    );
    return $this->view->render('programstudi/detail', FALSE, $data);
  }

  public function actionHapus(){
    if(!$this->islogin('01')){
    return $this->view->render('no-access',FALSE, $data);
  }
    $this->model->delete(
      array(
        "IDProdi"=>$this->get('id'),
      ),"ProgramStudi"
    );
  }

  public function actionTambah(){

    $data['title'] ="<i class='fa fa-bank'></i> <b>Program Studi</b>";
   $data['sub_title'] ="<i class='fa fa-plus'></i> <b>Tambah Program Studi</b>";

   if(!$this->islogin('01')){
    return $this->view->render('no-access',FALSE, $data);
  }

    return $this->view->render('programstudi/_form', false, $data);
  }

  public function actionSave(){
    if(!$this->islogin('01')){
    return $this->view->render('no-access',FALSE, $data);
  }

    if(isset($_POST['simpan'])){
      $input =  array(
        'Kode'     => $this->post('Kode'),
        'Prodi'     => $this->post('Nama'),
        'Fakultas' => $this->post('Fakultas'),
        'KaProdi'  => $this->post('KaProdi'),
        'NIDN'     => $this->post('NIDN')
      );

      $insert = $this->model->save('programstudi', $input);
      if($insert){
        echo "<script>alert('Sudah disimpan');</script>
        <script>window.location.assign('?p=ProgramStudi');</script>";
      }else{
        echo "<script>alert('Gagal disimpan');</script>
        <script>window.location.assign('?p=ProgramStudi');</script>";
      }
    }else{
      echo "<script>window.location.assign('?p=ProgramStudi');</script>";
    }
  }

  public function actionUpdate(){
   $data['title'] ="<i class='fa fa-bank'></i> <b>Program Studi</b>";
   $data['sub_title'] ="<i class='fa fa-edit'></i> <b>Update Program Studi</b>";

   if(!$this->islogin('01')){
    return $this->view->render('no-access',FALSE, $data);
  }

  $prodi =$this->model->findOne(
    "*",
    "IDProdi=".$this->get('id')
  );

  if(empty($prodi)){
    echo "<script>alert('Data tidak ditemukan');</script>
    <script>window.location.assign('?p=ProgramStudi');</script>";
  }       
  $data['prodi'] = $prodi;      
  return $this->view->render('programstudi/_form-edit', false, $data);
}

public function actionEdit(){
  if(!$this->islogin('01')){
    return $this->view->render('no-access',FALSE, $data);
  }

  if(isset($_POST['simpan'])){
    $input =  array(
      'Kode'     => $this->post('Kode'),
      'Prodi'     => $this->post('Nama'),
      'Fakultas' => $this->post('Fakultas'),
      'KaProdi'  => $this->post('KaProdi'),
      'NIDN'     => $this->post('NIDN')
    );

    $update = $this->model->edit($input, "IDProdi='".$this->post('IDProdi')."'");
    if($update){
      echo "<script>alert('Sudah diubah');</script>
      <script>window.location.assign('?p=ProgramStudi');</script>";
    }else{
      echo "<script>alert('Gagal diubah');</script>
      <script>window.location.assign('?p=ProgramStudi');</script>";
    }
  }else{
    echo "<script>window.location.assign('?p=ProgramStudi');</script>";
  }
}

}
