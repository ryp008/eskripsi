<?php

/**
 * Description of JudulController
 *
 * @author rolly
 */
class JudulController extends Controller{
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

    $data['title'] = "<i class='fa fa-book'></i> <b>Judul Skripsi</b>";
    $data['sub_title'] ='Judul Skripsi';

    if(!$this->islogin('012345')){
      return $this->view->render('no-access',FALSE, $data);
    }

    $data['ta'] = $this->model->getAll('tbl_ta', '*');

    $sts = $this->get('sts');
    $tahun = $this->get('thn');
    $cari = $this->get('key');

    if($sts == 'terima'){
      $status = 'SUDAH ACC';
    }elseif($sts == 'tolak'){
      $status = 'SUDAH DITOLAK';
    }else{
      $status='';
    }

    // Cek apakah terdapat data page pada URL          
    $page = (!empty($this->get('page'))) ? $this->get('page') : 1;                    
      $limit = 15; // Jumlah data per halamannya                    
      // Untuk menentukan dari data ke berapa yang akan ditampilkan pada tabel yang ada di database
      $limit_start = ($page - 1) * $limit;

      $limit_data = $limit_start.",".$limit;

      $data['no'] = $limit_start + 1; // Untuk penomoran tabel

      $where =" tbl_judul.IsEmpty = 'N' ";

      if(!empty($status)){        
        $where .= " and tbl_judul.status = '".$status."' ";
      }

      if(!empty($tahun)){
        $where .= " and tbl_judul.tahun = '".$tahun."' ";
      }

      if(!empty($cari)){
        $where .= " and (tbl_judul.nim LIKE  '%".$cari."' or tbl_judul.judul LIKE '%".$cari."%') ";
      }

      $select = "mhsw.NIM, mhsw.Name, tbl_judul.id, tbl_judul.prodi, tbl_judul.judul, tbl_judul.latar, tbl_judul.bahasa, tbl_judul.status, tbl_judul.tgl_pengajuan, tbl_judul.tgl_periksa";
      $join = "inner join mhsw on mhsw.NIM = tbl_judul.NIM";
      $order = "tbl_judul.tgl_pengajuan DESC";

      $data['judul']=$this->model->getAllJoin('tbl_judul', $select, $join, $where, $order, $limit_data);
    //$data['judul']=$this->model->getAll('tbl_judul', '*');

      $data['page'] = $page;

