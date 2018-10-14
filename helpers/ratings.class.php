<?php
class Ratings
{
    private $fp = "http://localhost/internshub/helpers/ratings.txt";
    
    //Wondering if a Constructor will ever be necessary
    
    /**
    * Counts the sum total votes for a 'RATEE'
    * RATEE may be a douchebag, an idiot or some lame media file
    * Besides, this method is Improvement prone - COME BACK HERE LATER
    * @access public
    * @param mixed $rid
    * @return int counter
    */
    public function totalRatesFor($rid){
        $all =file($this->fp);
        $counter = 0;
        foreach($all as $line){
            list($rater, $ratee, $points) = explode("::", $line);
            if($ratee == $rid){
                $counter += $points;
            }
        }
        if($counter == 0){
            return false;
        }
        return $counter;
    }
    
    public function countRaters($rid){
        $all = file($this->fp);
        $raters = 0;
        foreach($all as $line){
            list($rater,$ratee, $points) = explode("::", $line);
            if($ratee != $rid){continue;}
            $raters++;
        }
        if($raters == 0){
            return false;
        }
        return $raters;
    }
    
    public function evaluate($rid){
        $totalPoints = $this->totalRatesFor($rid);
        $numRaters = $this->countRaters($rid);
        if($totalPoints === false || $numRaters === false){
            return false;
        }
        $x = $totalPoints/$numRaters;
        return round($x);
    }
    
    public function rate($rater, $ratee, $pts){
        if($pts > 5){
            return "Error while Rating!";
        }
        $all = file($this->fp);
        foreach($all as $line){
            list($raters,$ratees, $points) = explode("::", $line);
            if($raters == $rater && $ratees == $ratee){
                return "You already rated";
            }
        }
        $f = fopen($this->fp, "ab+");
        try{
            fwrite($f, "\n".$rater."::".$ratee."::".$pts);
            return "ok";
        }
        catch(Exception $e){
            return $e->getMessage();
        }
    }
    
    /*COMING SOON
    public function unrate($rater, $ratee){
        $all = file($this->fp);
        foreach($all as $line){
            list($raters, $ratees, $points) = explode("::", $line);
            if()
        }
    }
    */
}

/*$fp = fopen("ratings.txt", "ab+");
try{
    fwrite($fp, "\n10::4::3");
    echo "Deal";
}
catch(PDOexception $e){
    echo $e->getMessage();
}*/