<?php
//on vérifie que notre formulaire ait bien été rempli
if (
    isset($_POST['username']) &&
    isset($_POST['email']) &&
    isset($_POST['password']) &&
    isset($_POST['password_repeat'])
) {
    //si le mot de passe est assez long
    if (mb_strlen($_POST['password']) > 6) {
        //on vérifie que la confirmation de mot de passe soit correcte
        if ($_POST['password'] == $_POST['password_repeat']) {
            //on vérifie que l'email envoyé soit bien au format email
            //filter_var permet de valider le format d'une chaine de caractères
            //ici on utilise le filtre FILTER_VALIDATE_EMAIL pour vérifier que la chaine soit au format email
            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $error = "Vous devez utiliser une adresse mail valide";
            } else {
                //on récupère nos données et on les stocke dans des variables
                $username = $_POST['username'];
                $email = $_POST['email'];
                //on hache le mot de passe à l'aide de la fonction password_hash() de PHP
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $sign_date = time();

                //on prépare la connexion a la bdd
                try {
                    $pdo = new PDO('mysql:host=localhost;dbname=membre;charset=utf8', 'souad', 'souad');
                } catch (PDOException $exception) {
                    die($exception->getMessage());
                }

                //on prépare notre requête insert into
                $query = $pdo->prepare('INSERT INTO user (username, email, password, sign_date) 
                                        VALUES (:username, :email, :password, :sign_date)');
                //on exécute notre requête avec nos paramètres de formulaire
                $query->execute([
                    ':username' => $username,
                    ':email' => $email,
                    ':password' => $password,
                    ':sign_date' => $sign_date,
                ]);
                //on récupère errorInfo pour connaître la nature de l'execution de notre requête
                //c'est à dire si tout s'est déroulé correctement ou si une erreur est survenue
                $query_error = $query->errorInfo(); //errorInfo() nous renvoie un tableau à 3 cases
                //la première case contient le code SQLSTATE décrivant l'état de la requête, sur 5 caractères
                //la deuxième case contient, si erreur il y a, le code d'erreur de SQL
                //la troisième case contient, si erreur il y a, le message d'erreur de SQL

                //si tout se passe bien, le tableau ressemblera à ['00000', '', '',]
                //c'est à dire que code SQLSTATE sera à zéro
                //si une erreur survient (erreur de duplicata par exemple) ["23000", 1062, 'erreur duplicata'];

                //on teste si une erreur est survenue, donc si le code SQLSTATE n'est PAS 00000
                if ($query_error[0] != "00000") {
                    //si le code d'erreur est celui du duplicata
                    if ($query_error[1] == 1062) {
                        $error = "Un utilisateur existe déjà avec ce pseudo ou email";
                    } else {
                        //sinon on plante la page en envoyant le message d'erreur
                        die("Erreur dans la connexion à la base de données");
                    }
                }
            }
        } else {
            $error = "Les mots de passes doivent être identiques";
        }
    } else {
        $error = "Erreur, mot de passe trop court, 8 caractères minimum";
    }
} else {
    $error = "Erreur, formulaire incomplet.";
}

if (isset($error)) {
    //si une erreur existe alors on renvoie sur la page d'inscription
    //avec un message d'erreur
    header('Location: signUp.php?error=' . $error);
} else {
    //sinon on envoie l'utilisateur vers le formulaire de connexion
    header('Location: signIn.php');
}
?>
