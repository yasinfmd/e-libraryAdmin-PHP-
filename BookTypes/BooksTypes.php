<?php

header("Content-Type: application/json; charset=UTF-8");
class BooksTypes extends  database
{
    public $result = array();
    public function getBooksType($where)
    {
        try{
            $response = $this->select("bookstype",$where,array());
            if(count($response)>0){
                for ($i=0;$i<count($response);$i++){
                    $this->result[] = array(
                        "bookstypeid" => $response[$i]['bookstypeid'],
                        "typename" => $response[$i]['typename'],
                    );
                }
                $headers=array("header"=>headers_list());
                return $this->result = array("status" => "200", "data" => $response,"headers"=>$headers);
            }else{
                return $this->result = array("status" => "204", "data" => array());
            }
        }
        catch (Exception $exception){
            return $this->result = array("status" => "500", "data" => "Sistemde Bir Hata Gerçekleşti", 'error' => $exception);
        }
        finally{
            $this->disconnect();
        }
    }
}