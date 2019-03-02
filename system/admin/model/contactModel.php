<?php

class contact{
    
    function displayAllConMsg(){
        $con=$GLOBALS['con'];//To get connection string
        $sql="SELECT * FROM contact_inbox ORDER BY contact_id DESC";
        $result=$con->query($sql);
        return $result;
    }
    function displayAllUserMsgSInbox(){//Because wanna display from user's name
        $con=$GLOBALS['con'];//To get connection string
        $sql="SELECT * FROM user_message u,staff s WHERE u.from_user=s.staff_id ORDER BY user_message_id DESC";
        $result=$con->query($sql);
        return $result;
    }
    function displayAllUserMsgSOutbox(){
        $con=$GLOBALS['con'];//To get connection string
        $sql="SELECT * FROM user_message u,staff s WHERE u.to_user=s.staff_id ORDER BY user_message_id DESC";
        $result=$con->query($sql);
        return $result;
    }
    function displayAllUserMsgMInbox(){
        $con=$GLOBALS['con'];//To get connection string
        $sql="SELECT * FROM user_message u,member m WHERE u.from_user=m.member_id ORDER BY user_message_id DESC";
        $result=$con->query($sql);
        return $result;
    }
    function displayAllUserMsgMOutbox(){
        $con=$GLOBALS['con'];//To get connection string
        $sql="SELECT * FROM user_message u,member m WHERE u.to_user=m.member_id ORDER BY user_message_id DESC";
        $result=$con->query($sql);
        return $result;
    }
    function displayAllConReply(){
        $con=$GLOBALS['con'];//To get connection string
        $sql="SELECT * FROM contact_outbox co ,contact_inbox ci WHERE co.contact_id = ci.contact_id ORDER BY reply_id DESC";
        $result=$con->query($sql);
        return $result;
    }
    
    function addContactMsg($fname,$lname,$email,$telephone,$subject,$message){
        
        $con=$GLOBALS['con']; 
        $sql="INSERT INTO contact_inbox VALUES('','$fname','$lname','$email','$telephone','$subject','$message',NOW(),'Unread')";
        $result=$con->query($sql);
        $contact_id=$con->insert_id;
        return $contact_id;
        
    }
    function addContactReply($contact_id,$staff_id,$reply){
        $con = $GLOBALS['con'];
        $sql="INSERT INTO contact_outbox VALUES('','$contact_id','$staff_id','$reply',NOW(),'Active')";
        $result=$con->query($sql);
        $reply_id=$con->insert_id;
        return $reply_id;
    }
    function deleteConMsg($contact_id){
        $con=$GLOBALS['con'];
        $sql="UPDATE contact_inbox SET status='Delete' WHERE contact_id='$contact_id'";
        $result=$con->query($sql);
        return $result;
    }
    function deleteMsg($message_id){
        $con=$GLOBALS['con'];
        $sql="UPDATE user_message SET status='Delete' WHERE user_message_id='$message_id'";
        $result=$con->query($sql);
        return $result;
    }
    function deleteReply($reply_id){
        $con=$GLOBALS['con'];
        $sql="UPDATE contact_outbox SET status_reply='DeleteReply' WHERE reply_id='$reply_id'";
        $result=$con->query($sql);
        return $result;
    }
    function ViewConMsg($contact_id){
        $con=$GLOBALS['con'];
        $sql="UPDATE contact_inbox SET status='Read' WHERE contact_id='$contact_id'";
        $result=$con->query($sql);
        return $result;
    }
    function ViewMsg($message_id){
        $con=$GLOBALS['con'];
        $sql="UPDATE user_message SET status='Read' WHERE user_message_id='$message_id'";
        $result=$con->query($sql);
        return $result;
    } 
    function displayConMessage($contact_id){
        
        $con=$GLOBALS['con'];
        $sql="SELECT* FROM contact_inbox WHERE contact_id='$contact_id'";
        $result=$con->query($sql);
        return $result;
    }
    function displayMessage($message_id){
        
        $con=$GLOBALS['con'];
        $sql="SELECT* FROM user_message WHERE user_message_id='$message_id'";
        $result=$con->query($sql);
        return $result;
    }
    function displayReply($reply_id){//For View Reply
        
        $con=$GLOBALS['con'];
        $sql="SELECT* FROM contact_outbox co,contact_inbox ci,staff s WHERE co.contact_id=ci.contact_id AND co.staff_id=s.staff_id AND reply_id='$reply_id'";
        $result=$con->query($sql);
        return $result;
    }
    
    function sendMessageSS($fromStaffId,$toStaffId,$subject,$message){
        $con = $GLOBALS['con'];
        $sql="INSERT INTO user_message VALUES('','$fromStaffId','$toStaffId',NOW(),'$subject','$message','SS','Unread')";
        $result=$con->query($sql);
        $UserMsgID=$con->insert_id;
        return $UserMsgID;
    }
    function sendMessageMM($fromMemberId,$toMemberId,$subject,$message){
        $con = $GLOBALS['con'];
        $sql="INSERT INTO user_message VALUES('','$fromMemberId','$toMemberId',NOW(),'$subject','$message','MM','Unread')";
        $result=$con->query($sql);
        $UserMsgID=$con->insert_id;
        return $UserMsgID;
    }
    function sendMessageMS($fromMemberId,$toStaffId,$subject,$message){
        $con = $GLOBALS['con'];
        $sql="INSERT INTO user_message VALUES('','$fromMemberId','$toStaffId',NOW(),'$subject','$message','MS','Unread')";
        $result=$con->query($sql);
        $UserMsgID=$con->insert_id;
        return $UserMsgID;
    }
    function sendMessageSM($fromStaffId,$toMemberId,$subject,$message){
        $con = $GLOBALS['con'];
        $sql="INSERT INTO user_message VALUES('','$fromStaffId','$toMemberId',NOW(),'$subject','$message','SM','Unread')";
        $result=$con->query($sql);
        $UserMsgID=$con->insert_id;
        return $UserMsgID;
    }
    function sendMessageReply($fromId,$toId,$subject,$message,$ty){
        $con = $GLOBALS['con'];
        $sql="INSERT INTO user_message VALUES('','$fromId','$toId',NOW(),'$subject','$message','$ty','Unread')";
        $result=$con->query($sql);
        $UserMsgID=$con->insert_id;
        return $UserMsgID;
    }
}