<?php
    class class_function
    {
        function dbCon($database)
        {
            $this->connection = mysqli_connect("localhost","root",""); 

            switch (strtolower($database)){
                case "icare" :
                    if(!mysqli_select_db( $this->connection,"icare"))
                    {
                        $err = mysqli_error($this->connection);
                        return false;
                    }
                    break;
                default :
            }
            
            return true;
        }

        function executeSQL($ssql,$dbase){
            
            if(!$this->dbCon($dbase))
            {
                mysqli_close($this->connection);
                return false;
            }
            
            $result = mysqli_query($this->connection,$ssql);
            
            

            if(!$result)
            {
                $err = mysqli_error($this->connection);
                mysqli_close($this->connection);
                return false;
            }
            
            //$GLOBALS['insert_id'] = mysqli_insert_id($this->connection);
            
            mysqli_close($this->connection);
            
            
            return $result;		
            
        }
        
        function right($str, $length) 
        {
            return substr($str, -$length);
        }
    }
?>