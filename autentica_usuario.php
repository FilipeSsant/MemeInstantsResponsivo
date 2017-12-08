<?php

    session_start();

    //inclui a conexao
    include_once("connection/conexao.php");

    //deixa as variaveis nulas para que nao ocorra nenhum erro visivel a o usuario
    $nome = "";

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>MemeInstants</title>
        <link rel="stylesheet" href="css/style.css">
        <link href="fonte" rel="stylesheet">
        <script type="text/javascript" src="jquery/jquery-2.2.4.js" ></script>
        <script>

            $(document).ready(function(){

                //pega altura máxima da tela para assim dar um css em uma div
                var altura = $(window).height();
                $("#conteudo_menu").css({"height":""+altura+""});

                <?php include_once("funcoes/previewfoto.js"); ?>

            });

            <?php include_once("funcoes/menu.js"); ?>

        </script>
    </head>
    <body>
        <!--Fundo Transparente-->
        <div id="fundo_transparente" onClick="fecharPopUps();">
        </div>
        <div id="esqueleto">
            <!--menu-->
            <?php include_once("menu/menu.php"); ?>
            <!--header-->
            <?php
                include_once("header/header.php");

                //faz um isset caso o botão seja clicado
                if(isset($_POST['btn_logar'])){

                    //resgata os valores
                    $login = $_POST['login'];
                    $senha = $_POST['senha'];

                    if($login == "" || $senha == ""){
                        ?>
                            <script>
                                swal({
                                  title: "Preencha todos os campos :/",
                                  text: "Um ou os dois campos se encontram vazios.",
                                  type: "error",
                                  icon: "error",
                                  button: {
                                             text: "Ok",
                                           },
                                  closeOnEsc: true,
                                });
                            </script>
                        <?php
                    }else{

                        $sql = "select * from tbl_usuario where login = '".$login."' and senha = '".$senha."'";

                        $select = mysql_query($sql);

                        if($rs=mysql_fetch_array($select)){
                            $_SESSION['id_usuario'] = $rs['id_usuario'];
                            ?>
                                <script>
                                    swal({
                                      title: "Usuário Logado com Sucesso :)",
                                      text: "Você será redirecionado para a página home.",
                                      type: "success",
                                      icon: "success",
                                      button: {
                                                 text: "Ok",
                                             },
                                      closeOnEsc: true,
                                    });
                                    //Voltar para o php sem dados na url
                                    setTimeout(function(){
                                        window.location = "home.php";
                                    }, 2000);
                                </script>
                            <?php
                        }else{
                            ?>
                                <script>
                                    swal({
                                      title: "Usuário ou Senha incorretos :/",
                                      text: "Verifique os dados.",
                                      type: "error",
                                      icon: "error",
                                      button: {
                                                 text: "Ok",
                                               },
                                      closeOnEsc: true,
                                    });
                                </script>
                            <?php
                        }
                    }
                }

                if(isset($_POST['btn_cadastrar'])){
                    //resgata os valores
                    $nome = $_POST['nome'];
                    $email = $_POST['email'];
                    $login = $_POST['loginc'];
                    $senha = $_POST['senhac'];

                    //pasta destino
                    $uploaddir = "arquivos/user/";
                    //pega o nome do arquivo e o arquivo em si e deixa em minusculo
                    $arquivo = strtolower(basename($_FILES['file_foto']['name']));
                    //junta o nome do arquivo com a pasta de destino
                    $uploadfile = $uploaddir.$arquivo;

                    //o comando strstr serve para pegar palavras similares ao igualado na frente
                    if((strstr($uploadfile, '.jpg')) || (strstr($uploadfile, '.jpeg')) || (strstr($uploadfile, '.gif')) || (strstr($uploadfile, '.png'))){
                        //move_uploaded_file serve para mover os arquivos para a pasta local
                        if(move_uploaded_file($_FILES['file_foto']['tmp_name'], $uploadfile)){
                            $sql = "insert into tbl_usuario (imagem, nome_usuario, login, senha, email)";
                            $sql = $sql." values('".$uploadfile."','".$nome."', '".$login."', '".$senha."', '".$email."')";

                            if(mysql_query($sql)){

                                $idusuario = mysql_insert_id();

                                $_SESSION['id_usuario'] = $idusuario;

                                ?>
                                    <script>
                                        swal({
                                          title: "Usuário Cadastrado com Sucesso :)",
                                          text: "Você será redirecionado para a página home.",
                                          type: "success",
                                          icon: "success",
                                          button: {
                                                     text: "Ok",
                                                 },
                                          closeOnEsc: true,
                                        });
                                        //Voltar para o php sem dados na url
                                        setTimeout(function(){
                                            window.location = "home.php";
                                        }, 3000);
                                    </script>
                                <?php
                            }else{
                                ?>
                                    <script>
                                        swal({
                                          title: "Houve um erro com nosso banco de dados :(",
                                          text: "".die(mysql_error())."",
                                          type: "error",
                                          icon: "error",
                                          button: {
                                                     text: "Ok",
                                                   },
                                          closeOnEsc: true,
                                        });
                                    </script>
                                <?php
                            }

                        }else{
                            ?>
                                <script>
                                    swal({
                                      title: "Um dos arquivos não foram enviados!",
                                      text: "",
                                      type: "error",
                                      icon: "error",
                                      button: {
                                                 text: "Ok",
                                               },
                                      closeOnEsc: true,
                                    });
                                </script>
                            <?php
                        }
                    }else{
                        ?>
                            <script>
                                swal({
                                  title: "Extensão Inválida!",
                                  text: "Verifique o formato do arquivo.",
                                  type: "error",
                                  icon: "error",
                                  button: {
                                             text: "Ok",
                                           },
                                  closeOnEsc: true,
                                });
                            </script>
                        <?php
                    }

                }

            ?>
            <div class="conteudo_login">
                <div class="titulo_pg">
                    <span class="centralizar_texto">Entre com sua conta</span>
                </div>
                <div class="conteudo_boxlogin">
                    <form action="autentica_usuario.php" id="form_login" method="post">
                        <!--inputs-->
                        <input class="input_texto" type="text" name="login" placeholder="Login"/><br>
                        <input class="input_texto" type="password" name="senha" placeholder="Senha"/><br>
                        <!--submit-->
                        <button id="bntsubmit" type="submit" name="btn_logar">
                            Entrar
                        </button>
                    </form>
                </div>
            </div>
            <div class="conteudo_cadastro">
                <div class="titulo_pg">
                    <span class="centralizar_texto">Cadastre sua conta</span>
                </div>
                <div class="conteudo_boxcadastro">
                    <form id="form_login" method="post" enctype="multipart/form-data">
                        <!--cadastro foto-->
                        <div id="div_foto">
                            <div id="foto_preview">
                                <img id="imagem" src="" alt="">
                            </div>
                            <div id="botao_addfoto">
                                <label for="btn_img" class="centralizar_texto">
                                    <img src="img/icons/foto.png" alt="">
                                </label>
                                <input id="btn_img" type="file" name="file_foto"/>
                            </div>
                        </div>
                        <!--inputs-->
                        <input id="primeiro_input" class="input_texto" type="text" name="nome" maxlength="45" placeholder="Nome"/><br>
                        <input class="input_texto" type="email" name="email" placeholder="E-mail" maxlength="45" required/><br>
                        <input class="input_texto" type="text" name="loginc" placeholder="Login" maxlength="20" required/><br>
                        <input class="input_texto" type="password" name="senhac" placeholder="Senha" maxlength="45" required/><br>
                        <!--submit-->
                        <button id="bntsubmit" type="submit" name="btn_cadastrar">
                            Cadastrar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