    //cari semua jumlah 
      $Jdata = $this->model->getAllJoin('tbl_judul', "count(tbl_judul.NIM) as jml", $join, $where);
      //jika ada
      //if(!empty($jdata)){
      $get_jumlah = $Jdata[0]['jml'];
      $data['jumlah'] = $get_jumlah;
    //}else{
    //  $get_jumlah = 0;
    //}
      $data['jumlah_page'] = ceil($get_jumlah / $limit);
      return $this->view->render('judul/index',FALSE,$data);
    }

    public function actionJudulProdi()
    {

      $prd ='';
      $sts = '';
      $sts = $this->get('sts');
      if($sts == 'proses'){
        $status = 'SEDANG DIPROSES';
      }elseif($sts == 'terima'){
        $status = 'SUDAH ACC';
      }elseif($sts == 'tolak'){
        $status = 'SUDAH DITOLAK';
      }else{
        $status ='';
      }

      if(Session::get('prodi') != 'all'){
        if(Session::get('prodi') == 'SI' ? $prd = 'Sistem Informasi '.$status : $prd = 'Sistem Komputer '.$status);
      }else{
        if($this->get('prodi') == 'si'){ 
          $prd ='Sistem Informasi '.$status;
        } elseif($this->get('prodi') == 'sk'){
          $prd = 'Sistem Komputer '.$status;
        }else{
          $prd='';
        }
      }

      $data['title'] = "<i class='fa fa-book'></i> <b>Judul Skripsi</b>";
      $data['sub_title'] = "<i class='fa fa-book'></i> <b> Judul Skripsi ".$prd." </b>";

      if(!$this->islogin('012345')){
        return $this->view->render('no-access',FALSE, $data);
      }
      $data['ta'] = $this->model->getAll('tbl_ta', '*');
      $prodi = '';
      $prodi = strtoupper($this->get('prodi'));
      $tahun = $this->get('thn'); 
      $cari = $this->get('key');

      // Cek apakah terdapat data page pada URL          
    $page = (!empty($this->get('page'))) ? $this->get('page') : 1;                    
      $limit = 15; // Jumlah data per halamannya                    
      // Untuk menentukan dari data ke berapa yang akan ditampilkan pada tabel yang ada di database
      $limit_start = ($page - 1) * $limit;

      $limit_data = $limit_start.",".$limit;

      $data['no'] = $limit_start + 1; // Untuk penomoran tabel  

      $where = "tbl_judul.IsEmpty = 'N' ";

      $sess_prodi = Session::get('prodi');
      if($sess_prodi != 'all'){
        $prodi = $sess_prodi;
        $where .= " and tbl_judul.prodi ='".$prodi."' ";
      }else{
        $where .= " and tbl_judul.prodi ='".$prodi."' ";        
      }



      $select = "mhsw.NIM, mhsw.Name, tbl_judul.id, tbl_judul.prodi, tbl_judul.rekomendasi, tbl_judul.judul, tbl_judul.latar, tbl_judul.bahasa, tbl_judul.status, tbl_judul.tgl_pengajuan, tbl_judul.tgl_periksa";
      $join = "inner join mhsw on mhsw.NIM = tbl_judul.NIM";
      $order = "tbl_judul.tgl_pengajuan ASC";


      if(!empty($tahun)){
        if($tahun != 'semua'){
          $where .= " and tbl_judul.tahun = '".$tahun."' ";
        }
      }

      if(!empty($status)){
        $where .= " and tbl_judul.status = '".$status."' ";
      }

       if(!empty($cari)){
        $where .= " and (tbl_judul.nim LIKE  '%".$cari."' or tbl_judul.judul LIKE '%".$cari."%') ";
      }

      $data['judul']=$this->model->getAllJoin('tbl_judul', $select, $join, $where, $order, $limit_data);

      $data['page'] = $page;

    //cari semua jumlah 
      $Jdata = $this->model->getAllJoin('tbl_judul', "count(tbl_judul.NIM) as jml", $join, $where);
      //jika ada
      //if(!empty($jdata)){
      $get_jumlah = $Jdata[0]['jml'];
      $data['jumlah'] = $get_jumlah;
    //}else{
    //  $get_jumlah = 0;
    //}
      $data['jumlah_page'] = ceil($get_jumlah / $limit);
      return $this->view->render('judul/judulprodi',FALSE,$data);
    }

    public function actionPengajuan(){
      $data=$this->model->tampilJudul();
      return $this->view->render('judul/pengajuan',FALSE,$data);
    }

    public function actionDetail(){
      if(!$this->islogin('01245')){
        return $this->view->render('no-access',FALSE);
      }
      $data=$this->model->innerJoin(
        "tbl_judul j, mhsw m",
        "*",
        "j.nim=m.NIM AND j.id=".$this->get('id')
      );

        //return to file detail judul
      return $this->view->render('judul/detail',true,$data, null, 'popup');
    }

    public function actionDetailProses(){
      if(!$this->islogin('0124')){
        return $this->view->render('no-access',FALSE);
      }
      $data = $this->model->getAllJoin('tbl_judul', "tbl_judul.*, concat_ws(', ',dosen.Name, dosen.Gelar) as NamaDosen",
        "inner join mhsw on mhsw.NIM = tbl_judul.nim
        left outer join dosen on dosen.ID = tbl_judul.dosenrekom",
        "tbl_judul.id ='".$this->get('id')."'");

    // $data=$this->model->innerJoin(
    //   "tbl_judul j, mhsw m, dosen",
    //   "*, dosen.Name, dosen.Gelar",
    //   "j.nim=m.NIM AND j.id='".$this->get('id')."' and j.dosenrekom = dosen.ID"
    // );

      $prodi = Session::get('prodi');

      $data2 = $this->model->getAllJoin('tbl_tim_seleksi', 
        "dosen.ID, CONCAT_WS(', ',dosen.Name, dosen.Gelar) as NamaDosen",
        "inner join dosen on dosen.ID = tbl_tim_seleksi.iddosen",
        "tbl_tim_seleksi.prodi ='".$prodi."'", 
        "dosen.Name ASC");


    //cek judul sudah acc atau belum
      $cekjudul = $this->model->getAll('tbl_judul', '*', "id ='".$this->get('id')."' and status = 'SUDAH ACC'", null, 1);
      if(!empty($cekjudul)){
        echo "<script>alert('Judul sudah pernah diproses');</script>;
        <script>window.close();</script>";
      }

        //return to file detail judul
      return $this->view->render('judul/detailproses',true,$data, $data2, 'popup');
    }

    public function actionProsesDiterima()
    {
      if(!$this->islogin('0124')){
        return $this->view->render('no-access',FALSE, $data);
      }
      if(!isset($_POST['update']))
      {
        echo "<script>window.location.assign('?p=Judul&x=JudulProdi&sts=proses');</script>";
      }    

      $kode = $this->post('kode');
      $status = $this->post('status');
      $comment = $this->post('comment');
      $NIM = $this->post('NIM');
      $IDJudul = $this->post('idj');
      $asesor = Session::get('name');

      $act = $this->post('act');
      if($act == 'rekomendasikan'){
        $dosen = $this->post('dosen');

        $dt_rekom = array(
          'dosenrekom' => $dosen,
          'rekomendasi' => 'BELUM'
        );
        $update = $this->model->edit('tbl_judul', $dt_rekom, "id ='".$IDJudul."'");
        echo "<script>window.close();</script>";

      }else{

        if ($kode == "acc" and $_POST['update'] == "Proses Judul Mahasiswa") {
          $tgl = date("Y-m-d h:i:s");

            //jika status DI ACC
            //set tanggal awal dan akhir bimbingan
          if($status == 1){
            $mulai = date('Y-m-d');
            //lama waktu bimbingan adalah 6 bulan dari judul di ACC oleh KA.Prodi.
            $akhir = date('Y-m-d', strtotime('+6 months', strtotime($mulai)));

            $data_update = array(
              'status'      => $status,
              'tgl_periksa' => date("Y-m-d h:i:s"),
              'asesor'      => $asesor,
              'comment'     =>$comment
            );
            $update = $this->model->edit('tbl_judul', $data_update, "id ='".$IDJudul."'");
            if($update){
              $updatepembinbing = $this->model->edit('tbl_pembimbing', array('Mbimbingan' => $mulai, 'Sbimbingan' => $akhir), "NIM ='".$NIM."'");

              echo "<script>window.close();</script>";
          //echo "<script>window.location.assign('?p=Judul&x=JudulProdi&sts=proses');</script>";          
            }else{
              echo "<script>alert('Gagal dalam proses judul');</script>";
              echo "<script>window.close();</script>";
              echo "<script>window.location.assign('?p=Judul&x=JudulProdi&sts=proses');</script>";
            }

          }else{
            $data_update = array(
              'status'      => $status,
              'tgl_periksa' => date("Y-m-d h:i:s"),
              'asesor'      => $asesor,
              'comment'     =>$comment
            );
            $update = $this->model->edit('tbl_judul', $data_update, "id ='".$IDJudul."'");
            if($update){
              echo "<script>window.close();</script>";
              echo "<script>window.location.assign('?p=Judul&x=JudulProdi&sts=proses');</script>";          
            }else{
              echo "<script>alert('Gagal dalam proses judul');</script>";
              echo "<script>window.close();</script>";
              echo "<script>window.location.assign('?p=Judul&x=JudulProdi&sts=proses');</script>";
            }
          }
        }else{
          echo "<script>window.location.assign('?p=Judul&x=JudulProdi&sts=proses');</script>";    
        }
      }

    }

    public function actionDiterima(){
      $data=$this->model->tampilSemua("tbl_judul t, mhsw m","*","t.nim=m.NIM AND t.status='SUDAH ACC' AND t.tgl_pengajuan LIKE'%2018%'");
      return $this->view->render('judul/diterima',FALSE,$data);
    }

    public function actionDitolak(){
      $data=$this->model->tampilSemua("tbl_judul","id,nim,judul,bahasa,prodi,status","status='SUDAH DITOLAK' AND tgl_pengajuan LIKE'%2018%'");
      return $this->view->render('judul/ditolak',FALSE,$data);
    }

    public function actionDosen(){
      return "Rolly Yesputra";
    }

    public function actionPengajuanJudul()
    {   

      $data['title'] = "<i class='fa fa-book'></i> <b>Judul Skripsi</b>";
      $data['sub_title'] = "<i class='fa fa-telegram'></i> <b>Pengajuan Judul Skripsi</b>";

      if(!$this->islogin('01245')){
        return $this->view->render('no-access',FALSE, $data);
      }

      $NIM = Session::get('username');
      $data['NIM'] = $NIM;
      $Prodi = Session::get('prodi');
      $data['Prodi'] = $Prodi;
      $data['pengajuan'] = true;
      $data['bahasa'] = $this->model->getAll('tbl_bahasa', '*', null, "nama ASC");
      $data['pesan_judul'] ='';

    //set value default
      $data['input'] = array(
        'Judul'    => '',
        'Objek'    => '',
        'Instansi' => '',
        'Bahasa'   => ''
      );
      $data['error_judul'] ='';    

    //jika di submit cek ketersediaan
      if(isset($_POST['cek'])){
        $Judul = $this->post('Judul');
        $Objek = $this->post('Objek');
        $Instansi = $this->post('Instansi');
        $Bahasa = $this->post('Bahasa');
        $judul_usul = strtolower($this->postTOstr($Judul));

        $data['input'] = array(
          'Judul'    =>  $Judul,
          'Objek'    =>  $Objek,
          'Instansi' =>  $Instansi,
          'Bahasa'   =>  $Bahasa
        );

       //cek jumlah kata judul
        $jumlah_kata = str_word_count($Judul, 0);
        if ($jumlah_kata < 6 || $jumlah_kata > 16) {
         $data['error_judul'] ="<strong>Maaf, Judul Skripsi Anda Tidak Sesuai dengan Aturan, Min 6 Kata dan Maksimal 16 Kata <br/>
         Jumlah Judul Anda : " . $jumlah_kata . " Kata , Silahkan Cari Judul Lain </strong>";
       }else{
        $persen_min = 80;
        $persen ='';

        //cari semua judul untuk dibandingkan dengan judul yang diusulkan
        $jdl = $this->model->getAll('tbl_judul', 'judul', "prodi='".$Prodi."'");
        foreach ($jdl as $key) {
          $judul_db = strtolower($this->postTOstr($key['judul']));

          //bandingkan
          similar_text($judul_usul, $judul_db, $persen);

          if($persen > $persen_min){
            $status ="DITOLAK";
            break;

          }else{
            $status ="DITERIMA";
          }
        }

        if($status == 'DITOLAK'){
          $data['pesan_judul'] = "Maaf judul Anda ''".ucwords($Judul)."'' tidak dapat diajukan karena judul tersebut sudah pernah diajukan. <br/> Silahkan ajukan judul yang lain. Semangat...";
        }elseif($status == 'DITERIMA'){
//set session untuk melengkapi pengajuan judul
          $array_sess = array(
            'Judul' => $Judul,
            'Objek' => $Objek,
            'Instansi' => $Instansi,
            'Bahasa' => $Bahasa
          );
          Session::set($array_sess);
          echo "<script>window.location.assign('?p=Judul&x=PengajuanJudulStep2');</script>";

        }
      }
    }

    //cek aktivasi
    $aktif = $this->model->getAll('tbl_aktivasi_mhs', '*', "NIM ='".$NIM."'");
    if(empty($aktif)){
      $data['pengajuan'] = false;
      $data['pesan'] = "Maaf status Anda belum aktif. Silahkan hubungi administrator";
    }else {
    //cek pembayaran
      $pembayaran = $this->model->getAll('tbl_pembayaran', '*', "NIM ='".$NIM."'");
      if(empty($pembayaran)){
        $data['pengajuan'] = false;
        $data['pesan'] = "Anda belum dapat melakukan pengajuan judul skripsi karena Anda belum menyelesaikan administrasi";
      }else {
        //cek pembimbing
        $pembimbing = $this->model->getAll('tbl_pembimbing', '*', " NIM ='".$NIM."'");
        if(empty($pembimbing)){
          $data['pengajuan'] = false;
          $data['pesan'] = "Anda belum memiliki dosen pembimbing. Silahkan hubungi program studi masing-masing";
        }else{
    //cek judul, jika judul sedang diproses atau sudah di acc maka tidak dapat melakukan pengajuan judul lagi
          $cekjudul = $this->model->getAll('tbl_judul', '*', "nim ='".$NIM."'", 'id DESC', 1);
          if(!empty($cekjudul)){
            if($cekjudul[0]['status'] == 'SUDAH ACC'){
              $data['pengajuan'] = false;
              $data['pesan'] = "Judul Anda sudah di ACC";
            }elseif($cekjudul[0]['status'] == 'SEDANG DIPROSES'){
              $data['pengajuan'] = false;
              $data['pesan'] = "Judul Anda sedang dalam proses.";
            }else{
          //cek jumlah ditolak, jika jumlah ditolak sudah 3 kali maka mahasiswa tidak dapat melakukan pengajuan judul secara online
          //cek tolak
              $cektolak = $this->model->getAll('tbl_judul', "count(status) as jumlahtolak", "nim ='".$NIM."' and status ='SUDAH DITOLAK'");
              if($cektolak[0]['jumlahtolak'] >= 3){
               $data['pengajuan'] = false;
               $data['pesan'] = "Anda sudah tidak dapat melakukan pengajuan judul secara online, karena judul Anda sudah ditolak sebanyak 3 kali. Silahkan hubungi Program Studi masing-masing";
             }else{
              $data['pengajuan'] = true;
            }
          }
        }else{
          $data['pengajuan'] = true;
        }
      }
    }
  }
  return $this->view->render('judul/pengajuan-step1',FALSE,$data);

}

