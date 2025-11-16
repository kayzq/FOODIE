<?php 

session_start();
include("studconnection.php");

/* if(isset($_POST['checkout']))
{
	$orderID = $_SESSION['orderID'];
	
} */

$orderID = $_SESSION['order4Receipt'];

// Import PHPMailer classes into the global namespace 
use PHPMailer\PHPMailer\PHPMailer; 
use PHPMailer\PHPMailer\Exception; 
 
// Exception class. 
require 'phpmailer\6.2\src\Exception.php';
// The main PHPMailer class. 
require 'phpmailer\6.2\src\PHPMailer.php';
// SMTP class, needed if you want to use SMTP. */
require 'phpmailer\6.2\src\SMTP.php';
 
$mail = new PHPMailer; 

$mail->isSMTP();                      // Set mailer to use SMTP 
$mail->Host = 'smtp.gmail.com';       // Specify main and backup SMTP servers 
$mail->SMTPAuth = true;               // Enable SMTP authentication 
$mail->Username = 'foodienull66@gmail.com';   // SMTP username //SILA UBAH DI SINI
$mail->Password = 'prpqhuwqjeuykjxb';   // SMTP password //SILA UBAH DI SINI
$mail->SMTPSecure = 'tls';            // Enable TLS encryption, `ssl` also accepted 
$mail->Port = 587;                    // TCP port to connect to 


 
$orderID = $_SESSION['order4Receipt'];

// Sender info 
$mail->setFrom('foodienull66@gmail.com', 'Foodie System'); //SILA UBAH DI SINI

