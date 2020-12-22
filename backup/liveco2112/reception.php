<?php
$prenom = $_POST['prenom'];
$nom = $_POST['nom'];
$age = $_POST['age'];

require_once('data_class.php');

$data= new data($prenom,$nom,$age);
$data->affiche($prenom,$nom,$age);
foreach ($data as  $value) {
    # code...
    var_dump('<br>'.$value.'<br>');
    var_dump($data);
    $data->affiche($data->prenom,$data->nom,$data->age,);
}

