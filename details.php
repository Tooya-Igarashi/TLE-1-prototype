<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: index_doctor.php');
    exit();
}

/** @var mysqli $db */
require_once 'includes/connection.php';

$id = mysqli_escape_string($db, $_GET['id']);
$query = "SELECT * FROM health WHERE id = $id";

$result = mysqli_query($db, $query)
or die('Error ' . mysqli_error($db) . ' with query ' . $query);

$health = mysqli_fetch_assoc($result);

mysqli_close($db);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= htmlentities($health['name'])?>Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css">
</head>
<body>

<header class="hero is-info">
    <div class="hero-body">
        <p class="title">Client detail</p>
        <p class="subtitle"><?= htmlentities($health['name'])?></p>
    </div>
</header>

<main class="container">
    <section class="section content">
        <ul>
            <li>Bloeddruk: <?= htmlentities($health['blood_pressure'])?></li>
            <li>Hartslag: <?= htmlentities($health['heart_rate'])?></li>
            <li>Bloedsuiker gehalte: <?= htmlentities($health['blood_sugar'])?>H</li>
            <li>Symptomen: <?= htmlentities($health['symptoms'])?></li>
            <li>Notities: <?= htmlentities($health['notes'])?></li>
        </ul>
        <a class="button" href="index_doctor.php">Go back to the list</a>
    </section>
</main>
</body>
</html>
