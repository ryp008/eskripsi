<?php


class ArsipController extends Controller{
  public function __construct(){
    parent::__construct();
  }

  public function index(){
    $data=$this->model->find();
    return $this->view->render('arsip/index',FALSE, $data);
  }

}

 ?>
