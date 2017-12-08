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
                if(isset($_POST['btn_cadastrar'])){

                    //resgata os valores
                    $nome = $_POST['nome_meme'];

                    //pasta destino
                    $uploaddirimg = "arquivos/img/";
                    $uploaddiraudio = "arquivos/audio/";

                    //pega o nome do arquivo e o arquivo em si e deixa em minusculo
                    $arquivoimg = strtolower(basename($_FILES['file_foto']['name']));
                    $arquivoaudio = strtolower(basename($_FILES['file_som']['name']));

                    //junta o nome do arquivo com a pasta de destino
                    $uploadfileimg = $uploaddirimg.$arquivoimg;
                    $uploadfileaudio = $uploaddiraudio.$arquivoaudio;

                    //o comando strstr serve para pegar palavras similares ao igualado na frente
                    if((strstr($uploadfileimg, '.jpg')) || (strstr($uploadfileimg, '.jpeg')) || (strstr($uploadfileimg, '.gif')) || (strstr($uploadfileimg, '.png'))){
                        if(strstr($uploadfileaudio, '.mp3')){
                            //move_uploaded_file serve para mover os arquivos para a pasta local
                            if(move_uploaded_file($_FILES['file_foto']['tmp_name'], $uploadfileimg)){
                                if(move_uploaded_file($_FILES['file_som']['tmp_name'], $uploadfileaudio)){

                                    //pega o id do usuario na sessao
                                    $idusuariosession = $_SESSION['id_usuario'];

                                    //insere na tbl_meme
                                    $sql = "insert into tbl_meme (nome_meme, img, audio, data_registro, status)";
                                    $sql = $sql." values('".$nome."', '".$uploadfileimg."', '".$uploadfileaudio."', now(), 0)";
                                    if(mysql_query($sql)){

                                        //pega o id inserido anteriormente
                                        $idmeme = mysql_insert_id();
                                        //insere na tbl_memeusuario
                                        $sql2 = "insert into tbl_memeusuario (id_meme, id_usuario)";
                                        $sql2 = $sql2." values(".$idmeme.",".$idusuariosession.")";
                                        if(mysql_query($sql2)){
                                            ?>
                                                <script>
                                                    swal({
                                                      title: 'Meme registrado com sucesso :)',
                                                      text: "Você quer continuar registrando? :D",
                                                      type: 'warning',
                                                      showCancelButton: true,
                                                      confirmButtonColor: '#3085d6',
                                                      cancelButtonColor: '#d33',
                                                      cancelButtonText: 'Não',
                                                      confirmButtonText: 'Sim',
                                                    }).then(function () {
                                                      window.location = "registrar_meme.php";
                                                    }, function (dismiss) {
                                                      // dismiss can be 'cancel', 'overlay',
                                                      // 'close', and 'timer'
                                                      if (dismiss === 'cancel') {
                                                        window.location = "home.php";
                                                      }
                                                    })
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
                                              text: "Arquivo de imagem.",
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
                                          text: "Arquivo de aúdio.",
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
                                      text: "Verifique o formato do arquivo do aúdio.",
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
                                  text: "Verifique o formato do arquivo da imagem.",
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
            <div class="conteudo_rgmeme">
                <div class="titulo_pg">
                    <span class="centralizar_texto">Registrar Meme</span>
                </div>
                <div class="conteudo_boxrgmeme">
                    <form id="form_registrarmeme" method="post" enctype="multipart/form-data">
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
                        <input id="primeiro_input" class="input_texto" type="text" name="nome_meme" placeholder="Nome do Meme"/>
                        <!--adicionar som-->
                        <label for="btn_som">
                            <div id="botao_addsom">
                                Adicionar Som (.mp3)
                                <input id="btn_som" type="file" name="file_som"/>
                            </div>
                        </label>
                        <!--submit-->
                        <button id="bntsubmit" type="submit" name="btn_cadastrar">
                            Registrar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
