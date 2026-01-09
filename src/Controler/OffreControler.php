<?php
namespace App\Service;
session_start();



if(isset($_POST['submit'])){
    header('location: ../views/dashboard-livreur.php');
    exit;
}
 if(isset($_POST['price'])){
    echo "<script>alert(\"votre prix est vide\")</script>";
    exit;
 }
 if(isset($_POST['duration'])){
    echo "<script>alert(\"votre duration est vide\")</script>";
    exit;
 }
 if(isset($_POST['option'])){
    echo "<script>alert(\"votre option est vide\")</script>";
    exit;
 }
 if(isset($_POST['vehicle'])){
    echo "<script>alert(\"votre vehicule est vide\")</script>";
    exit; 
 }


