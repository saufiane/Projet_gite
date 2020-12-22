<?php
$message = $_GET['message'];
$image = "<img src=photo/2.png width=100 height=100 alt=image>";
require_once('libraries/database.php');
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire saisie de data</title>
</head>

<body>
    <!---  Formulaire method post send $var to recept.php 
with simple type en name only no more need today-->
    <form action="creation.php" method="post" enctype="multipart/form-data">
        <input type="text" name="prenom"><br>
        <input type="text" name="nom"><br>
        <input type="email" name="email"><br>
        <input type="text" name="telephone"><br>
        <input type="text" name="groupe"><br>
        <input type="file" name="photo"><br>
        <input type="submit" name="submit" value="Créé">
    </form>
    <?php
    echo $message;
     $users = readUsers();
$users2 = array_reverse($users);
        foreach ($users2 as $key => $value) {

            echo "<br>".$value['prenom']."<a href='supprimer.php?id=".$value['id']."'>Supprimer</a>";
            echo "<br>".$value['nom'];
            echo "<br>".$value['email'];
            echo "<br>".$value['telephone'];
            echo "<br>".$value['groupe']."<br>";
            if (file_exists($value['photo'])){
                echo "<br>".$value['nom']."<a href='maj.php?id=".$value['id']."&prenom=".$value['prenom']."&nom=".$value['nom']."&email=".$value['email']."&telephone=".$value['telephone']."&groupe=".$value['groupe']."&photo=".$value['photo']."&id=".$value['id']."' >
               <img src=".$value['photo']." width=200 height=200 alt=image> </a>";
            echo "<br><br>";
            }else {echo "<br>".$value['nom']."<a href='maj.php?id=".$value['id']."&prenom=".$value['prenom']."&nom=".$value['nom']."&email=".$value['email']."&telephone=".$value['telephone']."&groupe=".$value['groupe']."&photo=".$value['photo']."&id=".$value['id']."' >
                ".$image. " </a>";
             echo "<br><br>";}

    }

    ?>
</body>

</html>