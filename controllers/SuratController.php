<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SuratController
 *
 * @author rolly
 */
class SuratController extends Controller{
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
    	$data['title'] = "<i class='fa fa-envelope-open'></i> <b>Surat</b>";
        $data['sub_title'] = "<i class='fa fa-envelope-open'></i> <b>Surat</b>";

        if(!$this->islogin('015')){
            return $this->view->render('no-access',FALSE, $data);
        }

    	return $this->view->render('surat/index',FALSE,$data);
    }

    public function actionCetakDoping()
    {
    	if(!$this->islogin('015')){
            return $this->view->render('no-access',FALSE);
        }

    	$prodi = Session::get('prodi');
    	$NIM= Session::get('username');

    	$select = "(select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_pembimbing.IDDosen1 ) as Dosen1, (select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_pembimbing.IDDosen2 ) as Dosen2 , (select NIDN from dosen where dosen.ID = tbl_pembimbing.IDDosen1 ) as NIDN1, (select NIDN from dosen where dosen.ID = tbl_pembimbing.IDDosen2 ) as NIDN2 , tbl_pembimbing.Mbimbingan, tbl_pembimbing.Sbimbingan, tbl_pembimbing.NoSurat, mhsw.Name, mhsw.NIM";
    	$where = "tbl_pembimbing.NIM =12220404";
    	$join = "inner join mhsw on mhsw.NIM = tbl_pembimbing.NIM";
    	$data['surat'] = $this->model->getAllJoin('tbl_pembimbing', $select, $join, $where, null, 1);

    	if(empty($data['surat'])){
    		echo "<script>alert('Dosen pembimbing belum di set. Silahkan hubungi prodi.');</script>;
      <script>window.close();</script>";
    	}
    	$data['judul'] = $this->model->getAll('tbl_judul', 'judul', "nim='".$NIM."'", "id desc", 1);
    	return $this->view->render('surat/cetak-doping',true ,$data, null, 'report');
    }

    public function actionCetakKelayakanJudul()
    {
    	if(!$this->islogin('015')){
            return $this->view->render('no-access',FALSE);
        }
    	$NIM = Session::get('username');
    	//cek statu judul
    	$select = "mhsw.Name, mhsw.NIM, tbl_judul.judul, tbl_judul.prodi, tbl_pembimbing.IDDosen1, dosen.Name as Dosen1, dosen.NIDN, tbl_judul.status";
    	$join = "inner join mhsw on mhsw.NIM = tbl_judul.nim
    				inner join tbl_pembimbing on tbl_pembimbing.NIM = tbl_judul.nim
    				left outer join dosen on dosen.ID = tbl_pembimbing.IDDosen1";
		$where = "tbl_judul.nim ='".$NIM."' and tbl_judul.status='SUDAH ACC'";
    	$data['judul'] = $this->model->getAllJoin('tbl_judul', $select, $join, $where, null, 1);

    	if(empty($data['judul'])){
    		echo "<script>alert('Judul Anda belum Di ACC');</script>;
      <script>window.close();</script>";
    	}
    	return $this->view->render('surat/cetak-kelayakan-judul',true ,$data, null, 'report');

    }

    public function actionCetakKehadiranSeminar()
    {
    	if(!$this->islogin('015')){
            return $this->view->render('no-access',FALSE);
        }
    	$kode = $this->get('kd');
    	$NIM = Session::get('username');
    	if($kode != 1 and $kode != 2){
    		echo "<script>alert('Surat tidak ditemukan');</script>;
    		<script>window.close();</script>";
    	}else{
    		if($kode ==1){
    			$view = "surat/cetak-kehadiran-proposal";
    		}else{
    			$view = "surat/cetak-kehadiran-hasil";
    		}
    	}

    	$data['row'] = $this->model->getAllJoin(
    				'mhsw', 
    				'mhsw.NIM, mhsw.Name, mhsw.KodeJurusan',
    				"inner join tbl_aktivasi_mhs on tbl_aktivasi_mhs.NIM = mhsw.NIM", 
    				"mhsw.NIM='".$NIM."'", null, 1
    			);

    	return $this->view->render($view,true ,$data, null, 'report');

    }

    public function actionCetakPermohonanSempro()
    {
    	if(!$this->islogin('015')){
            return $this->view->render('no-access',FALSE);
        }
    	$NIM = Session::get('username');
    	//cek statu judul
    	$select = "mhsw.Name, mhsw.NIM, tbl_judul.judul, tbl_judul.prodi, tbl_pembimbing.IDDosen1, dosen.Name as Dosen1, dosen.NIDN, tbl_judul.status";
    	$join = "inner join mhsw on mhsw.NIM = tbl_judul.nim
    				inner join tbl_pembimbing on tbl_pembimbing.NIM = tbl_judul.nim
    				left outer join dosen on dosen.ID = tbl_pembimbing.IDDosen1";
		$where = "tbl_judul.nim ='".$NIM."' and tbl_judul.status='SUDAH ACC'";
    	$data['judul'] = $this->model->getAllJoin('tbl_judul', $select, $join, $where, null, 1);

    	if(empty($data['judul'])){
    		echo "<script>alert('Judul Anda belum Di ACC');</script>;
      <script>window.close();</script>";
    	}
    	return $this->view->render('surat/cetak-permohonan-sempro',true ,$data, null, 'report');


    }

    public function actionCetakPermohonanSemha()
    {
    	if(!$this->islogin('015')){
            return $this->view->render('no-access',FALSE);
        }
    	$NIM = Session::get('username');
    	//cek statu judul
    	$select = "mhsw.Name, mhsw.NIM, tbl_judul.judul, tbl_judul.prodi, tbl_pembimbing.IDDosen1, dosen.Name as Dosen1, dosen.NIDN, tbl_judul.status";
    	$join = "inner join mhsw on mhsw.NIM = tbl_judul.nim
    				inner join tbl_pembimbing on tbl_pembimbing.NIM = tbl_judul.nim
    				left outer join dosen on dosen.ID = tbl_pembimbing.IDDosen1";
		$where = "tbl_judul.nim ='".$NIM."' and tbl_judul.status='SUDAH ACC'";
    	$data['judul'] = $this->model->getAllJoin('tbl_judul', $select, $join, $where, null, 1);

    	if(empty($data['judul'])){
    		echo "<script>alert('Judul Anda belum Di ACC');</script>;
      <script>window.close();</script>";
    	}
    	return $this->view->render('surat/cetak-permohonan-semha',true ,$data, null, 'report');
    }

    public function actionCetakPermohonanSidang()
    {
        if(!$this->islogin('015')){
            return $this->view->render('no-access',FALSE);
        }
        $NIM = Session::get('username');
        //cek statu judul
        $select = "mhsw.Name, mhsw.NIM, tbl_judul.judul, tbl_judul.prodi, tbl_pembimbing.IDDosen1, dosen.Name as Dosen1, dosen.NIDN, tbl_judul.status";
        $join = "inner join mhsw on mhsw.NIM = tbl_judul.nim
                    inner join tbl_pembimbing on tbl_pembimbing.NIM = tbl_judul.nim
                    left outer join dosen on dosen.ID = tbl_pembimbing.IDDosen1";
        $where = "tbl_judul.nim ='".$NIM."' and tbl_judul.status='SUDAH ACC'";
        $data['judul'] = $this->model->getAllJoin('tbl_judul', $select, $join, $where, null, 1);

        if(empty($data['judul'])){
            echo "<script>alert('Judul Anda belum Di ACC');</script>;
      <script>window.close();</script>";
        }
        return $this->view->render('surat/cetak-permohonan-sidang',true ,$data, null, 'report');


    }

    public function actionCetakUndanganSempro()
    {
        if(!$this->islogin('015')){
            return $this->view->render('no-access',FALSE);
        }

        $NIM = Session::get('username');

        $select = "mhsw.NIM, mhsw.Name, mhsw.KodeJurusan, tbl_seminar.*,                        
        (select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_pembimbing.IDDosen1 ) as Dosen1, 
        (select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_pembimbing.IDDosen2 ) as Dosen2,
        (select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_seminar.IDKetua) as Ketua,
        (select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_seminar.IDPenguji1 ) as Penguji1,
        (select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_seminar.IDPenguji2 ) as Penguji2,
        tbl_seminar.Gelombang, tbl_seminar.Tahun, tbl_seminar.IDSeminar";

        $join ="inner join mhsw on mhsw.NIM = tbl_seminar.NIM
                inner join tbl_pembimbing on tbl_pembimbing.NIM = tbl_seminar.NIM";
        $where ="tbl_seminar.JenisSeminar = 'Proposal' and tbl_seminar.NIM = '".$NIM."'";
        $data['undangan'] = $this->model->getAllJoin('tbl_seminar', $select, $join, $where);
        return $this->view->render('surat/cetak-undangan-sempro',true ,$data, null, 'report');                   
    }

    public function actionCetakUndanganSemha()
    {
        if(!$this->islogin('015')){
            return $this->view->render('no-access',FALSE);
        }

        $NIM = Session::get('username');

        $select = "mhsw.NIM, mhsw.Name, mhsw.KodeJurusan, tbl_seminar.*,                        
        (select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_pembimbing.IDDosen1 ) as Dosen1, 
        (select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_pembimbing.IDDosen2 ) as Dosen2,
        (select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_seminar.IDKetua) as Ketua,
        (select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_seminar.IDPenguji1 ) as Penguji1,
        (select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_seminar.IDPenguji2 ) as Penguji2,
        tbl_seminar.Gelombang, tbl_seminar.Tahun, tbl_seminar.IDSeminar";

        $join ="inner join mhsw on mhsw.NIM = tbl_seminar.NIM
                inner join tbl_pembimbing on tbl_pembimbing.NIM = tbl_seminar.NIM";
        $where ="tbl_seminar.JenisSeminar = 'Hasil' and tbl_seminar.NIM = '".$NIM."'";
        $data['undangan'] = $this->model->getAllJoin('tbl_seminar', $select, $join, $where);
        return $this->view->render('surat/cetak-undangan-semha',true ,$data, null, 'report');                   
    }
}
