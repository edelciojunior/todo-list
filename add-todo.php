<?php
include "includes/config.php";
session_start();
if (!isset($_SESSION["user_email"])) {
    header("Location: index.php");
    die();
}

$msg = "";

if (isset($_POST["addTodo"])) {
    $title = mysqli_real_escape_string($conn, $_POST["title"]);
    $desc = mysqli_real_escape_string($conn, $_POST["desc"]);

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
    $sql = null;

    // Inserindo a tarefa
    $sql = "INSERT INTO todos (title, description, user_id) VALUES ('$title', '$desc', '$user_id')";
    $res = mysqli_query($conn, $sql);
    if ($res) {
        $_POST["title"] = "";
        $_POST["desc"] = "";
        $msg = "<div class='alert alert-success'>Tarefa criada com sucesso!.</div>";
    } else {
        $msg = "<div class='alert alert-danger'>Falha ao criar tarefa.</div>";
    }
}

?>


<!doctype html>
<html lang="pt-br">

<head>
    <?php getHead(); ?>
</head>

<body class="bg-light">
    <?php getHeader(); ?>

    <div class="container py-5">
        <div class="row">
            <div class="col-md-5 mx-auto">
                <div class="card bg-white rounded border shadow">
                    <div class="card-header px-4 py-3">
                        <h4 class="card-title">Adicionar Tarefa</h4>
                    </div>
                    <div class="card-body p-4">
                        <?php echo $msg; ?>
                        <form action="" method="POST">
                            <div class="mb-3">
                                <label for="title" class="form-label">Título</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="" value="<?php if (isset($_POST["addTodo"])) {
                                                                                                                                                    echo $_POST["title"];
                                                                                                                                                } ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="desc" class="form-label">Descrição</label>
                                <textarea class="form-control" id="desc" name="desc" rows="3" required><?php if (isset($_POST["addTodo"])) {
                                                                                                            echo $_POST["title"];
                                                                                                        } ?></textarea>
                            </div>
                            <div>
                                <button type="submit" name="addTodo" class="btn btn-primary me-2">Adicionar</button>
                                <button type="reset" class="btn btn-danger">Limpar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>