public function actionPengajuanJudulStep2()
{ 

  $data['title'] = "<i class='fa fa-book'></i> <b>Judul Skripsi</b>";
  $data['sub_title'] = "<i class='fa fa-telegram'></i> <b>Pengajuan Judul Skripsi</b>";

  if(!$this->islogin('015')){
    return $this->view->render('no-access',FALSE, $data);
  }

  if(empty(Session::get('Judul'))){
    echo "<script>window.location.assign('?p=Judul&x=PengajuanJudul');</script>";
  }

    //set value default
  $data['input'] = array(
    'NIM' => Session::get('username'),
    'Prodi' => Session::get('prodi'),
    'Judul'    => Session::get('Judul'),
    'Objek'    => Session::get('Objek'),
    'Instansi' => Session::get('Instansi'),
    'Bahasa'   => Session::get('Bahasa'),
    'Latar' => '',
    'Rumusan' => '',
    'Batasan' => '',
    'Tujuan' => '',
    'Manfaat' => ''
  );
  $data2 = array();

    //jika di submit
  if(isset($_POST['submit'])){

    $NIM      = $this->post('NIM');
    $Prodi    = $this->post('Prodi');
    $Judul    = $this->post('Judul');
    $Objek    = $this->post('Objek');
    $Instansi = $this->post('Instansi');
    $Bahasa   = $this->post('Bahasa') ;
    $Latar1    = str_replace('&nbsp;', ' ',$this->post('Latar'));
    $Rumusan1  = str_replace('&nbsp;', ' ',$this->post('Rumusan'));
    $Batasan1  = str_replace('&nbsp;', ' ',$this->post('Batasan')) ;
    $Tujuan1   = str_replace('&nbsp;', ' ',$this->post('Tujuan'));
    $Manfaat1  = str_replace('&nbsp;', ' ',$this->post('Manfaat'));

    $Latar    = str_replace(array('<p>','</p>'), '',$Latar1);
    $Rumusan  = str_replace(array('<p>','</p>'), '',$Rumusan1);
    $Batasan  = str_replace(array('<p>','</p>'), '',$Batasan1);
    $Tujuan   = str_replace(array('<p>','</p>'), '',$Tujuan1);
    $Manfaat  = str_replace(array('<p>','</p>'), '',$Manfaat1);

      //set error form

    if(trim($NIM) == ""){
      $data2['NIM'] = "NIM tidak boleh kosong.!";
    }
    if(trim($Prodi) == ""){
      $data2['Prodi'] = "Prodi tidak boleh kosong.!";
    }
    if(trim($Judul) == ""){
      $data2['Judul'] = "Judul tidak boleh kosong.!";
    }
    if(trim($Latar) == ""){
      $data2['Latar'] = "Latar tidak boleh kosong.!";
    }else{
                //hitung jumlah kata dalam latar belakang
                //minimal 500 kata
      $jml_kata = str_word_count(trim($Latar),0);
      if($jml_kata < 500){
        $kurang_kata = 500 - $jml_kata;
        $data2['Latar'] = "Jumlah kata dalam latar belakang minimal 500 kata. <br/> Kurang $kurang_kata kata lagi.";
      }
    }

    if(trim($Rumusan) == "")
    {
      $data2['Rumusan'] = "Rumusan tidak boleh kosong.!";                 
    }else{
                //hitung jumlah kata dalam rumusan masalah
                //minimal 500 kata
      $jml_kata = str_word_count(trim($Rumusan),0);
      if($jml_kata <= 30){
        $data2['Rumusan'] = "Rumusan terlalu singkat";
      }
    }

    if(trim($Batasan) == ""){
      $data2['Batasan'] = "Batasan tidak boleh kosong";
    }else{
                //hitung jumlah kata dalam rumusan masalah
                //minimal 500 kata
      $jml_kata = str_word_count(trim($Batasan),0);
      if($jml_kata <= 30){
        $data2['Batasan']  = "Batasan masalah terlalu singkat.";
      }
    }

    if(trim($Tujuan) == ""){
     $data2['Tujuan']  = "Tujuan Penelitian tidak boleh kosong.!";
   }else{
                //hitung jumlah kata dalam rumusan masalah
                //minimal 500 kata
    $jml_kata2 = str_word_count(trim($Tujuan),0);
    if($jml_kata2 <= 30){
      $data2['Tujuan']  = "Tujuan Penelitian terlalu singkat.";
    }
  }

  if(trim($Manfaat) == ""){
   $data2['Manfaat']  = "Manfaat Penelitian tidak boleh kosong.!";
 }else{
                //hitung jumlah kata dalam rumusan masalah
                //minimal 500 kata
  $jml_kata2 = str_word_count(trim($Manfaat),0);
  if($jml_kata2 <= 30){
    $data2['Manfaat']  = "Manfaat Penelitian terlalu singkat.";
  }
}

if(trim($Bahasa) == ""){
  $data2['Bahasa']  = "Bahasa Pemrograman tidak boleh kosong.!";
}

if(trim($Instansi) == ""){
  $data2['Instansi']  = "Nama Perusahaan tidak boleh kosong.!";
}

if(trim($Objek) == ""){
  $data2['Batasan']  = "Objek Penelitian tidak boleh kosong.!";
}

$data['input'] = array(
  'NIM'      => Session::get('username'),
  'Prodi'    => Session::get('prodi'),
  'Judul'    => Session::get('Judul'),
  'Objek'    => Session::get('Objek'),
  'Instansi' => Session::get('Instansi'),
  'Bahasa'   => Session::get('Bahasa'),
  'Latar'    => $Latar,
  'Rumusan'  => $Rumusan,
  'Batasan'  => $Batasan,
  'Tujuan'   => $Tujuan,
  'Manfaat'  => $Manfaat
);

if (count($data2)<1 ){
  //cari tahun aktif
  $ta=date('Y').'1';
  $id_ta=date('Y').'1';

  $tahun = $this->model->getAll('tbl_ta','id,kode', "aktif ='Y'", null, 1);
  if(!empty($tahun)){
    $ta = $tahun[0]['kode'];
    $id_ta = $tahun[0]['id'];
  }
    // echo "<script>alert('Judul sudah pernah diproses');</script>;
     // <script>window.close();</script>";
     // 
     // simpan ke tbl_judul
  $data_input = array(
   'nim'           => $NIM, 
   'prodi'         => $Prodi, 
   'judul'         => $Judul, 
   'latar'         => $Latar1, 
   'rumusan'       => $Rumusan1, 
   'batasan'       => $Batasan1, 
   'tujuan'        => $Tujuan1, 
   'manfaat'       => $Manfaat1, 
   'instansi'      => $Instansi, 
   'bahasa'        => $Bahasa, 
   'status'        => 'SEDANG DIPROSES',
   'objek'         => $Objek,        
   'tgl_pengajuan' => date('Y-m-d H:s:i'),
   'id_ta'         => $id_ta,
   'tahun'         => $ta, 
   'IsEmpty'       => 'N'
 );
  $insert = $this->model->save('tbl_judul', $data_input);
  if($insert){
    echo "<script>alert('Judul sudah sudah disimpan');</script>;
    <script>window.location.assign('?p=Judul&x=JudulSaya');</script>";
  }else{
    $data['[pesan'] = "Judul tidak dapat disimpan. <br/> Pastikan isian tidak menggunakan karakter '(kutip satu)";
  }
}
}
return $this->view->render('judul/pengajuan-step2',FALSE,$data, $data2);
}

