<?php
    require_once("templates/header.php")
?>

<div id="main-container" class="container-fluid">

    <div class="col-md-12">

        <div class="row" id="auth-row">

            <div class="col-md-4" id="register-container">

                <h2>Criar conta</h2>

                <form action="<?= $BASE_URL ?>auth_process.php" method="post">

                    <input type="hidden" name="type" value="register">
                    
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" class="form-control" id="email" name="email" autocomplete="on">
                    </div>
                    
                    <div class="form-group">
                        <label for="name">Nome Completo</label>
                        <input type="text" class="form-control" id="name" name="name" autocomplete="on">
                    </div>
                    
                    <div class="form-group">
                        <label for="data_nasc">Data de Nascimento</label>
                        <input type="date" class="form-control" id="data_nasc" name="data_nasc" autocomplete="on">
                    </div>
                    
                    <div class="form-group">
                        <label for="mae">Nome da mãe</label>
                        <input type="text" class="form-control" id="mae" name="mae" autocomplete="on">
                    </div>
                    
                    <div class="form-group">
                        <label for="cpf">CPF</label>
                        <input type="text" class="form-control" id="cpf" name="cpf" autocomplete="on" maxlength="11">
                    </div>


                    <p>Gênero:</p>

                    <div class="form-group">
                        <input style="margin-right: 5px;" class="form-check-input" type="radio" name="genero" id="genero" value="Masculino" checked>
                        <label for="genero">Masculino</label>
                    </div>

                    <div class="form-group">
                        <input style="margin-right: 5px;" class="form-check-input" type="radio" name="genero" id="genero" value="Feminio" checked>
                        <label for="genero">Feminino</label>
                    </div>

                    <div class="form-group">
                        <input style="margin-right: 5px;" class="form-check-input " type="radio" name="genero" id="genero" value="Discreto" checked>
                        <label for="genero">Prefiro não dizer</label>
                    </div>  

                    <br>
                    
                    <div class="form-group">
                        <label for="celular">Número de Celular</label>
                        <input type="text" class="form-control" id="celular" name="celular" autocomplete="on">
                    </div>

                    <div class="form-group">
                        <label for="cep">CEP</label>
                        <input type="text" class="form-control" id="cep" name="cep" autocomplete="on">
                    </div>

                    <div class="form-group">
                        <label for="bairro">Bairro</label>
                        <input type="text" class="form-control" id="bairro" name="bairro" autocomplete="on">
                    </div>

                    <div class="form-group">
                        <label for="municipio">Município</label>
                        <input type="text" class="form-control" id="municipio" name="municipio" autocomplete="on">
                    </div>

                    <div class="form-group">
                        <label for="estado">Estado</label>
                        <input type="text" class="form-control" id="estado" name="estado" autocomplete="on">
                    </div>

                    <div class="form-group">
                        <label for="endereco">Endereço</label>
                        <input type="text" class="form-control" id="endereco" name="endereco" autocomplete="on">
                    </div>

                    <div class="form-group">
                        <label for="numero">Número</label>
                        <input type="text" class="form-control" id="numero" name="numero" autocomplete="on">
                    </div>

                    <div class="form-group">
                        <label for="password">Senha</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>

                    <div class="form-group">
                        <label for="confirmpassword">Confirmar Senha</label>
                        <input type="password" class="form-control" id="confirmpassword" name="confirmpassword">
                    </div>

                    <input type="submit" class="btn card-btn" value="Cadastrar">
                    <input type="reset" class="btn card-btn" value="Limpar">

                </form>

            </div>

        </div>

    </div>

</div>

<script src="../projeto4.0/js/validação.js"></script>
    
<?php
    require_once("templates/footer.php")
?>