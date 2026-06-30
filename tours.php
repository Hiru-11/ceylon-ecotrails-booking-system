<?php
// Include database connection
include 'db.php';

// Fetch tours from database
$sql = "SELECT * FROM tours ORDER BY id ASC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>CeylonEcoTrails | Tours & Experiences</title>
  <link rel="stylesheet" href="Css/tour.css" />
    <!-- Favicon (logo in browser tab) -->
  <link rel="icon" type="image/png" href="Resources/Logo.png" />
</head>
<body>

  <!-- Header / Navbar -->
  <header>
    <div class="logo">
      <img src="Resources/Logo.png" alt="CeylonEcoTrails Logo" class="logo-img">
      <h1>CeylonEcoTrails</h1>
    </div>
    <nav>
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="aboutUs.php">About</a></li>
        <li><a href="tours.php" class="active">Tours</a></li>
        <li><a href="events.php">Events</a></li>
        <li><a href="gallery.php">Gallery</a></li>
        <li><a href="booking.php">Booking</a></li>
        <li><a href="contactUs.php">Contact Us</a></li>
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

  <!-- Tours Section -->
  <section class="tours-section">
    <h2>Our Tours & Experiences</h2>

    <?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            ?>
            <div class="tour-card">
                <img src="<?php echo $row['image']; ?>" alt="<?php echo htmlspecialchars($row['name']); ?>">
                <div class="tour-header">
                    <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                    <button class="toggle-btn">More Info</button>
                </div>
                <div class="tour-content">
                    <p><?php echo htmlspecialchars($row['description']); ?></p>
                    <ul>
                        <li><strong>Difficulty:</strong> <?php echo htmlspecialchars($row['difficulty']); ?></li>
                        <li><strong>Duration:</strong> <?php echo htmlspecialchars($row['duration']); ?></li>
                        <li><strong>Group Size:</strong> <?php echo htmlspecialchars($row['group_size']); ?></li>
                        <li><strong>Price:</strong> <?php echo htmlspecialchars($row['price']); ?> per person</li>
                        <li><strong>Next Departure:</strong> <?php echo htmlspecialchars($row['next_departure']); ?></li>
                        <li><strong>Places Visited:</strong> <?php echo htmlspecialchars($row['places_visited']); ?></li>
                    </ul>
                    <div class="btn-container">
                        <a href="booking.php?tour_id=<?php echo $row['id']; ?>" class="book-btn">Book Now</a>
                    </div>
                </div>
            </div>
            <?php
        }
    } else {
        echo "<p>No tours available at the moment. Please check back later.</p>";
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

