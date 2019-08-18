<?php


class Parser
{
    public $querystring;

    public function RequestParseHandle($query)
    {
        for ($i = 0; $i < count($query); $i++) {
            if ($query[$i]['Operation'] === "EQ") {
                $this->querystring .= $query[$i]['PropertyName'] . "=" . "'".$query[$i]['PropertyValue']."'" . "AND";
            } else if ($query[$i]['Operation'] === "IN") {
                $exploded = explode(",", $query[$i]['PropertyValue']);
                $inData = "";
                for ($j = 0; $j < count($exploded); $j++) {
                    if ($j == count($exploded) - 1) {
                        $inData .= "'" . $exploded[$j] . "'";
                    } else {
                        $inData .= "'" . $exploded[$j] . "'" . ",";
                    }
                }
                $this->querystring .= $query[$i]['PropertyName'] . " " . 'IN' . " " . "(" . $inData . ")" . " " . "AND";
            } else if ($query[$i]['Operation'] === "LT") {
                $this->querystring .= $query[$i]['PropertyName'] . "<" . "'". $query[$i]['PropertyValue']."'" . " " . "AND";
            } else if ($query[$i]['Operation'] === "GT") {
                $this->querystring .= $query[$i]['PropertyName'] . ">" ."'". $query[$i]['PropertyValue']."'" . " " . "AND";

            } else if ($query[$i]['Operation'] === "CT") {
                $this->querystring .= $query[$i]['PropertyName'] . " " . 'LIKE %' . $query[$i]['PropertyValue'] . '%' . " " . "AND";
            } else if ($query[$i]['Operation'] === "NE") {
                $this->querystring .= $query[$i]['PropertyName'] . "!=" . $query[$i]['PropertyValue'] . "AND";
            }
        }
        $andIndex = strripos($this->querystring, "AND");
        $this->querystring = substr($this->querystring, 0, $andIndex);
        return
            $this->querystring;

    }
}