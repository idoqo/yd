<?php
//clone of pager.class.php. Difference just in the name
//was too lazy to locate all instances of Pager in the whole project.
class OKPager
{
    public $conn = null; //it requires a valid db connection
    private $query = "";
    private $limit;

    /**If limit is intended to be set with the query, pass it to the construct*/
    public function __construct($query, $limit = 10){
        $this->query = $query;
        $this->limit = $limit;
    }

    public function countTotalRows($bounded=array()){
        $st = $this->conn->prepare($this->query);
        if(!empty($bounded)) {
            $st->execute($bounded);
        }
        else{$st->execute();}
        return $st->rowCount();
    }

    /**
     * queries a database using offset and limit as range.
     * page parameter is the page - Page to view
     * if there are arrays to be bounded with the query, pass it as bounded
     * @param mixed
     * @param array
     * @return mixed results
     */
    public function fetchData($page=false, $bounded=array()){
        if($page == false){$offset = 0;}
        else{$offset = ($page - 1) * ($this->limit);}
        $sql = $this->query." LIMIT ".$offset.", ".$this->limit;
        $st = $this->conn->prepare($sql);
        try{
            if(!empty($bounded)){
                $st->execute($bounded);
            }
            else{$st->execute();}
            $results =array();
            while($rs = $st->fetch(PDO::FETCH_ASSOC)){
                $results[] = $rs;
            }
            return $results;
        }
        catch(PDOException $e){
            return $e->getMessage();
        }
    }
}