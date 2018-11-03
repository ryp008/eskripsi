<?php

/**
 * Description of JudulController
 *
 * @author rolly
 */
class LaporanController extends Controller{
    //put your code here
  public function __construct() {
    parent::__construct();
  }

  public function isAdmin()
  {
    if(!Session::get('islogin') and Session::get('level') != 1){
      echo "<script>window.location.assign('?p=index');</script>";
    }
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
  }

  public function actionSemua()
  {
    $data['title'] = "<i class='fa fa-file-text-o'></i> <b>Laporan</b>";
    $data['sub_title'] = "<i class='fa fa-file-text-o'></i> <b>Laporan Judul Skripsi</b>";

    if(!$this->islogin('0123')){
      return $this->view->render('no-access',FALSE, $data);
    }

    $data['ta'] = $this->model->getAll('tbl_ta', '*', null ,"kode ASC");

    if(isset($_GET['go'])){
      $tahun = $this->get('thn');

      $select =" mhsw.NIM, mhsw.Name, tbl_judul.judul, tbl_judul.status, tbl_judul.bahasa, tbl_judul.objek ";
      $where = " tbl_judul.status !='TIDAK ADA STATUS' ";

      if(Session::get('prodi') != 'all'){
      $where .= " and tbl_judul.prodi ='".Session::get('prodi')."' ";
      }

      if($tahun != 'semua'){
        $where .= " and tbl_judul.tahun ='".$tahun."' ";
      }      

    $join = " inner join mhsw on mhsw.NIM = tbl_judul.nim ";
    $order =" tbl_judul.tahun, tbl_judul.nim ASC ";
    $data['laporan'] = $this->model->getAllJoin('tbl_judul', $select, $join, $where, $order);
    }
    
  return $this->view->render('laporan/semua-judul',FALSE,$data);

  }

  public function actionCetakSemua()
  {
   if(!$this->islogin('0123')){
      return $this->view->render('no-access',FALSE);
    }
      $tahun = $this->get('thn');

      $select =" mhsw.NIM, mhsw.Name, tbl_judul.judul, tbl_judul.status, tbl_judul.bahasa, tbl_judul.objek ";
      $where = " tbl_judul.status !='TIDAK ADA STATUS' ";

      if(Session::get('prodi') != 'all'){
      $where .= " and tbl_judul.prodi ='".Session::get('prodi')."' ";
      }

      if($tahun != 'semua'){
        $where .= " and tbl_judul.tahun ='".$tahun."' ";
      }      

    $join = " inner join mhsw on mhsw.NIM = tbl_judul.nim ";
    $order =" tbl_judul.tahun, tbl_judul.nim ASC ";
    $laporan = $this->model->getAllJoin('tbl_judul', $select, $join, $where, $order);
    
    if(empty($laporan)){
      echo "<script>alert('Data tidak ditemukan');</script>;
            <script>window.close();</script>";
    }
    $data['laporan'] = $laporan;
    $data['tahun'] = $tahun;

  return $this->view->render('laporan/cetak-semua', TRUE, $data, null, 'report');

  }

  public function actionJudulDiterima()
  {
    $data['title'] = "<i class='fa fa-file-text-o'></i> <b>Laporan</b>";
    $data['sub_title'] = "<i class='fa fa-file-text-o'></i> <b>Laporan Judul Skripsi Diterima</b>";

    if(!$this->islogin('0123')){
      return $this->view->render('no-access',FALSE, $data);
    }

    $data['ta'] = $this->model->getAll('tbl_ta', '*', null ,"kode ASC");

    if(isset($_GET['go'])){
      $tahun = $this->get('thn');

      $select =" mhsw.NIM, mhsw.Name, tbl_judul.judul, tbl_judul.status, tbl_judul.bahasa, tbl_judul.objek ";
      $where = " tbl_judul.status ='SUDAH ACC' ";

      if(Session::get('prodi') != 'all'){
      $where .= " and tbl_judul.prodi ='".Session::get('prodi')."' ";
      }

      if($tahun != 'semua'){
        $where .= " and tbl_judul.tahun ='".$tahun."' ";
      }   

    $join = " inner join mhsw on mhsw.NIM = tbl_judul.nim ";
    $order =" tbl_judul.tahun, tbl_judul.nim ASC ";
    $data['laporan'] = $this->model->getAllJoin('tbl_judul', $select, $join, $where, $order);
    }
    
  return $this->view->render('laporan/judul-diterima',FALSE,$data);

  }