// Set email format to HTML 
$mail->isHTML(true); 

 
// Mail subject  
$mail->Subject = 'Woot woot, new order from ' . $orderID;
// --- Fetch order + student + admin data ---
$qry = mysqli_query($conn, "SELECT o.orderID, o.orderDate, o.deliveryDate, o.dormLevel, o.dormNo, b.buildingName, s.studName, s.studEmail, s.studPhoneNo, a.adminName, a.adminPhoneNo, a.adminEmail
    FROM orders o
    INNER JOIN buildings b ON o.buildingID = b.buildingID
    INNER JOIN students s ON o.studID = s.studID
    INNER JOIN admins a ON o.adminID = a.adminID
    WHERE o.orderID = '$orderID'");

if (!$qry || mysqli_num_rows($qry) == 0) {
    echo "Order not found.";
    exit();
}

$data = mysqli_fetch_assoc($qry);

// fetch order details
$sql = "SELECT od.quantity, p.prodName, p.price, t.typeName FROM orderdetails od
    INNER JOIN products p ON od.prodID = p.prodID
    INNER JOIN prodtypes t ON p.typeID = t.typeID
    WHERE od.orderID = '$orderID'";

$qry2 = mysqli_query($conn, $sql);

// --- sanitize emails ---
$to = isset($data['studEmail']) ? trim($data['studEmail']) : '';
$toAdd = isset($data['adminEmail']) ? trim($data['adminEmail']) : '';

// --- Build receipt HTML using real data ---
$totalPrice = 0.00;

$bodyContent = '<div style="font-family: Arial, Helvetica, sans-serif; max-width:420px; padding:16px; border:1px solid #e0e0e0; border-radius:8px;">';
$bodyContent .= '<div style="text-align:center; margin-bottom:6px;">';
$bodyContent .= '<h2 style="margin:0;">FOODIE</h2>';
$bodyContent .= '<div style="font-size:13px; color:#666; margin-top:4px;">Receipt</div>';
$bodyContent .= '</div>';

$bodyContent .= '<div style="font-size:13px; color:#333; margin-top:8px;">';
$bodyContent .= '<strong>Order ID:</strong> ' . htmlspecialchars($data['orderID']) . '<br>';
$bodyContent .= '<strong>Order Date:</strong> ' . htmlspecialchars($data['orderDate']) . '<br>';
$bodyContent .= '<strong>Delivery Date:</strong> ' . htmlspecialchars($data['deliveryDate']) . '<br>';
$bodyContent .= '</div>';

$bodyContent .= '<hr style="border:0; border-top:1px dashed #ddd; margin:12px 0;">';

$bodyContent .= '<div style="font-size:13px; margin-bottom:8px;">';
$bodyContent .= '<strong>Customer</strong><br>';
$bodyContent .= htmlspecialchars($data['studName']) . '<br>';
$bodyContent .= htmlspecialchars($data['studEmail']) . '<br>';
$bodyContent .= htmlspecialchars($data['studPhoneNo']) . '<br>';
$bodyContent .= '</div>';

$bodyContent .= '<div style="font-size:13px; margin-bottom:8px;">';
$bodyContent .= '<strong>Delivery To</strong><br>';
$bodyContent .= htmlspecialchars($data['buildingName']) . '<br>';
$bodyContent .= 'Level ' . htmlspecialchars($data['dormLevel']) . ' , Room ' . htmlspecialchars($data['dormNo']) . '<br>';
$bodyContent .= '</div>';

$bodyContent .= '<hr style="border:0; border-top:1px dashed #ddd; margin:12px 0;">';

$bodyContent .= '<table cellpadding="4" cellspacing="0" width="100%" style="font-size:13px;">';
$bodyContent .= '<tr><th align="left">Item</th><th align="center">Qty</th><th align="right">Total</th></tr>';

if ($qry2 && mysqli_num_rows($qry2) > 0) {
    while ($r = mysqli_fetch_assoc($qry2)) {
        $lineTotal = floatval($r['price']) * intval($r['quantity']);
        $totalPrice += $lineTotal;

        $itemName = htmlspecialchars($r['prodName']);
        $qty = intval($r['quantity']);
        $lineTotalStr = 'RM ' . number_format($lineTotal, 2);

        $bodyContent .= "<tr>
            <td style=\"border-top:1px solid #f0f0f0;\">{$itemName}</td>
            <td align=\"center\" style=\"border-top:1px solid #f0f0f0;\">{$qty}</td>
            <td align=\"right\" style=\"border-top:1px solid #f0f0f0;\">{$lineTotalStr}</td>
        </tr>";
    }
} else {
    $bodyContent .= '<tr><td colspan="3" style="padding-top:10px;">No items found</td></tr>';
}

$bodyContent .= '</table>';

$bodyContent .= '<hr style="border:0; border-top:1px dashed #ddd; margin:12px 0;">';

$bodyContent .= '<div style="font-size:15px; font-weight:bold; text-align:right;">Total: RM ' . number_format($totalPrice, 2) . '</div>';

$bodyContent .= '<div style="font-size:12px; color:#666; margin-top:12px;">';
$bodyContent .= '<strong>Shipped by:</strong> ' . htmlspecialchars($data['adminName']) . '<br>';
$bodyContent .= 'Contact: ' . htmlspecialchars($data['adminPhoneNo']) . ' | ' . htmlspecialchars($data['adminEmail']) . '<br>';
$bodyContent .= '</div>';

$bodyContent .= '<div style="text-align:center; margin-top:14px; font-size:12px; color:#777;">Thank you for ordering with FOODIE!</div>';
$bodyContent .= '</div>'; // end wrapper

$mail->Body = $bodyContent;
$mail->AltBody = "FOODIE Receipt\nOrder: {$data['orderID']}\nTotal: RM " . number_format($totalPrice, 2) . "\nThank you for ordering.";

$mail->addAddress("$toAdd"); //to send to admin specifically based on orderid - to which building they are assigned to
$mail->addBCC("$to"); //to send a receipt copy to the customer (student)
$mail->Body = $bodyContent;
$mail->SMTPDebug = 3;

// Send email 
if(!$mail->send()) { 
    echo 'Message could not be sent. Mailer Error: '.$mail->ErrorInfo; //error msg kalau msg x leh send
} else { 
    echo "<script language = 'javascript'>alert('Receipt has be sent to your email. Check your inbox.');window.location='receipts.php';</script>";
}
//https://dev.to/hmawebdesign/how-to-send-html-form-via-php-mailer-4mf9 //untuk activate email app password
?>


