<?php

header("Content-Type: application/json; charset=UTF-8");
class Authors extends database
{
    public $result = array();

    public function getAuthors($where)
    {
        try {
            $response = $this->getrows(
                "SELECT * FROM authors
WHERE  $where
", array());
            if (count($response)) {
                for ($i = 0; $i < count($response); $i++) {
                    $this->result[] = array(
                        "authorsid" => $response[$i]['authorsid'],
                        "authorsname" => $response[$i]['authorsname'],
                        "authorslastname" => $response[$i]['authorslastname'],
                        "authorsage" => $response[$i]['authorsage'],
                        "authorscountry" => $response[$i]['authorscountry'],
                    );
                }
                $headers = array("header" => headers_list());
                return $this->result = array("status" => "200", "data" => $response, "headers" => $headers);
            } else {
                return $this->result = array("status" => "204", "data" => array());
            }
        } catch (Exception $e) {
            return $this->result = array("status" => "500", "data" => "Sistemde Bir Hata Gerçekleşti", 'error' => $e);
        } finally {
            $this->disconnect();
        }
    }

    public function getAuthorsBooks($where)
    {

        try {
            $response = $this->getrows(
                "    SELECT * FROM `authorsbooks` AS ab INNER JOIN authors AS a ON ab.authorsid=a.authorsid INNER JOIN books AS b ON ab.booksid=b.bookid 
INNER JOIN bookstype AS bt ON bt.bookstypeid=b.bookstype
WHERE  $where
", array());
            if (count($response)) {
                for ($i = 0; $i < count($response); $i++) {
                    $this->result[] = array(
                        "id" => $response[$i]['id'],
                        "booksid" => $response[$i]['booksid'],
                        "authorsid" => $response[$i]['authorsid'],
                        "authorsage" => $response[$i]['authorsage'],
                        "authorscountry" => $response[$i]['authorscountry'],
                        "bookname" => $response[$i]['bookname'],
                        "pagecount" => $response[$i]['pagecount'],
                        "releasedate" => $response[$i]['releasedate'],
                        "typename" => $response[$i]['typename'],
                        "bookstype" => $response[$i]['bookstype'],
                    );
                }
                $headers = array("header" => headers_list());
                return $this->result = array("status" => "200", "data" => $response, "headers" => $headers);
            } else {
                return $this->result = array("status" => "204", "data" => array());
            }
        } catch (Exception $e) {
            return $this->result = array("status" => "500", "data" => "Sistemde Bir Hata Gerçekleşti", 'error' => $e);
        } finally {
            $this->disconnect();
        }
    }
    public  function addAuthors($data)
    {
        try{
            for ($i = 0; $i < count($data); $i++) {
                $authdata = array(
                    "authorsname"=>$data[$i]['name'],
                    "authorslastname"=>$data[$i]['lastname'],
                    "authorsage"=>$data[$i]['age'],
                    "authorscountry"=>$data[$i]['country'],
                );
            }
            $addRows = $this->insert('authors', $authdata);
            if ($addRows) {
                $response=$this->getrows("SELECT * FROM `authors` ORDER BY authorsid DESC LIMIT 1");
                $this->result[] = array(
                    "authorsid" => $response[0]['authorsid'],
                    "authorsname" => $response[0]['authorsname'],
                    "authorslastname" => $response[0]['authorslastname'],
                    "authorsage" => $response[0]['authorsage'],
                    "authorscountry" => $response[0]['authorscountry'],
                );
                $headers = array("header" => headers_list());
                return  $this->result = array("status" => "200","data"=>$this->result,"headers"=>$headers);
            } else {
                return  $this->result = array("status" => "204","data"=>array());
            }
        }
        catch (Exception $e){
            return  $this->result = array("status" => "500","data"=>array());
        }
        finally{
            $this->disconnect();
        }

    }
}
