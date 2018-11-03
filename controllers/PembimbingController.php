<?php

/**
 * Description of JudulController
 *
 * @author rolly
 */
class PembimbingController extends Controller{
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
    $data['title'] = "<i class='fa fa-user-circle'></i> <b> Pembimbing</b>";
    $data['sub_title'] = "<i class='fa fa-user-circle'></i> <b> Pembimbing Skripsi</b>";

    if(!$this->islogin('0124')){
      return $this->view->render('no-access',FALSE, $data);
    }

    $data['ta'] = $this->model->getAll('tbl_ta', '*');

    $data['pesan'] ='';
      //jika submit update
    if(isset($_POST['submit'])){
     $update = $this->UpdatePembimbing();
     if($update){
      $data['pesan'] = "Pembimbing sudah diubah";
    }else{
      $data['pesan'] = "Pembimbing gagal diubah";
    }
  }

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

return $this->view->render('pembimbing/index',FALSE,$data);
}

public function actionEditPembimbing()
{
  $data['title'] = "<i class='fa fa-user-circle'></i> <b> Pembimbing</b>";
    $data['sub_title'] = "<i class='fa fa-edit'></i> <b>Edit Pembimbing Skripsi</b>";

    if(!$this->islogin('0124')){
      return $this->view->render('no-access',FALSE, $data);
    }

  $data['dosen'] = $this->model->getAll('dosen', "ID, CONCAT_WS(', ',Name, dosen.Gelar) as NamaDosen", null, "Name ASC");

  $IDPembimbing = $this->get('id');
  $prodi = Session::get('prodi');

  $where = "tbl_pembimbing.IDPembimbing = '".$IDPembimbing."' ";
  if($prodi != 'all'){
   $where .= " and mhsw.KodeJurusan ='".$prodi."'";
  }

  $select = "mhsw.NIM, mhsw.Name, tbl_pembimbing.*";
  $join = "inner join mhsw on mhsw.NIM = tbl_pembimbing.NIM";

  $pembimbing = $this->model->getAllJoin('tbl_pembimbing', $select, $join, $where, null, 1);
  if(!$pembimbing){
    $data['row'] = '';
    $data['pesan'] = "Data pembimbing tidak ditemukan.";
  }else{
    $data['row'] = $pembimbing;
  }

  return $this->view->render('pembimbing/form-edit',FALSE,$data);
}

public function UpdatePembimbing()
{
  if(!$this->islogin('0124')){
      return $this->view->render('no-access',FALSE);
    }
  $IDPembimbing = $this->post('IDP');
  $page = $this->post('page');

  $data_input = array(
    'IDDosen1' => $this->post('IDDosen1'),
    'IDDosen2' => $this->post('IDDosen2')
  );
  $update = $this->model->edit($data_input, "IDPembimbing ='".$IDPembimbing."'");
  return $update;
}

