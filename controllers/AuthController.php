<?php

class AuthController extends Controller{

  public function __construct(){
    parent::__construct();
  }

  public function index(){
    $this->view->render("user/index");
  }

  public function actionLogin(){

  }

  public function actionLogout(){
    //hapus session
    session_destroy();
    //kembalikan ke index
    echo "<script> window.location.assign('?p=index'); </script>";
  }

}

 ?>
