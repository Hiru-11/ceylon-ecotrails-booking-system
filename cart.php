<?php
session_start();
include 'db.php';

// Price & fixed date data
$tourPrices = [
    "Cultural Heritage Hike" => 18000,
    "Waterfall Trek" => 10000,
    "Birdwatching Tour" => 9500,
    "Rainforest Expedition" => 17500,
    "Mountain Climbing Adventure" => 25000,
    "Eco Awareness Festival" => 0,
    "Rainforest Conservation Camp" => 0,
    "Mountain Clean-Up Challenge" => 0
];

$fixedTours = [
    "Eco Awareness Festival" => "2025-12-10",
    "Rainforest Conservation Camp" => "2025-12-18",
    "Mountain Clean-Up Challenge" => "2025-12-27"
];

// Ensure session booking exists
if (!isset($_SESSION['booking'])) {
    $_SESSION['booking'] = [
        'user' => [],
        'details' => [],
        'tours' => []
    ];
}

// Remove a tour
if (isset($_GET['remove'])) {
    $idx = (int)$_GET['remove'];
    if (isset($_SESSION['booking']['tours'][$idx])) {
        unset($_SESSION['booking']['tours'][$idx]);
        $_SESSION['booking']['tours'] = array_values($_SESSION['booking']['tours']);
    }
    header("Location: cart.php");
    exit;
}

// Update cart
if (isset($_POST['update_cart'])) {
    $parts = $_POST['participants'] ?? [];
    $dates = $_POST['tour_date'] ?? [];
    foreach ($parts as $idx => $num) {
        $num = (int)$num;
        if (isset($_SESSION['booking']['tours'][$idx])) {
            $_SESSION['booking']['tours'][$idx]['participants'] = $num;
            $tourName = $_SESSION['booking']['tours'][$idx]['tour_name'];
            if (!isset($fixedTours[$tourName])) {
                $_SESSION['booking']['tours'][$idx]['tour_date'] = $dates[$idx] ?? $_SESSION['booking']['tours'][$idx]['tour_date'];
            }
        }
    }
    header("Location: cart.php");
    exit;
}

// Add new tour
if (isset($_POST['add_tour'])) {
    $newTour = $_POST['new_tour'] ?? '';
    $newParticipants = isset($_POST['new_participants']) ? (int)$_POST['new_participants'] : 0;
    $newDate = $_POST['new_date'] ?? '';
    if ($newTour && $newParticipants > 0) {
        $pricePerPerson = $tourPrices[$newTour] ?? 0;
        $tourDate = isset($fixedTours[$newTour]) ? $fixedTours[$newTour] : $newDate;
        $found = false;
        foreach ($_SESSION['booking']['tours'] as &$t) {
            if ($t['tour_name'] === $newTour && $t['tour_date'] === $tourDate) {
                $t['participants'] += $newParticipants;
                $found = true;
                break;
            }
        }
        if (!$found) {
            $_SESSION['booking']['tours'][] = [
                'tour_name' => $newTour,
                'participants' => $newParticipants,
                'tour_date' => $tourDate,
                'price_per_person' => $pricePerPerson
            ];
        }
    }
    header("Location: cart.php");
    exit;
}

