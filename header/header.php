<!--Include no SweetAlert-->
<script src = "sweetalert/sweetalert.min.js" > </script>
<!-- Include a polyfill for ES6 Promises (optional) for IE11 and Android browser -->
<script src="sweetalert/core.js"></script>
<script>

    //função sair sessão
    function sairSessao(){
        swal({
          title: 'Sua conta será desconectada!',
          text: "Tem certeza que quer sair? :(",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          cancelButtonText: 'Não',
          confirmButtonText: 'Sim',
        }).then(function () {
          window.location = "modulos/sair_sessao.php";
        }, function (dismiss) {
          // dismiss can be 'cancel', 'overlay',
          // 'close', and 'timer'
          if (dismiss === 'cancel') {

          }
        })
    }

</script>
<header>
    <?php

        $areausuario = '<a href="autentica_usuario.php">
                            <div id="area_usuario">
                                <img id="img_user" class="centralizar_texto" src="img/icons/user.png" alt="">
                            </div>
                        </a>';

        //verifica se na sessão há um usuario logado
        if(isset($_SESSION['id_usuario'])){

            $idusuario = $_SESSION['id_usuario'];

            $sql = "select * from tbl_usuario where id_usuario = ".$idusuario;

            $select = mysql_query($sql);

            if($rs=mysql_fetch_array($select)){

                $nomeusuario = $rs['nome_usuario'];
                $imgusuario = $rs['imagem'];
                $login = $rs['login'];
                $email = $rs['email'];

                $areausuario = '<div id="area_usuario">
                                    <img id="img_user" class="centralizar_texto" src="'.$imgusuario.'" alt="">
                                    <div id="btn_sair" onclick="sairSessao();">
                                        <img class="centralizar_texto" src="img/icons/sair.png" alt="">
                                    </div>
                                </div>';
            }
        }

    ?>
    <!--Logo-->
    <div id="header_logo">
        <div id="menu">
            <img id="menu_img" onclick="abrirMenu();" class="centralizar_texto" src="img/icons/menu.png" alt="">
        </div>
        <div id="logo">
        </div>
        <?php echo($areausuario); ?>
    </div>
</header>
