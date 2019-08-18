<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Max-Age: 86400');
header("Access-Control-Allow-Methods: GET, POST,PUT,DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Authorization, Content-Type,Accept, Origin");

class Istatistic extends database
{
    public $result = array();

    public function getIstatistic()
    {
        try {
            $sales = $this->getrows("SELECT COUNT(id) FROM usersbooks", array());
            $users = $this->getrows("SELECT COUNT(userid) FROM users WHERE authid=?", array(2));
            $authors = $this->getrows("SELECT COUNT(authorsid) FROM authors", array());
            $price = $this->getrows("SELECT * FROM `usersbooks` AS ub INNER JOIN books b ON b.bookid=ub.bookid", array());
            $totalprice = 0;
            for ($i = 0; $i < count($price); $i++) {
                $totalprice += floatval($price[$i]['price']);
            }
            $headers = array("header" => headers_list());
            return $this->result = array("status" => "200", "data" => array("sales" => $sales[0], "users" => $users[0], "authors" => $authors[0], "totalprice" => $totalprice), "headers" => $headers);
        } catch (Exception $e) {
            return $this->result = array("status" => "500", "data" => "Sistemde Bir Hata Gerçekleşti", 'error' => $e);
        } finally {
            $this->disconnect();
        }
    }
}