public function actionAdd(){

}

public function actionCek(){
      //proses cek judul mahasiswa dengan menggunakan php similar
      //Melakukan pengecakan data dari judul yang diinput oleh mahasiswa dan disesuaikan dengan
      //judul yang ada didalam database. Dengan menggunakan algoritma dan similar_text yang ada
      //didalam fungsi bawaan program php secara default.
  $judul=$this->post('judul');
  $bahasa=$this->post('bahasa');
  $instansi=$this->post('instansi');
  $objek=$this->post('objek');

      //ambil data dari database
  $data=$this->model->find("*");
}

public function actionValidasi(){

}

public function actionDosen1(){
  $data=$this->model->findOne("*", "id=".$this->get('id'));
  return $this->view->render('judul/pembimbing',FALSE,$data);
}

public function actionDosen2(){
  $data=$this->model->findOne();
  return $data;
}

public function actionPeriksa(){

}

public function actionRekomendasi(){

}

public function actionGantiJudul()
{ 
  $data['title'] = "<i class='fa fa-book'></i> <b>Judul Skripsi</b>";
  $data['sub_title'] = "<i class='fa fa-edit'></i> <b>Update Judul Skripsi</b>";

  if(!$this->islogin('012')){
    return $this->view->render('no-access',FALSE, $data);
  }

  $prodi = Session::get('prodi');
  $data['forminput'] = false;

    //jika dilakukan pencarian
  if(isset($_GET['go'])){
    $NIM = $this->get('nim');
      //cari mahasiswa
    $mhsw = $this->model->getAll('mhsw', 'Name', "NIM ='".$NIM."' and KodeJurusan ='".$prodi."'", null, 1);
    if(empty($mhsw)){
      $data['pesan'] = "Mahasiswa dengan NIM $NIM tidak ditemukan";
    }else{
      //cek apakah judulnya sudah di acc
      $cekjudul = $this->model->getAll('tbl_judul', "*", "status ='SUDAH ACC' and nim ='".$NIM."'");
      if(empty($cekjudul)){
        $data['pesan'] = "Judul tidak dapat di ubah karena judul belum di periksa atau belum ACC.";
      }else{
        $data['forminput'] = true;
        $data['row'] = $cekjudul;
      }
    }
  }
  return $this->view->render('judul/ganti-judul',FALSE,$data);
}

