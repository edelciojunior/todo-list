<?php
include "includes/config.php";
session_start();

if (isset($_SESSION["user_email"])) {
    header("Location: todos.php");
    die();
}
?>

<!doctype html>
<html lang="pt-br">

<head>
    <?php getHead(); ?>
</head>

<body>
    <div class="container col-xl-10 col-xxl-8 px-4 py-5">
        <div class="row align-items-center g-lg-5 py-5">
            <div class="col-lg-7 text-center text-lg-start">
                <h1 class="display-4 fw-bold lh-1 mb-3">APP Lista de Tarefas</h1>
                <p class="col-lg-10 fs-4 lead">Insira seu e-mail e senha para realizar o login em sua conta ou para realizar um novo cadastro.</p>
            </div>
            <div class="col-md-10 mx-auto col-lg-5">
                <form action="login.php" method="POST" class="p-4 p-md-5 border rounded-3 bg-light">
                    <div class="form-floating mb-3">
                        <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com">
                        <label for="floatingInput">E-mail</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password">
                        <label for="floatingPassword">Senha</label>
                    </div>
                    <button name="submit" class="w-100 btn btn-lg btn-primary" type="submit">Entrar</button>
                    <hr class="my-4">
                    <small class="text-muted">APP Lista de Tarefas - 2023</small>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>