<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Laporan
 *
 * @author rolly
 */
class Laporan extends Model {
//put your code here
  
    public function delete($where = null, $page = null) {
        
    }

    public function edit($field = null, $where = null, $page = null) {
        
    }

    public function find() {
        
    }

    public function getAllJoin($table, $rows =null, $join =null, $where =null, $order =null, $limit = null)
    {
       $this->crud->selectjoin1($table, $rows, $join, $where, $order);
        $data=$this->crud->getResult();
        return $data;
    }

    public function findOne($rows, $where = null, $order = null, $limit = null) {
        $this->crud->select($this->tabel(), "*", $where);
        $data=$this->crud->getResult();
        return json_decode($data,true);
    }

    public function getAll($table, $rows, $where = null, $order = null, $limit = null)
    {
      $this->crud->find($table, $rows, $where, $order, $limit);
      $data= $this->crud->getResult();
      return $data;
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

}
