<?php
session_start();
extract($_SESSION);
header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: 0");
// following files need to be included
require_once("./lib/config_paytm.php");
require_once("./lib/encdec_paytm.php");


$_SESSION['detail'] = $_POST;   
$date = date("d-m-Y");
$time = date("H-i-s");
$order = array();


// print_r($_POST);
extract($_POST);
  
// print_r($_SESSION['detail']);


 $name = $_SESSION['detail']['first_name'];
 $cemail = $_SESSION['detail']['email'];
 $cphn = $_SESSION['detail']['contact_phone'];


// $order["name"] = $name;
//     $order["email"] = $cemail;
// 	$order["phn"] = $cphn;
    

//      $_SESSION["order"] = $order;
// 	 print_r($_SESSION['order']);
	//  exit();



$checkSum = "";

$paramList = array();
 
// print_r($_SESSION);

$ORDER_ID =$cphn.$date.$time;
// print_r($ORDER_ID);
// exit;
// $ORDER_ID = $_SESSION["order"]["order_id"];
// $CUST_ID = $_SESSION["order"]["customer_id"];
$CUST_ID = $cphn;
$INDUSTRY_TYPE_ID = "Retail";
$CHANNEL_ID = "WEB";
// $TXN_AMOUNT = $_SESSION["order"]["amount"];
$TXN_AMOUNT = $_POST['amount'];

// print_r($order);

// exit();
$_SESSION['myValue']=3;


// Create an array having all required parameters for creating checksum.
$paramList["MID"] = PAYTM_MERCHANT_MID;
$paramList["ORDER_ID"] = $ORDER_ID;
$paramList["CUST_ID"] = $CUST_ID;
$paramList["INDUSTRY_TYPE_ID"] = $INDUSTRY_TYPE_ID;
$paramList["CHANNEL_ID"] = $CHANNEL_ID;
$paramList["TXN_AMOUNT"] = $TXN_AMOUNT;
$paramList["WEBSITE"] = PAYTM_MERCHANT_WEBSITE;




$paramList["CALLBACK_URL"] = "https://immivisas.com/payment/pgResponse.php";

/*
$paramList["MSISDN"] = $MSISDN; //Mobile number of customer
$paramList["EMAIL"] = $EMAIL; //Email ID of customer
$paramList["VERIFIED_BY"] = "EMAIL"; //
$paramList["IS_USER_VERIFIED"] = "YES"; //

*/

//Here checksum string will return by getChecksumFromArray() function.
$checkSum = getChecksumFromArray($paramList,PAYTM_MERCHANT_KEY);

?>
<html>
<head>
<title>Merchant Check Out Page</title>
</head>
<body>
	<center><h1>Please do not refresh this page...</h1></center>
		<form method="post" action="<?php echo PAYTM_TXN_URL ?>" name="f1">
		<table border="1">
			<tbody>
			<?php
			foreach($paramList as $name => $value) {
				echo '<input type="hidden" name="' . $name .'" value="' . $value . '">';
			}
			?>
			<input type="hidden" name="CHECKSUMHASH" value="<?php echo $checkSum ?>">
			</tbody>
		</table>
		<script type="text/javascript">
			document.f1.submit();
		</script>
	</form>
</body>
</html>