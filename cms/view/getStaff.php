<?php include_once '../common/dbconnection.php'; ?>
<?php
if(isset($_POST["query"])){
    $request = mysqli_real_escape_string($con,$_POST["query"]);
    $query = "SELECT * FROM staff WHERE staff_email LIKE '%".$request."%'";

    $result = mysqli_query($con, $query);
    
//    print_r($result);

    $data = array();

    if(mysqli_num_rows($result) > 0)
    {
     while($row =mysqli_fetch_assoc($result))
     {
      $data[] = $row["staff_email"];
      //$data_id[] = $row["staff_id"];
     }
     echo json_encode($data);
    }

}

?>
