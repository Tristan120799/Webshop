<?php

// STAP 1 & 8 - Is het een POST-request, nee dan redirect naar fout page (laatste is OPTIONEEL)
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
   // The request is using the POST method
   header('Status: 405 Method Not Allowed');   // Geen fout page dus
   exit();
}
// STAP 2 - Ophalen ingetikte gegevens in vars en beveiligen
$firstname = trim(htmlentities($_POST['firstname']));
$prefixes = trim(htmlentities($_POST['prefixes']));
$lastname = trim(htmlentities($_POST['lastname']));
$street = trim(htmlentities($_POST['street']));
$house_number = trim(htmlentities($_POST['housenumber']));
$addition = trim(htmlentities($_POST['addition']));
$zipcode = trim(htmlentities($_POST['zipcode']));
$city = trim(htmlentities($_POST['city']));
$email = trim(htmlentities($_POST['email']));
$password = trim($_POST['password']);
$password_confirm = trim($_POST['password_confirm']);

// TODO: STAP 3 - Controle op verplichte velden, redirecten als niet alles is ingevuld naar registratie met melding

// TODO: STAP 4 & 9 - Controle of e-mail al in DB zit, ja dan redirect naar registratie met melding

// STAP 5 - Gegevens opslaan in DB
require_once '../Database/Database.php';

$sql = "
   INSERT INTO `customers`(`firstname`, `prefixes`, `lastname`, `street`, `house_number`, `addition`, `zipcode`, `city`, `email`, `password`)
   VALUES(:firstname, :prefixes, :lastname, :street, :house_number, :addition, :zipcode, :city, :email, :password)
";
$placeholders = [
   ':firstname' => $firstname,
   ':prefixes' => $prefixes,
   ':lastname' => $lastname,
   ':street' => $street,
   ':house_number' => $house_number,
   ':addition' => $addition,
   ':zipcode' => $zipcode,
   ':city' => $city,
   ':email' => $email,
   ':password' => password_hash($password, PASSWORD_DEFAULT),
];

if(empty($firstname || $lastname || $street || $house_number || $zipcode || $city || $email || $password)) {
    header('Location: ../../register.php');
    die();
}

Database::query($sql, $placeholders);

header('Location: ../../index.php');
exit();
// TODO: STAP 6 & 7 - Verificatie mail sturen en redirecten naar index met melding (OPTIONEEL)

