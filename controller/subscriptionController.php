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
        $graceDate = date('Y-m-d', strtotime("+11 days", strtotime($endDate)));
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
            header("Location:../cms/view/subscription/renew-membership.php?subID=$subID&memID=$memID&pacID=$pacID");
            exit;
        }else{
            header("Location:../cms/view/subscription/reactivate-membership.php?subID=$subID&memID=$memID&pacID=$pacID");
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
            header("Location:../cms/view/subscription/reactivate-membership.php?msg=$msg");
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

        $memberID = $_POST['member_id'];
        $subscriptionID = $_POST['subscription_id'];
        $updatedBy = $user['staff_id'];

        $packageID = $_POST['package'];
        if (empty($packageID)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Package can not be empty','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/subscription/renew-membership.php?msg=$msg");
            exit;
        }

        $payMethod = $_POST['payment'];
        if (empty($payMethod)) {
            $msg = json_encode(array('title'=>'Warning','message'=> 'Please select a payment method','type'=>'warning'));
            $msg = base64_encode($msg);
            header("Location:../cms/view/subscription/renew-membership.php?msg=$msg");
            exit;
        }

        $today = date("Y-m-d");

        if($payMethod == Subscription::WEB){

            //Update package
            if(Member::updatePackage($packageID,$updatedBy,$memberID)){            
                $dataSet = Subscription::getSubscriptionDetailsByID($subscriptionID);
                if(!empty($dataSet)){
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
    
                    $app_id = OPENEXCHANGERATES_APP_ID;
                    $base = Subscription::USD;
                    $symbols = Subscription::LKR;
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
                    // var_dump($latest); exit;
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

                            /**
                             * Create the invoice
                             ***/
    
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
                                "memo": "Package Subscription Payment Invoice",
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
                                "address_line_1": "'.ADDRESS_LINE_1.'",
                                "address_line_2": "'.ADDRESS_LINE_2.'",
                                "admin_area_2": "'.ADMIN_AREA_2.'",
                                "admin_area_1": "'.ADMIN_AREA_1.'",
                                "postal_code": "'.POSTAL_CODE.'",
                                "country_code": "'.COUNTRY.'"
                                },
                                "email_address": "'.PAYPAL_EMAIL.'",
                                "phones": [
                                {
                                    "country_code": "'.COUNTRY_CODE.'",
                                    "national_number": "'.NATIONAL_NUMBER.'",
                                    "phone_type": "MOBILE"
                                }
                                ],
                                "website": "'.WEB_SITE.'",
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
                                
                            /**
                            * send the invoice
                            ***/
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
                    $msg = json_encode(array('title'=>'Warning','message'=> UNKNOWN_ERROR,'type'=>'danger'));
                    $msg = base64_encode($msg);
                    header("Location:../cms/view/subscription/index.php?msg=$msg");
                    exit;
                }
            }else{
                $msg = json_encode(array('title'=>'Warning: ','message'=> 'Package update failed','type'=>'danger'));
                $msg = base64_encode($msg);
                header("Location:../cms/view/subscription/index.php?msg=$msg");
                exit;
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

        header("Location:../cms/view/subscription/view-subscription.php");
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

        header("Location:../cms/view/subscription/");           
}

