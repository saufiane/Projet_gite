<?php
require_once('libraries/database.php');

// if (is_uploaded_file($_FILES['photo']['tmp_name'])) {
//     echo "File ". $_FILES['photo']['name'] ." uploaded successfully.\n";
//     echo "Displaying contents\n";
//     // readfile($_FILES['photo']['tmp_name']);
//  } else {
//     echo "Possible file upload attack: ";
//     echo "filename '". $_FILES['photo']['tmp_name'] . "'.";
//  }
$uploaddir = "photo/";
$filename = $uploaddir . basename($_FILES['photo']['name']);
move_uploaded_file($_FILES['photo']['tmp_name'], $filename);
echo "<br>".$uploaddir." <br>".$filename;
$prenom = $_POST['prenom'];
$nom = $_POST['nom'];
$email = $_POST['email'];
$telephone = $_POST['telephone'];
$groupe = $_POST['groupe'];
$photo = $filename;

// $pdo = getPdo();
createUser($prenom, $nom, $email, $telephone, $groupe, $photo);
header('Location:index.php');
// $lastUser = readLastUser();
// print_r($lastUser);