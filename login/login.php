<!DOCTYPE html>

<?php


session_start();

///////////////////ERROR MANAGEMENT//////////////////////////////
$error = [];
$form_valid = false;

if (isset($_POST) && isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["password_confirmation"])) {
    click_summit();
}

function click_summit()
{
    //Stock value
    global $error, $form_valid, $user_created;
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $password = htmlspecialchars($_POST["password"]);
    $confirmation = htmlspecialchars($_POST["password_confirmation"]);

    //Check Errors
    if (!preg_match('/[A-Z]?[a-z-\'éèêïîôùàâ]{3,10}/', $name)) {
        $error["error_name"] =  "Your name is not valid, try again ;)\n";
    }
    if (!preg_match('/[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}/', $email)) {
        $error["error_email"] =  "Your email is not valid, please check your email.\n";
    }
    if ($password !== $confirmation) {
        $error["error_password"] =  "Your password and your confirmation password are not similar.\n";
    }

    //Form valid
    if (count($error) === 0) {
        $form_valid = true;
        $user_created = true;

        //Store in Json and encode
        $password_hash = md5($password);
        $users = array(
            "name"    => $name,
            "email"    => $email,
        );
        $file_json = "login.json";
        $json = json_encode($users);
        file_put_contents($file_json, $json);
    }
}




?>

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- FontAwesome Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- CSS Links -->
    <link href="./login.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="footer.css">


    <title>login</title>

</head>

<body class="page">
    <p><?php
        if (isset($_POST["name"])) {
            echo "Hello " . htmlspecialchars($_POST["name"]) . " ! <br> Nice to see you :)";
        } else {
            echo "Hello you";
        }
        ?></p>

    <div class="incsription_form">
        <form action="inscription.php" method="post" name="Inscription" id="form" class="form_input">
            <!-- Name -->
            <label for="name"> Your Name :</label></br>
            <input type="text" name="name" placeholder="Jim" value="<?PHP if (isset($_POST["name"])) echo htmlspecialchars($_POST['name']); ?>" required></br>
            <p span style="color: red;"><?= isset($error["error_name"]) ? $error["error_name"] : ""; ?></p>
            <!-- Email -->
            <label for="email"> Your Email :</label></br>
            <input type="text" name="email" placeholder="Jim@hgmail.com" value="<?PHP if (isset($_POST["email"])) echo htmlspecialchars($_POST['name']); ?>" required></br>
            <p span style="color: red;"><?= isset($error["error_email"]) ? $error["error_email"] : ""; ?></p>
            <!-- Password -->
            <label for="password"> Your Password:</label></br>
            <input type="password" name="password" placeholder="*****" required></br>
            <p span style="color: red;"><?= isset($error["error_password"]) ? $error["error_password"] : ""; ?></p>
            <!-- Confirmation -->
            <label for="password_confirmation"> Your Password confirmation:</label></br>
            <input type="password" name="password_confirmation" placeholder="*****" required></br>
            <p span style="color: red;"><?= isset($error["error_password"]) ? $error["error_password"] : ""; ?></p>
        </form>

        <!-- Submit -->
        <button type="submit" name="submit" form="form" value="submit" class="button">Submit</button>

        <p class="form_ok">
            <?php if ($form_valid) {
                echo "<br>Welldone ! <br><br>
                    You have validated your form ! See you soon :)";
            } ?>
        </p>
    </div>


</body>

</html>