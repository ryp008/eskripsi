<?php

/*
 * Author : Rolly Yesputra
 * website : rollyyesputra.web.id
 * email : rollyyesputra1@gmail.com
 *
 */

class ProcessDB extends PDO {

    private $result;

    /* Membuat Konstruktor */

    public function __construct() {
        try {
            $dsn = DB::$engine . ':dbname=' . DB::$dbname . ';host=' . DB::$host;
            parent::__construct($dsn, DB::$user, DB::$pass);
            //echo "Koneksi Sukses";
        } catch (PDOException $e) {
            echo "Koneksi Gagal : " . $e->getMessage();
        }
    }

    /*
     * Create function for insert data to table
     */

    public function create($table, $rows = null, $header = null) {
        try {
            $sql = "INSERT INTO " . $table;
            $row = null;
            $value = null;
            foreach ($rows as $key => $nilainya) {
                # code...
                $row .= "," . $key;
                $value .= ", :" . $key;
            }
            $sql .= "(" . substr($row, 1) . ")";
            $sql .= "VALUES(" . substr($value, 1) . ")";

            $stmt = parent::prepare($sql);
            $stmt->execute($rows);
            $rowcount = $stmt->rowCount();
            if ($rowcount != 0) {
                echo "<script> alert('Simpan Data Berhasil, Jumlah = $rowcount');
						  window.location.assign('?p=$header');</script>";
            } else {
                echo "<script> alert('Simpan Data Error $sql, Data Sudah Ada $rowcount',); window.location.assign('?p=$header'); </script>";
            }

            return $rowcount;
        } catch (PDOException $e) {
            $kesalahan = $e->getMessage();
            echo "<script> alert('Simpan Data Gagal, $kesalahan'); </script>";
        }
    }
    /**
     * Fungsi untuk menyimpan data ke basisdata
     */
    public function insert($table, $rows = null) {
        try {
            $sql = "INSERT INTO " . $table;
            $row = null;
            $value = null;
            foreach ($rows as $key => $nilainya) {
                # code...
                $row .= "," . $key;
                $value .= ", :" . $key;
            }
            $sql .= "(" . substr($row, 1) . ")";
            $sql .= "VALUES(" . substr($value, 1) . ")";

            $stmt = parent::prepare($sql);
            $stmt->execute($rows);
            $rowcount = $stmt->rowCount();
            if ($rowcount != 0) {
                return true;
            } else {
                //echo "<script> alert('Simpan Data Error $sql, Data Sudah Ada $rowcount',); window.location.assign('?p=$header'); </script>";
                return false;
            }

            return $rowcount;
        } catch (PDOException $e) {
            $kesalahan = $e->getMessage();
            echo "<script> alert('Simpan Data Gagal, $kesalahan'); </script>";
        }
    }
    /**
     * fungsi untuk insert data ke basisdata
     */
    public function insertloop($table, $rows = null) {
        try {
            $sql = "INSERT INTO " . $table;
            $row = null;
            $value = null;
            foreach ($rows as $key => $nilainya) {
                # code...
                $row .= "," . $key;
                $value .= ", :" . $key;
            }
            $sql .= "(" . substr($row, 1) . ")";
            $sql .= "VALUES(" . substr($value, 1) . ")";

            $stmt = parent::prepare($sql);
            $stmt->execute($rows);
            $rowcount = $stmt->rowCount();
            // if ($rowcount != 0) {
            //     return true;
            // } else {
            //     //echo "<script> alert('Simpan Data Error $sql, Data Sudah Ada $rowcount',); window.location.assign('?p=$header'); </script>";
            //     return false;
            // }

            return $rowcount;
        } catch (PDOException $e) {
            $kesalahan = $e->getMessage();
            echo "<script> alert('Simpan Data Gagal, $kesalahan'); </script>";
        }
    }

    /*
     * Create function for update data to table
     */

    public function update($table, $field = null, $where = null, $header = null) {
        try {
            $update = 'UPDATE ' . $table . ' SET ';
            $set = null;
            $value = null;
            foreach ($field as $key => $values) {
                # code...
                $set .= ', ' . $key . ' = :' . $key;
                $value .= ', ":' . $key . '":"' . $values . '"';
            }

            $update .= substr(trim($set), 1);
            $json = '{' . substr($value, 1) . '}';
            $param = json_decode($json, true);
            if ($where != null) {
                $update .= ' WHERE ' . $where;
            }

            $query = parent::prepare($update);
            $query->execute($param);
            $rowcount = $query->rowCount();
            if ($rowcount != 0) {
                return true;
                //echo "<script> alert('Data Berhasil Diupdate, Jumlah = $rowcount');
              //window.location.assign('?p=$header');</script>";
            } else {
                return false;
                //echo "<script> alert('Update Data Error'); window.location.assign('?p=$header'); </script>";
            }

            // if ($header != null) {
            //     session_start();
            //     $_SESSION['pesan'] = "EDIT DATA TABEL $table SUKSES";
            //     header("location:" . $header);
            // }
            return $rowcount;
        } catch (PDOException $e) {
            echo "<script> alert('Simpan Data Gagal'); </script>";
        }
    }

