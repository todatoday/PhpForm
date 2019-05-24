<?php 

if(isset($_POST['user']) && isset($_POST['password']))
{
    $user = $_POST['user'];
    $password = $_POST['password'];

try{

    $pdo = new PDO(
            'mysql:host=localhost;dbname=membre;charset=utf8',
             'souad',
             'souad'
            );
 } catch (PDOException $exception) {
            die($exception->getMessage());
     }
    }

$query = $pdo->prepare('SELECT * FROM user WHERE username = :user OR email = :user');
$query->execute([
    ":user" => $user,
    ]);

    if($data = $query->fetch()){
        if(password_verify($password, $data['password'])){
            session_start();
            $_SESSION['user_id'] = $data['id']; //on stoclk l'in de l'utilisateur
            $_SESSION['sign_in_time'] = time(); //on stock l'heure de la connesion
            header('Location: userPage.php'); //on envoie l'user vers son espace membre
        }
    }

  
      
?>