  public function actionCetakJudulDiterima()
  {
    if(!$this->islogin('0123')){
      return $this->view->render('no-access',FALSE);
    }

    $tahun = $this->get('thn');

      $select =" mhsw.NIM, mhsw.Name, tbl_judul.judul, tbl_judul.status, tbl_judul.bahasa, tbl_judul.objek ";
      $where = " tbl_judul.status ='SUDAH ACC' ";

      if(Session::get('prodi') != 'all'){
      $where .= " and tbl_judul.prodi ='".Session::get('prodi')."' ";
      }

      if($tahun != 'semua'){
        $where .= " and tbl_judul.tahun ='".$tahun."' ";
      }   
    $join = " inner join mhsw on mhsw.NIM = tbl_judul.nim ";
    $order =" tbl_judul.tahun, tbl_judul.nim ASC ";
    $laporan = $this->model->getAllJoin('tbl_judul', $select, $join, $where, $order);
    
    if(empty($laporan)){
      echo "<script>alert('Data tidak ditemukan');</script>;
            <script>window.close();</script>";
    }
    $data['laporan'] = $laporan;
    $data['tahun'] = $tahun;

  return $this->view->render('laporan/cetak-diterima', TRUE, $data, null, 'report');

  }

  public function actionJudulDitolak()
  {
    $data['title'] = "<i class='fa fa-file-text-o'></i> <b>Laporan</b>";
    $data['sub_title'] = "<i class='fa fa-file-text-o'></i> <b>Laporan Judul Skripsi Ditolak</b>";

    if(!$this->islogin('0123')){
      return $this->view->render('no-access',FALSE, $data);
    }

    $data['ta'] = $this->model->getAll('tbl_ta', '*', null ,"kode ASC");

    if(isset($_GET['go'])){
      $tahun = $this->get('thn');

      $select =" mhsw.NIM, mhsw.Name, tbl_judul.judul, tbl_judul.status, tbl_judul.bahasa, tbl_judul.objek ";
      $where = " tbl_judul.status ='SUDAH DITOLAK' ";

      if(Session::get('prodi') != 'all'){
      $where .= " and tbl_judul.prodi ='".Session::get('prodi')."' ";
      }

      if($tahun != 'semua'){
        $where .= " and tbl_judul.tahun ='".$tahun."' ";
      }

    $join = " inner join mhsw on mhsw.NIM = tbl_judul.nim ";
    $order =" tbl_judul.tahun, tbl_judul.nim ASC ";
    $data['laporan'] = $this->model->getAllJoin('tbl_judul', $select, $join, $where, $order);
    }
    
  return $this->view->render('laporan/judul-ditolak',FALSE,$data);

  }

  public function actionCetakJudulDitolak()
  {
    if(!$this->islogin('0123')){
      return $this->view->render('no-access',FALSE);
    }

    $tahun = $this->get('thn');

      $select =" mhsw.NIM, mhsw.Name, tbl_judul.judul, tbl_judul.status, tbl_judul.bahasa, tbl_judul.objek ";
      $where = " tbl_judul.status ='SUDAH DITOLAK' ";

      if(Session::get('prodi') != 'all'){
      $where .= " and tbl_judul.prodi ='".Session::get('prodi')."' ";
      }

      if($tahun != 'semua'){
        $where .= " and tbl_judul.tahun ='".$tahun."' ";
      }   
    $join = " inner join mhsw on mhsw.NIM = tbl_judul.nim ";
    $order =" tbl_judul.tahun, tbl_judul.nim ASC ";
    $laporan = $this->model->getAllJoin('tbl_judul', $select, $join, $where, $order);
    
    if(empty($laporan)){
      echo "<script>alert('Data tidak ditemukan');</script>;
            <script>window.close();</script>";
    }
    $data['laporan'] = $laporan;
    $data['tahun'] = $tahun;

  return $this->view->render('laporan/cetak-ditolak', TRUE, $data, null, 'report');

  }

