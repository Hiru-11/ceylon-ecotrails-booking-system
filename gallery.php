<?php
// Include database connection
include 'db.php';

// Fetch gallery items from database
$sql = "SELECT * FROM gallery ORDER BY id ASC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>CeylonEcoTrails | Gallery</title>
  <link rel="stylesheet" href="Css/gallery.css" />
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
        <li><a href="gallery.php" class="active">Gallery</a></li>
        <li><a href="booking.php">Booking</a></li>
        <li><a href="contactUs.php">Contact</a></li>
      </ul>
    </nav>
  </header>

  <!-- Hero Section -->
  <section class="hero">
    <div class="hero-text">
      <h2>Gallery of Adventures</h2>
      <p>Capturing the beauty, joy, and spirit of CeylonEcoTrails.</p>
    </div>
  </section>

  <!-- Gallery Section -->
  <section class="gallery-section">
    <h2>Explore Our Memories</h2>

    <!-- Search Bar -->
    <div class="gallery-search">
      <input type="text" id="gallerySearch" placeholder="Search by keyword (e.g., mountain, wildlife, rainforest)..." />
    </div>

    <div class="gallery-grid">

      <?php
      if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
              if ($row['media_type'] === 'image') {   //=== this is a strict comparison operator thats used to check if the media type is an image 
                  ?>
                  <div class="gallery-item" data-category="<?php echo htmlspecialchars($row['category']); ?>">
                      <img src="<?php echo htmlspecialchars($row['media_path']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>">
                  </div>
                  <?php
              } else if ($row['media_type'] === 'video') { // this is a strict compariosn operator thats used to check if the media type is a video
                  ?>
                  <div class="gallery-item" data-category="<?php echo htmlspecialchars($row['category']); ?>">
                      <video src="<?php echo htmlspecialchars($row['media_path']); ?>" controls muted></video>
                  </div>
                  <?php
              }
          }
      } else {
          echo "<p>No gallery items available at the moment.</p>";
      }

      $conn->close();
      ?>

    </div>
  </section>

  <!-- Modal (Lightbox) -->
  <div id="lightbox" class="lightbox">
    <span class="close">&times;</span>
    <img class="lightbox-content" id="lightbox-img">
  </div>

  <!-- Footer -->
  <footer>
    <p>© 2025 CeylonEcoTrails | Designed by IT Master</p>
    <div class="socials">
      <a href="#">Facebook</a>
      <a href="#">Instagram</a>
      <a href="#">YouTube</a>
    </div>
  </footer>

  <!-- Lightbox and Search option -->
  <script>
    // Lightbox
    const lightbox = document.getElementById('lightbox');
    const lightboxImg = document.getElementById('lightbox-img');
    const closeBtn = document.querySelector('.close');

    document.querySelectorAll('.gallery-item img').forEach(img => {
      img.addEventListener('click', () => {
        lightbox.style.display = 'flex';
        lightboxImg.src = img.src;
      });
    });

    closeBtn.addEventListener('click', () => { // closing the lighbox when the cancel button is clicked
      lightbox.style.display = 'none';
    });

    lightbox.addEventListener('click', (e) => { //closing the lighbox when an area outside the lightbox is clicked
      if (e.target !== lightboxImg) {
        lightbox.style.display = 'none';
      }
    });

    // Search Filter
    const searchInput = document.getElementById('gallerySearch');
    const galleryItems = document.querySelectorAll('.gallery-item');

    searchInput.addEventListener('input', () => {
      const term = searchInput.value.toLowerCase();
      galleryItems.forEach(item => {
        const category = item.dataset.category.toLowerCase();
        const altText = item.querySelector('img') ? item.querySelector('img').alt.toLowerCase() : '';
        if (category.includes(term) || altText.includes(term)) {
          item.style.display = 'block';
        } else {
          item.style.display = 'none';
        }
      });
    });
  </script>

</body>
</html>
