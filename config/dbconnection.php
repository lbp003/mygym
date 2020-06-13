<?php
//class for database connection
class dbconnection{
    
    function connection(){
        //dbconnection
        $host="localhost";
        $un="id13796618_root";
        $pw="52n2B^MCuq]Ni{\-";
        $db="id13796618_mygym";
        //connection
        $con= new mysqli($host,$un,$pw,$db);
        return $con;
        
        
    }
}
$conobj=new dbconnection(); //To create an object
$con=$conobj->connection(); //To get connection string
$GLOBALS['con']=$con; 
?>