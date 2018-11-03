<?php

/**
 * Description of Timseleksi
 * Tim adhock merupakan tim dosen yang bertugas untuk memeriksa judul skripsi yang diajukan oleh
 * Mahasiswa secara online
 * @author rolly
 */
class Timseleksi  extends Model{
    //put your code here
    public function __construct() {
        parent::__construct();
    }

    public function delete($where = null, $page = null) {
      $this->crud->delete(
        $this->tabel(), $where, $page
      );
    }

     public function edit($field = null, $where = null, $page = null) {
        return $this->crud->update($this->tabel(), $field, $where, $page);
    }

    public function find() {
      $this->crud->select($this->tabel(),"*");
      $data= $this->crud->getResult();
      return json_decode($data,true);
    }

    public function findOne($rows, $where = null, $order = null, $limit = null) {
      $this->crud->select($this->tabel(),$rows, $where);
      $data= $this->crud->getResult();
      return json_decode($data,true);
    }

     public function save($table = null, $data_input = null) {
         return $this->crud->insert($table, $data_input);
    }

    public function getAllJoin($table, $rows =null, $join =null, $where =null, $order =null, $limit = null)
    {
       $this->crud->selectjoin($table, $rows, $join, $where, $order);
        $data=$this->crud->getResult();
        return json_decode($data,true);
    }

    public function getAll($table, $rows, $where = null, $order = null, $limit = null)
    {
      $this->crud->select($table, $rows, $where, $order, $limit);
      $data= $this->crud->getResult();
      return json_decode($data,true);
    }

    public function tabel() {
        return "tbl_tim_seleksi";
    }

}
