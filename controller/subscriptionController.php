<?php
include_once '../config/dbconnection.php';
include_once '../config/session.php';
include_once '../config/global.php';
include_once '../model/package.php';
include_once '../model/member.php';
include_once '../model/subscription.php';
include_once '../model/role.php';

$user=$_SESSION['user'];
$auth = new Role();

$status=$_REQUEST['status'];


switch ($status){

    /**
     * Choose package action
     */
    case "Payment":
       
         if(!$user)
    {
        $msg = SESSION_TIMED_OUT;
        $msg = base64_encode($msg);
        header("Location:../cms/view/index/index.php?msg=$msg");
        exit;
    }


        if(!$auth->checkPermissions(array(Role::MANAGE_SUBSCRIPTION)))
        {
            $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/dashboard/dashboard.php?msg=$msg");
            exit;
        }

        $today = date("Y-m-d");

        $membershipID = $_REQUEST['membership_id'];

        $dataSet = Subscription::getSubscriptionDetailsByID($membershipID);
        $row = $dataSet->fetch_assoc();
        
        $memberID = $row['member_id'];
        $packageID = $row['package_id'];

        $endDate = $row['end_date'];
        $graceDate = date('Y-m-d', strtotime("+7 days", strtotime($endDate)));
        // var_dump($graceDate); exit;

        //get active packages
        $dataSet = Package::getActivePackage();
        $packagAr = [];
        while($row = $dataSet->fetch_assoc())
        {
            $packagAr[$row['package_id']] = $row['package_name'];
        }
        // print_r($packagAr); exit;
        
        $_SESSION['pacData'] = $packagAr;
        $memID = base64_encode($memberID);
        $subID = base64_encode($membershipID);
        $pacID = base64_encode($packageID);

        if($graceDate >= $today){

            header("Location:../cms/view/subscription/renewMembership.php?subID=$subID&memID=$memID&pacID=$pacID");
            exit;
        }else{

            header("Location:../cms/view/subscription/reactivateMembership.php?subID=$subID&memID=$memID&pacID=$pacID");
            exit;
        }
        
break;

    /**
     * Reactivate the member
    */  
    case "Reactivate":

         if(!$user)
    {
        $msg = SESSION_TIMED_OUT;
        $msg = base64_encode($msg);
        header("Location:../cms/view/index/index.php?msg=$msg");
        exit;
    }


        if(!$auth->checkPermissions(array(Role::MANAGE_SUBSCRIPTION)))
        {
            $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/dashboard/dashboard.php?msg=$msg");
            exit;
        }

        $memberID = $_POST['member_id'];
        $subscriptionID = $_POST['subscription_id'];
        $updatedBy = $user['staff_id'];

        $packageID = $_POST['package'];
        if (empty($packageID)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Package can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/subscription/reactivateMembership.php?msg=$msg");
            exit;
        }
        $method = Subscription::CASH;
        $res = Subscription::reactivateMemberSubscription($memberID, $subscriptionID, $packageID, $updatedBy, $method);

        if($res){
            $msg = json_encode(array('title'=>'Success: ','message'=> 'Member has been reactivated','type'=>'success'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/subscription/index.php?msg=$msg");
            exit;
        }else{
            $msg = json_encode(array('title'=>'Warning','message'=> UNKNOWN_ERROR,'type'=>'danger'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/subscription/index.php?msg=$msg");
            exit;
        }

break;

    /**
     * Renew the membership
    */
    case "Renew":

         if(!$user)
    {
        $msg = SESSION_TIMED_OUT;
        $msg = base64_encode($msg);
        header("Location:../cms/view/index/index.php?msg=$msg");
        exit;
    }


        if(!$auth->checkPermissions(array(Role::MANAGE_SUBSCRIPTION)))
        {
            $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/dashboard/dashboard.php?msg=$msg");
            exit;
        }

        $subscriptionID = $_POST['subscription_id'];
        $updatedBy = $user['staff_id'];

        $packageID = $_POST['package'];
        if (empty($packageID)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Package can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/subscription/renewMembership.php?msg=$msg");
            exit;
        }

        $payMethod = $_POST['payment'];
        if (empty($payMethod)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Please select a payment method','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/subscription/renewMembership.php?msg=$msg");
            exit;
        }

        if($payMethod == Subscription::WEB){

            //Update package
            Member::updatePackage($packageID,$updatedBy,$subscriptionID);
            // var_dump($res); exit;

            $today = date("Y-m-d");
            $dataSet = Subscription::getSubscriptionDetailsByID($subscriptionID);
            $row = $dataSet->fetch_assoc();
            
            $dueDate = date("Y-m-d",strtotime($row['end_date']));
            $memberID = $row['member_id'];
            $firstName = $row['first_name'];
            $lastName = $row['last_name'];
            $package = $row['package_name'];
            $email = $row['email'];
            $phone = $row['telephone'];
            $fee = $row['fee'];
            // var_dump($dueDate); exit;
            // echo $newReferenceCode; exit;

            // https://docs.openexchangerates.org/docs/latest-json

            $app_id = '35c38025e1ef434786933b036608a6e4';
            $base = 'USD';
            $symbols = 'LKR';
            $oxr_url = "https://openexchangerates.org/api/latest.json?app_id=".$app_id."&base=".$base."&symbols=".$symbols."&prettyprint=false";
            
            // Open CURL session:
            $ch = curl_init($oxr_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            
            // Get the data:
            $json = curl_exec($ch);
            $err = curl_error($ch);
            curl_close($ch);

            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
            
            // Decode JSON response:
            $latest = json_decode($json);
            
            // You can now access the rates inside the parsed object, like so:

            $lkrRate = $latest->rates->LKR;
            $feeInUSD = round($fee/$lkrRate, 2);

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

                     //Generate random invoice number
                    $numRan = [
                        rand(11,99) . time() . rand(111,999),
                        rand(11,99) . time() . rand(111,999),
                        rand(11,99) . time() . rand(111,999),
                        rand(11,99) . time() . rand(111,999),
                        rand(11,99) . time() . rand(111,999)
                    ];
                    $invoiceNum = $numRan[rand(0,4)];

                    $curl = curl_init();

                    curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://api.sandbox.paypal.com/v2/invoicing/invoices",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => '{
                    "detail": {
                        "invoice_number": "#'.$invoiceNum.'",
                        "reference": "deal-ref",
                        "invoice_date": "'.$today.'",
                        "currency_code": "USD",
                        "note": "Thank you.",
                        "term": "No refunds after 30 days.",
                        "memo": "This is a long contract",
                        "payment_term": {
                        "term_type": "DUE_ON_DATE_SPECIFIED",
                        "due_date": "'.$dueDate.'"
                        }
                    },
                    "invoicer": {
                        "name": {
                          "given_name": "'.SYSTEM_BUSINESS_NAME.'",
                          "surname": ""
                        },
                        "address": {
                          "address_line_1": "1234 First Street",
                          "address_line_2": "337673 Hillside Court",
                          "admin_area_2": "Anytown",
                          "admin_area_1": "CA",
                          "postal_code": "98765",
                          "country_code": "US"
                        },
                        "email_address": "pglbuddhika-facilitator@gmail.com",
                        "phones": [
                          {
                            "country_code": "094",
                            "national_number": "4085551234",
                            "phone_type": "MOBILE"
                          }
                        ],
                        "website": "www.hirufitness.com",
                        "tax_id": "ABcNkWSfb5ICTt73nD3QON1fnnpgNKBy- Jb5SeuGj185MNNw6g",
                        "logo_url": "https://example.com/logo.PNG",
                        "additional_notes": "2-4"
                      },
                      "primary_recipients": [
                        {
                          "billing_info": {
                            "name": {
                              "given_name": "'.$firstName.'",
                              "surname": "'.$lastName.'"
                            },
                            "email_address": "'.$email.'"
                          }
                        }
                      ],
                      "items": [
                        {
                          "name": "'.$package.'",
                          "description": "",
                          "quantity": "1",
                          "unit_amount": {
                            "currency_code": "USD",
                            "value": "'.$feeInUSD.'"
                          },
                          "unit_of_measure": "AMOUNT"
                        }
                      ]
                    }',
                    CURLOPT_HTTPHEADER => array(
                        'authorization: Bearer '.$accessToken,
                        'content-type: application/json',
                        'prefer: return=representation'
                    ),
                    ));

                    $response = curl_exec($curl);
                    $err = curl_error($curl);

                    curl_close($curl);

                    if ($err) {
                    echo "cURL Error #:" . $err;
                    } else {

                        // echo $response; exit; 

                        $data = json_decode($response);
                        $id = $data->id;
                        
                        $curl = curl_init();

                        curl_setopt_array($curl, array(
                        CURLOPT_URL => "https://api.sandbox.paypal.com/v2/invoicing/invoices/".$id."/send?notify_merchant=true",
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => "",
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 30,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => "POST",
                        CURLOPT_POSTFIELDS => '{
                        "send_to_invoicer": true
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
                            //record invoice details
                            $res = Subscription::addInvoice($invoiceNum,$id,$memberID,$today,$updatedBy,$subscriptionID);
                            // var_dump($res); exit;
                            if($res){    
                                $msg = json_encode(array('title'=>'Success','message'=> 'Member invoice has been sent','type'=>'success'));
                                $msg = base64_encode($msg);
                                header("Location:../cms/view/subscription/index.php?msg=$msg");
                                exit;
                               
                            }else{
                                $msg = json_encode(array('title'=>'Warning','message'=> UNKNOWN_ERROR,'type'=>'danger'));
                                $msg = base64_encode($msg);
                                header("Location:../cms/view/subscription/index.php?msg=$msg");
                                exit;
                            }
                        }
                    }
                }
            }
        }else{
            $method = Subscription::CASH;

            $res = Subscription::renewMemberSubscription($memberID, $subscriptionID, $packageID, $updatedBy,$method);

            if($res){
                $msg = json_encode(array('title'=>'Success: ','message'=> 'Member subscription has been renewed','type'=>'success'));
                $msg = base64_encode($msg);
                header("Location:../cms/view/subscription/index.php?msg=$msg");
                exit;
            }else{
                $msg = json_encode(array('title'=>'Warning','message'=> UNKNOWN_ERROR,'type'=>'danger'));
                $msg = base64_encode($msg);
                header("Location:../cms/view/subscription/index.php?msg=$msg");
                exit;
            }
        }


break;

    /**
     * Index actiton
     */
    case "View":
         if(!$user)
    {
        $msg = SESSION_TIMED_OUT;
        $msg = base64_encode($msg);
        header("Location:../cms/view/index/index.php?msg=$msg");
        exit;
    }


        if(!$auth->checkPermissions(array(Role::VIEW_SUBSCRIPTION)))
        {
            $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/dashboard/dashboard.php?msg=$msg");
            exit;
        }

        
        $membershipID = $_REQUEST['membership_id'];

        $dataSet = Subscription::getSubscriptionDetailsByID($membershipID);
        $subscriptionData = $dataSet->fetch_assoc();

        $_SESSION['subscriptionData'] = $subscriptionData;

        header("Location:../cms/view/subscription/viewSubscription.php");
        exit;
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


        if(!$auth->checkPermissions(array(Role::MANAGE_SUBSCRIPTION, Role::VIEW_SUBSCRIPTION)))
        {
            $msg = json_encode(array('title'=>'Warning','message'=> UNAUTHORIZED_ACCESS,'type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/dashboard/dashboard.php?msg=$msg");
            exit;
        }

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
}