public function actionProsesUpdateJudul()
{
  if(!$this->islogin('012')){
    return $this->view->render('no-access',FALSE);
  }

  if(isset($_POST['submit']))
  {
    $IDJudul = $this->post('IDJudul');
    $JudulBaru = $this->post('JudulBaru');
    $update = $this->model->edit('tbl_judul', array('judul' => $JudulBaru), "id ='".$IDJudul."'");
    if($update)
    {
      echo "<script>alert('Judul berhasil diubah');</script>
      <script>window.location.assign('?p=Judul&x=GantiJudul');</script>;" ;       
    }else{
      echo "<script>alert('Judul gagal diubah');</script>
      <script>window.location.assign('?p=Judul&x=GantiJudul');</script>;" ;
    }
  }else{
    echo "<script>window.location.assign('?p=Judul&x=GantiJudul');</script>;";
  }
}

public function actionCetak(){

}

public function actionJudulOffline()
{ 

  $data['title'] ="<i class='fa fa-book'></i> <b>Judul Offline</b>";
  $data['sub_title'] = "<i class='fa fa-telegram'> </i> <b>Input Judul Offline</b>";

  if(!$this->islogin('012')){
    return $this->view->render('no-access',FALSE, $data);
  }

  $prodi = Session::get('prodi');
  $data['forminput'] = false;

    //jika dilakukan pencarian
  if(isset($_GET['go'])){
    $NIM = $this->get('nim');
      //cari mahasiswa
    $mhsw = $this->model->getAll('mhsw', 'Name', "NIM ='".$NIM."' and KodeJurusan ='".$prodi."'", null, 1);
    if(empty($mhsw)){
      $data['pesan'] = "Mahasiswa dengan NIM $NIM tidak ditemukan";
    }else{
      //cek apakah judulnya sudah ditolak sebnyak 3 kali
      $cekjudul = $this->model->getAll('tbl_judul', "count(status) as jumlah", "status ='SUDAH DITOLAK' and nim ='".$NIM."'");
      if($cekjudul[0]['jumlah'] < 3){
        $data['pesan'] = "Tidak dapat input judul offline untuk mahasiswa ini, karena judul yang ditolak belum mencukupi jumlah maksimal untuk input judul offline.";
      }else{
        $data['forminput'] = true;
        $data['nim'] = $NIM;
        $data['prodi'] = $prodi;
        $data['bahasa'] = $this->model->getAll('tbl_bahasa', '*', null, "nama ASC");
      }
    }
  }

    //jika disimpan
  if(isset($_POST['simpan'])){
    $tahun = $this->model->getAll('tbl_ta', 'kode', "aktif = 'Y'");
    $data_input =  array(
      'nim'      => $this->post('NIM'),
      'prodi'    => $this->post('Prodi'),
      'judul'    => $this->post('Judul'),
      'latar'    => str_replace('&nbsp;', ' ',$this->post('Latar')),
      'rumusan'  => str_replace('&nbsp;', ' ',$this->post('Rumusan')),
      'batasan'  => str_replace('&nbsp;', ' ',$this->post('Batasan')),
      'tujuan'   => str_replace('&nbsp;', ' ',$this->post('Tujuan')),
      'manfaat'  => str_replace('&nbsp;', ' ',$this->post('Manfaat')),
      'instansi' => $this->post('Instansi'),
      'bahasa'   => $this->post('Bahasa'),
      'objek'    => $this->post('Objek'),
      'status'   => 'SEDANG DIPROSES',
      'tgl_pengajuan' => date('Y-m-d H:s:i'),
      'tahun' => $tahun[0]['kode'],
      'IsEmpty' => 'N'
    );
      //proses simpan
    $insert = $this->model->save('tbl_judul', $data_input);
    if($insert){
      echo "<script>alert('Judul sudah di simpan');</script>
      <script>window.location.assign('?p=Judul&x=JudulProdi&sts=proses');</script>";
    }else{
      $data['pesan'] = "Judul offline gagal disimpan";
    }
  }

  return $this->view->render('judul/input-offline',FALSE,$data);

}

