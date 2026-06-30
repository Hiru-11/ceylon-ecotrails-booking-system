<?php
// contact.php
session_start();
include 'db.php'; 

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // Server-side validation
    $errorMessage = '';
    if (!preg_match("/^[a-zA-Z\s]+$/", $fullName)) {
        $errorMessage = "Name can only contain letters and spaces.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) { //php email validator 
        $errorMessage = "Please enter a valid email address.";
    } elseif (!preg_match("/^\d{10}$/", $phone)) {
        $errorMessage = "Phone number must be exactly 10 digits.";
    } elseif (!$message) {
        $errorMessage = "Please enter a message.";
    }

    if (!$errorMessage) { //prepare statement avoids sql injections 
        $stmt = $conn->prepare("INSERT INTO contacts (full_name, email, phone, message) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $fullName, $email, $phone, $message); //only strings are used 

        if ($stmt->execute()) {
            $successMessage = "Your message has been sent successfully!";
        } else {
            $errorMessage = "Failed to send your message. Please try again.";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>CeylonEcoTrails | Contact Us</title>
  <link rel="stylesheet" href="Css/contact.css" />
  <script>
    function validateForm() {
        const name = document.getElementById("name").value.trim();
        const email = document.getElementById("email").value.trim();
        const phone = document.getElementById("phone").value.trim();
        const message = document.getElementById("message").value.trim();

        if (!/^[a-zA-Z\s]+$/.test(name)) {
            alert("Name can only contain letters and spaces.");
            return false;
        }
        if (!/^\d{10}$/.test(phone)) {
            alert("Phone number must be exactly 10 digits.");
            return false;
        }
        const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$/;
        if (!emailPattern.test(email)) {
            alert("Please enter a valid email address.");
            return false;
        }
        if (!message) {
            alert("Please enter a message.");
            return false;
        }
        return true; // Form can submit
    }
  </script>
  <!-- Favicon (logo in browser tab) -->
  <link rel="icon" type="image/png" href="Resources/Logo.png" />
</head>
<body>

  <!-- Header -->
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
        <li><a href="contactUs.php" class="active">Contact</a></li>
      </ul>
    </nav>
  </header>

  <!-- Hero Section -->
  <section class="hero">
    <div class="hero-text">
      <h2>Get in Touch with Us</h2>
      <p>We’d love to hear from you! Reach out for bookings, inquiries, or collaborations.</p>
    </div>
  </section>

  <!-- Contact Section -->
  <section class="contact-section">
    <h2>Contact Us</h2>

    <div class="contact-container">

     <!-- Contact Form -->
    <div class="message-container">
      <?php if(isset($successMessage)): ?>
        <p class="success-msg"><?= htmlspecialchars($successMessage) ?></p>
      <?php elseif(isset($errorMessage)): ?>
        <p class="error-msg"><?= htmlspecialchars($errorMessage) ?></p>
      <?php endif; ?>
    </div>

    <form class="contact-form" method="POST" action="" onsubmit="return validateForm()">
        <div class="form-group">
          <label for="name">Full Name:</label>
          <input type="text" id="name" name="name" placeholder="Enter your name" required value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" />
        </div>

        <div class="form-group">
          <label for="email">Email Address:</label>
          <input type="email" id="email" name="email" placeholder="example@email.com" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" />
        </div>

        <div class="form-group">
          <label for="phone">Phone Number:</label>
          <input type="tel" id="phone" name="phone" placeholder="07x-xxxxxxx" required value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>" />
        </div>

        <div class="form-group">
          <label for="message">Message:</label>
          <textarea id="message" name="message" rows="5" placeholder="Write your message..." required><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>
        </div>

        <div class="btn-container">
          <button type="submit" class="send-btn">Send Message</button>
          <button type="reset" class="cancel-btn">Clear</button>
        </div>
    </form>


      <!-- Office Info & Social Links -->
      <div class="contact-info">
        <h3>Our Office</h3>
        <img src="Resources/Staff Photo.jpg" alt="CeylonEcoTrails Office" class="office-img">
        <p>📍 Kandy, Sri Lanka</p>
        <p>📧 info@ceylonecotrails.com</p>
        <p>📞 +94 77 123 4567</p>

        <h3>Follow Us</h3>
        <div class="socials">
            <a href="#">Facebook</a>
            <a href="#">Instagram</a>
            <a href="#">YouTube</a>
        </div>
      </div>

    </div>
  </section>

  <!-- Footer -->
  <footer>
    <p>© 2025 CeylonEcoTrails | Designed by IT Master</p>
  </footer>

</body>
</html>