  public function actionLaporanPembayaran()
  {
    $data['title'] = "<i class='fa fa-file-text-o'></i> <b>Laporan</b>";
    $data['sub_title'] = "<i class='fa fa-file-text-o'></i> <b>Laporan Pembayaran Bimbingan Skripsi</b>";

    if(!$this->islogin('0123')){
      return $this->view->render('no-access',FALSE, $data);
    }

    $data['ta'] = $this->model->getAll('tbl_ta', '*', null, "kode ASC");

    $data['all'] = '';
    if(isset($_GET['go'])){

    $where =' ';
    $where .= " tbl_aktivasi_mhs.Status ='1' ";
    $tahun = $this->get('tahun');
    if($tahun == 'semua' || $tahun == ''){
      $where .= ' ';
    }else{
       $where .= " and tbl_aktivasi_mhs.Tahun = '".$tahun."' ";
     }
    $prodi = $this->get('prodi');
    if($prodi == 'semua' || $prodi == ''){
      $where .= ' ';
    }else{
       $where .= " and  mhsw.KodeJurusan ='".$prodi."'";
     }

    $select = "mhsw.NIM, mhsw.Name, mhsw.KodeJurusan, tbl_aktivasi_mhs.*, tbl_pembayaran.STATUS_BYR, tbl_uang_masuk.tgl_bayar";
    $join = "inner join tbl_ta on tbl_ta.kode = tbl_aktivasi_mhs.Tahun
    inner join mhsw on mhsw.NIM = tbl_aktivasi_mhs.NIM
    left outer join tbl_pembayaran on tbl_pembayaran.NIM = tbl_aktivasi_mhs.NIM
    left outer join tbl_uang_masuk on tbl_uang_masuk.NIM = tbl_aktivasi_mhs.NIM";

    $order = "tbl_aktivasi_mhs.Tahun DESC , mhsw.Name ASC";

    $data['all'] = $this->model->getAllJoin('tbl_aktivasi_mhs',$select, $join, $where, $order);
  }

  return $this->view->render('laporan/laporan-pembayaran', FALSE, $data);
    
  }

  public function actionCetakPembayaran()
  {
    if(!$this->islogin('0123')){
      return $this->view->render('no-access',FALSE);
    }

    $where =' ';
    $where .= " tbl_aktivasi_mhs.Status ='1' ";
    $tahun = $this->get('tahun');
    if($tahun == 'semua' || $tahun == ''){
      $where .= ' ';
    }else{
       $where .= " and tbl_aktivasi_mhs.Tahun = '".$tahun."' ";
     }
    $prodi = $this->get('prodi');
    if($prodi == 'semua' || $prodi == ''){
      $where .= ' ';
    }else{
       $where .= " and  mhsw.KodeJurusan ='".$prodi."'";
     }

    $select = "mhsw.NIM, mhsw.Name, mhsw.KodeJurusan, tbl_aktivasi_mhs.*, tbl_pembayaran.STATUS_BYR, tbl_uang_masuk.tgl_bayar";
    $join = "inner join tbl_ta on tbl_ta.kode = tbl_aktivasi_mhs.Tahun
    inner join mhsw on mhsw.NIM = tbl_aktivasi_mhs.NIM
    left outer join tbl_pembayaran on tbl_pembayaran.NIM = tbl_aktivasi_mhs.NIM
    left outer join tbl_uang_masuk on tbl_uang_masuk.NIM = tbl_aktivasi_mhs.NIM";

    $order = "tbl_aktivasi_mhs.Tahun DESC , mhsw.Name ASC";

    $data['all'] = $this->model->getAllJoin('tbl_aktivasi_mhs',$select, $join, $where, $order);
    if(empty($data['all'])){
      echo "<script>alert('Data tidak ditemukan');</script>;
            <script>window.close();</script>";
    }

    $data['tahun'] = $tahun;
    $data['prodi'] = $prodi;
    $data2['class'] = 'A4.landscape';

  return $this->view->render('laporan/cetak-pembayaran', true, $data, null, 'report');
    
  }

