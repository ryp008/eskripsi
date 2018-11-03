<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AdhockController
 *
 * @author rolly
 */
class AdhockController extends Controller{
    //put your code here

  public function __construct() {
    parent::__construct();
  }

  public function islogin()
  {
    if(!Session::get('islogin')){
      echo "<script>window.location.assign('?p=index');</script>";
    }
  }

  public function index(){

    $this->islogin();
    $data['title'] = 'Tim Adhock';
    $data['sub_title'] = 'Tim Adhock';

    $select = "dosen.NIDN, dosen.Name, dosen.Gelar, tbl_tim_adhock.*";
    $join = "inner join dosen on dosen.ID = tbl_tim_adhock.iddosen";

    $where = '';
    if(Session::get('prodi') != 'all'){
      $where = "tbl_tim_adhock.prodi ='".Session::get('prodi')."'";
    }

    $data['tim'] = $this->model->getAllJoin('tbl_tim_adhock', $select, $join, $where, "tbl_tim_adhock.prodi, dosen.Name ASC");

    return $this->view->render('adhock/index',FALSE,$data);
  }

  public function actionDetail(){
    $data=$this->model->findOne(
      "*",
      "id=".$this->get('id')
    );
    return $this->view->render('adhock/detail', FALSE, $data);
  }

  public function actionHapus(){
    $this->model->delete(
      array(
        "id"=>$this->get('id'),
      ),"Adhock"
    );
  }

  public function actionTambah(){
    $this->islogin();
    $data['title'] = 'Tim Adhock';
    $data['sub_title'] ='Tambah Tim Adhock';
    $data['dosen'] = $this->model->getAll('dosen', "ID, CONCAT_WS(', ',Name, dosen.Gelar) as NamaDosen", null, "Name ASC");

    if(isset($_POST['simpan'])){
      $IDDosen = $this->post('IDDosen');
      $prodi = $this->post('Prodi');

      $insert = $this->model->save('tbl_tim_adhock', array('iddosen' => $IDDosen, 'prodi' => $prodi));
      if($insert){
        echo "<script>alert('Sudah Disimpan');</script>;
        <script>window.location.assign('?p=Adhock');</script>";
      }else{
        echo "<script>alert('Gagal Disimpan');</script>;
        <script>window.location.assign('?p=Adhock');</script>";
      }
    }
    return $this->view->render('adhock/tambah_form', false, $data);
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

  public function actionEdit(){
    $this->model->edit(
      array(
        "nik"=>$this->post('nik'),
        "nama"=>$this->post('nama'),
        "bagian"=>$this->post('bagian')
      ),"id=".$this->post('id'),"Adhock"
    );
  }

}