public function actionJudulSaya()
{

  $data['title'] ="<i class='fa fa-book'></i> <b>Judul Skripsi</b>";
  $data['sub_title'] ="<i class='fa fa-book'></i> <b> Judul Skripsi Saya</b>";
  if(!$this->islogin('015')){
    return $this->view->render('no-access',FALSE, $data);
  }
  $NIM = Session::get('username');
  $data['judul'] = $this->model->getAll('tbl_judul', 'id, nim, judul, tgl_pengajuan, bahasa, objek, instansi, prodi, status', "nim='".$NIM."'", "id DESC");
  return $this->view->render('judul/judul-saya', FALSE, $data);

}

public function actionJudulRekomendasi()
{  

  $data['title'] = "<i class='fa fa-book'></i> <b>Judul Skripsi</b> ";
  $data['sub_title'] = "<i class='fa fa-share-alt'></i>  <b>Rekomendasi Judul Skripsi</b>";
  if(!$this->islogin('0124')){
    return $this->view->render('no-access',FALSE, $data);
  }
  $prodi = Session::get('prodi');

  $select = "mhsw.NIM, mhsw.Name, tbl_judul.judul, tbl_judul.status, tbl_judul.rekomendasi, tbl_judul.tahun, tbl_judul.id, tbl_judul.tgl_rekom, CONCAT_WS(', ',dosen.Name, dosen.Gelar) as NamaDosen";
  $join = "inner join mhsw on mhsw.NIM = tbl_judul.nim
  inner join tbl_tim_seleksi on tbl_tim_seleksi.iddosen = tbl_judul.dosenrekom
  inner join dosen on dosen.ID = tbl_tim_seleksi.iddosen";
  $where = "tbl_judul.prodi ='".$prodi."'";

  $data['judul'] = $this->model->getAllJoin('tbl_judul', $select, $join, $where, "tbl_judul.tahun, mhsw.Name ASC");

  return $this->view->render('judul/judul-rekomendasi', FALSE, $data);

}

