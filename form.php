<?php

require __DIR__ . '/inc/db-connect.inc.php';
require __DIR__ . '/inc/functions.inc.php';


// ["name"] => "SCR-20241024-nkyx.png",
// ["full_path"] => "SCR-20241024-nkyx.png",
// ["type"]=>  "image/png",
// ["tmp_name"]=>  "/Applications/XAMPP/xamppfiles/temp/phppObfYD",
// ["error"]=> 0,
// ["size"]=> int(262023)


if (!empty($_POST)) {
    var_dump($_POST);
    $title = $_POST['title'] ?? '';
    $date = $_POST['date'] ?? '';
    $message = $_POST['message'] ?? '';
    $image_path = null;

    if (!empty($_FILES) && !empty($_FILES['image'])) {
        $image = $_FILES['image'];

        if ($image['error'] === 0 && $image['size'] !== 0) {
            $imageWithoutExtension = pathinfo($image['name'], PATHINFO_FILENAME);
            $name = preg_replace('/[^a-zA-Z0-9]/', '', $imageWithoutExtension);

            $originalImage = $image['tmp_name'];
            $imageName =  'img' . '-' . $name . '.png';
            $desImage = __DIR__ . '/' . $imageName;

            $image_path = $imageName;

            $dim = 400;

            $imageSize = getimagesize($originalImage);
            if (!empty($imageSize)) {
                [$width, $height] = $imageSize;

                $scaleFactor = $dim / max($width, $height);

                $newWidth = $width * $scaleFactor;
                $newHeight = $height * $scaleFactor;

                $im = imagecreatefrompng($originalImage);
                if (!empty($im)) {
                    $newIm = imagecreatetruecolor($newWidth, $newHeight);

                    imagecopyresampled($newIm, $im, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

                    header("Content-Type: image/jpeg");
                    imagejpeg($newIm, $desImage);
                }
            }
        }
    }

    try {
        $stmt = $pdo->prepare('INSERT INTO `entries` (`title`, `date`, `message`, `image`) VALUES (:title, :date, :message, :image)');
        $stmt->bindValue(':title', $title, PDO::PARAM_STR);
        $stmt->bindValue(':date', $date, PDO::PARAM_STR);
        $stmt->bindValue(':message', $message, PDO::PARAM_STR);
        $stmt->bindValue(':image', $image_path, PDO::PARAM_STR);
        $stmt->execute();
        echo "Record inserted successfully!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    header('Location: index.php');
}


?>

<?php require __DIR__ . '/views/header.view.php' ?>

<h1 class="main-heading">New Entry</h1>

<form method="POST" action="form.php" enctype="multipart/form-data">
    <div class="form-group">
        <label class="from-group__label" for="image">Image:</label>
        <input class="from-group__input" type="file" id="image" name="image" />
    </div>
    <div class="form-group">
        <label class="from-group__label" for="title">Title:</label>
        <input class="from-group__input" type="text" id="title" name="title" />
    </div>
    <div class="form-group">
        <label class="from-group__label" for="date">Date:</label>
        <input class="from-group__input" type="date" id="date" name="date" />
    </div>
    <div class="form-group">
        <label class="from-group__label" for="message">Message:</label>
        <textarea class="from-group__input" id="message" name="message" rows="6"></textarea>
    </div>
    <div class="form-submit">
        <button class="button">
            <svg class="button__icon" viewBox="0 0 34.7163912799 33.4350009649">
                <g style="fill: none; stroke: currentColor; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2px;">
                    <polygon points="20.6844359446 32.4350009649 33.7163912799 1 1 10.3610302393 15.1899978903 17.5208901631 20.6844359446 32.4350009649" />
                    <line x1="33.7163912799" y1="1" x2="15.1899978903" y2="17.5208901631" />
                </g>
            </svg>
            Save!
        </button>
    </div>
</form>

<?php require __DIR__ . '/views/footer.view.php' ?>