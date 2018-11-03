<?php

class StatistikController extends Controller{

  public function __construct(){
    parent::__construct();
  }

  public function index(){
      $data['title'] = 'Dashbord Skripsi';
  
 $s = "(SELECT COUNT(nim) as Total FROM tbl_judul where IsEmpty='N') as total,
    (SELECT COUNT(nim) as Total FROM tbl_judul where IsEmpty='N' and status='SUDAH ACC') as acc,
    (SELECT COUNT(nim) as Total FROM tbl_judul where IsEmpty='N' and status='SUDAH DITOLAK')  as tolak,
    (SELECT COUNT(nim) as Total FROM tbl_judul where IsEmpty='N' and status='SEDANG DIPROSES')  as proses";
  $data['jml'] = $this->model->getAll('tbl_judul', $s);

  //prodi si
  $si = "(SELECT COUNT(nim) as Total FROM tbl_judul where IsEmpty='N' and prodi ='SI') as total,
    (SELECT COUNT(nim) as Total FROM tbl_judul where IsEmpty='N' and status='SUDAH ACC' and prodi ='SI') as acc,
    (SELECT COUNT(nim) as Total FROM tbl_judul where IsEmpty='N' and status='SUDAH DITOLAK' and prodi ='SI')  as tolak,
    (SELECT COUNT(nim) as Total FROM tbl_judul where IsEmpty='N' and status='SEDANG DIPROSES' and prodi ='SI')  as proses";
  $where = "tbl_judul.prodi ='SI'";
  $data['jmlsi'] = $this->model->getAll('tbl_judul', $si, $where);

  //prodi si
  $sk = "(SELECT COUNT(nim) as Total FROM tbl_judul where IsEmpty='N' and prodi ='SK') as total,
    (SELECT COUNT(nim) as Total FROM tbl_judul where IsEmpty='N' and status='SUDAH ACC' and prodi ='SK') as acc,
    (SELECT COUNT(nim) as Total FROM tbl_judul where IsEmpty='N' and status='SUDAH DITOLAK' and prodi ='SK')  as tolak,
    (SELECT COUNT(nim) as Total FROM tbl_judul where IsEmpty='N' and status='SEDANG DIPROSES' and prodi ='SK')  as proses";
  $where = "tbl_judul.prodi ='SK'";
  $data['jmlsk'] = $this->model->getAll('tbl_judul', $sk, $where);

  $data['ta'] = $this->model->getAll('tbl_ta', 'kode', null, "kode asc");
  //acc
  foreach ($data['ta'] as $value) {
      $select = "count(tbl_judul.status) as Jacc";
      $join = "inner join tbl_ta on tbl_ta.kode = tbl_judul.tahun";
      $where = "tbl_ta.kode='".$value['kode']."' and tbl_judul.status='SUDAH ACC'";
      $data['acc'.$value['kode']] = $this->model->getAllJoin('tbl_judul', $select, $join, $where);
  }
  //tolak
  foreach ($data['ta'] as $value) {
      $select = "count(tbl_judul.status) as Jtolak";
      $join = "inner join tbl_ta on tbl_ta.kode = tbl_judul.tahun";
      $where = "tbl_ta.kode='".$value['kode']."' and tbl_judul.status='SUDAH DITOLAK'";
      $data['tolak'.$value['kode']] = $this->model->getAllJoin('tbl_judul', $select, $join, $where);
  }

  //proses
  foreach ($data['ta'] as $value) {
      $select = "count(tbl_judul.status) as Jproses";
      $join = "inner join tbl_ta on tbl_ta.kode = tbl_judul.tahun";
      $where = "tbl_ta.kode='".$value['kode']."' and tbl_judul.status='SEDANG DIPROSES'";
      $data['proses'.$value['kode']] = $this->model->getAllJoin('tbl_judul', $select, $join, $where);
  }

  //prodi sistem informasi
  //acc SI
  foreach ($data['ta'] as $value) {
      $select = "count(tbl_judul.status) as Jacc";
      $join = "inner join tbl_ta on tbl_ta.kode = tbl_judul.tahun";
      $where = "tbl_ta.kode='".$value['kode']."' and tbl_judul.status='SUDAH ACC' and tbl_judul.prodi ='SI'";
      $data['accsi'.$value['kode']] = $this->model->getAllJoin('tbl_judul', $select, $join, $where);
  }
  //tolak SI
  foreach ($data['ta'] as $value) {
      $select = "count(tbl_judul.status) as Jtolak";
      $join = "inner join tbl_ta on tbl_ta.kode = tbl_judul.tahun";
      $where = "tbl_ta.kode='".$value['kode']."' and tbl_judul.status='SUDAH DITOLAK' and tbl_judul.prodi ='SI'";
      $data['tolaksi'.$value['kode']] = $this->model->getAllJoin('tbl_judul', $select, $join, $where);
  }

  //proses SI
  foreach ($data['ta'] as $value) {
      $select = "count(tbl_judul.status) as Jproses";
      $join = "inner join tbl_ta on tbl_ta.kode = tbl_judul.tahun";
      $where = "tbl_ta.kode='".$value['kode']."' and tbl_judul.status='SEDANG DIPROSES' and tbl_judul.prodi ='SI'";
      $data['prosessi'.$value['kode']] = $this->model->getAllJoin('tbl_judul', $select, $join, $where);
  }

  //prodi sistem Komputer
  //acc SI
  foreach ($data['ta'] as $value) {
      $select = "count(tbl_judul.status) as Jacc";
      $join = "inner join tbl_ta on tbl_ta.kode = tbl_judul.tahun";
      $where = "tbl_ta.kode='".$value['kode']."' and tbl_judul.status='SUDAH ACC' and tbl_judul.prodi ='SK'";
      $data['accsk'.$value['kode']] = $this->model->getAllJoin('tbl_judul', $select, $join, $where);
  }
  //tolak SI
  foreach ($data['ta'] as $value) {
      $select = "count(tbl_judul.status) as Jtolak";
      $join = "inner join tbl_ta on tbl_ta.kode = tbl_judul.tahun";
      $where = "tbl_ta.kode='".$value['kode']."' and tbl_judul.status='SUDAH DITOLAK' and tbl_judul.prodi ='SK'";
      $data['tolaksk'.$value['kode']] = $this->model->getAllJoin('tbl_judul', $select, $join, $where);
  }

  //proses SI
  foreach ($data['ta'] as $value) {
      $select = "count(tbl_judul.status) as Jproses";
      $join = "inner join tbl_ta on tbl_ta.kode = tbl_judul.tahun";
      $where = "tbl_ta.kode='".$value['kode']."' and tbl_judul.status='SEDANG DIPROSES' and tbl_judul.prodi ='SK'";
      $data['prosessk'.$value['kode']] = $this->model->getAllJoin('tbl_judul', $select, $join, $where);
  }

  //berdasarkan bahasa pemrograman
  $selectbahasa ="(SELECT COUNT(tbl_judul.nim) FROM tbl_judul WHERE tbl_judul.bahasa LIKE '%php%') as php,

  (SELECT COUNT(tbl_judul.nim) FROM tbl_judul WHERE tbl_judul.bahasa LIKE '%java%') as java,

  (SELECT COUNT(tbl_judul.nim) FROM tbl_judul WHERE (tbl_judul.bahasa LIKE '%basic%' or tbl_judul.bahasa LIKE'%vb%')) as vb,

  (SELECT COUNT(tbl_judul.nim) FROM tbl_judul WHERE tbl_judul.bahasa LIKE '%flash%') as flash,

  (SELECT COUNT(tbl_judul.nim) FROM tbl_judul  WHERE (tbl_judul.bahasa='C' or tbl_judul.bahasa='C++' or tbl_judul.bahasa='C AVR' or tbl_judul.bahasa='Android' or tbl_judul.bahasa='Delphi')) as android,

  (SELECT COUNT(tbl_judul.nim) FROM tbl_judul WHERE tbl_judul.bahasa LIKE'%dream%') as dw";

  $data['bhs'] = $this->model->getAll('tbl_judul', $selectbahasa, null, null, "1");

  //berdasarkan tema judul
  $selecttema = "(SELECT COUNT(tbl_judul.nim) FROM tbl_judul WHERE tbl_judul.judul LIKE'%Sistem Informasi%') as SistemInformasi,

  (SELECT COUNT(tbl_judul.nim) FROM tbl_judul WHERE tbl_judul.judul LIKE'%otomatis%') as otomatis,

  (SELECT COUNT(tbl_judul.nim) FROM tbl_judul WHERE tbl_judul.judul LIKE'%pendukung keputusan%') as spk,

  (SELECT COUNT(tbl_judul.nim) FROM tbl_judul WHERE tbl_judul.judul LIKE'%pakar%') as pakar,

  (SELECT COUNT(tbl_judul.nim) FROM tbl_judul WHERE (tbl_judul.judul LIKE'%micro%' or tbl_judul.judul LIKE'%mikro%')) as micro,

  (SELECT COUNT(tbl_judul.nim) FROM tbl_judul WHERE (tbl_judul.bahasa LIKE'%php%' or tbl_judul.bahasa LIKE'%java web%')) as web";
  $data['tema'] = $this->model->getAll('tbl_judul', $selecttema, null, null, '1');

  $data['taMinMax'] = $this->model->getAll('tbl_ta', 'MAX(kode) as end, MIN(kode) as start');

    $this->view->render("statistik/index", false, $data);
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
