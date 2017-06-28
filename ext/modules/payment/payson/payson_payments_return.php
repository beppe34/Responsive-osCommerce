<?php
chdir('../../../../');
include('includes/application_top.php');
include('includes/modules/payment/payson.php');

\log::w("payson_payments_return.php: token: " . $_GET['TOKEN']);

if ( strlen($_GET['TOKEN']) <= 0)
{
   tep_redirect(tep_href_link("checkout_payment.php")); 
}

$payson = new payson();

$result = $payson->call_payson_api('PaymentDetails', array("token"    => $_GET['TOKEN']));

$res_arr = explode("&",$result);
$i=0;
$ipn_status = '';
while($i < sizeof($res_arr) ){
    list($tag, $val) = explode("=", $res_arr[$i]);
    if ($val == 'COMPLETED' || $val == 'PENDING' || $val == 'ERROR'){
          $ipn_status = $val;
            break;
                    
    }
    $i++;    
}
\log::w("payson_payments_return.php: ipn_status: " . $ipn_status);
switch($ipn_status){
    case 'COMPLETED':
    case 'PENDING':
        tep_redirect(tep_href_link('checkout_process.php?token=' . $_GET['TOKEN'] . '&type=TRANSFER', '', 'SSL')); 
        break;
    case 'ERROR':
    case 'DENIED';
    case 'EXPIRED';
        paysonApiError('Payment denaid by Payson');
        exit;
    default:
        
        
}


function paysonApiError($error) {
    $error_code = '<html>
                    <head>
			<script type="text/javascript"> 
				alert("'.$error.'");
				window.location="'.tep_href_link('checkout_payment.php').'";
			</script>
		</head>
		</html>';
    echo $error_code;
    exit;
			
}
?>
