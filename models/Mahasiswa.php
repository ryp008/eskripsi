<?php
class Mahasiswa extends Model{
    public function __construct() {
        parent::__construct();
    }

    public function tabel(){
      return "mhsw";
    }


    public function fields(){
        return array(
            "nim","nim_enkripsi","namalengkap","email","alamat"
        );
    }


    public function find(){
      $this->crud->select($this->tabel(),"*");
      $data= $this->crud->getResult();
      return json_decode($data,true);
    }

    public function findOne($rows, $where = null, $order = null, $limit = null){      
      $this->crud->select(
        $tabel, $rows, $where, $order, $limit
      );
      $data=$this->crud->getResult();
      return json_decode($data, true);
    }

    public function getAllJoin($table, $rows =null, $join =null, $where =null, $order =null, $limit = null)
    {
       $this->crud->selectjoin($table, $rows, $join, $where, $order, $limit);
        $data=$this->crud->getResult();
        return json_decode($data,true);
    }

    public function save($tabel= null, $rows = null) {
    return $this->crud->insert($tabel, $rows);        
  }

    public function saveloop($tabel =null, $rows = null){
      $this->crud->insertloop($tabel, $rows);
    }

    public function edit($table = null, $field = null, $where = null, $page = null) {
    return $this->crud->update($table, $field, $where, $page);
  }

    public function delete($where = null, $page = null){
      $this->crud->delete($this->tabel(),$where,$page);
    }

    public function getAll($table, $rows, $where = null, $order = null, $limit = null)
    {
      $this->crud->select($table, $rows, $where, $order, $limit);
      $data= $this->crud->getResult();
      return json_decode($data,true); 
    }

    public function getMhswAktif($select, $join, $where, $order){
      $this->crud->selectjoin('tbl_aktivasi_mhs',$select, $join, $where, $order);
      $data= $this->crud->getResult();
      return json_decode($data,true); 
    }

    public function getMhsw($select, $where, $order){
      $this->crud->select('mhsw', $select, $where, $order);
      $data= $this->crud->getResult();
      return json_decode($data,true); 
    }

}
