<?php
session_start();
include_once  "connect.php";
include_once  "includes/layouts/header.php";

?>

<div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
        <div class="carousel-item active" data-bs-interval="5000">
            <img src="includes/photos/patriarch1HomePage.jpg" class="d-none d-md-block w-100" alt="Desktop Image">
            <!-- صورة للموبايل -->
            <img src="includes/photos/patriarch1HomePageMob.jpg" class="d-block d-md-none w-100" alt="Mobile Image">
            <div class="carousel-caption d-block text-white bg-dark bg-opacity-50 rounded p-2">
                <h5>First slide label</h5>
                <p>Some representative placeholder content for the first slide.</p>
            </div>
        </div>
        <div class="carousel-item" data-bs-interval="5000">
            <img src="includes/photos/—Pngtree—jesus standing on the mountain_3170007.jpg" class="d-block w-100" alt="...">
            <div class="carousel-caption d-block text-white bg-dark bg-opacity-50 rounded p-2">
                <h5>Second slide label</h5>
                <p>Some reprشesentative placeholder content for the second slide.</p>
            </div>
        </div>
        <div class="carousel-item" data-bs-interval="5000">
            <img src="includes/photos/—Pngtree—the cross on hill with_15784505.jpg" class="d-block w-100" alt="...">
            <div class="carousel-caption d-block text-white bg-dark bg-opacity-50 rounded p-2">
                <h5>Third slide label</h5>
                <p>Some representative placeholder content for the third slide.</p>
            </div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>


<?php
include_once "includes/layouts/footer.php";
?>