<?php
    //Realiza a conexão com o banco de dados mysqli
    //passamos o local do BD, o usuario e a senha
    $conexao = mysql_connect("localhost", "root","bcd127");
    //Definimos o database a ser utilizado no projeto
    mysql_select_db("dbmeme");
?>
