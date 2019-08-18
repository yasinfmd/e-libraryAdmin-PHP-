<?php

header("Content-Type: application/json; charset=UTF-8");

class Users extends database
{
    public $result = array();

    public function getUsers($where)
    {
        try {
            $response = $this->getrows("SELECT * FROM `users` AS u INNER JOIN gender AS g ON u.genderid=g.genderid INNER JOIN mails AS m ON u.userid=m.userid
INNER JOIN phones AS p ON p.userid=u.userid INNER JOIN muh_iller AS mi ON mi.id=u.cityid WHERE $where", array());
            if (count($response)) {
                for ($i = 0; $i < count($response); $i++) {
                    $this->result[] = array(
                        "userid" => $response[$i]['userid'],
                        "username" => $response[$i]['username'],
                        "userlastname" => $response[$i]['userlastname'],
                        "age" => $response[$i]['age'],
                        "genderid" => $response[$i]['genderid'],
                        "ipadres" => $response[$i]['ipadres'],
                        "cityid" => $response[$i]['cityid'],
                        "authid" => $response[$i]['authid'],
                        "userimg" => "data:image/png;base64," . base64_encode($response[$i]['userimg']),
                        "gendername" => $response[$i]['gendername'],
                        "mail" => $response[$i]['mail'],
                        "phonenumber" => $response[$i]['phonenumber'],
                        "baslik" => $response[$i]['baslik'],
                    );
                }
                $headers = array("header" => headers_list());
                return $this->result = array("status" => "200", "data" => $this->result, "headers" => $headers);
            } else {
                return $this->result = array("status" => "204", "data" => array());
            }
        } catch (Exception $e) {
            return $this->result = array("status" => "500", "data" => "Sistemde Bir Hata Gerçekleşti", 'error' => $e);
        } finally {
            $this->disconnect();
        }

    }

    public function delUser($where)
    {
        try {
            $response = $this->delete("users", $where, array());
            if ($response) {
                $response = $this->getrows("SELECT * FROM `users` AS u INNER JOIN gender AS g ON u.genderid=g.genderid INNER JOIN mails AS m ON u.userid=m.userid
INNER JOIN phones AS p ON p.userid=u.userid INNER JOIN muh_iller AS mi ON mi.id=u.cityid WHERE authid=?", array(2));
                if (count($response)) {
                    for ($i = 0; $i < count($response); $i++) {
                        $this->result[] = array(
                            "userid" => $response[$i]['userid'],
                            "username" => $response[$i]['username'],
                            "userlastname" => $response[$i]['userlastname'],
                            "age" => $response[$i]['age'],
                            "genderid" => $response[$i]['genderid'],
                            "ipadres" => $response[$i]['ipadres'],
                            "cityid" => $response[$i]['cityid'],
                            "authid" => $response[$i]['authid'],
                            "userimg" => "data:image/png;base64," . base64_encode($response[$i]['userimg']),
                            "gendername" => $response[$i]['gendername'],
                            "mail" => $response[$i]['mail'],
                            "phonenumber" => $response[$i]['phonenumber'],
                            "baslik" => $response[$i]['baslik'],
                        );
                    }
                    $headers = array("header" => headers_list());
                    return $this->result = array("status" => "200", "data" => $this->result, "headers" => $headers);
                }
            } else {
                return $this->result = array("status" => "500", "data" => "Sistemde Bir Hata Gerçekleşti");
            }

        } catch (Exception $e) {
            return $this->result = array("status" => "500", "data" => "Sistemde Bir Hata Gerçekleşti", 'error' => $e);
        } finally {
            $this->disconnect();
        }
    }
}