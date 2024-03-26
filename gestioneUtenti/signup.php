<?php
    //impostazioni
    $redirect = $_SERVER["PHP_SELF"];
    include("../creazione_database/config.php");

    //lettura campi
    $username = $_POST["username"];
    $pass1 = md5($_POST["password1"]);
    $pass2 = md5($_POST["password2"]);

    //connessione al database
    $con = new mysqli($db_host, $db_user, $db_password, $db_name);
    if($con == false) die("Connessione Fallita");

    //controllo inserimento campi
    $sql = "SELECT username FROM utenti";
    $ris = $con->query($sql) or die("Query Fallita");

    if($username == ""){
        $con->close();
        $error_message = "Il Campo Utente Non Può Essere Vuoto";
        echo "<script>alert('$error_message'); window.location.href = '$redirect';</script>";
        exit;
    }

    if($pass1 == "" || $pass2 == ""){
        $con->close();
        $error_message = "Il Campo Password Non Può Essere Vuoto";
        echo "<script>alert('$error_message'); window.location.href = '$redirect';</script>";
        exit;
    }

    if($pass1 != $pass2){
        $con->close();
        $error_message = "Il Campi Password Non Coincidono";
        echo "<script>alert('$error_message'); window.location.href = '$redirect';</script>";
        exit;
    }

    while($row = $ris->fetch_assoc()){
        if($row["username"] == $username){
            $con->close();
            $error_message = "Utente già Esistente";
            echo "<script>alert('$error_message'); window.location.href = '$redirect';</script>";
            exit;
        }
    }

    //registrazione utente
    $sql = "INSERT INTO utenti(username, pass, tipo) VALUES('$username', '$pass1', 'user')";
    $ris = $con->query($sql) or die("Query Fallita");
    $con->close();
    header("Location: login.php");
    exit;
?>