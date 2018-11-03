<?php


class Statistik extends Model{
	public function __construct(){
		parent::__construct();
	}

	public function tabel() {
        return 'tbl_judul';
    }

    public function find() {

    	$join = "inner join mhsw on mhsw.NIM = tbl_judul.nim";
        $this->crud->selectjoin($this->tabel(),"mhsw.NIM, mhsw.Name, mhsw.KodeJurusan, tbl_judul.judul, tbl_judul.latar, tbl_judul.bahasa, tbl_judul.instansi, tbl_judul.status, tbl_judul.objek, tbl_judul.tgl_pengajuan", $join, null, 'tgl_pengajuan DESC', 5);
      $data= $this->crud->getResult();
      return json_decode($data,true);
        
    }

    public function getAllJoin($table, $rows =null, $join =null, $where =null, $order =null, $limit = null)
    {
       $this->crud->selectjoin($table, $rows, $join, $where, $order);
        $data=$this->crud->getResult();
        return json_decode($data,true);
    }

    public function getAll($table, $rows, $where = null, $order = null, $limit = null, $group =null)
    {
      $this->crud->select($table, $rows, $where, $order, $limit, $group);
      $data= $this->crud->getResult();
      return json_decode($data,true);
    }
    
    public function delete($where = null, $page = null) {
        
    }

    public function edit($field = null, $where = null, $page = null) {
        
    }

    

    public function findOne($rows, $where = null, $order = null, $limit = null) {
        
    }

    public function save($rows = null, $page = null) {
        
    }

}


?>
