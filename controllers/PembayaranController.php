<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PembayaranController
 *
 * @author rolly
 */
class PembayaranController extends Controller{
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

  public function index()
  {

  }

  public function actionbayar()
  {
   $data['title'] = "<i class='fa fa-wpforms'></i> <b>Pembayaran</b>";
   $data['sub_title'] = "<i class='fa fa-wpforms'></i> <b>Form Pembayaran Skripsi </b>";

   if(!$this->islogin('013')){
      return $this->view->render('no-access',FALSE, $data);
  }

  if(isset($_GET['nim'])){
    	//ambil master biaya
   $masterbiaya = $this->model->getBiaya();
   $data['biaya'] = $masterbiaya;
   $NIM = $this->get('nim');
   $select = "mhsw.NIM, mhsw.Name, mhsw.KodeJurusan, tbl_aktivasi_mhs.Status, tbl_aktivasi_mhs.TglAktif, tbl_uang_masuk.tgl_bayar, tbl_pembayaran.STATUS_BYR";
   $join = "left outer join tbl_pembayaran on tbl_pembayaran.NIM = mhsw.NIM
   left outer join tbl_uang_masuk on tbl_uang_masuk.NIM = mhsw.NIM
   left outer join tbl_aktivasi_mhs on tbl_aktivasi_mhs.NIM = mhsw.NIM";
   $where = "mhsw.NIM = '".$NIM."'";

   $cekmhs = $this->model->cekMhsw($select, $join, $where);
   $data['mhsw'] = $cekmhs;
}    		

return $this->view->render('pembayaran/form-pembayaran', false, $data);
}

public function actiongobayar()
{

    if(!$this->islogin('013')){
      return $this->view->render('no-access',FALSE);
  }

   if(isset($_POST['submit'])){   		

      $TA = $this->post('TA');
      $NIM = $this->post('NIM');
      $user = Session::get('username');
      $jenis = $this->post('JenisBayar');
      $tbayar = $this->post('JumlahBayar');
      $biaya = $this->post('Biaya');

      if($biaya < $tbayar){
         $uangkembali = $tbayar-$biaya;
         $jumlah_uang = $tbayar;
     }else{
         $uangkembali = 0;
         $jumlah_uang = $biaya;
     }

     $ipuser = $_SERVER['REMOTE_ADDR'];

     $data_input1 = array(
       "user" => $user,
       "NIM" => $NIM,
       "TA" => $TA,
       "jenis_bayar" => $jenis,
       "besar_uang" => $biaya,
       "total_bayar" => $jumlah_uang,
       "uang_kembali" => $uangkembali,
       "tgl_bayar" => date("Y-m-d H:s:i"),
       "ip_user" => $ipuser
   );
    		//untuk ke tabel pembayaran
     $data_input2 = array(
      'NIM' => $NIM,
      'STATUS_BYR' => 'LUNAS'
  );

    		//input ke tablel uang masuk
     $input_uang_masuk = $this->model->save('tbl_uang_masuk', $data_input1);
     if($input_uang_masuk){
    			//input ke tabel pembayaran
         $inputpembayaran = $this->model->save('tbl_pembayaran', $data_input2);
         echo "<script>alert('Pembayaran sudah disimpan');</script>
         <script>window.location.assign('?p=Pembayaran&x=bayar&nim=".$NIM."');</script>";
     }else{
         echo "<script>alert('Pembayaran gagal disimpan');</script>
         <script>window.location.assign('?p=Pembayaran&x=bayar&nim=".$NIM."');</script>";
     }

 }else{
  echo "<script>window.location.assign('?p=Pembayaran&x=bayar');</script>";    		
}
}

public function actionallpembayaran()
{
   $data['title'] = "<i class='fa fa-wpforms'></i> <b>Pembayaran</b>";
   $data['sub_title'] = "<i class='fa fa-wpforms'></i> <b> Semua Transaksi Pembayaran</b>";

   if(!$this->islogin('013')){
      return $this->view->render('no-access',FALSE, $data);
  }

   $data['ta'] = $this->model->getTA();

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

$order = "tbl_aktivasi_mhs.Tahun DESC ,tbl_aktivasi_mhs.NIM ASC";

$data['all'] = $this->model->getAllPembayaran($select, $join, $where, $order);

return $this->view->render('pembayaran/all-pembayaran', false, $data);

}

public function actionpembayaranlunas()
{
   $data['title'] = "<i class='fa fa-wpforms'></i> <b>Pembayaran</b>";
   $data['sub_title'] = "<i class='fa fa-wpforms'></i> <b> Semua Transaksi Pembayaran Lunas</b>";

   if(!$this->islogin('013')){
      return $this->view->render('no-access',FALSE, $data);
  }

   $data['ta'] = $this->model->getTA();

   $where =' ';
   $where .= " tbl_aktivasi_mhs.Status ='1' and tbl_pembayaran.STATUS_BYR = 'LUNAS' ";
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

$order = "tbl_aktivasi_mhs.Tahun DESC ,tbl_aktivasi_mhs.NIM ASC";

$data['all'] = $this->model->getAllPembayaran($select, $join, $where, $order);

return $this->view->render('pembayaran/lunas-pembayaran', false, $data);

}

public function actionHapus()
{
   if(!$this->islogin('013')){
      return $this->view->render('no-access',FALSE);
  }

    $NIM = $this->get('id');

        //cekk
    $bayar = $this->model->getAll('tbl_uang_masuk', '*', "NIM ='".$NIM."'");
    if(empty($bayar)){
        echo "<script>alert('Data tidak ditemukan');</script>
        <script>window.location.assign('?p=Pembayaran&x=allpembayaran');</script>";
    }else{
        $this->model->hapus('tbl_pembayaran', array("NIM"=>$NIM),"Pembayaran&x=allpembayaran");
        $this->model->hapus('tbl_uang_masuk', array("NIM"=>$NIM),"Pembayaran&x=allpembayaran");

    }
}
}
