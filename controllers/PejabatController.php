<?php


/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PejabatController
 *
 * @author rolly
 */
class PejabatController extends Controller{
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
      $data['title'] = "<i class='fa fa-users'></i> <b>Pejabat</b>";
        $data['sub_title'] = "<i class='fa fa-users'></i> <b>Pejabat</b>";
        if(!$this->islogin('01')){
    return $this->view->render('no-access',FALSE, $data);
}
        $data['pj'] = $this->model->find();
        return $this->view->render('pejabat/index',FALSE,$data);
    }

    public function actionTambah(){
       $data['title'] = "<i class='fa fa-users'></i> <b>Pejabat</b>";
        $data['sub_title'] = "<i class='fa fa-user-plus'></i> <b>Tambah Pejabat</b>";
        if(!$this->islogin('01')){
    return $this->view->render('no-access',FALSE, $data);
}
      return $this->view->render("pejabat/_form" , FALSE, $data);
    }

    public function actionSave(){
       if(!$this->islogin('01')){
    return $this->view->render('no-access',FALSE);
}
      $this->model->save(
        array(
          "nidn"=>$this->post("nidn"),
          "nama"=>$this->post("nama"),
          "jabatan"=>$this->post("jabatan"),
          "periode"=>$this->post("periode")
        ),
        "Pejabat"
      );
    }

    public function actionHapus(){
      if(!$this->islogin('01')){
    return $this->view->render('no-access',FALSE);
}
      $this->model->delete(
        array("id"=>$this->get('id')),"Pejabat"
      );
    }

    public function actionDetail(){
      $data['title'] = "<i class='fa fa-users'></i> <b>Pejabat</b>";
        $data['sub_title'] = "<i class='fa fa-user-circle'></i> <b>Detail Pejabat</b>";
       if(!$this->islogin('01')){
    return $this->view->render('no-access',FALSE);
}
      $data['row']=$this->model->findOne(
        "*",
        "id=".$this->get('id')
      );
      return $this->view->render('pejabat/detail',FALSE,$data);
    }

    public function actionUpdate(){
      if(!$this->islogin('01')){
    return $this->view->render('no-access',FALSE);
}
      $data=$this->model->findOne(
        "*",
        "id=".$this->get('id')
      );
      return $this->view->render('pejabat/edit',FALSE,$data);
    }

    public function actionEdit(){
 if(!$this->islogin('01')){
    return $this->view->render('no-access',FALSE);
}
      $update = $this->model->edit(
        array(
          "nidn"=>$this->post("nidn"),
          "nama"=>$this->post("nama"),
          "jabatan"=>$this->post("jabatan"),
          "periode"=>$this->post("periode")
        ),
        "id=".$this->post('id')
      );
      if($update){
            echo "<script>alert('Sudah diubah');</script>
            <script>window.location.assign('?p=Pejabat');</script>";
            }
            else{
            //echo "<script>alert('Gagal diubah');</script>";
            echo "<script>window.location.assign('?p=Pejabat');</script>";
            }
    }

}
