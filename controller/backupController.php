<?php
include_once '../config/dbconnection.php';
include_once '../config/session.php';
include_once '../config/global.php';
include_once '../model/role.php';

require_once '../vendor/autoload.php';
use Ifsnop\Mysqldump as IMysqldump;

$user=$_SESSION['user'];
$auth = new Role(); 

$status=$_REQUEST['status'];

switch ($status){
    
    case "Backup":

    
         if(!$user)
    {
        $msg = SESSION_TIMED_OUT;
        $msg = base64_encode($msg);
        header("Location:../cms/view/index/index.php?msg=$msg");
        exit;
    }


        if(!$auth->checkPermissions(array(Role::MANAGE_BACKUP)))
        {
            $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/class/index.php?msg=$msg");
            exit;
        }

        try {
            $dump = new IMysqldump\Mysqldump('mysql:host=localhost;dbname=mygym', 'root', '');
            $dump->start('../public/db/dump.sql');

            $msg = json_encode(array('title'=>'Success','message'=>'Database backup successful','type'=>'success'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/backup/index.php?msg=$msg");
            exit;

        } catch (\Exception $e) {
            echo 'mysqldump-php error: ' . $e->getMessage();
        }     
break;

    /**
     * Index actiton
     */

    case "index":

         if(!$user)
    {
        $msg = SESSION_TIMED_OUT;
        $msg = base64_encode($msg);
        header("Location:../cms/view/index/index.php?msg=$msg");
        exit;
    }


        if(!$auth->checkPermissions(array(Role::MANAGE_CLASS, Role::VIEW_CLASS)))
        {
            $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/dashboard/dashboard.php?msg=$msg");
            exit;
        }

        header("Location:../cms/view/backup/");
}
?>