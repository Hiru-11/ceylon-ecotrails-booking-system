<?php
session_start();
include 'db.php';

// Fixed date tours
$fixedTours = [
    "Eco Awareness Festival" => "2025-12-10",
    "Rainforest Conservation Camp" => "2025-12-18",
    "Mountain Clean-Up Challenge" => "2025-12-27"
];

// Tour images
$tourImages = [
    "Cultural Heritage Hike" => "Resources/culturalheritagesites.jpg",
    "Waterfall Trek" => "Resources/waterfalltrekking.jpg",
    "Birdwatching Tour" => "Resources/birdwatching.jpg",
    "Rainforest Expedition" => "Resources/rainforestexpeditions.jpg",
    "Mountain Climbing Adventure" => "Resources/mountainclimbingsrilanka.jpg",
    "Eco Awareness Festival" => "Resources/cycling.jpg",
    "Rainforest Conservation Camp" => "Resources/rainforestwalk.jpg",
    "Mountain Clean-Up Challenge" => "Resources/mountaincleaning.jpg"
];

// Tour prices
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

$allTours = array_keys($tourImages);

// Load any existing session booking in case the user comes back from the cart to the booking page
$sessionBooking = $_SESSION['booking'] ?? [];
$sessionUser = $sessionBooking['user'] ?? [];
$sessionDetails = $sessionBooking['details'] ?? [];
$sessionTours = $sessionBooking['tours'] ?? [];

