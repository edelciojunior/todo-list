<?php
include "includes/config.php";
session_start();
if (!isset($_SESSION["user_email"])) {
    header("Location: index.php");
    die();
}

if (isset($_GET["id"])) {
    $todoId = mysqli_real_escape_string($conn, $_GET["id"]);

    // Consulta o usuário conforme e-mail cadastrado
    $sql = "SELECT id FROM users WHERE email='{$_SESSION["user_email"]}'";
    $res = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($res);
    if ($count > 0) {
        $row = mysqli_fetch_assoc($res);
        $user_id = $row["id"];
    } else {
        $user_id = 0;
    }

    //Deletar Tarefa
    $sql = "DELETE FROM todos WHERE id='{$todoId}' AND user_id='{$user_id}'";
    mysqli_query($conn, $sql);
    header("Location: todos.php");
} else {
    header("Location: todos.php");
}

?>