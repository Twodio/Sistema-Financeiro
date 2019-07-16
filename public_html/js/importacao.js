
function importa(){

    cnpj = $("#doc").val();

    $.post("../jpost/getpage.jpost.php", { cnpj: cnpj })
    .done(function( data ) {
        if(data === "Too many requests, please try again later."){
            alert("Muitas requisições foram enviadas ao mesmo tempo, tente novamente em alguns segundos!");
        } else {
            resul = JSON.parse(data);
            
            document.getElementById("doc").value = resul.cnpj;
            document.getElementById("nome").value = resul.nome;
            document.getElementById("celular").value = resul.telefone.substring(0, 15);
            document.getElementById("telefone").value = resul.telefone.substring(17, 31);
            document.getElementById("email").value = resul.email;
        }
    });
}