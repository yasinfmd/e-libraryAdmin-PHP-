<?php

//require("./dbclas/pdocls.php");
header("Content-Type: application/json; charset=UTF-8");

class Books extends database
{
    public $result = array();

    public function getAllBooks($where)
    {
        try {
            $response = $this->getrows(
                "SELECT * FROM `books` AS b INNER JOIN bookstype AS bt ON bt.bookstypeid=b.bookstype INNER JOIN authorsbooks AS ab ON ab.booksid=b.bookid
INNER JOIN authors a ON a.authorsid=ab.authorsid
WHERE  $where
", array());
            if (count($response)) {
                for ($i = 0; $i < count($response); $i++) {
                    $this->result[] = array(
                        "bookid" => $response[$i]['bookid'],
                        "bookname" => $response[$i]['bookname'],
                        "pagecount" => $response[$i]['pagecount'],
                        "price" => $response[$i]['price'],
                        "releasedate" => $response[$i]['releasedate'],
                        "typename" => $response[$i]['typename'],
                        "bookstype" => $response[$i]['bookstype'],
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

    public function getSoldBook($where)
    {
        try {
            $response = $this->getrows(
                "SELECT * FROM `usersbooks` AS ub INNER JOIN users AS us ON us.userid=ub.userid 
INNER JOIN books AS b ON b.bookid=ub.bookid INNER JOIN bookstype AS bt ON bt.bookstypeid=b.bookstype 
WHERE  $where
", array());
            if (count($response) > 0) {
                for ($i = 0; $i < count($response); $i++) {
                    $this->result[] = array(
                        "id" => $response[$i]['id'],
                        "bookid" => $response[$i]['bookid'],
                        "userid" => $response[$i]['userid'],
                        "username" => $response[$i]['username'],
                        "userlastname" => $response[$i]['userlastname'],
                        "age" => $response[$i]['age'],
                        "usertoken" => $response[$i]['usertoken'],
                        "bookname" => $response[$i]['bookname'],
                        "pagecount" => $response[$i]['pagecount'],
                        "price" => $response[$i]['price'],
                        "releasedate" => $response[$i]['releasedate'],
                        "typename" => $response[$i]['typename'],
                        "bookstype" => $response[$i]['bookstype'],
                        "solddate" => $response[$i]['solddate']
                    );
                }
                $headers = array("header" => headers_list());
                return $this->result = array("status" => "200", "data" => $this->result, "headers" => $headers);
            } else {
                return $this->result = array("status" => "204", "data" => array());
            }
        } catch (Exception $exception) {
            return $this->result = array("status" => "500", "data" => "Sistemde Bir Hata Gerçekleşti", 'error' => $exception);
        } finally {
            $this->disconnect();
        }
    }

    public function getSoldBookDetail($where)
    {
        try {
            $response = $this->getrows(
                "SELECT * FROM `usersbooks` AS ub 
INNER JOIN users AS us ON us.userid=ub.userid 
INNER JOIN books AS b ON b.bookid=ub.bookid 
INNER JOIN bookstype AS bt ON bt.bookstypeid=b.bookstype 
  INNER JOIN paymentstype AS pt on pt.ptypeid=ub.paytypeid
  INNER JOIN authorsbooks AS at ON at.booksid= ub.bookid INNER JOIN authors ah ON at.authorsid=ah.authorsid
WHERE  $where
", array());
            if (count($response) > 0) {
                for ($i = 0; $i < count($response); $i++) {
                    $this->result[] = array(
                        "id" => $response[$i]['id'],
                        "bookid" => $response[$i]['bookid'],
                        "userid" => $response[$i]['userid'],
                        "username" => $response[$i]['username'],
                        "userlastname" => $response[$i]['userlastname'],
                        "age" => $response[$i]['age'],
                        "usertoken" => $response[$i]['usertoken'],
                        "bookname" => $response[$i]['bookname'],
                        "pagecount" => $response[$i]['pagecount'],
                        "price" => $response[$i]['price'],
                        "releasedate" => $response[$i]['releasedate'],
                        "typename" => $response[$i]['typename'],
                        "bookstype" => $response[$i]['bookstype'],
                        "solddate" => $response[$i]['solddate'],
                        "ptype" => $response[$i]['ptype'],
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
        } catch (Exception $exception) {
            return $this->result = array("status" => "500", "data" => "Sistemde Bir Hata Gerçekleşti", 'error' => $exception);
        } finally {
            $this->disconnect();
        }
    }

    public function setBooks($where, $booksdata,$authorsdata,$bookid)
    {
        try {
            for ($i = 0; $i < count($booksdata); $i++) {
                $data = array(
                    "bookname" => $booksdata[$i]['bookname'],
                    "pagecount" => $booksdata[$i]['pagecount'],
                    "price" => $booksdata[$i]['price'],
                    "releasedate" => $booksdata[$i]['releasedate'],
                    "bookstype" => $booksdata[$i]['bookstype'],
                );
                $books = $this->update("books", $data, "$where", array());
            }
            $this->delete("authorsbooks","booksid=?",array($bookid));
                for($j=0;$j<count($authorsdata);$j++){
                     $data=array(
                         "booksid"=>$bookid,
                         "authorsid"=>$authorsdata[$j]['authorsid'],

                     );
                 $this->insert("authorsbooks",$data);
                 }
            if ($books) {
                $response = $this->getrows("SELECT * FROM `books` AS b INNER JOIN bookstype AS bt ON bt.bookstypeid=b.bookstype INNER JOIN authorsbooks AS ab ON ab.booksid=b.bookid
INNER JOIN authors a ON a.authorsid=ab.authorsid
WHERE  $where");
                for($i=0;$i<count($response);$i++){
                    $this->result[] = array(
                        "bookid" => $response[$i]['bookid'],
                        "bookname" => $response[$i]['bookname'],
                        "pagecount" => $response[$i]['pagecount'],
                        "price" => $response[$i]['price'],
                        "releasedate" => $response[$i]['releasedate'],
                        "typename" => $response[$i]['typename'],
                        "bookstype" => $response[$i]['bookstype'],
                        "authorsid" => $response[$i]['authorsid'],
                        "authorsname" => $response[$i]['authorsname'],
                        "authorslastname" => $response[$i]['authorslastname'],
                        "authorsage" => $response[$i]['authorsage'],
                        "authorscountry" => $response[$i]['authorscountry'],
                    );

                }

                return $this->result = array("status" => "200", "data" => $this->result);
            } else {
                return $this->result = array("status" => "500", "data" => "Sistemde Bir Hata Gerçekleşti",);
            }

        } catch (Exception $e) {
            return $this->result = array("status" => "500", "data" => "Sistemde Bir Hata Gerçekleşti", 'error' => $e);
        } finally {
            $this->disconnect();
        }
    }


}