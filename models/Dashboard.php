<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Home
 *
 * @author rolly
 */
class Home extends Model{
    public function __construct() {
        parent::__construct();
    }

     public function table() {
        return 'tbl_judul';
    }
    
    public function delete($where = null, $page = null) {
        
    }

    public function edit($field = null, $where = null, $page = null) {
        
    }

    public function find() {
        $this->crud->select($this->table(),"*",null, 'tgl_pengajuan DESC', 5);
      $data= $this->crud->getResult();
      return json_decode($data,true);
        
    }

    public function findOne($rows, $where = null, $order = null, $limit = null) {
        
    }

    public function save($rows = null, $page = null) {
        
    }

   

//put your code here
}
