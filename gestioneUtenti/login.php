<?php
    //impostazioni
    $redirect = $_SERVER["PHP_SELF"];
    include("../creazione_database/config.php");
    session_start();

    //acquisizione campi
    $username = $_POST["username"];
    $password = md5($_POST["password"]);

    //connessione al database
    $con = new mysqli($db_host, $db_user, $db_password, $db_name);
    if($con == false) die("Connessione fallita");

    //query login utente
    $sql = "SELECT username, pass, tipo FROM utenti WHERE username='$username' AND pass='$password'";
    $ris = $con->query($sql) or die("Query Fallita: " . $con->error);
    $row = $ris->fetch_array();

    //controllo esistenza dati
    if($row["username"] == $username && $row["pass"] == $password){
        $_SESSION["user"] = $username;
        if($row["tipo"] == "admin") {
            $con->close();
            header("Location: ../amministrazione.php");
            exit;
        }
        else {
            $con->close();
            header("Location: ../utente.php");
            exit;
        }
    } else {
        $con->close();
        $error_message = "Utente non trovato";
        echo "<script>alert('$error_message'); window.location.href = '$redirect';</script>";
        exit;
    }
?>