
function debounce(func, delay) {
    console.log('deboucing?');
    let timer;
    return function () {
        const context = this;
        const args = arguments;
        clearTimeout(timer);
        timer = setTimeout(() => func.apply(context, args), delay);
    };
}
function processaPessoa(p){
    return `<br> ${p.nome}`;

}

function processForm() {
    const $resultado = $('#resultado');
    var dados = $('form').serialize();
    const nome = dados.split("=")[1];
    console.log(nome);
    console.log(nome.length);
    if(nome.length>1){
        $.ajax({
            url: '/atividade_testephp/backend/processa.php',
            method: 'get',
            dataType: 'json',
            data: dados,
            success: function (pessoas) {
                console.dir(pessoas);
                 //$('#resultado').empty().html(`<meta charset="UTF-8">`);
                
                $resultado.empty().html(pessoas.map(processaPessoa)); 

            },
            error: function(error){
                console.dir(error);
                if(error.status == 404){
                    $resultado.empty().html("Nenhum resultado encontrado.");
                }
            }
            
        });
    }

    return false;
}

$(document).ready(function () {
    console.log('ready?');
    $("#myform").submit(function(event) {
        event.preventDefault();
    });

    const debouncedProcessForm = debounce(processForm, 500);
    $('form > div > input').keyup(debouncedProcessForm);
});