<?php
//class for database connection
class dbconnection{
    
    function connection(){
        //dbconnection
        $host="localhost";
        $un="root";
        $pw="";
        $db="mygym";
        //connection
        $con= new mysqli($host,$un,$pw,$db);
        return $con;
        
        
    }
}
$conobj=new dbconnection(); //To create an object
$con=$conobj->connection(); //To get connection string