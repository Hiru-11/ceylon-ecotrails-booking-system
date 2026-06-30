<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
   <!-- Mkes the website responsive in all devices -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>CeylonEcoTrails | Home</title> 
  <link rel="stylesheet" href="Css/style.css" />  
  <!-- Favicon  -->
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
        <li><a href="index.php" class="active">Home</a></li>
        <li><a href="aboutUs.php">About</a></li>
        <li><a href="tours.php">Tours</a></li>
        <li><a href="events.php">Events</a></li>
        <li><a href="gallery.php">Gallery</a></li>
        <li><a href="booking.php">Booking</a></li>
        <li><a href="contactUs.php">Contact</a></li>
      </ul>
    </nav>
  </header>

  <!-- Hero Video Section -->
  <section class="hero">
    <video autoplay muted loop class="hero-video">
      <source src="Resources/Nature(Section)Video.mp4" type="video/mp4">
      Your browser does not support the video tag.
    </video>
    <div class="hero-text">
      <h2>Welcome to CeylonEco Trails</h2>
      <p>Discover Sri Lanka’s most breathtaking eco-adventures, connecting nature, culture, and community.</p>
    </div>
  </section>

<section class="about-experience-container">
  <!-- About Us Box -->
  <div class="box about-box">
    <h2>About CeylonEco Trails</h2>
    <p>
      CeylonEcoTrails is your gateway to sustainable trekking and eco-tourism in the heart of Sri Lanka.
      We offer a perfect blend of nature, cultural exploration, and adventure while promoting eco-friendly travel
      and supporting local communities.
    </p>
    <img src="Resources/logo.png" alt="CeylonEcoTrails Logo" class="about-logo">
  </div>

  <!-- Experiences Box -->
  <div class="box experience-box">
    <h2>Our Experiences</h2>
    <ul class="experience-list">
      <li>Guided trekking tours through lush forests and mountains</li>
      <li>Eco-adventure activities: birdwatching, waterfall hikes, and rainforest expeditions</li>
      <li>Community-based tours supporting local artisans</li>
      <li>Eco-lodges and camps designed for comfort and sustainability</li>
      <li>Workshops and volunteering programs for conservation</li>
    </ul>
  </div>
</section>

</section>


  <!-- Packages Section -->
  <section class="packages">
    <h2>Our Tour Packages</h2>

    <div class="package">
      <h3>Highland Explorer</h3>
      <p>Experience a 3-day guided trek through the Knuckles Mountain Range. Includes meals, lodging, and eco-guide support.</p>
    </div>

    <div class="package">
      <h3>Rainforest Discovery</h3>
      <p>2 nights in a forest eco-lodge with guided rainforest exploration, waterfall hikes, and local cuisine experiences.</p>
    </div>

    <div class="package">
      <h3>Cultural Heritage Trail</h3>
      <p>Immerse yourself in Sri Lanka’s cultural roots with village tours, temple visits, and traditional cooking sessions.</p>
    </div>

    <div class="btn-container">
      <a href="tours.php" class="btn">Explore All Packages</a>
    </div>
  </section>

  <!-- CTA Section (Call to Action)-->
  <section class="cta">
    <h2>Want to Learn More?</h2>
    <p>Discover more about our eco-tours, workshops, and how we can make your adventure unforgettable.</p>
    <a href="contactUs.php" class="btn">Contact Us</a>
  </section>

  <!-- Footer -->
  <footer>
    <p>&copy; 2025 CeylonEcoTrails | Designed by IT Master</p>
    <div class="socials">
      <a href="#">Facebook</a> <!--Place Holder '#' symbol is used as the actual social media links arent available yet.Therefore whe this is clicked the user will be navigated to the top of the page-->
      <a href="#">Instagram</a>
      <a href="#">YouTube</a>
    </div>
  </footer>

  <script src="script.js"></script>
</body>
</html>