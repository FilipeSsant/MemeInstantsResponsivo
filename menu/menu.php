<?php

    $opcaoregmeme = '';

    //verificar se o usuário está na sessão para ser liberada a opção de registrar um meme
    if(isset($_SESSION['id_usuario'])){
        $opcaoregmeme = '<a href="registrar_meme.php">
                            <div class="opcoes_menu">
                                <span class="centralizar_texto">Add Meme</span>
                                <img src="img/icons/reg_meme.png" alt="">
                            </div>
                        </a>';
    }

?>
<div id="conteudo_menu">
    <a href="home.php">
        <div class="opcoes_menu">
            <span class="centralizar_texto">Home</span>
            <img src="img/icons/home.png" alt="">
        </div>
    </a>
    <?php
        //essa opcao so aparece qnd tem um usuario na sessao
        echo($opcaoregmeme);
    ?>
</div>
