<?php

/**
 * Description of Judul
 *
 * @author rolly
 */
class Judul extends Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }
    /**
     * Mencari data didalam tabel judul
     */
    public function findAll() {
        $this->crud->find($this->tabel(), "id,nim,judul,prodi,bahasa,status",NULL,"prodi ASC");
        $data = $this->crud->getResult();
        return $data;
    }
    /**
     * Fungsi getAllJoin tanpa menggunakan json
     */
    public function getAllJoin($table, $rows =null, $join =null, $where =null, $order =null, $limit = null)
    {
       $this->crud->selectjoin1($table, $rows, $join, $where, $order, $limit);
        $data=$this->crud->getResult();
        return $data;
    }
    /**
     * Fungsi getAlljoin dengan menggunakan json
     */
    public function getAllJoin1($table, $rows =null, $join =null, $where =null, $order =null, $limit = null)
    {
       $this->crud->selectjoin($table, $rows, $join, $where, $order, $limit);
        $data=$this->crud->getResult();
        return json_decode($data,true);
    }
    /**
     * fungsi untuk mengambil satu dari dalam basisdata
     */
    public function findOne($rows, $where = null, $order = null, $limit = null) {
        $this->crud->select($this->tabel(), "*", $where);
        $data=$this->crud->getResult();
        return json_decode($data,true);
    }
    /**
     * fungsi untuk mengambil semua data dari dalam tabel dan dikembalikan dalam bentuk data json
     */
    public function getAll($table, $rows, $where = null, $order = null, $limit = null)
    {
      $this->crud->select($table, $rows, $where, $order, $limit);
      $data= $this->crud->getResult();
      return json_decode($data,true);
    }

    /**
     * Fungsi untuk menggunakan queri innerjoin
     */
    public function innerJoin($tabel=null, $rows=null, $where=null, $order=null, $limit=null){
      $this->crud->select($tabel, $rows, $where);
      $data=$this->crud->getResult();
      return json_decode($data, true);
    }
    /**
     * Fungsi untuk menampilkan semua data dari dalam basisdata
     */
    public function tampilSemua($tabel=null, $rows=null, $where=null, $order=null, $limit=null){
      $this->crud->find($tabel, $rows, $where);
      $data = $this->crud->getResult();
      return $data;
    }
    /**
     * Menampilkan semua data dari dalam tabel
     */
    public function find() {
        $this->crud->select($this->tabel(), "nim,prodi,bahasa,status","status='SUDAH ACC'");
        $data = $this->crud->getResult();
        return json_decode($data, true);
    }
    /**
     * menampilkan semua data judul
     */
    public function tampilJudul(){
      $this->crud->select("tbl_bahasa","*");
      $data=$this->crud->getResult();
      return json_decode($data,true);
    }
    /**
     * fungsi save
     */
    public function save($tabel= null, $rows = null) {
        return $this->crud->insert($tabel, $rows);        
    }
    /**
     * fungsi mengambil data judul
     */
    public function tabel() {
        return "tbl_judul";
    }
    /**
     * fungsi delete
     */
    public function delete($where = null, $page = null) {
      $this->crud->delete(
        $this->tabel(), $where, $page
      );
    }
    /**
     * fungsi edit data
     */
    public function edit($tabel = null, $field = null, $where = null, $page = null) {
        return $this->crud->update($tabel, $field, $where, $page);
    }

}
