function verificaCadastrado(doc){
   $.post("../jpost/cadcliente.jpost.php", { doc: doc, op: "load" })
    .done(function( data ) {
        resul = JSON.parse(data);
        if(resul.status !== "ERROR"){
            document.getElementById("userId").value = resul.id;
            document.getElementById("doc").value = resul.doc;
            document.getElementById("nome").value = resul.nome;
            document.getElementById("celular").value = resul.celular;
            document.getElementById("telefone").value = resul.telefone;
            document.getElementById("email").value = resul.email;
            document.getElementById("rg").value = resul.rg;
            document.getElementById("fax").value = resul.fax;
            document.getElementById("email").value = resul.email;
            document.getElementById("contato").value = resul.contato;
            document.getElementById("observacao").value = resul.observacao;
            document.getElementById("inscestadual").value = resul.insc_est;
            document.getElementById("inscmunicipal").value = resul.insc_mun;
            return true;
        } else
            return false;
    });
}

function importa(){

    doc = $("#doc").val();
    doc = doc.replace(/[^0-9]/g,'');
    
    if(doc.length === 11){
        $.post("../jpost/getcpf.jpost.php", { cpf: doc })
        .done(function( data ) {
            resul = JSON.parse(data);
            
            if(resul.status === "ERROR"){
                verificaCadastrado(resul.cpf);
                alert("CPF inválido!");
            } else{
                verificaCadastrado(resul.cpf);
                document.getElementById("doc").value = resul.cpf;
            }
        });
    } else
        if(doc.length === 14){
            $.post("../jpost/getcnpj.jpost.php", { cnpj: doc })
            .done(function( data ) {
                if(data === "Too many requests, please try again later."){
                    alert("Muitas requisições foram enviadas ao mesmo tempo, tente novamente em alguns segundos!");
                } else {
                    if(data.substring(0,10) === "Cannot GET"){
                        alert("Digite um CNPJ válido, apenas números!");
                    } else {
                        resul = JSON.parse(data);

                        if(resul.status === "ERROR"){
                            alert(resul.message);
                            document.getElementById("nome").value = "";
                            document.getElementById("celular").value = "";
                            document.getElementById("telefone").value = "";
                            document.getElementById("email").value = "";
                        } else {
                            
                            document.getElementById("doc").value = resul.cnpj;
                            document.getElementById("nome").value = resul.nome;
                            document.getElementById("celular").value = resul.telefone.substring(0, 15);
                            document.getElementById("telefone").value = resul.telefone.substring(17, 31);
                            document.getElementById("email").value = resul.email;
                        }
                    }
                }
            });
        } else {
            document.getElementById("estrangeiro").checked = true;
        }
}