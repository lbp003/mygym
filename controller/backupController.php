<?php
include '../common/dbconnection.php';
include '../model/backupModel.php';
include '../common/Session.php';

//define("BACKUP_PATH","../backup/");

$status=$_REQUEST['status'];

$objbp= new backup();


switch ($status){
    
    case "Backup":

    //https://www.webslesson.info/2018/02/backup-mysql-database-using-php.html
        
        $connect = new PDO("mysql:host=localhost;dbname=zgym", "root", "");
        $get_all_table_query = "SHOW TABLES";
        $statement = $connect->prepare($get_all_table_query);
        $results = $statement->execute();
        $result = $statement->fetchAll();

        if(isset($_POST['table']))
        {
         $output = '';
         foreach($_POST["table"] as $table)
         {
          $show_table_query = "SHOW CREATE TABLE " . $table . "";
          $statement = $connect->prepare($show_table_query);
          $statement->execute();
          $show_table_result = $statement->fetchAll();

          foreach($show_table_result as $show_table_row)
          {
           $output .= "\n\n" . $show_table_row["Create Table"] . ";\n\n";
          }
          $select_query = "SELECT * FROM " . $table . "";
          $statement = $connect->prepare($select_query);
          $statement->execute();
          $total_row = $statement->rowCount();

          for($count=0; $count<$total_row; $count++)
          {
           $single_result = $statement->fetch(PDO::FETCH_ASSOC);
           $table_column_array = array_keys($single_result);
           $table_value_array = array_values($single_result);
           $output .= "\nINSERT INTO $table (";
           $output .= "" . implode(", ", $table_column_array) . ") VALUES (";
           $output .= "'" . implode("','", $table_value_array) . "');\n";
          }
         }
         $file_name = 'zgym_' . date('y_m_d_H_i_s') . '.sql';
         $file_handle = fopen($file_name, 'w+');
         fwrite($file_handle, $output);
         fclose($file_handle);
         header('Content-Description: File Transfer');
         header('Content-Type: application/octet-stream');
         header('Content-Disposition: attachment; filename=' . basename($file_name));
         header('Content-Transfer-Encoding: binary');
         header('Expires: 0');
         header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file_name));
            ob_clean();
            flush();
            readfile($file_name);
            unlink($file_name);
        }
            $msg=base64_encode("Successfully Backed Up");
            header("Location:../view/backup.php?msg=$msg");

                
break;
}

?>