  public function actionLaporanSempro()
  {
    $data['title'] = "<i class='fa fa-file-text-o'></i> <b>Laporan</b>";
    $data['sub_title'] = "<i class='fa fa-file-text-o'></i> <b>Laporan Seminar Proposal</b>";

    if(!$this->islogin('0123')){
      return $this->view->render('no-access',FALSE, $data);
    }

    $data['ta'] = $this->model->getAll('tbl_ta', '*', null, "kode ASC");
    $data['laporan'] ='';

    if(isset($_GET['go'])){
    $where =' ';
    $where .= " tbl_seminar.JenisSeminar = 'Proposal' ";
    $tahun = $this->get('tahun');
    if($tahun == 'semua' || $tahun == ''){
      $where .= ' ';
    }else{
       $where .= " and tbl_seminar.Tahun = '".$tahun."' ";
     }
    $prodi = $this->get('prodi');
    if($prodi == 'semua' || $prodi == ''){
      $where .= ' ';
    }else{
       $where .= " and  tbl_seminar.Prodi ='".$prodi."'";
     }

     $gel = $this->get('gel');
    if($gel == 'semua' || $gel == ''){
      $where .= ' ';
    }else{
       $where .= " and  tbl_seminar.Gelombang ='".$gel."'";
     }

     $select = "mhsw.NIM, mhsw.Name, mhsw.KodeJurusan, tbl_seminar.*, 
                (select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_seminar.IDKetua) as Ketua,
    (select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_seminar.IDPenguji1 ) as Penguji1,
    (select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_seminar.IDPenguji2 ) as Penguji2";
    $join = "inner join mhsw on mhsw.NIM = tbl_seminar.NIM";
    $order = "tbl_seminar.Gelombang, mhsw.Name ASC";

    $data['laporan'] = $this->model->getAllJoin('tbl_seminar', $select, $join, $where, $order);
  }

    return $this->view->render('laporan/laporan-sempro', false, $data);
  }

  public function actionCetakSempro()
  {
    if(!$this->islogin('0123')){
      return $this->view->render('no-access',FALSE);
    }

    $where =' ';
    $where .= " tbl_seminar.JenisSeminar = 'Proposal' ";
    $tahun = $this->get('tahun');
    if($tahun == 'semua' || $tahun == ''){
      $where .= ' ';
    }else{
       $where .= " and tbl_seminar.Tahun = '".$tahun."' ";
     }
    $prodi = $this->get('prodi');
    if($prodi == 'semua' || $prodi == ''){
      $where .= ' ';
    }else{
       $where .= " and  tbl_seminar.Prodi ='".$prodi."'";
     }

     $gel = $this->get('gel');
    if($gel == 'semua' || $gel == ''){
      $where .= ' ';
    }else{
       $where .= " and  tbl_seminar.Gelombang ='".$gel."'";
     }

     $select = "mhsw.NIM, mhsw.Name, mhsw.KodeJurusan, tbl_seminar.*, 
                (select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_seminar.IDKetua) as Ketua,
    (select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_seminar.IDPenguji1 ) as Penguji1,
    (select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_seminar.IDPenguji2 ) as Penguji2";
    $join = "inner join mhsw on mhsw.NIM = tbl_seminar.NIM";
    $order = "tbl_seminar.Gelombang, mhsw.Name ASC";

    $data['laporan'] = $this->model->getAllJoin('tbl_seminar', $select, $join, $where, $order);
    if(empty($data['laporan'])){
      echo "<script>alert('Data tidak ditemukan');</script>;
            <script>window.close();</script>";
    }
    $data['tahun'] = $tahun;
    $data['prodi'] = $prodi;
    $data2['class'] = 'A4.landscape';
    return $this->view->render('laporan/cetak-laporan-sempro', true, $data, $data2, 'report');

  }

