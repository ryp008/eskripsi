<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Bimbingan
 *
 * @author rolly
 */
class Pembimbing extends Model{
    public function delete($where = null, $page = null) {
        
    }

     public function tabel() {
        return 'tbl_pembimbing';
    }

    public function edit($field = null, $where = null, $page = null) {
        return $this->crud->update($this->tabel(), $field, $where, $page);
    }

    public function find() {
        
    }

    public function findOne($rows, $where = null, $order = null, $limit = null) {
        
    }

    public function save($tabel= null, $rows = null) {
        return $this->crud->insert($tabel, $rows);        
    }

    public function getAllJoin($table, $rows =null, $join =null, $where =null, $order =null, $limit = null)
    {
       $this->crud->selectjoin($table, $rows, $join, $where, $order, $limit);
        $data=$this->crud->getResult();
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