// Handle form submission: save user and selected tours into session, then go to cart. The POST method collects data and stores them securely in variables
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // simple checks are done. 
    $firstName = trim($_POST['firstName'] ?? '');
    $lastName = trim($_POST['lastName'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $altPhone = trim($_POST['altPhone'] ?? '');
    $emergencyName = trim($_POST['emergencyName'] ?? '');
    $emergencyNumber = trim($_POST['emergencyNumber'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $paymentMethod = $_POST['paymentMethod'] ?? '';
    $currency = $_POST['currency'] ?? 'LKR';
    $notes = $_POST['notes'] ?? '';


    // Build session structure
    $_SESSION['booking'] = [
        'user' => [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'phone' => $phone,
            'alt_phone' => $altPhone,
            'emergency_name' => $emergencyName,
            'emergency_number' => $emergencyNumber
        ],
        'details' => [
            'payment_method' => $paymentMethod,
            'currency' => $currency,
            'notes' => $notes
        ],
        'tours' => []
    ];

    // Loop through tours and collect selected ones
    foreach ($allTours as $tourName) {
        $fieldParticipants = 'tourParticipants_' . str_replace(' ', '_', $tourName);
        $participants = isset($_POST[$fieldParticipants]) ? (int)$_POST[$fieldParticipants] : 0;
        if ($participants > 0) {
            $fieldDate = 'tourDate_' . str_replace(' ', '_', $tourName);
            $tourDate = $fixedTours[$tourName] ?? ($_POST[$fieldDate] ?? '');
            $pricePerPerson = $tourPrices[$tourName] ?? 0;

            $_SESSION['booking']['tours'][] = [
                'tour_name' => $tourName,
                'participants' => $participants,
                'tour_date' => $tourDate,
                'price_per_person' => $pricePerPerson
            ];
        }
    }

    // Redirect to cart to let user review / edit / add / confirm
    header("Location: cart.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CeylonEcoTrails | Booking</title>
<link rel="stylesheet" href="Css/booking.css">
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
    <li><a href="booking.php" class="active">Booking</a></li>
    <li><a href="contactUs.php">Contact</a></li>
</ul>
    </nav>
  </header>

<section class="hero">
<div class="hero-text">
<h2>Book Your Next Adventure</h2>
<p>Secure your spot on our eco-friendly tours and workshops today!</p>
</div>
</section>

<form method="POST" id="bookingForm">
<section class="booking-section">
<h2>Select Tours & Participants</h2>
<div class="tour-cards">
<?php foreach ($allTours as $tourName):

    // find existing selection in session (if user returned from cart)
    $existing = null;
    foreach ($sessionTours as $st) {
        if ($st['tour_name'] === $tourName) { $existing = $st; break; }
    }
?>
<div class="tour-card">
    <?php if(isset($tourImages[$tourName])): ?>
      <img src="<?= $tourImages[$tourName] ?>" alt="<?= htmlspecialchars($tourName) ?>">
    <?php endif; ?>

    <h4><?= htmlspecialchars($tourName) ?></h4>

    <?php if (isset($fixedTours[$tourName])): ?>
      <p><strong>Date: <?= $fixedTours[$tourName] ?></strong></p>
    <?php else: ?>
      <label>Select Date:</label>
      <input type="date" name="tourDate_<?= str_replace(' ', '_', $tourName) ?>" value="<?= htmlspecialchars($existing['tour_date'] ?? '') ?>">
    <?php endif; ?>

    <label>Participants:</label>
    <input type="number" name="tourParticipants_<?= str_replace(' ', '_', $tourName) ?>" min="0" value="<?= (int)($existing['participants'] ?? 0) ?>">
</div>
<?php endforeach; ?>
</div>
</section>

<section class="booking-section">
  <h2>Booking Details</h2>
  <div class="booking-form">
    <!-- First and Last Name -->
    <div class="form-group">
      <label>First Name:</label>
      <input type="text" name="firstName" required placeholder="Enter your first name"
        pattern="[A-Za-z\s]+" title="Only letters allowed"
        value="<?= htmlspecialchars($sessionUser['first_name'] ?? '') ?>">
    </div>
    <div class="form-group">
      <label>Last Name:</label>
      <input type="text" name="lastName" required placeholder="Enter your last name"
        pattern="[A-Za-z\s]+" title="Only letters allowed"
        value="<?= htmlspecialchars($sessionUser['last_name'] ?? '') ?>">
    </div>

    <!-- Address -->
    <div class="form-group">
      <label>Address:</label>
      <input type="text" name="address" required placeholder="Enter your address"
        value="<?= htmlspecialchars($sessionUser['address'] ?? '') ?>">
    </div>

    <!-- Phone Numbers -->
    <div class="form-group">
      <label>Primary Phone Number:</label>
      <input type="tel" name="phone" required placeholder="Enter primary phone number"
        pattern="[0-9]{10,15}" title="Enter a valid phone number"
        value="<?= htmlspecialchars($sessionUser['phone'] ?? '') ?>">
    </div>
    <div class="form-group">
      <label>Alternate Phone Number:</label>
      <input type="tel" name="altPhone" placeholder="Enter alternate phone number"
        pattern="[0-9]{10,15}" title="Enter a valid phone number"
        value="<?= htmlspecialchars($sessionUser['alt_phone'] ?? '') ?>">
    </div>

    <!-- Emergency Contact -->
    <div class="form-group">
      <label>Emergency Contact Name:</label>
      <input type="text" name="emergencyName" required placeholder="Enter emergency contact name"
        pattern="[A-Za-z\s]+" title="Only letters allowed"
        value="<?= htmlspecialchars($sessionUser['emergency_name'] ?? '') ?>">
    </div>
    <div class="form-group">
      <label>Emergency Contact Number:</label>
      <input type="tel" name="emergencyNumber" required placeholder="Enter emergency contact number"
        pattern="[0-9]{10,15}" title="Enter a valid phone number"
        value="<?= htmlspecialchars($sessionUser['emergency_number'] ?? '') ?>">
    </div>

    <!-- Email -->
    <div class="form-group">
      <label>Email Address:</label>
      <input type="email" name="email" required placeholder="Enter your email"
        value="<?= htmlspecialchars($sessionUser['email'] ?? '') ?>">
    </div>

    <!-- Payment Method -->
    <div class="form-group">
      <label>Payment Method:</label>
      <div class="radio-row">
        <label>
          <input type="radio" name="paymentMethod" value="Card" required 
            <?= (($sessionDetails['payment_method'] ?? '') === 'Card') ? 'checked' : '' ?>> Card
        </label>
        <label>
          <input type="radio" name="paymentMethod" value="Cash" required 
            <?= (($sessionDetails['payment_method'] ?? '') === 'Cash') ? 'checked' : '' ?>> Cash
        </label>
      </div>
    </div>

    <!-- Currency -->
    <div class="form-group">
      <label>Currency:</label>
      <div class="radio-row">
        <label>
          <input type="radio" name="currency" value="LKR" required 
            <?= (($sessionDetails['currency'] ?? '') === 'LKR') ? 'checked' : '' ?>> LKR
        </label>
        <label>
          <input type="radio" name="currency" value="USD" required 
            <?= (($sessionDetails['currency'] ?? '') === 'USD') ? 'checked' : '' ?>> USD
        </label>
      </div>
    </div>

    <!-- Additional Notes -->
    <div class="form-group">
      <label>Additional Notes:</label>
      <textarea name="notes" placeholder="Any special requests or notes"><?= htmlspecialchars($sessionDetails['notes'] ?? '') ?></textarea>
    </div>

    <!-- Submit Button -->
    <div class="btn-container">
      <button type="submit" class="confirm-btn">Confirm Booking</button>
    </div>
  </div>
</section>

<footer>
<p>© 2025 CeylonEcoTrails | Designed by IT Master</p>
</footer>
</body>
</html>