  public function actionLaporanSemha()
  {
    $data['title'] = "<i class='fa fa-file-text-o'></i> <b>Laporan</b>";
    $data['sub_title'] = "<i class='fa fa-file-text-o'></i> <b>Laporan Seminar Hasil</b>";

    if(!$this->islogin('0123')){
      return $this->view->render('no-access',FALSE, $data);
    }

    $data['ta'] = $this->model->getAll('tbl_ta', '*', null, "kode ASC");
    $data['laporan'] ='';

    if(isset($_GET['go'])){
    $where =' ';
    $where .= " tbl_seminar.JenisSeminar = 'Hasil' ";
    $tahun = $this->get('tahun');
    if($tahun == 'semua' || $tahun == ''){
      $where .= ' ';
    }else{
       $where .= " and tbl_seminar.Tahun = '".$tahun."' ";
     }
    $prodi = $this->get('prodi');
    if($prodi == 'semua' || $prodi == ''){
      $where .= ' ';
    }else{
       $where .= " and  tbl_seminar.Prodi ='".$prodi."'";
     }

     $gel = $this->get('gel');
    if($gel == 'semua' || $gel == ''){
      $where .= ' ';
    }else{
       $where .= " and  tbl_seminar.Gelombang ='".$gel."'";
     }

     $select = "mhsw.NIM, mhsw.Name, mhsw.KodeJurusan, tbl_seminar.*, 
                (select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_seminar.IDKetua) as Ketua,
    (select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_seminar.IDPenguji1 ) as Penguji1,
    (select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_seminar.IDPenguji2 ) as Penguji2";
    $join = "inner join mhsw on mhsw.NIM = tbl_seminar.NIM";
    $order = "tbl_seminar.Gelombang, mhsw.Name ASC";

    $data['laporan'] = $this->model->getAllJoin('tbl_seminar', $select, $join, $where, $order);
  }

    return $this->view->render('laporan/laporan-semha', false, $data);
  }

  public function actionCetakSemha()
  {
      if(!$this->islogin('0123')){
      return $this->view->render('no-access',FALSE);
    }

    $where =' ';
    $where .= " tbl_seminar.JenisSeminar = 'Hasil' ";
    $tahun = $this->get('tahun');
    if($tahun == 'semua' || $tahun == ''){
      $where .= ' ';
    }else{
       $where .= " and tbl_seminar.Tahun = '".$tahun."' ";
     }
    $prodi = $this->get('prodi');
    if($prodi == 'semua' || $prodi == ''){
      $where .= ' ';
    }else{
       $where .= " and  tbl_seminar.Prodi ='".$prodi."'";
     }

     $gel = $this->get('gel');
    if($gel == 'semua' || $gel == ''){
      $where .= ' ';
    }else{
       $where .= " and  tbl_seminar.Gelombang ='".$gel."'";
     }

     $select = "mhsw.NIM, mhsw.Name, mhsw.KodeJurusan, tbl_seminar.*, 
                (select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_seminar.IDKetua) as Ketua,
    (select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_seminar.IDPenguji1 ) as Penguji1,
    (select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_seminar.IDPenguji2 ) as Penguji2";
    $join = "inner join mhsw on mhsw.NIM = tbl_seminar.NIM";
    $order = "tbl_seminar.Gelombang, mhsw.Name ASC";

    $data['laporan'] = $this->model->getAllJoin('tbl_seminar', $select, $join, $where, $order);
    if(empty($data['laporan'])){
      echo "<script>alert('Data tidak ditemukan');</script>;
            <script>window.close();</script>";
    }
    $data['tahun'] = $tahun;
    $data['prodi'] = $prodi;
    $data2['class'] = 'A4.landscape';
    return $this->view->render('laporan/cetak-laporan-semha', true, $data, $data2, 'report');

  }