// Confirm booking
if (isset($_POST['confirm_booking'])) {
    $session = $_SESSION['booking'] ?? null;
    if (empty($session) || empty($session['user']) || empty($session['tours'])) {
        $error = "Booking details incomplete. Go back to booking and fill details.";
    } else {
        $u = $session['user'];
        $firstName = $conn->real_escape_string($u['first_name'] ?? '');
        $lastName = $conn->real_escape_string($u['last_name'] ?? '');
        $email = $conn->real_escape_string($u['email'] ?? '');

// Remove phone field or handle it differently
        $emergencyName = $conn->real_escape_string($u['emergency_name'] ?? '');
        $emergencyNumber = $conn->real_escape_string($u['emergency_number'] ?? '');

//SQL query thats used to save the user information ito the user table in the database
        $insertUser = "INSERT INTO users (first_name, last_name, email, emergency_name, emergency_number)
                        VALUES ('$firstName', '$lastName', '$email', '$emergencyName', '$emergencyNumber')";

//This runs the query and saves the details to the databse 
        if ($conn->query($insertUser) === TRUE) {
            $userId = $conn->insert_id;

//Gets the details from the sesssion. The real_escape string is used to prevent SQL injections. 
            $d = $session['details'];
            $paymentMethod = $conn->real_escape_string($d['payment_method'] ?? '');
            $currency = $conn->real_escape_string($d['currency'] ?? 'LKR');
            $notes = $conn->real_escape_string($d['notes'] ?? '');
            $totalPriceCalc = 0;

//SQL query thats used to save the booking information ito the bookings table in the database
            $insertBooking = "INSERT INTO bookings (user_id, booking_date, payment_method, currency, notes, total_price)
                              VALUES ('$userId', CURDATE(), '$paymentMethod', '$currency', '$notes', 0)";
            
//This runs the query and saves the details to the databse         
            if ($conn->query($insertBooking) === TRUE) {
                $bookingId = $conn->insert_id;

//Adding rhe details to the table along with the calculations (Calculation of total price)
                foreach ($session['tours'] as $t) {
                    $tourName = $conn->real_escape_string($t['tour_name']);
                    $participants = (int)$t['participants'];
                    $tourDate = $conn->real_escape_string($t['tour_date'] ?? '');
                    $pricePerPerson = isset($t['price_per_person']) ? (float)$t['price_per_person'] : (float)($tourPrices[$t['tour_name']] ?? 0);
                    $totalPriceCalc += $participants * $pricePerPerson;

//Inserting each tour to the booking_tour table and linking the table bookingID so that multiple tours in one booking can be enabled
                    $insertTour = "INSERT INTO booking_tours (booking_id, tour_name, participants, tour_date, price_per_person)
                                   VALUES ('$bookingId', '$tourName', '$participants', '$tourDate', '$pricePerPerson')";
                    $conn->query($insertTour);
                }

//Calculation of the total booking price (with the multiple tpurs)
                $conn->query("UPDATE bookings SET total_price = '$totalPriceCalc' WHERE booking_id = $bookingId");
                unset($_SESSION['booking']);

                if (strtolower($paymentMethod) === 'card') {
                    $return_url = "http://localhost/TREKKING_PROJECT/cart.php?booking_id=$bookingId&payment=card_success";
                    $cancel_url = "http://localhost/TREKKING_PROJECT/cart.php?booking_id=$bookingId&payment=card_failed";
                    $notify_url = "http://localhost/TREKKING_PROJECT/ipn.php";

                //payment gateway integration
                    echo "<form id='payhere_form' action='https://sandbox.payhere.lk/pay/checkout' method='post'>
                            <input type='hidden' name='merchant_id' value='1232573'>
                            <input type='hidden' name='return_url' value='$return_url'>
                            <input type='hidden' name='cancel_url' value='$cancel_url'>
                            <input type='hidden' name='notify_url' value='$notify_url'>
                            <input type='hidden' name='order_id' value='$bookingId'>
                            <input type='hidden' name='items' value='Trekking Booking'>
                            <input type='hidden' name='currency' value='LKR'>
                            <input type='hidden' name='amount' value='$totalPriceCalc'>
                            <input type='hidden' name='first_name' value='$firstName'>
                            <input type='hidden' name='last_name' value='$lastName'>
                            <input type='hidden' name='email' value='$email'>
                            <input type='hidden' name='phone' value='$phone'>
                            <input type='hidden' name='address' value='Colombo'>
                            <input type='hidden' name='city' value='Colombo'>
                            <input type='hidden' name='country' value='Sri Lanka'>
                          </form>
                          <script>document.getElementById('payhere_form').submit();</script>";
                    exit;
                } else {
                    header("Location: cart.php?booking_id=$bookingId&payment=cash_success");
                    exit;
                }
            } else {
                $error = "Error creating booking: " . $conn->error;
            }
        } else {
            $error = "Error creating user: " . $conn->error;
        }
    }
}