public function actionJudulRekomendasiDosen()
{ 

 $data['title'] = "<i class='fa fa-book'></i> <b>Judul Skripsi</b> ";
 $data['sub_title'] = "<i class='fa fa-share-alt'></i>  <b>Rekomendasi Judul Skripsi</b>";
 if(!$this->islogin('014')){
  return $this->view->render('no-access',FALSE, $data);
}

$IDDosen = Session::get('id_user');

  //$prodi = Session::get('prodi');

$select = "mhsw.NIM, mhsw.Name, tbl_judul.judul, tbl_judul.status, tbl_judul.rekomendasi, tbl_judul.tahun, tbl_judul.id, tbl_judul.tgl_rekom, CONCAT_WS(', ',dosen.Name, dosen.Gelar) as NamaDosen";
$join = "inner join mhsw on mhsw.NIM = tbl_judul.nim
inner join tbl_tim_seleksi on tbl_tim_seleksi.iddosen = tbl_judul.dosenrekom
inner join dosen on dosen.ID = tbl_tim_seleksi.iddosen";
$where = "tbl_tim_seleksi.IDDosen ='".$IDDosen."'";

$data['judul'] = $this->model->getAllJoin('tbl_judul', $select, $join, $where, "tbl_judul.tahun, mhsw.Name ASC");

return $this->view->render('judul/judul-rekomendasi', FALSE, $data);

}

public function actionProsesRekom()
{  
  if(!$this->islogin('014')){
    return $this->view->render('no-access',FALSE, $data);
  }
  if(isset($_POST['simpan'])){
    $IDJ = $this->post('idj');
    $data_update = array(
      'rekomendasi' => $this->post('rekom'),
      'tgl_rekom' => date('Y-m-d'),
      'comment_rekom' => $this->post('komen')
    );
    $update = $this->model->edit('tbl_judul', $data_update, "id ='".$IDJ."'");
    echo "<script>window.close()</script>";
  }else{
    echo "<script>alert('Gagal disimpan');</script>
    <script>window.close();</script>";
  }
}


public function actionHapus()
{

  if(!$this->islogin('01')){
    return $this->view->render('no-access',FALSE, $data);
  }
  $this->model->delete(
    array(
      "id"=>$this->get('id'),
    ),"Judul"
  );
}

public function actionProsesJudul()
{

  if(!$this->islogin('0124')){
    return $this->view->render('no-access',FALSE, $data);
  }
  $asesor = Session::get('name');

  $status= $this->get('sts');
  $idj = $this->get('idj');

  $tgl = date("Y-m-d h:i:s");
  $NIM = $this->get('nim');

  if(empty($status) or empty($idj) or empty($NIM)){
   echo "<script>alert('Judul tidak dapat diproses');</script>";
   echo "<script>window.location.assign('?p=Judul&x=JudulProdi&sts=proses');</script>";
 }else{
    //cek apakah sudah pernah di ACC
  $cekjudul = $this->model->getAll('tbl_judul', "status", "status = 'SEDANG DIPROSES' and id ='".$idj."' and nim ='".$NIM."'");
  if(!empty($cekjudul)){
            //jika status DI ACC
            //set tanggal awal dan akhir bimbingan
    if($status == 1){
      $mulai = date('Y-m-d');
            //lama waktu bimbingan adalah 6 bulan dari judul di ACC oleh KA.Prodi.
      $akhir = date('Y-m-d', strtotime('+6 months', strtotime($mulai)));

      $data_update = array(
        'status'      => 'SUDAH ACC',
        'tgl_periksa' => date("Y-m-d h:i:s"),
        'asesor'      => $asesor
          //'comment'     =>$comment
      );
      $update = $this->model->edit('tbl_judul', $data_update, "id ='".$idj."'");
      if($update){
        $updatepembinbing = $this->model->edit('tbl_pembimbing', array('Mbimbingan' => $mulai, 'Sbimbingan' => $akhir), "NIM ='".$NIM."'");

        echo "<script>alert('Judul Sudah diproses');</script>";
        echo "<script>window.close();</script>";
        echo "<script>window.location.assign('?p=Judul&x=JudulProdi&sts=proses');</script>";          
      }else{
        echo "<script>alert('Gagal dalam proses judul');</script>";
        echo "<script>window.close();</script>";
        echo "<script>window.location.assign('?p=Judul&x=JudulProdi&sts=proses');</script>";
      }

    }else{
      $data_update = array(
        'status'      => 'SUDAH DITOLAK',
        'tgl_periksa' => date("Y-m-d h:i:s"),
        'asesor'      => $asesor
          //'comment'     =>$comment
      );
      $update = $this->model->edit('tbl_judul', $data_update, "id ='".$idj."'");
      if($update){
        echo "<script>alert('Judul sudah diproses');</script>";
        echo "<script>window.close();</script>";
        echo "<script>window.location.assign('?p=Judul&x=JudulProdi&sts=proses');</script>";          
      }else{
        echo "<script>alert('Gagal dalam proses judul');</script>";
        echo "<script>window.close();</script>";
        echo "<script>window.location.assign('?p=Judul&x=JudulProdi&sts=proses');</script>";
      }
    }
  }else{
    echo "<script>alert('Judul tidak dapat diproses');</script>";
    echo "<script>window.location.assign('?p=Judul&x=JudulProdi&sts=proses');</script>";
  }
}
}