public function actionSetPembimbing()
{
  $data['title'] = "<i class='fa fa-user-circle'></i> <b> Pembimbing</b>";
    $data['sub_title'] = "<i class='fa fa-gears'></i> <b>Set Pembimbing Skripsi</b>";

    if(!$this->islogin('0124')){
      return $this->view->render('no-access',FALSE, $data);
    }

  $prodi = Session::get('prodi');

  $data['dosen'] = $this->model->getAll('dosen', "ID, CONCAT_WS(', ',Name, dosen.Gelar) as NamaDosen", null, "Name ASC");
  $data['pesan'] = '';
      //jika ditekan submit
  if(isset($_POST['set'])){
    $ta = $this->model->getAll('tbl_ta', '*', "aktif = 'Y'", "kode DESC", 1);

    $NIM      = $this->post('NIM');
    $IDDosen1 = $this->post('IDDosen1');
    $IDDosen2 = $this->post('IDDosen2');
        //cek jenis submit, update atau insert
    $proses = $this->post('proses');
    if($proses == 'insert'){          
      $surat     = $this->NoSurat($prodi);
      $data_input = array(
        'NIM'       => $NIM,
        'Prodi'     => $prodi,
        'IDDosen1'  => $IDDosen1,
        'IDDosen2'  => $IDDosen2,
        'KodeSurat' => $surat[0],
        'NoSurat'   => $surat[1],
        'Tahun'     => $ta[0]['kode'],
        'TglSet'    => date('Y-m-d H:s:i')
      );
      $insert = $this->model->save('tbl_pembimbing', $data_input);
      if($insert){
        $data['pesan'] = 'Dosen pembimbing sudah di set';
      }else{
        $data['pesan'] = 'Dosen pembimbing gagal di set';          
      }
    }else{
      $IDPembimbing = $this->post('IDPembimbing');
      $data_update = array(
        'IDDosen1' => $IDDosen1,
        'IDDosen2' => $IDDosen2
      );
      $update = $this->model->edit($data_update, "IDPembimbing ='".$IDPembimbing."'");
      if($update){
        $data['pesan'] = 'Dosen pembimbing sudah di update';
      }else{
        $data['pesan'] = 'Dosen pembimbing gagal di update';          
      }
    }
  }
      // Cek apakah terdapat data page pada URL          
  $page = (!empty($this->get('page'))) ? $this->get('page') : 1;                    
      $limit = 20; // Jumlah data per halamannya                    
      // Untuk menentukan dari data ke berapa yang akan ditampilkan pada tabel yang ada di database
      $limit_start = ($page - 1) * $limit;

      $limit_data = $limit_start.",".$limit;

      $data['no'] = $limit_start + 1; // Untuk penomoran tabel

      $where =" tbl_aktivasi_mhs.NIM != '' ";
      if($prodi == 'all'){
        $where .= '';
      }else{
        $where .= " and mhsw.KodeJurusan = '".$prodi."' ";
      }

      //jika dilakukan pencarian
      if(isset($_GET['go'])){
        $text = $this->postTOstr($this->get('cari'));
        if($this->get('go') == 'filter'){
          $where .= " and (mhsw.NIM LIKE '%".$text."%' or mhsw.Name LIKE '%".$text."%') ";
        }else{
          $where .= ' ';
        }
      }

      $select = "mhsw.NIM, mhsw.Name, mhsw.KodeJurusan, tbl_pembayaran.STATUS_BYR, (select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_pembimbing.IDDosen1 ) as Dosen1, (select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_pembimbing.IDDosen2 ) as Dosen2,
      (select judul from tbl_judul where tbl_judul.nim = tbl_aktivasi_mhs.NIM order by id desc limit 1) as JudulSkirpsi, tbl_pembimbing.IDDosen1, tbl_pembimbing.IDDosen2, tbl_pembimbing.IDPembimbing ";
      $join = "inner join mhsw on mhsw.NIM = tbl_aktivasi_mhs.NIM
      left outer join tbl_pembimbing on tbl_pembimbing.NIM = mhsw.NIM
      left outer join tbl_pembayaran on tbl_pembayaran.NIM = mhsw.NIM 
      left outer join tbl_uang_masuk on tbl_uang_masuk.NIM = tbl_pembayaran.NIM";
      $order = " tbl_uang_masuk.tgl_bayar DESC ";

      $data['pmb'] = $this->model->getAllJoin('tbl_aktivasi_mhs', $select, $join, $where, $order, $limit_data);

      $data['page'] = $page;

      //cari semua jumlah 
      $Jdata = $this->model->getAllJoin('tbl_aktivasi_mhs', "count(tbl_aktivasi_mhs.NIM) as jml", $join, $where);
      //jika ada
      //if(!empty($jdata)){
      $get_jumlah = $Jdata[0]['jml'];
    //}else{
    //  $get_jumlah = 0;
    //}
      $data['jumlah_page'] = ceil($get_jumlah / $limit); 
      $data['jumlah'] = $get_jumlah;

      return $this->view->render('pembimbing/set-pembimbing',FALSE,$data);

    }

    public function actionPembimbingMhsw()
    {
      $data['title'] = "<i class='fa fa-user-circle'></i> <b>Pembimbing Skripsi</b>";
      $data['sub_title'] = "<i class='fa fa-user-circle'></i> <b>Pembimbing Saya</b>";

      if(!$this->islogin('01245')){
     return $this->view->render('no-access',FALSE);
    }      
      $NIM= Session::get('username');

       $select = "(select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_pembimbing.IDDosen1 ) as Dosen1, (select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_pembimbing.IDDosen2 ) as Dosen2 ,tbl_pembimbing.Mbimbingan, tbl_pembimbing.Sbimbingan, tbl_pembimbing.NoSurat";
      $where = "tbl_pembimbing.NIM ='".$NIM."'";

      $data['pembimbing'] = $this->model->getAll('tbl_pembimbing', $select, $where);
      return $this->view->render('pembimbing/pembimbing-mhsw',FALSE,$data);

    }

    public function actionBimbinganDosen()
    {
      
      $data['title'] = "<i class='fa fa-user-circle'></i> <b>Pembimbing Skripsi</b>";
      $data['sub_title'] = "<i class='fa fa-user-circle'></i> <b>Data Mahasiswa Bimbingan </b>";
      if(!$this->islogin('0124')){
      return $this->view->render('no-access',FALSE);
    }

      $IDDosen = Session::get('id_user');

      $select ="mhsw.NIM, mhsw.Name, 
          (select tbl_judul.judul from tbl_judul where tbl_judul.nim = tbl_pembimbing.NIM order by id DESC limit 1) as judul,
          (select tbl_judul.status from tbl_judul where tbl_judul.nim = tbl_pembimbing.NIM order by id DESC limit 1) as status,
          (select tbl_judul.tahun from tbl_judul where tbl_judul.nim = tbl_pembimbing.NIM order by id DESC limit 1) as tahun,
          (select tbl_judul.id from tbl_judul where tbl_judul.nim = tbl_pembimbing.NIM order by id DESC limit 1) as id,
           tbl_pembimbing.Prodi";
      $join = "inner join mhsw on mhsw.NIM = tbl_pembimbing.NIM";

      $order ="tbl_pembimbing.Tahun, mhsw.Name ASC";

      $where1 = "tbl_pembimbing.IDDosen1 ='".$IDDosen."'";
      $where2 = "tbl_pembimbing.IDDosen2 ='".$IDDosen."'";

      $data['dosen1'] = $this->model->getAllJoin('tbl_pembimbing', $select, $join, $where1, $order);
      $data['dosen2'] = $this->model->getAllJoin('tbl_pembimbing', $select, $join, $where2, $order);

      return $this->view->render('pembimbing/mhsw-bimbingan',FALSE,$data);

    }

    public function postTOstr($string){
      return preg_replace("/[^a-zA-Z0-9. ,]/", "", $string);
    }

    public function NoSurat($prodi =null){
      if(!$this->islogin('0124')){
      return $this->view->render('no-access',FALSE);
    }
      $panjang = 3;
      $inisial = '';

      $NS = $this->model->getAll('tbl_pembimbing', "MAX(KodeSurat) as KS", "Prodi = '".$prodi."'");

      $angka = $NS[0]['KS'];
      if ($NS[0]['KS']=="") {
        $angka=0;
      }
      else {
        $angka = $NS[0]['KS'];
      }

      $angka++;
      $angka  = strval($angka); 
      $tmp ="";
      for($i=1; $i<=($panjang-strlen($inisial)-strlen($angka)); $i++) {
        $tmp=$tmp."0";
      }
     //format penulisan No Surat
    // nosurat-kodesurat/KodeUnitKerja/PP/bulan(dalam bentuk angka romawi)/Tahun
    // ex : 001-1/STMIK-R.01/PP/II/2018
      $no_surat = $tmp.$angka;
      $jns = 1;
      if($prodi == 'SI'){
        $unitKerja = "/STMIK-R.02/PP/";
      }else{
        $unitKerja = "/STMIK-R.01/PP/";
      }

      $bulan = date('m');
      $array_bulan = array('01' => 'I', '02' => 'II', '03' => 'III', '04' => 'IV', '05' => 'V',
        '06' => 'VI', '07' => 'VII', '08' => 'VIII', '09' => 'IX', '10' => 'X', '11' => 'XI', '12' => 'XII');
      $bulanromawi = $array_bulan[$bulan];
      $tahun = date('Y');

      $surat_tugas = $no_surat."-".$jns.$unitKerja.$bulanromawi."/".$tahun;

      return $data = array($no_surat, $surat_tugas);
    }

  }