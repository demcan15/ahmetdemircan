<?php
require __DIR__.'/inc/db.php';
require __DIR__.'/inc/header.php';
?>
<section class="hero">
<div>
<h1>Welcome to <span>Yellow Site</span></h1>
<p>Your gateway to cars, jobs and more!</p>
</div>
</section>
<div class="slider">
<div class="slides">
<div class="slide"><img src="/assets/images/slide1.jpg" alt="slide" style="width:100%;height:100%;object-fit:cover"></div>
<div class="slide"><img src="/assets/images/slide2.jpg" alt="slide" style="width:100%;height:100%;object-fit:cover"></div>
<div class="slide"><img src="/assets/images/slide3.jpg" alt="slide" style="width:100%;height:100%;object-fit:cover"></div>
</div>
</div>
<section class="cards">
<div class="card">
<h3>Cars Gallery</h3>
<p>Browse vehicles and filter by year, fuel and price.</p>
<a class="btn" href="/cars.php">Go to Cars</a>
</div>
<div class="card">
<h3>Job Postings</h3>
<p>Explore job opportunities and apply online.</p>
<a class="btn" href="/jobs.php">Go to Jobs</a>
</div>
<div class="card">
<h3>Contact</h3>
<p>Reach out for support or inquiries.</p>
<a class="btn" href="/contact.php">Contact Us</a>
</div>
</section>
<?php require __DIR__.'/inc/footer.php'; ?>