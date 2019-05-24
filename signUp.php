<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Inscription</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='signUp.css'>

</head>

<body>
    <form action="signUp_process.php" class="form" method="post">
        <label for="username"><br/>
            Username<br/>
            <input type="text" name="username" id="username" required>
        </label><br/>
        <label for="email">
            E-Mail<br/>
            <input type="email" name="email" id="email" required>
        </label><br/>

        <label for="password">
            Password<br/>
            <input type="password" name="password" id="password" required>
        </label><br/>

        <label for="password_repeat">
            Repeat password<br/>
            <input type="password" name="password_repeat" id ="password_repeat" required>
        </label><br/>
        <input type="submit" id="up" value="Sign Up">
    </form>
</body>

</html>
