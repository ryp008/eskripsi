<?php

class HomeController extends Controller{

  public function __construct(){
    parent::__construct();
  }

  public function index(){
      $data['title'] = 'Dashbord Skripsi';
    if(isset($_GET['go'])){
      $data['sub_title'] = 'Hasil Pencarian';
      $key = $this->get('key');

      $select = "mhsw.NIM, mhsw.Name, mhsw.KodeJurusan, tbl_judul.judul, tbl_judul.latar, tbl_judul.bahasa, tbl_judul.instansi, tbl_judul.status, tbl_judul.objek, tbl_judul.tgl_pengajuan";
      $join = "inner join mhsw on mhsw.NIM = tbl_judul.nim";
      $where ="tbl_judul.nim LIKE '%".$key."%' or tbl_judul.judul LIKE '%".$key."%'";
      $data['judul'] = $this->model->getAllJoin('tbl_judul', $select, $join, $where);
    }else{
      $ta = $this->model->getAll('tbl_ta', 'tahun',"aktif = 'Y'");
      $data['sub_title'] = 'Pengajuan Judul Terbaru T.A '.$ta[0]['tahun'];
   $data['judul'] = $this->model->find();
 }

 $s = "(SELECT COUNT(nim) as Total FROM tbl_judul where IsEmpty='N') as total,
    (SELECT COUNT(nim) as Total FROM tbl_judul where IsEmpty='N' and status='SUDAH ACC') as acc,
    (SELECT COUNT(nim) as Total FROM tbl_judul where IsEmpty='N' and status='SUDAH DITOLAK')  as tolak,
    (SELECT COUNT(nim) as Total FROM tbl_judul where IsEmpty='N' and status='SEDANG DIPROSES')  as proses";
  $data['jml'] = $this->model->getAll('tbl_judul', $s);

    $this->view->render("index/index", false, $data);
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

?>
