var endId;
var userId;

function alteraEndId(id){
    endId = id;
}

function alteraUserId(id){
    userId = id;
}

$('#addEndereco').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var cep = button.data('cep');
    var codmun = button.data('codmun');
    var endereco = button.data('endereco');
    var nro = button.data('nro');
    var complemento = button.data('complemento');
    var bairro = button.data('bairro');
    var cidade = button.data('cidade');
    var uf = button.data('uf');
    var value = button.data('value');
    var modal = $(this); 
  
    modal.find('.modal-title').text('Editando endereço');
    modal.find('#cep').val(cep);
    modal.find('#codmun').val(codmun);
    modal.find('#endereco').val(endereco);
    modal.find('#nro').val(nro);
    modal.find('#complemento').val(complemento);
    modal.find('#bairro').val(bairro);
    modal.find('#cidade').val(cidade);
    modal.find('#uf').val(uf);
    
    if(value === "alterar")
        $("#salvarEndereco").attr('onclick', 'editEnd('+endId+');');
    else
        $("#salvarEndereco").attr('onclick', 'cadEnd();');
});

function editEnd(){
    var cep = $("#cep").val();
    var cod_mun = $("#codmun").val();
    var endereco = $("#endereco").val();
    var nro = $("#nro").val();
    var complemento = $("#complemento").val();
    var bairro = $("#bairro").val();
    var cidade = $("#cidade").val();
    var uf = $("#uf").val();
    
    $.post( "../jpost/cadcliente.jpost.php", { cod: endId, op: 'edit', cep: cep, cod_mun: cod_mun, endereco: endereco, nro: nro, complemento: complemento, bairro: bairro, cidade: cidade, uf: uf })
        .done(function( data ) {
            alert( data );
            $("#buscar").trigger('click');
        });
}

function cadEnd(){
    var cep = $("#cep").val();
    var cod_mun = $("#codmun").val();
    var endereco = $("#endereco").val();
    var nro = $("#nro").val();
    var complemento = $("#complemento").val();
    var bairro = $("#bairro").val();
    var cidade = $("#cidade").val();
    var uf = $("#uf").val();
    
    $.post( "../jpost/cadcliente.jpost.php", { id_usr: userId, op: 'addEnd', cep: cep, cod_mun: cod_mun, endereco: endereco, nro: nro, complemento: complemento, bairro: bairro, cidade: cidade, uf: uf })
        .done(function( data ) {
            alert( data );
            $("#buscar").trigger('click');
        });
}

function delUsuario(){
    $.post( "../jpost/cadcliente.jpost.php", { cod: userId, op: 'delUser' })
        .done(function( data ) {
            alert( data );
            $("#buscar").trigger('click');
        });

}

function delEnd(){
    $.post( "../jpost/cadcliente.jpost.php", { cod: endId, op: 'del' })
        .done(function( data ) {
            alert( data );
            $("#buscar").trigger('click');
        });

}