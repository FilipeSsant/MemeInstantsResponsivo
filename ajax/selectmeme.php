<?php

    //inclui a conexao
    include_once("../connection/conexao.php");

    //verifica se por acaso a variavel requisitada está na pg
    if(isset($_POST['idmeme'])){
        //regasta no post a variavel enviada
        $idmeme = $_POST['idmeme'];
        $resultado = "";
        $sql = "select * from tbl_dadosmemeusuario where id_meme = ".$idmeme;
        $select = mysql_query($sql) or die(mysql_error());

        if($rs=mysql_fetch_array($select)){
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

            $resultado ='<div class="titulo_pg">
                            <span class="centralizar_texto">'.$nomememeap.'</span>
                        </div>
                        <div class="conteudo_boxaprovar">
                            <div class="botoes_condicoes">
                                <a href="aprovar_meme.php?id='.$idmeme.'&modo=aprovar">
                                    <div class="botao_condicao" style="background-color:#7bd67d">
                                        <img class="centralizar_texto" src="img/icons/aprovar.png" alt="">
                                    </div>
                                </a>
                                <a href="aprovar_meme.php?id='.$idmeme.'&modo=reprovar&linkimg='.$caminhoimagem.'">
                                    <div class="botao_condicao" style="background-color:#e24848">
                                        <img class="centralizar_texto" src="img/icons/reprovar.png" alt="">
                                    </div>
                                </a>
                            </div>
                            <!--mostrar foto-->
                            <div id="div_foto">
                                <div id="foto_preview">
                                    <img id="imagem" src="'.$caminhoimagem.'" alt="">
                                </div>
                            </div>
                            <!--inputs-->
                            <input disabled value="By: '.$nomeusuario.'" id="primeiro_input" class="input_texto" type="text"/><br>
                            <input disabled value="'.$databr.'" ás "'.$horaminuto.'" class="input_texto" type="text"/>
                            <!--adicionar som-->
                            <div id="botao_addsom">
                                Ouvir Som
                            </div>
                            <audio controls>
                              <source id="audio_source" src="'.$audio.'" type="audio/mp3">
                            </audio>
                        </div>';
        }
        echo($resultado);
    }

?>
