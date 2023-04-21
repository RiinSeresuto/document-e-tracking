<?php
include("./connection/db.php");

if(isset($_POST['submit'])):
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    $get_user_query = "SELECT `id`,`email`,`password`,`superAdmin` FROM `users` WHERE `email` = '$email'";
    $result_user_query = mysqli_query($db, $get_user_query);

    if(mysqli_num_rows($result_user_query) == 1) {
        // Verify password
        $row = mysqli_fetch_assoc($result_user_query);

        if(password_verify($password, $row['password'])) {
            // Login successful
            $_SESSION['id'] = $row['id'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['isSuperAdmin'] = $row['superAdmin'];

            header('Location: ./');
            exit();
        } else {
            // Invalid password
            $error = 'Invalid username or password';
        }
    } else {
        // User does not exist
        $error = 'Invalid username or password';
      }
endif;
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Signin</title>

        <link href="./assets/css/bootstrap.min.css" rel="stylesheet" />
        <link href="./assets/css/signin.css" rel="stylesheet" />
    </head>
    <body class="text-center">
        <main class="form-signin w-100 m-auto">
            <form method="POST">
                <img class="signin-logo" src="./assets/img/DMMMSU-Logo-white-small.png" alt="DMMMSU Logo"/>
                <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

                <div class="form-floating">
                    <input type="email" class="form-control" id="email" name="email" placeholder="name@email.com" required />
                    <label for="email">Email</label>
                </div>
                <div class="form-floating">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required />
                    <label for="password">Password</label>
                </div>
                <?php if(isset($error)): ?>
                    <div class="alert alert-danger">
                        <?php echo $error ?>
                    </div>
                <?php endif; ?>
                <button class="w-100 btn btn-lg btn-primary" type="submit" name="submit">
                    Sign in
                </button>
            </form>
        </main>
    </body>
</html>
