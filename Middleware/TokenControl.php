<?php

use Firebase\JWT\JWT;
require ("./dbclas/pdocls.php");
header("Content-Type: application/json; charset=UTF-8");
require 'Plugins/JWT/jwt.php';

class TokenControl
{
    public function createToken(array $tokenpayload ,$key)
    {
        $jwt = JWT::encode($tokenpayload, base64_decode(strtr($key, '-_', '+/')), 'HS256');
        return $jwt;
    }
    public function readToken($token, string $key="userid")
    {
        $db=new database();
        $decoded = JWT::decode($token, base64_decode(strtr($key, '-_', '+/')), ['HS256']);
      if ($decoded) {
            $result = $db->getrows("SELECT * FROM `users` WHERE usertoken = ?",array($token));
            if ($decoded->userid == $result[0]['userid'] &&  $token == $result[0]['usertoken'] && $decoded->authid==1) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}