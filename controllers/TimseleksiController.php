<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TimseleksiController
 *
 * @author rolly
 */
class TimseleksiController extends Controller{
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

    $data['title'] = "<i class='fa fa-user-secret'></i> <b>Tim Seleksi Judul</b>";
   $data['sub_title'] = "<i class='fa fa-users'></i> <b>Tim Seleksi Judul</b>";
   if(!$this->islogin('01')){
    return $this->view->render('no-access',FALSE, $data);
  }

    $select = "dosen.NIDN, dosen.Name, dosen.Gelar, tbl_tim_seleksi.*";
    $join = "inner join dosen on dosen.ID = tbl_tim_seleksi.iddosen";

    $where = '';
    if(Session::get('prodi') != 'all'){
      $where = "tbl_tim_seleksi.prodi ='".Session::get('prodi')."'";
    }

    $data['tim'] = $this->model->getAllJoin('tbl_tim_seleksi', $select, $join, $where, "tbl_tim_seleksi.prodi, dosen.Name ASC");

    return $this->view->render('timseleksi/index',FALSE,$data);
  }

  /*public function actionDetail(){
    $data=$this->model->findOne(
      "*",
      "id=".$this->get('id')
    );
    return $this->view->render('adhock/detail', FALSE, $data);
  }*/

  public function actionHapus(){

   if(!$this->islogin('01')){
    return $this->view->render('no-access',FALSE);
  }

    $this->model->delete(
      array(
        "id"=>$this->get('id'),
      ),"Timseleksi"
    );
  }

  public function actionTambah(){
    $data['title'] = "<i class='fa fa-user-secret'></i> <b>Tim Seleksi Judul</b>";
   $data['sub_title'] = "<i class='fa fa-user-plus'></i> <b>Tambah Tim Seleksi Judul</b>";
   if(!$this->islogin('01')){
    return $this->view->render('no-access',FALSE, $data);
  }

    $data['dosen'] = $this->model->getAll('dosen', "ID, CONCAT_WS(', ',Name, dosen.Gelar) as NamaDosen", null, "Name ASC");

    if(isset($_POST['simpan'])){
      $IDDosen = $this->post('IDDosen');
      $prodi = $this->post('Prodi');

      $insert = $this->model->save('tbl_tim_seleksi', array('iddosen' => $IDDosen, 'prodi' => $prodi));
      if($insert){
        echo "<script>alert('Sudah Disimpan');</script>;
        <script>window.location.assign('?p=Timseleksi');</script>";
      }else{
        echo "<script>alert('Gagal Disimpan');</script>;
        <script>window.location.assign('?p=Timseleksi');</script>";
      }
    }
    return $this->view->render('timseleksi/tambah_form', false, $data);
  }

  public function actionEdit(){
   $data['title'] = "<i class='fa fa-user-secret'></i> <b>Tim Seleksi Judul</b>";
   $data['sub_title'] = "<i class='fa fa-edit'></i> <b>Edit Tim Seleksi Judul</b>";
   if(!$this->islogin('01')){
    return $this->view->render('no-access',FALSE, $data);
  }

    $data['dosen'] = $this->model->getAll('dosen', "ID, CONCAT_WS(', ',Name, dosen.Gelar) as NamaDosen", null, "Name ASC");

    if(isset($_POST['simpan'])){
      $IDTim = $this->post('idtim');
      //$IDDosen = $this->post('IDDosen');
      $prodi = $this->post('Prodi');

      $update = $this->model->edit(array('prodi' => $prodi), "id ='".$IDTim."'");
      if($update){
        echo "<script>alert('Sudah Disimpan');</script>;
        <script>window.location.assign('?p=Timseleksi');</script>";
      }else{
        echo "<script>alert('Gagal Disimpan');</script>;
        <script>window.location.assign('?p=Timseleksi');</script>";
      }
    }

    $ID = $this->get('id');
    $tim = $this->model->getAll('tbl_tim_seleksi', '*', "id ='".$ID."'");
    if(empty($tim)){
      echo "<script>alert('Data tidak ditemukan');</script>;
        <script>window.location.assign('?p=Timseleksi');</script>";
    }

    $data['row'] = $tim;
    return $this->view->render('timseleksi/edit_form', false, $data);
  }

  public function actionSave(){
    $this->model->save(
      array(
        "nik"=>$this->post('nik'),
        "nama"=>$this->post('nama'),
        "bagian"=>$this->post('bagian')
      ),"Adhock"
    );
  }

  public function actionUpdate(){
    $data=$this->model->findOne(
      "*",
      "id=".$this->get('id')
    );
    return $this->view->render('adhock/edit', FALSE, $data);
  }

  public function actionDetail(){
$data['title'] = "<i class='fa fa-user-secret'></i> <b>Tim Seleksi Judul</b>";
   $data['sub_title'] = "<i class='fa fa-user-circle'></i> <b>Detail Tim Seleksi Judul</b>";
   if(!$this->islogin('01')){
    return $this->view->render('no-access',FALSE, $data);
  }

    $IDtim = $this->get('id');

    $select = "dosen.NIDN, dosen.Name, dosen.Gelar, tbl_tim_seleksi.*";
    $join = "inner join dosen on dosen.ID = tbl_tim_seleksi.iddosen";

    $where = "tbl_tim_seleksi.id='".$IDtim."' ";
    if(Session::get('prodi') != 'all'){
      $where = " and tbl_tim_seleksi.prodi ='".Session::get('prodi')."'";
    }

    $data['tim'] = $this->model->getAllJoin('tbl_tim_seleksi', $select, $join, $where, "tbl_tim_seleksi.prodi, dosen.Name ASC");

    $select2 = 'mhsw.NIM, mhsw.Name, tbl_judul.judul, tbl_judul.status, tbl_judul.rekomendasi, tbl_judul.tahun';
    $join2  ="inner join mhsw on mhsw.NIM = tbl_judul.nim
              inner join tbl_tim_seleksi on tbl_tim_seleksi.iddosen = tbl_judul.dosenrekom";
    $data['judul'] = $this->model->getAllJoin('tbl_judul', $select, $join, $where, "tbl_judul.tahun, mhsw.Name ASC");
    
    return $this->view->render('timseleksi/detail', FALSE, $data);    
  }

  }
