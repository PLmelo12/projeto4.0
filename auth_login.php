<?php
    require_once("templates/header.php")
?>

<div id="main-container" class="container-fluid">

    <div class="col-md-12">

        <div class="row" id="auth-row">

            <div class="col-md-4" id="login-container">

                <h2>Entrar</h2>

                <form action="<?= $BASE_URL ?>auth_process.php" method="POST">

                    <input type="hidden" name="type" value="login">

                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>

                    <div class="form-group">
                        <label for="password">Senha</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>

                    <input type="submit" class="btn card-btn" value="Entrar">
                    
                    <p>Não tem login? <a href="<?= $BASE_URL ?>auth_cadastro.php">Cadastre-se</a></p>
                </form>

            </div>

        </div>

    </div>

</div>
    
<?php
    require_once("templates/footer.php")
?>