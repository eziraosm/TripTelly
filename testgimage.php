<?php
include("dbconnect.php");
include("fn_triptelly.php");


$placeID = isset($_GET['placeID']) ? $_GET['placeID'] : null;
$data = fetchPlaceDetail($placeID);

// Extract photos and reviews
$photos = $data['photos'];
$reviews = $data['reviews'];

var_dump($photos['photo_reference']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attraction Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .gallery {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
        }
        .gallery img {
            width: 200px;
            height: 150px;
            object-fit: cover;
            border-radius: 5px;
        }
        .reviews {
            border-top: 1px solid #ccc;
            padding-top: 20px;
        }
        .review {
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px dashed #ddd;
        }
        .review img {
            border-radius: 50%;
            width: 50px;
            height: 50px;
            object-fit: cover;
            margin-right: 10px;
        }
        .review-header {
            display: flex;
            align-items: center;
            margin-bottom: 5px;
        }
        .review-content {
            margin-left: 60px;
        }
    </style>
</head>
<body>
    <h1>Attraction Details</h1>

    <!-- Image Gallery -->
    <h2>Image Gallery</h2>
    <div class="gallery">
        <?php foreach ($photos as $photo): ?>
            <img src="https://maps.googleapis.com/maps/api/place/photo?maxwidth=400&photoreference=<?= $photo['photo_reference'] ?>&key=AIzaSyBpHdMS0pMIrrjewOeEpo5z-ykG0FMYbiQ" alt="Attraction Photo">
        <?php endforeach; ?>
    </div>

    <!-- Reviews -->
    <h2>Reviews</h2>
    <div class="reviews">
        <?php foreach ($reviews as $review): ?>
            <div class="review">
                <div class="review-header">
                    <img src="<?= $review['profile_photo_url'] ?>" alt="Reviewer">
                    <strong><?= $review['author_name'] ?></strong>
                    &nbsp; | &nbsp;
                    <span>Rating: <?= $review['rating'] ?>/5</span>
                </div>
                <div class="review-content">
                    <p><?= $review['text'] ?></p>
                    <small><?= $review['relative_time_description'] ?></small>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
