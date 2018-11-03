<?php

class DashboardController  extends Controller{
  public function __construct() {
    parent::__construct();
  }

  public function index(){
   // $data = $this->model->find();
    $this->view->render("index/index");
  }

  public function actionAbout(){

      return $this->view->render('index/ebout');
  }

  public function actionBantuan(){
      return $this->view->render('index/bantuan');
  }

  public function actionEbooks(){
      return $this->view->render('index/ebooks');
  }

  public function actionContact(){
      return $this->view->render('index/contact');
  }

    public function actionTutorial(){
      return $this->view->render('index/tutorial');
  }

  public function actionLogout(){
    echo "<script> alert('Anda sudah logout'); window.location.assign('?p=index');</script>";
  }

}