public function actionAccJudul()
{

  if(!$this->islogin('012')){
    return $this->view->render('no-access',FALSE, $data);
  }
  $asesor = Session::get('name');

  $status= $this->get('sts');
  $idj = $this->get('id');

  $tgl = date("Y-m-d h:i:s");
  $NIM = $this->get('nim');

  if(empty($status) or empty($idj) or empty($NIM)){
   echo "<script>alert('Judul tidak dapat diproses');</script>";
   echo "<script>window.location.assign('?p=Judul&x=JudulRekomendasi');</script>";
 }else{
    //cek apakah sudah pernah di ACC
  $cekjudul = $this->model->getAll('tbl_judul', "status", "status = 'SEDANG DIPROSES' and id ='".$idj."' and nim ='".$NIM."'");
  if(!empty($cekjudul)){
            //jika status DI ACC
            //set tanggal awal dan akhir bimbingan
    if($status == 1){
      $mulai = date('Y-m-d');
            //lama waktu bimbingan adalah 6 bulan dari judul di ACC oleh KA.Prodi.
      $akhir = date('Y-m-d', strtotime('+6 months', strtotime($mulai)));

      $data_update = array(
        'status'      => 'SUDAH ACC',
        'tgl_periksa' => date("Y-m-d h:i:s")
        //'asesor'      => $asesor
          //'comment'     =>$comment
      );
      $update = $this->model->edit('tbl_judul', $data_update, "id ='".$idj."'");
      if($update){
        $updatepembinbing = $this->model->edit('tbl_pembimbing', array('Mbimbingan' => $mulai, 'Sbimbingan' => $akhir), "NIM ='".$NIM."'");

        echo "<script>alert('Judul Sudah diproses');</script>";
        echo "<script>window.close();</script>";
        echo "<script>window.location.assign('?p=Judul&x=JudulRekomendasi');</script>";          
      }else{
        echo "<script>alert('Gagal dalam proses judul');</script>";
        echo "<script>window.close();</script>";
        echo "<script>window.location.assign('?p=Judul&x=JudulRekomendasi');</script>";
      }

    }else{
      $data_update = array(
        'status'      => 'SUDAH DITOLAK',
        'tgl_periksa' => date("Y-m-d h:i:s")
       // 'asesor'      => $asesor
          //'comment'     =>$comment
      );
      $update = $this->model->edit('tbl_judul', $data_update, "id ='".$idj."'");
      if($update){
        echo "<script>alert('Judul sudah diproses');</script>";
        echo "<script>window.close();</script>";
        echo "<script>window.location.assign('?p=Judul&x=JudulRekomendasi');</script>";          
      }else{
        echo "<script>alert('Gagal dalam proses judul');</script>";
        echo "<script>window.close();</script>";
        echo "<script>window.location.assign('?p=Judul&x=JudulRekomendasi');</script>";
      }
    }
  }else{
    echo "<script>alert('Judul tidak dapat diproses');</script>";
    echo "<script>window.location.assign('?p=Judul&x=JudulRekomendasi');</script>";
  }
}
}

public function actionUbah()
{
  $data['title'] = "<i class='fa fa-book'></i> <b>Judul Skripsi</b> ";
  $data['sub_title'] = "<i class='fa fa-edit'></i>  <b>Edit Judul Skripsi</b>";
  if(!$this->islogin('01')){
    return $this->view->render('no-access',FALSE, $data);
  }

  //proses update
  if(isset($_POST['simpan'])){
    $ID = $this->post('id');
    // update ke tbl_judul
  $data_input = array(
      'nim'      => $this->post('nim'),
      'judul'    => $this->post('judul'),
      'latar'    => str_replace('&nbsp;', ' ',$this->post('latar')),
      'rumusan'  => str_replace('&nbsp;', ' ',$this->post('rumusan')),
      'batasan'  => str_replace('&nbsp;', ' ',$this->post('batasan')),
      'tujuan'   => str_replace('&nbsp;', ' ',$this->post('tujuan')),
      'manfaat'  => str_replace('&nbsp;', ' ',$this->post('manfaat'))
 );
  $update = $this->model->edit('tbl_judul', $data_input, "id='".$ID."'");
  if($update){
    echo "<script>alert('Judul sudah sudah diubah');</script>;
    <script>window.location.assign('?p=Judul');</script>";
  }else{
    $data['[pesan'] = "Judul tidak dapat disimpan. <br/> Pastikan isian tidak menggunakan karakter '(kutip satu)";
  }
  }

    $ID= $this->get('id');
    $judul = $this->model->getAll('tbl_judul', '*', "id ='".$ID."'");
    if(empty($judul)){
      echo "<script>alert('Judul tidak ditemukan');</script>";
    echo "<script>window.location.assign('?p=Judul');</script>";
    }else{
      //$data['input'] = $judul[0]['nim'];
      foreach ($judul as $value) {
        $data['input'] = $value;
      }
    }
  
  return $this->view->render('judul/edit',FALSE,$data);

}


function postTOstr($data){
  return preg_replace("/[^a-zA-Z0-9]/", "", $data);
}

}
