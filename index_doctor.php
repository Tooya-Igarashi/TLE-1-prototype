<?php
global $db;
require_once 'includes/connection.php';

$query = "SELECT * FROM health";

$result = mysqli_query($db, $query)
or die('Error '.mysqli_error($db).' with query '.$query);

$health = [];

while($row = mysqli_fetch_assoc($result))
{
    $health[] = $row;
}
mysqli_close($db);
?>
<!doctype html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Game completion</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css">
</head>
<body>
<nav class="navbar">
    <a class="navbar-item" href="register.php">Register</a>
    <a class="navbar-item" href="login.php">Log in</a>
    <a class="navbar-item" href="logout.php">Log out</a>
</nav>
<header class="hero is-info">
    <div class="hero-body">
        <p class="title">Good morning Doctor</p>
        <p class="subtitle">Overview of your patients data</p>
    </div>
</header>
<main class="container">
    <section class="section">
        <a class="button mt-4" href="create.php">Create new game list</a>

        <table class="table mx-auto">
            <thead>
            <tr>
                <th>ID</th>
                <th>Naam</th>
                <th>Lengte</th>
                <th>Gewicht</th>
                <th>Bloeddruk</th>
                <th>Hartslag</th>
                <th>Bloed suiker</th>
                <th>Symptomen</th>
                <th>Notities</th>
                <th>Details</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <td colspan="6">&copy; My Collection</td>
            </tr>
            </tfoot>
            <tbody>
            <?php
            foreach ($health as $i => $healthy) {?>
                <tr>
                    <td><?= ($i + 1) ?></td>
                    <td> <?=htmlentities($healthy['name'])?> </td>
                    <td> <?=htmlentities($healthy['height'])?> </td>
                    <td> <?=htmlentities($healthy['weight'])?> </td>
                    <td> <?=htmlentities($healthy['blood_pressure'])?>H </td>
                    <td> <?=htmlentities($healthy['heart_rate'])?> </td>
                    <td> <?=htmlentities($healthy['blood_sugar'])?> </td>
                    <td> <?=htmlentities($healthy['symptoms'])?> </td>
                    <td> <?=htmlentities($healthy['notes'])?> </td>
                    <td> <a href="details.php?id=<?=$healthy['id']?>">Details</a> </td>
                </tr>
            <?php }?>
            </tbody>
        </table>
    </section>
</main>
</body>
</html>