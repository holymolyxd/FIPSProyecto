var route = document.getElementsByName('routeName')[0].getAttribute('content');
var base = location.protocol+'//'+location.host;

document.addEventListener('DOMContentLoaded', function () {
    var btn_search = document.getElementById('btn_search');
    var form_search = document.getElementById('form_search');
    if(btn_search){
        btn_search.addEventListener('click', function (e){
            e.preventDefault();
            if(form_search.style.display === 'block'){
                form_search.style.display = 'none';
            }
            else
            {
                form_search.style.display = 'block';
            }
        });
    }

    route_active = document.getElementsByClassName('lk-'+route)[0].classList.add('active');

    btn_deleted = document.getElementsByClassName('btn_deleted');
    for (i = 0; i < btn_deleted.length; i++){
        btn_deleted[i].addEventListener('click',delete_object);
    }
});

function expander_sidebar()
{
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $(".wrapper").toggleClass("toggled");
    });
}

function mostrar_tooltip()
{
    $(document).ready(function (){
        $('[data-toggle="tooltip"]').tooltip();
    });
}

function expander_textarea()
{
    $('#description').focus(function (){
        $(this).animate({"height":"100px",}, "fast");
    });

    $('#description').blur(function (){
        $(this).animate({"height":"40px",}, "fast");
    });
}

function contar_caracteres_textarea()
{
    if(route == "role_add" || route == "role_edit" || route == "permission_edit" || route == "permission_add"){
        const description = document.getElementById('description');
        const contador = document.getElementById('contador');
        description.addEventListener('input', function(e) {
            const target = e.target;
            const longitudMax = target.getAttribute('maxlength');
            const longitudAct = target.value.length;
            contador.innerHTML = `${longitudAct}/${longitudMax}`;
        });
    }
}

function contar_caracteres_inputText()
{
    if(route == "role_add" || route == "role_edit" || route == "permission_edit" || route == "permission_add"){
        const name = document.getElementById('name');
        const contador2 = document.getElementById('contador2');
        name.addEventListener('input', function(e) {
            const target = e.target;
            const longitudMax = target.getAttribute('maxlength');
            const longitudAct = target.value.length;
            contador2.innerHTML = `${longitudAct}/${longitudMax}`;
        });
    }
}

$(document).ready(function (){
    mostrar_tooltip();
    expander_textarea();
    contar_caracteres_textarea();
    expander_sidebar();
    contar_caracteres_inputText();
});

function delete_object(e){
    e.preventDefault();
    var object = this.getAttribute('data-object');
    var action = this.getAttribute('data-action');
    var path = this.getAttribute('data-path');
    var url = base + '/' + path + '/' + object + '/' + action;
    var title, text, icon, confirmText;
    if(action == "delete"){
        title = '¿Estas seguro de eliminar este elemento?';
        text = "Recuerda que esta accion enviara este elemento a la papelera o lo eliminar de forma definitiva";
        icon = 'question';
        confirmText = 'Si, eliminar elemento';
    }
    if(action == "restore"){
        title = '¿Quieres restaurar este elemento?';
        text = "Esta accion restaurara este elemento y estara activo en la BD";
        icon = 'question';
        confirmText = 'Si, restaurar elemento';
    }

    Swal.fire({
        title: title,
        text: text,
        icon: icon,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: confirmText
    }).then((result) => {
        if (result.value) {
            window.location.href = url;
        }
    });
}
