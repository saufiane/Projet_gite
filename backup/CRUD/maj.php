<?php
require_once('libraries/database.php');
// reception des variables POST du formulaire
$id = trim($_GET['id']);
$prenom = $_GET['prenom'];
$nom = $_GET['nom'];
$email = $_GET['email'];
$telephone = $_GET['telephone'];
$groupe = $_GET['groupe'];
$photo = $_GET['photo'];
/***************************************************** */
@$uploaddir = 'photo/';
@$uploadfile = $uploaddir . basename($_FILES['photo']['name']);
echo '<pre>';
move_uploaded_file(@$_FILES['photo']['tmp_name'], @$uploadfile);
/****************************************************** */
// si id est define & est un numeric dans _POST
if (isset( $_POST['id'] ) && is_numeric( $_POST['id'] ) )
   {
    $id = $_POST['id'];
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $groupe = $_POST['groupe'];
    $photo = $uploadfile;
    updateUser($prenom, $nom, $email, $telephone, $groupe, $photo, $id);
    header('Location:index.php');
} 
else
    echo "/***********************************************************************************************************/";

 $majUser = readLastUser();
 print_r($majUser.'<br>');
 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value=<?=$id?>>
        <input type="text" name="prenom" value=<?=$prenom?>>
        <input type="text" name="nom" value=<?=$nom?>>
        <input type="text" name="email" value=<?=$email?>>
        <input type="text" name="telephone" value=<?=$telephone?>>
        <input type="text" name="groupe" value=<?=$groupe?>>
        <input type="file" name="photo" value=<?=$photo?>><br>
        <input type="submit" value="MAJ">
    </form>
    <?php  echo "/***********************************************************************************************************/";?>
</body>
</html>