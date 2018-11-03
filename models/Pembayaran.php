<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Pembayaran
 *
 * @author rolly
 */
class Pembayaran extends Model {
    public function hapus($table, $where = null, $page = null) {
        $this->crud->delete(
        $table,$where,$page);
    }

    public function delete($where = null, $page = null) {
    }
    public function edit($field = null, $where = null, $page = null) {
        
    }

    public function find() {
        
    }

    public function findOne($rows, $where = null, $order = null, $limit = null) {
        
    }

    public function save($table = null, $data_input = null) {
         return $this->crud->insert($table, $data_input);
      //     $this->crud->create(
      //   'tbl_uang_masuk', $data_input, 'bayar'
      // );
    } 
    
    // public function save($rows = null, $page = null) {
    //   $this->crud->create(
    //    'tbl_uang_masuk', $rows, $page
    //   );
    // }

    public function tabel() {
        
    }

    public function cekMhsw($select, $join, $where)
    {
        $this->crud->selectjoin('mhsw', $select, $join, $where, null, 1);
      $data= $this->crud->getResult();
      return json_decode($data,true); 
    }

    public function getBiaya(){
        $this->crud->find('tbl_master_biaya', "BIAYA, TA", null, "ID DESC" , 1);
      $data= $this->crud->getResult();
      return $data;
      //return json_decode($data,true);
    }

    public function getTA()
    {
      $this->crud->select('tbl_ta',"kode, tahun");
      $data= $this->crud->getResult();
      return json_decode($data,true); 
    }

    public function getAllPembayaran($select, $join, $where, $order){
      $this->crud->selectjoin('tbl_aktivasi_mhs',$select, $join, $where, $order);
      $data= $this->crud->getResult();
      return json_decode($data,true); 
    }

    public function getAll($table, $rows, $where = null, $order = null, $limit = null)
    {
      $this->crud->select($table, $rows, $where, $order, $limit);
      $data= $this->crud->getResult();
      return json_decode($data,true);
    }

//put your code here
}