  public function actionLaporanSidang()
  {
    $data['title'] = "<i class='fa fa-file-text-o'></i> <b>Laporan</b>";
    $data['sub_title'] = "<i class='fa fa-file-text-o'></i> <b>Laporan Sidang Meja Hijau</b>";

    if(!$this->islogin('0123')){
      return $this->view->render('no-access',FALSE, $data);
    }

    $data['ta'] = $this->model->getAll('tbl_ta', '*', null, "kode ASC");
    $data['laporan'] ='';

    if(isset($_GET['go'])){
    $where =' ';
    $where .= " tbl_sidang.Sidang = 'Y' ";
    $tahun = $this->get('tahun');
    if($tahun == 'semua' || $tahun == ''){
      $where .= ' ';
    }else{
       $where .= " and tbl_sidang.Tahun = '".$tahun."' ";
     }
    $prodi = $this->get('prodi');
    if($prodi == 'semua' || $prodi == ''){
      $where .= ' ';
    }else{
       $where .= " and  tbl_sidang.Prodi ='".$prodi."'";
     }

     $gel = $this->get('gel');
    if($gel == 'semua' || $gel == ''){
      $where .= ' ';
    }else{
       $where .= " and  tbl_sidang.Gelombang ='".$gel."'";
     }

     $select = "mhsw.NIM, mhsw.Name, mhsw.KodeJurusan, tbl_sidang.*, 
                (select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_sidang.IDKetua) as Ketua,
    (select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_sidang.IDPenguji1 ) as Penguji1,
    (select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_sidang.IDPenguji2 ) as Penguji2";
    $join = "inner join mhsw on mhsw.NIM = tbl_sidang.NIM";
    $order = "tbl_sidang.Gelombang, mhsw.Name ASC";

    $data['laporan'] = $this->model->getAllJoin('tbl_sidang', $select, $join, $where, $order);
  }

    return $this->view->render('laporan/laporan-sidang', false, $data);
  }

  public function actionCetakSidang()
  {

    if(!$this->islogin('0123')){
      return $this->view->render('no-access',FALSE);
    }

    $where =' ';
    $where .= " tbl_sidang.Sidang = 'Y' ";
    $tahun = $this->get('tahun');
    if($tahun == 'semua' || $tahun == ''){
      $where .= ' ';
    }else{
       $where .= " and tbl_sidang.Tahun = '".$tahun."' ";
     }
    $prodi = $this->get('prodi');
    if($prodi == 'semua' || $prodi == ''){
      $where .= ' ';
    }else{
       $where .= " and  tbl_sidang.Prodi ='".$prodi."'";
     }

     $gel = $this->get('gel');
    if($gel == 'semua' || $gel == ''){
      $where .= ' ';
    }else{
       $where .= " and  tbl_sidang.Gelombang ='".$gel."'";
     }

     $select = "mhsw.NIM, mhsw.Name, mhsw.KodeJurusan, tbl_sidang.*, 
                (select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_sidang.IDKetua) as Ketua,
    (select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_sidang.IDPenguji1 ) as Penguji1,
    (select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_sidang.IDPenguji2 ) as Penguji2";
    $join = "inner join mhsw on mhsw.NIM = tbl_sidang.NIM";
    $order = "tbl_sidang.Gelombang, mhsw.Name ASC";

    $data['laporan'] = $this->model->getAllJoin('tbl_sidang', $select, $join, $where, $order);
    if(empty($data['laporan'])){
      echo "<script>alert('Data tidak ditemukan');</script>;
            <script>window.close();</script>";
    }
    $data['tahun'] = $tahun;
    $data['prodi'] = $prodi;
    $data2['class'] = 'A4.landscape';
    return $this->view->render('laporan/cetak-laporan-sidang', true, $data, $data2, 'report');

  }