     public function update2($table, $field = null, $where = null, $header = null) {
        try {
            $update = "UPDATE " . $table . " SET ". $field." WHERE ".$where;            
            $query = parent::prepare($update);
            $query->execute();
            $rowcount = $query->rowCount();
            if ($rowcount != 0) {
                return true;
            } else {
                return false;
            }
            return $rowcount;
        } catch (PDOException $e) {
            echo "<script> alert('Simpan Data Gagal'); </script>";
        }
    }

    /*
     * Create function for select data to table
     */

    public function delete($table, $where = null, $header = null) {
        try {
            $command = 'DELETE FROM ' . $table;

            $list = Array();
            $parameter = null;
            foreach ($where as $key => $value) {
                $list[] = "$key = :$key";
                $parameter .= ', ":' . $key . '":"' . $value . '"';
            }
            $command .= ' WHERE ' . implode(' AND ', $list);

            $json = "{" . substr($parameter, 1) . "}";
            $param = json_decode($json, true);

            $query = parent::prepare($command);
            $query->execute($param);
            $rowcount = $query->rowCount();
            if ($rowcount != 0) {
                echo "<script> alert('Data Berhasil Dihapus, Jumlah = $rowcount');
              window.location.assign('?p=$header');</script>";
            } else {
                echo "<script> alert('Hapus Data Error, Data Sudah Ada $rowcount'); window.location.assign('?p=$header'); </script>";
            }

            // if ($header != null) {
            //     session_start();
            //     $_SESSION['pesan'] = "HAPUS DATA TABEL $table SUKSES";
            //     header("location:" . $header);
            // }

            return $rowcount;
        } catch (PDOException $e) {
            echo "<script> alert('Hapus Gagal'); </script>";
        }
    }

    /*
     * Create function for select data to table
     * Author rolly yesputra
     * rollyyesputra.web.id
     */

    public function select($table, $rows, $where = null, $order = null, $limit = null) {
        try {
            $sql = "SELECT " . $rows . " FROM " . $table;
            if ($where != null)
                $sql .= " WHERE " . $where;
            if ($order != null)
                $sql .= " ORDER BY " . $order;
            if ($limit != null)
                $sql .= " LIMIT " . $limit;
            $query = parent::prepare($sql);
            $query->execute();
            $posts = array();
            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                # code...
                $posts[] = $row;
            }
            return $this->result = json_encode($posts);
        } catch (PDOException $e) {
            echo "<script> alert('Data Tidak Ada...'); </script>";
        }
    }
    /**
     * fungsi untuk menampilkan data dengan join table
     */
    public function selectjoin($table, $rows, $join=null, $where = null, $order = null, $limit = null) {
        try {
            $sql = "SELECT " . $rows . " FROM " . $table;
            if ($join != null)
                $sql .= " $join ";
            if ($where != null)
                $sql .= " WHERE " . $where;
            if ($order != null)
                $sql .= " ORDER BY " . $order;
            if ($limit != null)
                $sql .= " LIMIT " . $limit;
            $query = parent::prepare($sql);
            $query->execute();
            $posts = array();
            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                # code...
                $posts[] = $row;
            }
            return $this->result = json_encode($posts);
        } catch (PDOException $e) {
            echo "<script> alert('Data Tidak Ada...'); </script>";
        }
    }

    /*
     * Mengambil data return
     */


    /**
    * tanpa menggunakan json
    */
    public function selectjoin1($table, $rows, $join=null, $where = null, $order = null, $limit = null) {
        try {
            $sql = "SELECT " . $rows . " FROM " . $table;
            if ($join != null)
                $sql .= " $join ";
            if ($where != null)
                $sql .= " WHERE " . $where;
            if ($order != null)
                $sql .= " ORDER BY " . $order;
            if ($limit != null)
                $sql .= " LIMIT " . $limit;
            $query = parent::prepare($sql);
            $query->execute();
            $posts = array();
            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                # code...
                $posts[] = $row;
            }
            return $this->result =$posts;
        } catch (PDOException $e) {
            echo "<script> alert('Data Tidak Ada...'); </script>";
        }
    }

    public function find($table, $rows, $where = null, $order = null, $limit = null) {
        $sql = "SELECT " . $rows . " FROM " . $table;
        if ($where != null)
            $sql .= " WHERE " . $where;
        if ($order != null)
            $sql .= " ORDER BY " . $order;
        if ($limit != null)
            $sql .= " LIMIT " . $limit;
        $query = parent::prepare($sql);
        $query->execute();
        $posts = array();
            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                # code...
                $posts[] = $row;
            }
        return $this->result =$posts;
    }

    public function getResult() {
        return $this->result;
    }
}
