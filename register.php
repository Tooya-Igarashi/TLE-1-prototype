<?php
/** @var mysqli $db */
require_once "includes/database.php";

// Get form data
$query = "SELECT * FROM users";
// Server-side validation
$result = mysqli_query($db, $query)
or die('Error '.mysqli_error($db).' with query '.$query);

$firstName = '';
$lastName = '';
$email = '';
$password = '';
$position = '';

// If data valid
if (isset($_POST['submit'])) {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $position = $_POST['position'];

    $errors = [];
    if ($firstName == ''){
        $errors['firstName'] = "first name cannot be empty";}

    if ($lastName == ''){
        $errors['lastName'] = "last name cannot be empty";}

    if ($position == ''){
        $errors['position'] = "position cannot be empty";}

    if ($email == ''){
        $errors['email'] = "email cannot be empty";}
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors['email'] = "email is invalid";}
}

if ($password == ''){
    $errors['password'] = "password cannot be empty";}
elseif (strlen($password) < 8){
    $errors['password'] = "password must be at least 8 characters";
}

// create a secure password, with the PHP function password_hash()
$securePassword = password_hash($password, PASSWORD_DEFAULT);
if (empty($errors)){
    echo $position, $firstName, $lastName, $email, $password;
    $query = "INSERT INTO `users`(`firstName`, `lastName`, `email`, `password`, `position`) 
            VALUES ('$firstName','$lastName', '$email','$securePassword', '$position')";
    // store the new user in the database.
    $result = mysqli_query($db, $query);
    // If query succeeded
    if ($result) {
        header("Location: login.php");
    }else {
        // If the query failed, show an error message
        echo "Error: " . mysqli_error($db);
    }
    // Redirect to login page

    // Exit the code
    exit();


}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css">
    <title>Registreren</title>
</head>
<body>

<section class="section">
    <div class="container content">
        <h2 class="title">Register With Email</h2>

        <section class="columns">
            <form class="column is-6" action="" method="post">

                <!-- First name -->
                <div class="field is-horizontal">
                    <div class="field-label is-normal">
                        <label class="label" for="firstName">First name</label>
                    </div>
                    <div class="field-body">
                        <div class="field">
                            <div class="control has-icons-left">
                                <input class="input" id="firstName" type="text" name="firstName" value="<?= htmlentities($firstName) ?>" />
                                <span class="icon is-small is-left"><i class="fas fa-user"></i></span>
                            </div>
                            <p class="help is-danger">
                                <?= $errors['firstName'] ?? '' ?>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Last name -->
                <div class="field is-horizontal">
                    <div class="field-label is-normal">
                        <label class="label" for="lastName">Last name</label>
                    </div>
                    <div class="field-body">
                        <div class="field">
                            <div class="control has-icons-left">
                                <input class="input" id="lastName" type="text" name="lastName" value="<?= htmlentities($lastName)?>" />
                                <span class="icon is-small is-left"><i class="fas fa-user"></i></span>
                            </div>
                            <p class="help is-danger">
                                <?= $errors['lastName'] ?? '' ?>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- position -->
                <div class="field is-horizontal">
                    <div class="field-label is-normal">
                        <label class="label" for="position">Account</label>
                    </div>
                    <div class="field-body">
                        <div class="field">
                            <div class="control has-icons-left">
                                <input type="radio" id="doctor" name="position" value="doctor">
                                <label for="doctor">Doktor</label>
                                <input type="radio" id="personal" name="position" value="personal">
                                <label for="personal">Persoonlijk</label>
                            </div>
                            <p class="help is-danger">
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Email -->
                <div class="field is-horizontal">
                    <div class="field-label is-normal">
                        <label class="label" for="email">Email</label>
                    </div>
                    <div class="field-body">
                        <div class="field">
                            <div class="control has-icons-left">
                                <input class="input" id="email" type="text" name="email" value="<?= htmlentities($email)?>" />
                                <span class="icon is-small is-left"><i class="fas fa-envelope"></i></span>
                            </div>
                            <p class="help is-danger">
                                <?= $errors['email'] ?? '' ?>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Password -->
                <div class="field is-horizontal">
                    <div class="field-label is-normal">
                        <label class="label" for="password">Password</label>
                    </div>
                    <div class="field-body">
                        <div class="field">
                            <div class="control has-icons-left">
                                <input class="input" id="password" type="password" name="password"/>
                                <span class="icon is-small is-left"><i class="fas fa-lock"></i></span>
                            </div>
                            <p class="help is-danger">
                                <?= $errors['password'] ?? '' ?>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Submit -->
                <div class="field is-horizontal">
                    <div class="field-label is-normal"></div>
                    <div class="field-body">
                        <button class="button is-link is-fullwidth" type="submit" name="submit">Register</button>
                    </div>
                </div>

            </form>
        </section>

    </div>
</section>
<a class="button mt-4" href="index.php">&laquo; Go back to the list</a>

</body>
</html>