  public function actionDosenPembimbing()
  {
    $data['title'] = "<i class='fa fa-file-text-o'></i> <b>Laporan</b>";
    $data['sub_title'] = "<i class='fa fa-file-text-o'></i> <b>Laporan Dosen Pembimbing</b>";

    if(!$this->islogin('0123')){
      return $this->view->render('no-access',FALSE, $data);
    }
    $data['ta'] = $this->model->getAll('tbl_ta', '*', null, "kode ASC");

    $tahun = $this->get('tahun');
  //$prodi = '';
  $prodi = strtoupper($this->get('prodi'));

  $sess_prodi = Session::get('prodi');
  if($sess_prodi != 'all'){
    $prodi = $sess_prodi;
  }

  $where = " tbl_pembimbing.NIM !='' ";

  if($prodi == 'SEMUA' || $prodi == ''){
    $where .= ' ';
  }else{
   $where .= " and  tbl_pembimbing.Prodi ='".$prodi."' ";
 }


 $select = "mhsw.NIM, mhsw.Name, mhsw.KodeJurusan, (select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_pembimbing.IDDosen1 ) as Dosen1, (select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_pembimbing.IDDosen2 ) as Dosen2, tbl_pembimbing.*";
 $join = "inner join mhsw on mhsw.NIM = tbl_pembimbing.NIM";
 $order = "tbl_pembimbing.Tahun, tbl_pembimbing.NIM ASC";


 if($tahun != 'semua' and !empty($tahun)){
  $where .= " and tbl_pembimbing.Tahun = '".$tahun."' ";
};
$data['pembimbing']=$this->model->getAllJoin('tbl_pembimbing', $select, $join, $where, $order);

    return $this->view->render('laporan/dosen-pembimbing', false, $data);

  }


  public function actionCetakDosenPembimbing()
  {
    if(!$this->islogin('0123')){
      return $this->view->render('no-access',FALSE);
    }

    $data['title'] ='Laporan';
    $data['sub_title'] ='Laporan Data Dosen Pembimbing Skripsi';

    $tahun = $this->get('tahun');
  //$prodi = '';
  $prodi = strtoupper($this->get('prodi'));

  $sess_prodi = Session::get('prodi');
  if($sess_prodi != 'all'){
    $prodi = $sess_prodi;
  }

  $where = " tbl_pembimbing.NIM !='' ";

  if($prodi == 'SEMUA' || $prodi == ''){
    $where .= ' ';
  }else{
   $where .= " and  tbl_pembimbing.Prodi ='".$prodi."' ";
 }


 $select = "mhsw.NIM, mhsw.Name, mhsw.KodeJurusan, (select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_pembimbing.IDDosen1 ) as Dosen1, (select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_pembimbing.IDDosen2 ) as Dosen2, tbl_pembimbing.*";
 $join = "inner join mhsw on mhsw.NIM = tbl_pembimbing.NIM";
 $order = "tbl_pembimbing.Tahun, tbl_pembimbing.NIM ASC";


 if($tahun != 'semua' and !empty($tahun)){
  $where .= " and tbl_pembimbing.Tahun = '".$tahun."' ";
};
$data['pembimbing']=$this->model->getAllJoin('tbl_pembimbing', $select, $join, $where, $order);

    $data2['class'] = 'A4.landscape';
    $data['tahun'] = $tahun;
    return $this->view->render('laporan/cetak-dosen-pembimbing', true, $data, $data2, 'report');

  }

}