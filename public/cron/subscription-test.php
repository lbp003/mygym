<?php 

include_once '../config/dbconnection.php';
include_once '../config/session.php';
include_once '../config/global.php';
include_once '../model/package.php';
include_once '../model/member.php';
include_once '../model/subscription.php';
include_once '../model/role.php';


    $today = date("Y-m-d");
    //Get late payment members
    $lateSubData = Subscription::getAllLateSubscription($today);
    // var_dump($lateSubData); exit;
    $lateSubaAr = [];
    $outMemberAr = [];
    while($row = $lateSubData->fetch_assoc())
    {
        $lateSubaAr[] = $row['membership_id'];

        $endDate = $row['end_date'];
        $graceDate = date('Y-m-d', strtotime("+7 days", strtotime($endDate)));

        if($graceDate < $today){

            $outMemberAr[] = $row['member_id'];
        }

        $invoiceIdNum = $row['invoice_id_number'];
        $paypalInvoiceNum = $row['invoice_number'];
        $payStatus = $row['payment_status'];
        $status = $row['invoice_status'];
        if(!empty($paypalInvoiceNum) && $status != "D"){
            // var_dump($paypalInvoiceNum); exit;
// echo "lbp"; exit;
        /**
         * To get the access token
         ***/

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, 'https://api.sandbox.paypal.com/v1/oauth2/token');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_USERPWD, PAYPAL_CREDENTIALS['sandbox']['client_id'] . ':' . PAYPAL_CREDENTIALS['sandbox']['client_secret']);
        
        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = 'Accept-Language: en_US';
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        
        $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                $data = json_decode($response);
                $accessToken = $data->access_token;
                // echo $accessToken; exit;


                //Search invoice details
                $curl = curl_init();

                curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.sandbox.paypal.com/v2/invoicing/search-invoices?total_required=true&page_size=1&page=1",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => '{
                "invoice_number": "'.$paypalInvoiceNum.'"
                }',
                CURLOPT_HTTPHEADER => array(
                    'authorization: Bearer '.$accessToken,
                    'content-type: application/json'
                ),
                ));

                $response = curl_exec($curl);
                $err = curl_error($curl);

                curl_close($curl);

                if ($err) {
                echo "cURL Error #:" . $err;
                } else {
                // echo $response; exit;
                $data = json_decode($response,true);
                $invoicePaymentStatus =  $data['items'][0]['status']; 
                // var_dump($invoicePaymentStatus); exit; 
                    // echo json_encode($data,JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES); exit;

                    $memberID = $row['member_id'];
                    $subscriptionID = $row['membership_id'];
                    $packageID = $row['package_id'];
                    $updatedBy = $user['staff_id'];
                    $method = Subscription::WEB;

                    if($invoicePaymentStatus == Subscription::PAYPAL_PAID && $graceDate >= $today){

                        $res = Subscription::renewMemberSubscription($memberID, $subscriptionID, $packageID, $updatedBy, $method);
                        // var_dump($res); exit;

                        if($res){
                            // echo $row['member_id']; exit;
                            $paidMembershipAr[] = $subscriptionID;
                            $paidMemberAr[] = $memberID;

                        }
                    }elseif($invoicePaymentStatus == Subscription::PAYPAL_PAID && $graceDate < $today){   
                        $res = Subscription::reactivateMemberSubscription($memberID, $subscriptionID, $packageID, $updatedBy, $method);
                        // var_dump($res); exit;
                        // Subscription::updateInvoice($memberID);

                        if($res){
                            $paidMembershipAr[] = $subscriptionID;
                            $paidMemberAr[] = $memberID;;
                        }
                    }elseif($invoicePaymentStatus == !Subscription::PAYPAL_PAID && $graceDate < $today){
                        $curl = curl_init();

                        curl_setopt_array($curl, array(
                        CURLOPT_URL => "https://api.sandbox.paypal.com/v2/invoicing/invoices/".$invoiceIdNum,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => "",
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 30,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => "DELETE",
                        CURLOPT_HTTPHEADER => array(
                            'authorization: Bearer '.$accessToken,
                            'content-type: application/json'
                        ),
                        ));

                        $response = curl_exec($curl);
                        $err = curl_error($curl);

                        curl_close($curl);

                        if ($err) {
                        echo "cURL Error #:" . $err;
                        } else {
                            $res = Subscription::deleteInvoice($memberID);
                        }
                    }elseif($invoicePaymentStatus == Subscription::PAYPAL_SENT && $graceDate >= $today){
                        // echo "lbp"; exit;
                        $paidMembershipAr[] = $subscriptionID;
                        $paidMemberAr[] = $memberID;;
                    }
                }

            }
        }
    }

    // echo "lol"; exit;
    // var_dump($lateSubaAr); exit;
    if(!empty($paidMembershipAr)){
        $lateSubaAr = array_diff($lateSubaAr, $paidMembershipAr);
    }
    if(!empty($paidMemberAr)){
        $outMemberAr = array_diff($outMemberAr, $paidMemberAr);
    }
    
    // var_dump($paidMemberAr); exit;
    //Update payment status of subscription
    if(!empty($lateSubaAr) || !empty($outMemberAr)){

        $result1 = Member::deactivateBulkMember($outMemberAr);
        $result2 = Subscription::updateBulkPaymentStatus($lateSubaAr);

        if($result1 && $result2){

            header("Location:../cms/view/subscription/");

        }else{
            $msg = json_encode(array('title'=>'Warning','message'=> UNKNOWN_ERROR,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/dashboard/dashboard.php?msg=$msg");
            exit;
        }
    }
    header("Location:../cms/view/subscription/");  