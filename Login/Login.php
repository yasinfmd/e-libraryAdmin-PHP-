<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Max-Age: 86400');
header("Access-Control-Allow-Methods: GET, POST,PUT,DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Authorization, Content-Type,Accept, Origin");
class Login extends database
{
    public $result = array();
    public function onLogin($user, $password)
    {
        try {
            $isUser = $this->select("mails", $user, array());
            if (count($isUser) > 0) {
                $userid = $isUser[0]['userid'];
                $passwordmatched = $this->select("password", "userid='$userid'", array());
                if ($passwordmatched[0]['password'] === $password) {
                    $response = $this->getrows(
                        "SELECT * FROM `users` u INNER JOIN gender g ON u.genderid=g.genderid INNER JOIN muh_iller m ON u.cityid=m.id INNER JOIN muh_ilceler n ON n.id=u.districtid
                        INNER JOIN mails h ON h.userid=u.userid INNER JOIN phones p ON p.userid=u.userid INNER JOIN authority j  ON j.authid=u.authid WHERE u.userid=? AND j.authid=1"
                        , array($userid));
                        $response = array(
                            "userid" => $response[0]['userid'],
                            "username" => $response[0]['username'],
                            "userlastname" => $response[0]['userlastname'],
                            "age" => $response[0]['age'],
                            "genderid" => $response[0]['genderid'],
                            "ipadres" => $response[0]['ipadres'],
                            "cityid" => $response[0]['cityid'],
                            "districtid" => $response[0]['districtid'],
                            "usertoken" => $response[0]['usertoken'],
                            "authid" => $response[0]['authid'],
                            "userimg" =>  "data:image/png;base64,".base64_encode($response[0]['userimg']),
                            "gendername" => $response[0]['gendername'],
                            "baslik" => $response[0]['baslik'],
                            "mail" => $response[0]['mail'],
                            "mailid" => $response[0]['mailid'],
                            "phonenumber" => $response[0]['phonenumber'],
                            "authname" => $response[0]['authname'],
                        );


                    $headers=array("header"=>headers_list());
                    return $this->result = array("status" => "200", "data" => $response,"headers"=>$headers);

                } else {
                    return $this->result = array("status" => "401", "data" => array());
                }
            }else{
                return $this->result = array("status" => "401", "data" => array());
            }

        } catch (Exception $e) {
            return $this->result = array("status" => "500", "data" => "Sistemde Bir Hata Gerçekleşti", 'error' => $e);
        } finally {
            $this->disconnect();
        }

    }
}

