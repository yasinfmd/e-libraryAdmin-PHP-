<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("./RequestParser/Parser.php");
require("./Middleware/TokenControl.php");

if (isset($_POST['SN']) && isset($_POST['MN'])) {
    $SN = $_POST['SN'];
    $MN = $_POST['MN'];
    $result = "";
    $parser = new Parser();
    $tokenControl = new TokenControl();
    if ($SN == "Login") {
        include("Login/Login.php");
        $login = new $SN();
        if ($MN == "onLogin") {
            $username = $parser->RequestParseHandle($_POST['username']);
            $result = $login->$MN($username, $_POST['password']);
        }
        echo json_encode($result);
    } else if ($SN == "Users") {
        if (isset($_POST['token'])) {
            $res = $tokenControl->readToken($_POST['token'], 'userid');
            if ($res == true) {
                include("Users/Users.php");
                $user = new $SN();
                if ($MN == "getUsers") {
                    if (isset($_POST['param']) && $_POST['param'] != null) {
                        $param = $parser->RequestParseHandle($_POST['param']);
                    } else {
                        $param = "1";
                    }
                    $result = $user->$MN($param);
                } else if ($MN == "delUser") {
                    if (isset($_POST['param']) && $_POST['param'] != null) {
                        $param = $parser->RequestParseHandle($_POST['param']);
                    } else {
                        $param = "1";
                    }
                    $result = $user->$MN($param);
                }
            } else {
                $result = array("status" => "401", "data" => array());
            }
        } else {
            $result = array("status" => "401", "data" => array());
        }
        echo json_encode($result);
    } else if ($SN == "Books") {
        if (isset($_POST['token'])) {
            $res = $tokenControl->readToken($_POST['token'], 'userid');
            if ($res == true) {
                include("Books/Books.php");
                $books = new $SN();
                if ($MN == "getSoldBook") {
                    if (isset($_POST['param']) && $_POST['param'] != null) {
                        $param = $parser->RequestParseHandle($_POST['param']);
                    } else {
                        $param = "1";
                    }
                    $result = $books->$MN($param);
                } else if ($MN == "getSoldBookDetail") {
                    if (isset($_POST['param']) && $_POST['param'] != null) {
                        $param = $parser->RequestParseHandle($_POST['param']);
                    }
                    $result = $books->$MN($param);
                } else if ($MN == "getAllBooks") {
                    if (isset($_POST['param']) && $_POST['param'] != null) {
                        $param = $parser->RequestParseHandle($_POST['param']);
                    } else {
                        $param = "1";
                    }
                    $result = $books->$MN($param);
                } else if ($MN == "setBooks") {
                    if (isset($_POST['param']) && $_POST['param'] != null) {
                        $param = $parser->RequestParseHandle($_POST['param']);
                    }
                    $result = $books->$MN($param, $_POST['updatedData'], $_POST['authorsData'], $_POST['bookid']);
                }
            } else {
                $result = array("status" => "401", "data" => array());
            }
        } else {
            $result = array("status" => "401", "data" => array());
        }
        echo json_encode($result);
    } else if ($SN == "Istatistic") {
        if (isset($_POST['token'])) {
            $res = $tokenControl->readToken($_POST['token'], 'userid');
            if ($res == true) {
                include("Istatistic/Istatistic.php");
                $istatistics = new $SN();
                if ($MN == "getIstatistic") {
                    $result = $istatistics->$MN();
                }
            } else {
                $result = array("status" => "401", "data" => array());
            }

        } else {
            $result = array("status" => "401", "data" => array());
        }
        echo json_encode($result);
    } else if ($SN == "BooksTypes") {
        if (isset($_POST['token'])) {
            $res = $tokenControl->readToken($_POST['token'], 'userid');
            if ($res == true) {
                include("BookTypes/BooksTypes.php");
                $type = new $SN();
                if ($MN == "getBooksType") {
                    if (isset($_POST['param']) && $_POST['param'] != null) {
                        $param = $parser->RequestParseHandle($_POST['param']);
                    } else {
                        $param = "1";
                    }
                    $result = $type->$MN($param);
                }
            } else {
                $result = array("status" => "401", "data" => array());
            }

        } else {
            $result = array("status" => "401", "data" => array());
        }
        echo json_encode($result);
    } else if ($SN == "Authors") {
        if (isset($_POST['token'])) {
            $res = $tokenControl->readToken($_POST['token'], 'userid');
            if ($res == true) {
                include("Authors/Authors.php");
                $type = new $SN();
                if ($MN == "getAuthors") {
                    if (isset($_POST['param']) && $_POST['param'] != null) {
                        $param = $parser->RequestParseHandle($_POST['param']);
                    } else {
                        $param = "1";
                    }
                    $result = $type->$MN($param);
                } else if ($MN == "getAuthorsBooks") {
                    if (isset($_POST['param']) && $_POST['param'] != null) {
                        $param = $parser->RequestParseHandle($_POST['param']);
                    } else {
                        $param = "1";
                    }
                    $result = $type->$MN($param);
                } else if ($MN == "addAuthors") {
                    $result = $type->$MN($_POST['authorsData']);
                }
            } else {
                $result = array("status" => "401", "data" => array());
            }

        } else {
            $result = array("status" => "401", "data" => array());
        }
        echo json_encode($result);
    }
}

?>