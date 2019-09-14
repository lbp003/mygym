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
            $msg = json_encode(array('title'=>'Warning','message'=> SESSION_TIMED_OUT,'type'=>'warning'));
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
            $msg = json_encode(array('title'=>'Warning','message'=> SESSION_TIMED_OUT,'type'=>'warning'));
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

        $res = Subscription::reactivateMemberSubscription($memberID, $subscriptionID, $packageID, $updatedBy);

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
            $msg = json_encode(array('title'=>'Warning','message'=> SESSION_TIMED_OUT,'type'=>'warning'));
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

        if($payMethod == "O"){

            //To get the access token
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
                    
                    $today = date("Y-m-d");

                    $dataSet = Subscription::getSubscriptionDetailsByID($subscriptionID);
                    $row = $dataSet->fetch_assoc();
                    
                    // echo $newReferenceCode; exit;

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
                        "currency_code": "LKR",
                        "note": "Thank you for your business.",
                        "term": "No refunds after 30 days.",
                        "memo": "This is a long contract",
                        "payment_term": {
                        "term_type": "NET_10",
                        "due_date": "'.$row['end_date'].'"
                        }
                    },
                    "invoicer": {
                        "name": {
                        "given_name": "'.SYSTEM_BUSINESS_NAME.'"
                        },
                        "address": {
                        "address_line_1": "1234 First Street",
                        "address_line_2": "337673 Hillside Court",
                        "admin_area_2": "Anytown",
                        "admin_area_1": "CA",
                        "postal_code": "98765",
                        "country_code": "LK"
                        },
                        "email_address": "pglbuddhika-facilitator@gmail.com",
                        "phones": [
                        {
                            "country_code": "001",
                            "national_number": "4085551234",
                            "phone_type": "MOBILE"
                        }
                        ],
                        "website": "www.test.com",
                        "tax_id": "ABcNkWSfb5ICTt73nD3QON1fnnpgNKBy- Jb5SeuGj185MNNw6g",
                        "logo_url": "https://example.com/logo.PNG",
                        "additional_notes": "2-4"
                    },
                    "primary_recipients": [
                        {
                          "billing_info": {
                            "name": {
                              "given_name": "Stephanie",
                              "surname": "Meyers"
                            },
                            "address": {
                              "address_line_1": "1234 Main Street",
                              "admin_area_2": "Anytown",
                              "admin_area_1": "CA",
                              "postal_code": "98765",
                              "country_code": "US"
                            },
                            "email_address": "pglbuddhika@gmail.com",
                            "phones": [
                              {
                                "country_code": "001",
                                "national_number": "4884551234",
                                "phone_type": "HOME"
                              }
                            ],
                            "additional_info_value": "add-info"
                          },
                          "shipping_info": {
                            "name": {
                              "given_name": "Stephanie",
                              "surname": "Meyers"
                            },
                            "address": {
                              "address_line_1": "1234 Main Street",
                              "admin_area_2": "Anytown",
                              "admin_area_1": "CA",
                              "postal_code": "98765",
                              "country_code": "US"
                            }
                          }
                        }
                      ],
                    "items": [
                        {
                        "name": "Yoga Mat",
                        "description": "Elastic mat to practice yoga.",
                        "quantity": "1",
                        "unit_amount": {
                            "currency_code": "USD",
                            "value": "50.00"
                        },
                        "tax": {
                            "name": "Sales Tax",
                            "percent": "7.25"
                        },
                        "discount": {
                            "percent": "5"
                        },
                        "unit_of_measure": "QUANTITY"
                        },
                        {
                        "name": "Yoga t-shirt",
                        "quantity": "1",
                        "unit_amount": {
                            "currency_code": "USD",
                            "value": "10.00"
                        },
                        "tax": {
                            "name": "Sales Tax",
                            "percent": "7.25"
                        },
                        "discount": {
                            "amount": {
                            "currency_code": "USD",
                            "value": "5.00"
                            }
                        },
                        "unit_of_measure": "QUANTITY"
                        }
                    ],
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

                        echo $response; exit; 

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
                            'authorization: Bearer A21AAGNcqCVsX1MVlZ6mZ_lb-iTTQo1euoZP09mVlsOE36F-anIUgWGhrbe56QEQE_f7iFzjxO9-QmGkDG8ExsoG75snBtQcA',
                            'content-type: application/json'
                        ),
                        ));

                        $response = curl_exec($curl);
                        $err = curl_error($curl);

                        curl_close($curl);

                        if ($err) {
                        echo "cURL Error #:" . $err;
                        } else {
                        echo $response;
                        }
                    }
                }
        }else{
            $res = Subscription::renewMemberSubscription($memberID, $subscriptionID, $packageID, $updatedBy);

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
            $msg = json_encode(array('title'=>'Warning','message'=> SESSION_TIMED_OUT,'type'=>'warning'));
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

    default:

        if(!$user)
        {
            $msg = json_encode(array('title'=>'Warning','message'=> SESSION_TIMED_OUT,'type'=>'warning'));
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
        }

        // var_dump($outMemberAr); exit;
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

?>
