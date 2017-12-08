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


            function ajaxSelect(id){
                //Coloca na variavel o value que está na caixa
                var idmeme = id;
                //Coloca na variavel a url que vai redirecionar para fazer o processo
                var url = "ajax/selectmeme.php";

                $.ajax({
                    //Define o método
                    method:"POST",
                    //Define a url
                    url:url,
                    //Coloca em formato JSON as informações para passar pelo POST
                    data:{idmeme:idmeme},
                    success:function(dados){
                        //Manda os dados que será concebido como $resultado para a div ou input em questão
                        $("#dados_meme").html(dados);
                    }

                });
            }

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

                if(isset($_GET['modo'])){
                    $modo = $_GET['modo'];
                    $idmeme = $_GET['id'];

                    switch($modo){
                        case 'aprovar':

                            $sql = "update tbl_meme set status = 1 where id_meme = ".$idmeme;

                            if(mysql_query($sql)){
                                ?>
                                    <script>
                                        swal({
                                          title: "Meme Aprovado com Sucesso :)",
                                          text: "O usuário será alertado de sua aprovação.",
                                          type: "success",
                                          icon: "success",
                                          button: {
                                                     text: "Ok",
                                                 },
                                          closeOnEsc: true,
                                        });
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

                            break;
                        case 'reprovar':

                            $sql = "delete from tbl_meme where id_meme = ".$idmeme;

                            if(mysql_query($sql)){

                                $sql = "delete from tbl_memeusuario where id_meme = ".$idmeme;

                                if(mysql_query($sql)){

                                    //Unlink que exclui a imagem da pasta
                                    unlink($_GET['linkimg']);

                                    ?>
                                        <script>
                                            swal({
                                              title: "Meme Reprovado",
                                              text: "O meme foi excluido permanentemente.",
                                              type: "success",
                                              icon: "success",
                                              button: {
                                                         text: "Ok",
                                                     },
                                              closeOnEsc: true,
                                            });
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

                            break;
                    }
                }

            ?>
            <div id="dados_meme" class="conteudo_aprovar">

            </div>
            <div class="conteudo" style="height:900px;">
                <div class="titulo_pg">
                    <span class="centralizar_texto">Memes para aprovação</span>
                </div>
                <?php

                    //while para geração dos memes que tem status = 0
                    //select na view que faz inner join entre as tabels tbl_usuario
                    //tbl_memeusuario e tbl_meme
                    $sql = "select * from tbl_dadosmemeusuario where status = 0";
                    $select = mysql_query($sql);

                    while($rs=mysql_fetch_array($select)){
                        $caminhoimagem = $rs['img'];
                        $idmeme = $rs['id_meme'];
                        $nomememeap = $rs['nome_meme'];
                        $nomeusuario = $rs['nome_usuario'];
                ?>
                        <div class="div_memeap" onclick="ajaxSelect(<?php echo($idmeme); ?>);">
                            <!--imagem-->
                            <div class="img_memap">
                                <img class="centralizar_texto" src="<?php echo($caminhoimagem); ?>" alt="">
                            </div>
                            <!--nome meme-->
                            <div class="nome_memeap">
                                <span class="centralizar_texto"><?php echo($nomememeap); ?></span>
                            </div>
                            <!--data feito-->
                            <div class="data_feitoap">
                                <span class="centralizar_texto">By: <?php echo($nomeusuario); ?></span>
                            </div>
                        </div>
                <?php
                    }
                ?>
            </div>
        </div>
    </body>
</html>
