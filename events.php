<?php
// Include database connection
include 'db.php';

// Fetch events from database
$sql = "SELECT * FROM events ORDER BY id ASC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>CeylonEcoTrails | Events</title>
  <link rel="stylesheet" href="Css/events.css" />
  <!-- Favicon (logo in browser tab) -->
  <link rel="icon" type="image/png" href="Resources/Logo.png" />
</head>
<body>

  <!-- Header  -->
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
        <li><a href="events.php" class="active">Events</a></li>
        <li><a href="gallery.php">Gallery</a></li>
        <li><a href="booking.php">Booking</a></li>
        <li><a href="contactUs.php">Contact</a></li>
      </ul>
    </nav>
  </header>

  <!-- Hero Section -->
  <section class="hero">
    <div class="hero-text">
      <h2>Explore Our Eco Adventures</h2>
      <p>Discover the natural beauty and cultural heritage of Sri Lanka with CeylonEcoTrails.</p>
    </div>
  </section>

  <!-- Calendar Section -->
<section class="calendar-section">
  <h2>Upcoming Events Calendar</h2>
  <div id="calendar"></div>
  <div id="event-details" class="event-details"></div>
</section>

  <!-- Events Section -->
  <section class="events-section">
    <h2>Our Special Events</h2>

    <?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            ?>
            <div class="event-card">
              <div class="event-header">
                <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                <span class="event-type"><?php echo htmlspecialchars($row['type']); ?></span>
              </div>
              <img src="<?php echo $row['image']; ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" style="width:100%; border-radius:10px; margin-bottom:15px;">
              <div class="event-content">
                <p><?php echo htmlspecialchars($row['description']); ?></p>
                <ul>
                  <li><strong>Date:</strong> <?php echo htmlspecialchars($row['date']); ?></li>
                  <li><strong>Location:</strong> <?php echo htmlspecialchars($row['location']); ?></li>
                  <li><strong>Activities:</strong> <?php echo htmlspecialchars($row['activities']); ?></li>
                  <li><strong>Participants:</strong> Up to <?php echo htmlspecialchars($row['max_participants']); ?> people</li>
                </ul>
                <div class="btn-container">
                  <button type="button" class="book-btn" onclick="window.location.href='booking.php'">Join Event</button>
                </div>
              </div>
            </div>
            <?php
        }
    } else {
        echo "<p>No events available at the moment. Please check back later.</p>";
    }

    // Close connection
    $conn->close();
    ?>

  </section>

  <!-- Footer -->
  <footer>
    <p>© 2025 CeylonEcoTrails | Designed by IT Master</p>
    <div class="socials">
      <a href="#">Facebook</a>
      <a href="#">Instagram</a>
      <a href="#">YouTube</a>
    </div>
  </footer>

<script src="script.js"></script>
</body>
</html>

