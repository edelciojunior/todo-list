<?php

// Função para conectar ao banco de dados 

function dbConnect()
{
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $database = "todo_list";

    $conn = mysqli_connect($hostname, $username, $password, $database) or die("Database connection failed.");
    return $conn;
}

$conn = dbConnect();


// Função para checar se o e-mail é válido

function emailIsValid($email)
{
    $conn = dbConnect();
    $sql = "SELECT email FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($result);
    if ($count > 0) {
        return true;
    } else {
        return false;
    }
}

// Função para validar login

function checkLoginDetails($email, $password)
{
    $conn = dbConnect();
    $sql = "SELECT email FROM users WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($result);
    if ($count > 0) {
        return true;
    } else {
        return false;
    }
}

// Função para criar usuários

function createUser($email, $password)
{
    $conn = dbConnect();
    $sql = "INSERT INTO users (email, password) VALUES ('$email', '$password')";
    $result = mysqli_query($conn, $sql);
    return $result;
}


/* ====================================================== */
/* Função de carregamento da Head */
/* ====================================================== */

function getHead()
{
    $pageTitle = dynamicTitle();
    $output = '<!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>'. $pageTitle .' - Projeto</title>';

    echo $output;
}

// Função de exibição do Header

function getHeader()
{
    $output = '<header class="py-3 mb-4 border-bottom bg-white">
                <div class="container-fluid"> <!-- d-flex flex-wrap justify-content-center -->
                    <nav class="navbar  bg-light">
                        <div class="container-fluid">
                        <a class="navbar-brand" href="todos.php">Lista de Tarefas</a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarText">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="todos.php">Início</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="add-todo.php">Add Tarefa</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="logout.php">Logout</a>
                            </li>
                            </ul>
                            <!-- <span class="navbar-text">
                            Navbar text with an inline element
                            </span> -->
                        </div>
                        </div>
                    </nav>
                </div>
            </header>';

    echo $output;
}

// Função para limitar texto

function textLimit($string, $limit)
{
    if (strlen($string) > $limit) {
        return substr($string, 0, $limit) . "...";
    } else {
        return $string;
    }
}

// Função para selecionar as tarefas

function getTodo($todo)
{
    $output = '<div class="card shadow-sm">
        <div class="card-body">
            <h4 class="card-title">'. textLimit($todo['title'], 28) .'</h4>
            <p class="card-text">'. textLimit($todo['description'], 75) .'</p>
            <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                    <a href="view-todo.php?id='. $todo['id'] .'" class="btn btn-sm btn-outline-secondary">Visualizar</a>
                    <a href="edit-todo.php?id='. $todo['id'] .'" class="btn btn-sm btn-outline-secondary">Editar</a>
                </div>
                <small class="text-muted">'. $todo['date'] .'</small>
            </div>
        </div>
    </div>';

    echo $output;
}

// Função para definir título dinamicamente

function dynamicTitle()
{
    global $conn;
    $filename = basename($_SERVER["PHP_SELF"]);
    $pageTitle = "";
    switch ($filename) {
        case 'index.php':
            $pageTitle = "Início";
            break;

        case 'todos.php':
            $pageTitle = "Lista de Tarefas";
            break;

        case 'add-todo.php':
            $pageTitle = "Add Tarefa";
            break;

        case 'edit-todo.php':
            $pageTitle = "Editar Tarefa";
            break;

        case 'view-todo.php':
            $todoId = mysqli_real_escape_string($conn, $_GET["id"]);
            $sql1 = "SELECT * FROM todos WHERE id='{$todoId}'";
            $res1 = mysqli_query($conn, $sql1);
            if (mysqli_num_rows($res1) > 0) {
                foreach ($res1 as $todo) {
                    $pageTitle = $todo["title"];
                }
            }
            break;

        default:
            $pageTitle = "Lista de Tarefas";
            break;
    }

    return $pageTitle;
}