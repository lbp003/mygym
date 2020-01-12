<?php 

include_once '../../config/dbconnection.php';
include_once '../../config/session.php';
include_once '../../config/global.php';
include_once '../../model/package.php';
include_once '../../model/member.php';
include_once '../../model/subscription.php';
include_once '../../model/role.php';

    $today = date("Y-m-d");
    $time = date("H:i:s");
    //Get active invoices
    $invoiceData = Subscription::getAllActiveInvoices();
    // var_dump($invoiceData); exit;
    if(!empty($invoiceData)){
        while($row = $invoiceData->fetch_assoc()){

            $invoiceID = $row['invoice_id'];
            $invoiceIdNum = $row['invoice_id_number'];
            $paypalInvoiceNum = $row['invoice_number'];
            $memberID = $row['member_id'];
            $membershipID = $row['membership_id'];
            $packageID = $row['package_id'];
    
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
    
                    /**
                     * Search invoice details
                     ***/
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
                    $data = json_decode($response,true);
    
                    $invoicePaymentStatus =  $data['items'][0]['status']; 
                    $fee =  $data['items'][0]['amount']['value'];
                    // $invoicePaymentStatus = Subscription::PAYPAL_PAID;
                        if($invoicePaymentStatus == Subscription::PAYPAL_PAID){
                            $res = Subscription::updatePaypalMemberSubscription($memberID, $membershipID, $packageID, $invoiceIdNum, $paypalInvoiceNum, $fee);
                            // var_dump($res); exit;
                            if($res){
                                $curl = curl_init();
    
                                curl_setopt_array($curl, array(
                                CURLOPT_URL => "https://api.sandbox.paypal.com/v2/invoicing/invoices/".$invoiceIdNum."/cancel",
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => "",
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 30,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => "POST",
                                CURLOPT_POSTFIELDS => '{
                                "subject": "Invoice Canceled",
                                "note": "Canceling the invoice",
                                "send_to_invoicer": true,
                                "send_to_recipient": true
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
                                    // echo $response;
                                    $res = Subscription::deleteInvoice($invoiceID);
                                }
                            }
    
                        }
    
    
                    }
    
                }
            }
    }
    
    //Get expired invoices
    $expiredInvoiceData = Subscription::getAllExpiringInvoices($today);

    if(!empty($expiredInvoiceData)){
        while($row = $expiredInvoiceData->fetch_assoc()){
            $invoiceID = $row['invoice_id'];
            $invoiceIdNum = $row['invoice_id_number'];
            $paypalInvoiceNum = $row['invoice_number'];
            $memberID = $row['member_id'];
            $membershipID = $row['membership_id'];
    
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

                    $curl = curl_init();
    
                    curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://api.sandbox.paypal.com/v2/invoicing/invoices/".$invoiceIdNum."/cancel",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => '{
                    "subject": "Invoice Canceled",
                    "note": "Canceling the invoice",
                    "send_to_invoicer": true,
                    "send_to_recipient": true
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
                        // echo $response;
                        $res = Subscription::deleteUnpaidInvoice($invoiceID,$membershipID);
                    }                    
                }
        }    
    }
    

echo "Cron executed at $today $time ";
exit;
