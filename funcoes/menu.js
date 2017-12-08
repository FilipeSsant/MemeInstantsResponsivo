function abrirMenu(){
    //usa o comando animate para fazer uma animação para a direita com o width
    $("#conteudo_menu").animate({"width":"700px"}, 200);
    $("#fundo_transparente").css({"display":"block"});
}

function fecharPopUps(){
    //usa o comando animate para fazer uma animação para a direita com o width
    $("#conteudo_menu").animate({"width":"0px"}, 200);
    $("#fundo_transparente").css({"display":"none"});
}
