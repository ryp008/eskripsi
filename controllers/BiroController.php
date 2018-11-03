<?php


/**
 * Description of BiroController
 *
 * @author rolly
 */
class BiroController extends Controller{
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
      $data['title'] = "<i class='fa fa-user-circle'></i> <b>Staff Biro</b>";
        $data['sub_title'] = "<i class='fa fa-users'></i> <b>Staff Biro</b>";
        if(!$this->islogin('01')){
    return $this->view->render('no-access',FALSE, $data);
}
        $data['biro']=$this->model->find();
        //print_r($data);
        return $this->view->render('biro/index',FALSE,$data);
    }

    public function actionDetail(){
      $data['title'] = "<i class='fa fa-user-circle'></i> <b>Staff Biro</b>";
        $data['sub_title'] = "<i class='fa fa-user'></i> <b>Detail Staff Biro</b>";
        if(!$this->islogin('01')){
    return $this->view->render('no-access',FALSE, $data);
}

      $data['row']=$this->model->findOne(
        "*",
        "id=".$this->get('id')
      );
      return $this->view->render('biro/detail', FALSE, $data);
    }

    public function actionHapus(){
      if(!$this->islogin('01')){
    return $this->view->render('no-access',FALSE);
}
      $this->model->delete(
        array(
          "id"=>$this->get('id'),
        ),"Biro"
      );
    }

    public function actionTambah(){
      $data['title'] = "<i class='fa fa-user-circle'></i> <b>Staff Biro</b>";
        $data['sub_title'] = "<i class='fa fa-user-plus'></i> <b>Tambah Staff Biro</b>";
        if(!$this->islogin('01')){
    return $this->view->render('no-access',FALSE, $data);
}
      return $this->view->render('biro/_form', FALSE, $data);
    }

    public function actionSave(){
      if(!$this->islogin('01')){
    return $this->view->render('no-access',FALSE);
}
      $this->model->save(
        array(
          "nik"=>$this->post('nik'),
          "nama"=>$this->post('nama'),
          "bagian"=>$this->post('bagian')
        ),"Biro"
      );
    }

    public function actionUpdate(){
      $data['title'] = "<i class='fa fa-user-circle'></i> <b>Staff Biro</b>";
        $data['sub_title'] = "<i class='fa fa-edit'></i> <b>Edit Staff Biro</b>";
        if(!$this->islogin('01')){
    return $this->view->render('no-access',FALSE, $data);
}
      $data['row']=$this->model->findOne(
        "*",
        "id=".$this->get('id')
      );
      return $this->view->render('biro/edit', FALSE, $data);
    }

    public function actionEdit(){
      if(!$this->islogin('01')){
    return $this->view->render('no-access',FALSE);
}
      $ID = $this->post('id');
      $data_update = array(
          "nik"=>$this->post('nik'),
          "nama"=>$this->post('nama'),
          "bagian"=>$this->post('bagian')
        );

        $update = $this->model->edit($data_update, "id ='".$ID."'");
            if($update){
            echo "<script>alert('Sudah diubah');</script>
            <script>window.location.assign('?p=Biro');</script>";
            }else{
            echo "<script>window.location.assign('?p=Biro');</script>";
            }
    }

}
