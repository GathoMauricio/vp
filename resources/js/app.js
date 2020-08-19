import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction';


document.addEventListener('DOMContentLoaded', function() {
    if($('#calendar').length > 0)
    { 
        var ruta_ajax_servicios = $("#txt_index_ajax").val();
        $.ajax({
            url: ruta_ajax_servicios,
            data:{
                
            },
            success: function(servicios) {
                var calendarEl = document.getElementById('calendar');
                var array_servicios = [];
                var color_item = '';
                $.each(servicios,function(index,servicio){
                    console.log(JSON.stringify(servicio));
                    switch(servicio.status_service_id)
                    {
                        case '1': color_item = '#566573'; break
                        case '2': color_item = '#F39C12'; break
                        case '3': color_item = '#27AE60'; break
                        case '4': color_item = '#2E86C1 '; break
                        case '5': color_item = '#C0392B'; break
                    }
                    array_servicios.push({
                        title : ' Hrs. '+servicio.customer.code,
                        start : servicio.schedule,
                        url : $("#txt_show_service_calendar").val()+'/'+servicio.id,
                        color: color_item
                    });

                });
                var calendar = new Calendar(calendarEl, {
                    themeSystem: 'bootstrap',
                    dateClick: function(info) {},
                    events: array_servicios,
                    eventClick : function(info) 
                    {},
                    headerToolbar: {
                        left: 'prev,today,next',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek'
                    },
                    views: {
                        dayGrid: {},
                        timeGrid: {},
                        week: {},
                        day: {}
                    },
                    plugins: [ dayGridPlugin,timeGridPlugin,interactionPlugin ]
                });
                calendar.setOption('locale', 'es');
                calendar.render();

                
            },
            error: function() {
                console.log("No se ha podido obtener la información");
            }
        });


        
    }
});

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
    //Agregar usuario final ajax
    $("#frm_create_final_user_ajax").submit(function(e){
        e.preventDefault();
        $.ajax({
            url: $("#frm_create_final_user_ajax").prop('action'),
            method: "POST",
            data:$("#frm_create_final_user_ajax").serialize(),
            success: function(respuesta) {
                //console.log(respuesta);
                var combo = $("#cbo_usuario_final");
                combo.html("--Seleccione una opción--");
                combo.append(respuesta);
                swal('Listo','Usuario final agregado','success');
                $("#create_final_user_modal").modal('hide');
            },
            error: function(e) {
                //console.log(JSON.stringify(e));
                swal('Atención', 'rellene los campos obligatorios eingrese un email válido','warning');
            }
        });
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
    if(value.length > 0){
        $("#customer_id_create_usuario_final_axax").val(value);
        $("#link_usuario_final_ajax").css('display', 'block');
    }else{
        $("#customer_id_create_usuario_final_axax").val('');
        $("#link_usuario_final_ajax").css('display', 'none');
    }
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

window.openCalendar = function(){
    $("#calendar_container").css('display','block');
}
window.closeCalendar = function(){
    $("#calendar_container").css('display','none');
}