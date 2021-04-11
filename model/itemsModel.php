<?php

class itemsModel
{
    // set database config for mysql
    function __construct($consetup)
    {
        $this->host = $consetup->host;
        $this->user = $consetup->user;
        $this->pass = $consetup->pass;
        $this->db = $consetup->db;
    }

    // open mysql data base
    public function open_db()
    {
        $this->condb = new mysqli($this->host, $this->user, $this->pass, $this->db);
        if ($this->condb->connect_error) {
            die("Erron in connection: " . $this->condb->connect_error);
        }
    }

    // close database
    public function close_db()
    {
        $this->condb->close();
    }

    // insert record
    public function insertRecord($obj)
    {
        try {
            $this->open_db();
            $query = $this->condb->prepare("INSERT INTO items (amount, buyer, receipt_id, items, buyer_email, note, city, phone, entry_by, buyer_ip, hash_key, entry_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            //$query=$this->condb->prepare("INSERT INTO hello (amount, buyer, receipt_id, items, buyer_email) VALUES (?, ?, ?, ?, ?)");
            $query->bind_param("isssssssisss", $obj->amount, $obj->buyer, $obj->receipt_id, $obj->items, $obj->buyer_email, $obj->note, $obj->city, $obj->phone, $obj->entry_by, $obj->buyer_ip, $obj->hash_key, $obj->entry_at);
            //$query->bind_param("issss", $obj->amount, $obj->buyer, $obj->receipt_id, $obj->items, $obj->buyeremail);
            $query->execute();
            $res = $query->get_result();
            $last_id = $this->condb->insert_id;
            $query->close();
            $this->close_db();
            return $last_id;
        } catch (Exception $e) {
            $this->close_db();
            throw $e;
        }
    }

    //update record
    public function updateRecord($obj)
    {

    }

    // delete record
    public function deleteRecord($id)
    {

    }

    // select record
    public function selectRecord($cond = array())
    {
        try {
            $this->open_db();
            if ($cond['id'] > 0 && !empty($cond) && isset($cond['date_from']) && isset($cond['date_to'])) {
                $query = $this->condb->prepare("SELECT * FROM items WHERE id=? AND entry_at >= ? AND entry_at <= ?");
                $query->bind_param("iss", $cond['id'], $cond['date_from'], $cond['date_to']);
            } else if (!empty($cond) && isset($cond['date_from']) && isset($cond['date_to'])) {
                $query = $this->condb->prepare("SELECT * FROM items WHERE entry_at >= ? AND entry_at <= ?");
                $query->bind_param("ss", $cond['date_from'], $cond['date_to']);
            } else if (!empty($cond) && isset($cond['date_from'])) {
                $query = $this->condb->prepare("SELECT * FROM items WHERE entry_at >= ?");
                $query->bind_param("s", $cond['date_from']);
            } else if (!empty($cond) && isset($cond['date_to'])) {
                $query = $this->condb->prepare("SELECT * FROM items WHERE entry_at <= ?");
                $query->bind_param("s", $cond['date_to']);
            } else if($cond['id'] > 0) {
                $query=$this->condb->prepare("SELECT * FROM items WHERE id=?");
                $query->bind_param("i",$cond['id']);
            }

            else {
                $query = $this->condb->prepare("SELECT * FROM items");
            }


            $query->execute();
            $res = $query->get_result();
            $query->close();
            $this->close_db();
            return $res;
        } catch (Exception $e) {
            $this->close_db();
            throw $e;
        }

    }
}

?>