// Default session cart
$booking = $_SESSION['booking'] ?? [];
$user = $booking['user'] ?? [];
$tours = $booking['tours'] ?? [];
$totalPrice = 0;
foreach ($tours as &$tour) {
    $tour['price_per_person'] = $tour['price_per_person'] ?? ($tourPrices[$tour['tour_name']] ?? 0);
    $tour['total_price'] = $tour['price_per_person'] * $tour['participants'];
    $totalPrice += $tour['total_price'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>CeylonEcoTrails | Cart</title>
<link rel="stylesheet" href="cart.css">
<style>
.update-btn, .add-btn, .confirm-btn {
    background-color: #28a745;
    color: #fff;
    border: none;
    padding: 8px 16px;
    cursor: pointer;
    border-radius: 4px;
    font-weight: bold;
}
.update-btn:hover, .add-btn:hover, .confirm-btn:hover {
    background-color: #218838;
}
</style>
  <!-- Favicon (logo in browser tab) -->
  <link rel="icon" type="image/png" href="Resources/Logo.png" />
</head>
<body>
<header>
<div class="logo">
    <img src="Resources/Logo.png" alt="CeylonEcoTrails Logo" class="logo-img"> 
    <h1>CeylonEcoTrails</h1>
</div>
<nav>
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="aboutUs.php">About</a></li>
        <li><a href="tours.php">Tours</a></li>
        <li><a href="events.php">Events</a></li>
        <li><a href="gallery.php">Gallery</a></li>
        <li><a href="booking.php">Booking</a></li>
        <li><a href="cart.php" class="active">Cart</a></li>
        <li><a href="contactUs.php">Contact</a></li>
    </ul>
</nav>
</header>

<section class="hero">
<div class="hero-text">
<h2>Your Booking Cart</h2>
<p>Review and manage your selected tours below.</p>
</div>
</section>

<section class="cart-section">
<h2>Booking Summary</h2>
<div class="cart-container">

<?php
if(isset($_GET['payment'])) {
    if($_GET['payment'] === 'cash_success') {
        echo "<p style='color:green;font-weight:bold;'>Booking confirmed! Please pay at our office on arrival.</p>";
    } elseif($_GET['payment'] === 'card_success') {
        echo "<p style='color:green;font-weight:bold;'>Payment successful via Card (PayHere). Thank you!</p>";
    } elseif($_GET['payment'] === 'card_failed') {
        echo "<p style='color:red;font-weight:bold;'>Card payment failed. Please try again.</p>";
    }
}
?>

<form method="POST">
<table class="cart-table">
<thead>
<tr><th>Tour Name</th><th>Participants</th><th>Date</th><th>Price</th><th>Remove</th></tr>
</thead>
<tbody>
<?php if(!empty($tours)): foreach($tours as $i=>$t): ?>
<tr>
<td><?= htmlspecialchars($t['tour_name']) ?></td>
<td><input type="number" name="participants[<?= $i ?>]" value="<?= (int)$t['participants'] ?>" min="0"></td>
<td>
<?php if(isset($fixedTours[$t['tour_name']])): ?>
<?= $fixedTours[$t['tour_name']] ?>
<input type="hidden" name="tour_date[<?= $i ?>]" value="<?= htmlspecialchars($fixedTours[$t['tour_name']]) ?>">
<?php else: ?>
<input type="date" name="tour_date[<?= $i ?>]" value="<?= htmlspecialchars($t['tour_date'] ?? '') ?>">
<?php endif; ?>
</td>
<td><?= ($t['price_per_person']>0)?number_format($t['total_price'],2).' '.htmlspecialchars($booking['details']['currency'] ?? 'LKR'):'–' ?></td>
<td><a href="cart.php?remove=<?= $i ?>" class="remove-btn">Remove</a></td>
</tr>
<?php endforeach; else: ?>
<tr><td colspan="5">No tours in cart. Go to <a href="booking.php">Booking</a> to add tours.</td></tr>
<?php endif; ?>
</tbody>
</table>
<div style="margin-top:12px;">
<button type="submit" name="update_cart" class="update-btn">Update Cart</button>
</div>
</form>

<hr>
<h3>Add a Tour</h3>
<form method="POST">
<label for="new_tour">Tour:</label>
<select name="new_tour" id="new_tour" required>
<option value="">-- choose --</option>
<?php foreach(array_keys($tourPrices) as $tn): ?>
<option value="<?= htmlspecialchars($tn) ?>"><?= htmlspecialchars($tn) ?></option>
<?php endforeach; ?>
</select>

<label for="new_participants">Participants:</label>
<input type="number" name="new_participants" id="new_participants" min="1" value="1" required>

<label for="new_date">Date (if not fixed):</label>
<input type="date" name="new_date" id="new_date">

<button type="submit" name="add_tour" class="add-btn">Add to Cart</button>
</form>

<div class="booking-details">
<h3>Booking Details</h3>
<p><strong>Name:</strong> <?= htmlspecialchars(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? '')) ?></p>
<p><strong>Email:</strong> <?= htmlspecialchars($user['email'] ?? '') ?></p>
<p><strong>Contact:</strong> <?= htmlspecialchars($user['phone'] ?? '') ?></p>
<p><strong>Payment Method:</strong> <?= htmlspecialchars($booking['details']['payment_method'] ?? '') ?></p>
<p><strong>Currency:</strong> <?= htmlspecialchars($booking['details']['currency'] ?? 'LKR') ?></p>
<p><strong>Additional Notes:</strong> <?= htmlspecialchars($booking['details']['notes'] ?? '') ?></p>
<p><strong>Total Price:</strong> <?= number_format($totalPrice,2) ?> <?= htmlspecialchars($booking['details']['currency'] ?? 'LKR') ?></p>
</div>

<form method="POST" style="margin-top:12px;">
<button type="submit" name="confirm_booking" class="confirm-btn" <?= empty($tours)?'disabled':'' ?>>Confirm & Save Booking</button>
</form>

</div>
</section>

<footer>
<p>© 2025 CeylonEcoTrails | Designed by IT Master</p>
</footer>
</body>
</html>
