<?php

    require_once("templates/header.php");

    require_once("models/User.php");
    require_once("dao/UserDAO.php");

    $user = new User();

    $userDao = new UserDao($conn, $BASE_URL);

    $userData = $userDao->verifyToken(true);

    $fullName = $user->getFullName($userData);

    if($userData->image == "") {
        $userData->image = "user.png";
    }

?>

<div id="main-container" class="container-fluid edit-profile-page">

    <div class="offset-md-4 col-md-4">

        <form action="<?= $BASE_URL ?>user_process.php" method="POST" enctype="multipart/form-data">

            <input type="hidden" name="type" value="update">

            <div class="row">
                
                <div class="col-md-12" id="foto-container">
                    
                    <div id="profile-image-container" style="background-image: url('<?= $BASE_URL ?>img/users/<?= $userData->image ?>')"></div>
                    
                    <!-- <div class="form-group">
                        <label for="image">Foto:</label>
                        <input type="file" class="form-control-file" name="image">
                    </div> -->
                    
                    <div class="form-group">
                        <label for="bio">Sobre você:</label>
                        <textarea class="form-control" name="bio" id="bio" rows="5" placeholder="Conte quem você é, o que faz e onde trabalha..."><?= $userData->bio ?></textarea>
                    </div>

                    <input type="submit" class="btn card-btn" value="Alterar">
                    
                </div>
                
            </div>

        </form>

        <div class="row" id="change-password-container">
        
            <div class="col-md-12">

                <h2>Alterar Senha:</h2>

                <p class="page-description">Digite a nova senha e confirme, para alterar a sua senha:</p>

                <form action="<?= $BASE_URL ?>user_process.php" method="POST">

                    <input type="hidden" name="type" value="changepassword">

                    <div class="form-group">
                        <label for="password">Senha:</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Digite a sua nova senha">
                    </div>

                    <div class="form-group">
                        <label for="confirmpassword">Confirmação de senha:</label>
                        <input type="password" class="form-control" name="confirmpassword" id="confirmpassword" placeholder="Confirme a sua nova senha">
                    </div>

                    <input type="submit" class="btn card-btn" value="Alterar Senha">
                </form>

            </div>

        </div>

    </div>

</div>
    
    
<?php
    require_once("templates/footer.php")
?>