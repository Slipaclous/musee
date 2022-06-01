<?php
session_start();
if (isset($_SESSION['username'])){
    header('LOCATION:dashboard.php');
}

if(isset($_POST['username'])){
    
    if(empty($_POST['username']) OR empty($_POST['password'])){
        $error="Veuillez remplir correctement le formulaire";
        
        
    }else{
        $username = htmlspecialchars($_POST['username']);
        require "../connexion.php";
        $req = $bdd->prepare("SELECT * FROM users WHERE login =?");
        $req->execute([$username]);
        $don = $req->fetch();
        if(!$don)
        {
            $error="Votre login n'est pas correct";
            
        }else{
            if(password_verify($_POST['password'],$don['password'])){
                $_SESSION['username']=$don['login'];
                $req->closeCursor();
                header("LOCATION:dashboard.php");
                
            }else{
                $error="votre mot de passe de correspond pas";
            }
        }
        $req->closeCursor();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Connexion à l'administration<</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-4 offset-4">
                <h1>Connexion à l'administration</h1>
                <form action="index.php" method="POST">
                    <div class="my-3">
                        <label for="username">Login: </label>
                        <input type="text" name="username" id="username" class="form-control">
                    </div>
                    <div class="my-3">
                        <label for="password">Password: </label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>
                    <div class="my-3">
                        <input type="submit" value="Connexion" class="btn btn-primary">
                    </div>
                    <?php 
                        if(isset($error))
                        {
                            echo "<div class='alert alert-danger'>".$error."</div>";
                        }
                    ?>
                </form>
            </div>
        </div>
    </div>

</body>
</html>