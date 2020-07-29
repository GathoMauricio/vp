const { isEmpty } = require('lodash');

require('./bootstrap');

$(document).ready(function(){
    getSepomex($("#txt_cp_sepomex").val());
    getCustomerAddress($('#txt_customer_adress_id').val());
    $("#contenedor_mensajes").animate({ scrollTop: $('#contenedor_mensajes').prop("scrollHeight")},0);
    //Pusher.logToConsole = true;
    var pusher = new Pusher('952d906c3edd3db0e583', {
      cluster: 'us2'
    });
    var user_id = $("#txt_pusher_user_id").val();
    var channel = pusher.subscribe('user_channel_'+user_id);
    channel.bind('mensaje_push', function(data) {
        //console.log(JSON.stringify(data));
        var ruta = $("#ruta_cargar_mensajes_push").val();
        $("#div_items_mensajes").html('<a href="" class="dropdown-item"><center><img src="'+$("#txt_img_loading").val()+'" alt="" width="40" height="40"></center></a>');
        $.ajax({
            url: ruta,
            data:{
                
            },
            success: function(respuesta) {
                //console.log(respuesta);
                //Sonido del mensaje
                $("#tono_mensaje").trigger('play');
                //Recargar icono
                $("#span_num_bubble").text(respuesta.contador);
                $("#span_num_bubble").css('color','red');
                //Recargar mensajes
                $("#div_items_mensajes").html(respuesta.html);
                
            },
            error: function() {
                console.log("No se ha podido obtener la información");
            }
        });
        //Recargar caja de bitacora
        var get_bitacora_ajax = $("#txt_ruta_get_bitacora_ajax").val();
        $.ajax({
            url: get_bitacora_ajax,
            data:{
                id:$("#txt_id_get_bitacora_ajax").val()
            },
            success: function(respuesta) {
                console.log(respuesta);
                //recargar caja de mensajes
                $("#contenedor_mensajes").html(respuesta.html);
                //poner scroll hasta abajo
                $("#contenedor_mensajes").animate({ scrollTop: $('#contenedor_mensajes').prop("scrollHeight")},300);
                
            },
            error: function() {
                console.log("No se ha podido obtener la información");
            }
        });
    });
    $("#form_store_comment").submit(function(e){
        e.preventDefault();
        var comment = $("#txt_comment_ajax").val();
        if(comment.length > 0)
        {
            $.ajax({
                url: $("#form_store_comment").prop('action'),
                method: "POST",
                data:$("#form_store_comment").serialize(),
                success: function(respuesta) {
                    //console.log(respuesta);
                    $("#form_store_comment")[0].reset();
                },
                error: function(e) {
                    console.log("No se ha podido obtener la información: "+JSON.stringify(e));
                }
            });
        }
    });
});

window.cargarUsuarios = function(value)
{
    var ruta = $("#ruta_cargar_empleados").val();
    var combo = $("#cbo_empleado_servicio");
    combo.html("--Seleccione una opción--");
    $.ajax({
        url: ruta,
        data:{
            'value':value
        },
        success: function(respuesta) {
            console.log(respuesta);
            combo.append(respuesta);
        },
        error: function() {
            console.log("No se ha podido obtener la información");
        }
    });
}
window.cargarUsuariosFinales = function(value)
{
    var ruta = $("#ruta_cargar_usuario_final").val();
    var combo = $("#cbo_usuario_final");
    combo.html("--Seleccione una opción--");
    $.ajax({
        url: ruta,
        data:{
            'value':value
        },
        success: function(respuesta) {
            //console.log(respuesta);
            combo.append(respuesta);
        },
        error: function() {
            console.log("No se ha podido obtener la información");
        }
    });
}
window.getSepomex = function(value) {
    $('#txt_cp_sepomex').css('color','black');
    $("#cbo_asentamiento_sepomex").html('');
    $("#txt_ciudad_sepomex").val('');
    $("#txt_municipio_sepomex").val('');
    $("#txt_estado_estado").val('');
    var ruta = $("#ruta_get_sepomex").val();
    if(!isNaN(value))
    {
        $.ajax({
            url: ruta,
            data:{
                'value':value
            },
            success: function(respuesta) {
                if(respuesta.length > 0 )
                {
                    $('#txt_cp_sepomex').css('color','green');
                    for(var i = 0; i < respuesta.length;i++)
                    {
                        $("#cbo_asentamiento_sepomex").append('<option value="'+respuesta[i].asentamiento+'">'+respuesta[i].asentamiento+'</option>');
                        $("#txt_ciudad_sepomex").val(respuesta[i].ciudad);
                        $("#txt_municipio_sepomex").val(respuesta[i].municipio);
                        $("#txt_estado_estado").val(respuesta[i].estado);
                    }
                }
            },
            error: function() {
                console.log("No se ha podido obtener la información");
            }
        });
    }else{
        $('#txt_cp_sepomex').css('color','red');
    }
}
window.getCustomerAddress = function(customer_id){
    var ruta = $("#ruta_get_customer_address").val();
    $.ajax({
        url: ruta,
        data:{
            'customer_id':customer_id
        },
        success: function(respuesta) {
            $("#txt_cp_sepomex").prop('value', respuesta.cp);
            getSepomex($("#txt_cp_sepomex").val());
            setTimeout(function(){ $("#cbo_asentamiento_sepomex").val(respuesta.asentamiento); },300)
            $("#txt_calle_numero").val(respuesta.calle_numero);
            $("#txt_piso").val(respuesta.piso);
            $("#txt_interior").val(respuesta.interior);
        },
        error: function() {
            console.log("No se ha podido obtener la información");
        }
    });
}
var comment_box = false;
window.switchCommentBox = function(){
    if(comment_box)
    {
        $(".contenedor_box").css('height','40');
        comment_box=false;
    }else{
        $(".contenedor_box").css('height','340');
        comment_box=true;
    }
}