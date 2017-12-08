<?php

    session_start();

    //inclui a conexao
    include_once("connection/conexao.php");

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

            });

            function playAudio(audio){

                var audio = new Audio(audio);

				audio.play();

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
            <?php include_once("header/header.php"); ?>
            <div class="conteudo_home" style="overflow:auto">
                <div class="conteudo_boxhome">
                    <?php
                        //while que manda as informações somente com o status = 1
                        $sql = "select * from tbl_dadosmemeusuario where status = 1";
                        $select = mysql_query($sql) or die(mysql_error());

                        while($rs=mysql_fetch_array($select)){
                            $idmeme = $rs['id_meme'];
                            $caminhoimagem = $rs['img'];
                            $nomememeap = $rs['nome_meme'];
                            $audio = $rs['audio'];
                            $data = $rs['data_registro'];
                            $nomeusuario = $rs['nome_usuario'];
                            //da um explode utilizando o espaço como separador, assim separando
                            //em 2 strings
                            $pthorariodata = explode(" ",$data);

                            $datan = $pthorariodata[0];
                            $horario = $pthorariodata[1];

                            $partesdata = explode("-", $datan);
                            $parteshorario = explode(":", $horario);
                            //dia/mes/ano
                            $databr = $partesdata[2]."/".$partesdata[1]."/".$partesdata[0];
                            //hora:min
                            $horaminuto = $parteshorario[0].":".$parteshorario[1];
                    ?>
                            <div class="box_meme" style="background-image:url('<?php echo($caminhoimagem); ?>');" onmouseup="playAudio('<?php echo($audio); ?>');">
                                <img src="img/icons/botaonormal.png" alt="" title="By: <?php echo($nomeusuario); ?>">
                                <span class="nome_memebox"><?php echo($nomememeap); ?></span>
                            </div>
                    <?php
                        }
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>
