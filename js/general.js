//libreria general JS

function muestraMensajeA(estilo, objeto, mensaje){
	objeto.after('<div class="alert '+estilo+'" role="alert">'+mensaje+'</div>');
}

function esperaSubmit(objBoton){
    //ocultamos el boton del contenido
    objBoton.hide();
    //cargamos un loadin haber como sale
    muestraLoading(objBoton, 'Despues' );
}

function cargamosSubmit(objBoton){
    //mostramos el tr del boton
    objBoton.show();
    //removemos el loading
    ocultaLoading();
}
//accion para mostrar un loading 
function muestraLoading(obj, momento ){
    momento = momento || 'Despues';
    img = "<img src='images/load.gif' class='imgLoading' />";
    //img = '<i class="fa fa-spinner fa-spin fa-3x imgLoading"></i>';
    if(momento ===  "Antes"){
        obj.before(img);
    }else if (momento ==="Despues"){
        obj.after(img);
    }
}
//remover loadings
function ocultaLoading(){
    $(".imgLoading").remove()
}

/*************************************************funciones para el envio de datos*********************************************/
function validaForm(){
    //regla general los formularios deben tener el id formMain
    objBoton = $("#formMain #btnSubmit")
    esperaSubmit(objBoton) ;
    //alert()
    $(".alert-short-row").remove();
    ban = true;
    $("#formMain :input").each(function(){
        if( $(this).attr("validar") == 1){
            if( $(this).val() == ""){
                $(this).after("<div class='alert alert-danger alert-short-row' role='alert'>'"+ $(this).attr('placeholder')+ "' no puede ir vacio</div>");
                $(this).focus();
                ban = false;
            }
        }
    });
    if(!ban){
        cargamosSubmit(objBoton);
    }
    return ban;
}

/********funcion para validar la extension de los Files++********/
 function valida_archivo( obj, arr ){ 
    obj.unbind("change")
       .change( function(){
            var file = $(this).parent().html()
            var id= $(this).attr("id");
            var dot = $(this).val().lastIndexOf("."); 
            var ext = $(this).val().substr( dot, $(this).val().length ).replace(".", "").toLowerCase(); 
            $(".alert").remove();
            if( $.inArray(ext, arr ) != -1 ){
                muestraMensajeA("alert-success", $(this), "Archivo valido");
            }else{
                $(this).parent().html(file)
                muestraMensajeA("alert-danger", $("#"+id), "Archivo no valido");
                valida_archivo( $(this) )
            }
        })
}
function error (){ alert("Error al enviar el formulario");  }

function respuesta (rt,st){
    $("#divRespuesta").html(rt);
    $("#btnReset").click();
    cargamosSubmit($("#formMain #btnSubmit"));
}
/******************************funciones prototype*****************************************/

String.prototype.alias = function(){
    valor = this;
    valor = valor.replace("_","");
    valor = valor.replace("ctl","");
    valor = valor.charAt(0).toUpperCase() + valor.slice(1);
    return valor;
}

String.prototype.capitalize = function() {
    return this.charAt(0).toUpperCase() + this.slice(1);
}


/*******************************************opciones data table*************/
var optDataTable = {
                autoFill: true,
                pageLength: 10,
                destroy: true,
                "language": {
                   "lengthMenu": "Mostrando _MENU_ registros por pagina",
                    "zeroRecords": "No se encontraron resultados - los sentimos",
                    "info": "Mostrando pagina _PAGE_ de _PAGES_",
                    "infoEmpty": "Registros no disponibles",
                    "infoFiltered": "(filtro desde _MAX_ total registros)",
                    "search":  "Buscar: ",
                    "zeroRecords":    "Ninguna coicidencia encontrada",
                    "paginate": {
                        "first":      "Inicio",
                        "last":       "Ultimo",
                        "next":       "Siguiente",
                        "previous":   "Previo"
                    }
                }
            };
var optDataTable2 = {
                autoFill: true,
                pageLength: 50,
                destroy: true,
                "language": {
                   "lengthMenu": "Mostrando _MENU_ registros por pagina",
                    "zeroRecords": "No se encontraron resultados - los sentimos",
                    "info": "Mostrando pagina _PAGE_ de _PAGES_",
                    "infoEmpty": "Registros no disponibles",
                    "infoFiltered": "(filtro desde _MAX_ total registros)",
                    "search":  "Buscar: ",
                    "zeroRecords":    "Ninguna coicidencia encontrada",
                    "paginate": {
                        "first":      "Inicio",
                        "last":       "Ultimo",
                        "next":       "Siguiente",
                        "previous":   "Previo"
                    }
                }
            };
var optDataTableNoPag = { 
                autoFill: true,
                pageLength: 50,
                ordering: false,
                "language": {
                   "lengthMenu": "Mostrando _MENU_ registros por pagina",
                    "zeroRecords": "No se encontraron resultados - los sentimos",
                    "info": "Mostrando pagina _PAGE_ de _PAGES_",
                    "infoEmpty": "Registros no disponibles",
                    "infoFiltered": "(filtro desde _MAX_ total registros)",
                    "search":  "Buscar: ",
                    "zeroRecords":    "Ninguna coicidencia encontrada",
                    "paginate": {
                        "first":      "Inicio",
                        "last":       "Ultimo",
                        "next":       "Siguiente",
                        "previous":   "Previo"
                    }
                }
            }; 



/********* function on para objetos con class btnEvento*********/

function eventoBtn(tabla){
    $(".btnEvento")
        .unbind("click")
        .on("click",function(){
        if($(this).attr("action") == "Editar"){
            window.location.href = $(this).attr("tk")
        }else if($(this).attr("action") == "simpleEditar"){
            $.fancybox({
              'href':   $(this).attr("tk"),
              'type':   'iframe'
            });
        }else if($(this).attr("action") == "simpleEditar2"){
            $.fancybox({
                'href':   $(this).attr("tk"),
                'type':   'iframe',
                'afterClose': function(){ carga_grid('refresh'); },
                'width': '1024'
            });
        }else if( $(this).attr("action") == "Eliminar"){
            obj =  $(this).parents("tr")
            if(confirm("¿Desea eliminar el registro?")){
                $.post($(this).attr("tk"),{}, 
                    function(rt,st){
                        alert(rt)
                        obj.remove()
                    })
            }
        }else if( $(this).attr("action") == "Eliminar2"){
            obj =  $(this).parents("tr");
            if(confirm("¿Desea eliminar el registro?")){
                $.post($(this).attr("tk"),{},
                    function(rt,st){
                        alert(rt);
                        obj.remove();
                        afterRemove();
                    })
            }
        }
    })
    if (tabla){
        tabla.on( 'draw', function () {
            eventoBtn();
        } )
    }
    
}

//Extrae parametros de GET
$.urlParam = function(name){
    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
    if (results==null){
       return null;
    }
    else{
       return results[1] || 0;
    }
}


function llenarForm(form, data) {
    $.each(data, function(key, value){
        obj = $(form+' #'+key)


        obj.val(value);
        if(obj.is('select')){
            obj.attr('val', value)
        }
        //alert( form+' #'+key + ' ' + $(form+' #'+key).is('select') )
        $(form+' [type="radio"][id^='+key+']').each(function() {
            if($(this).val()==value) {
                $(this).prop('checked', true);
            }
        });
    });
}
function llenarCheckBox(name, data) {
    $.each(data, function(element, value){
        $.each(value, function(key, value){
            $('[name="'+name+'"][value="'+value+'"]').prop('checked', true);
        });
    });
}

//Limita cuantos dígitos se pueden insertar manualmente en un input type number
function maxLengthCheck(object){
    if (object.value.length > object.maxLength){
        object.value = object.value.slice(0, object.maxLength);
    }
}

function lockCombo(arrayKey,w){
    if (w != ""){
        selectID = "#"+arrayKey.substring(arrayKey.indexOf("[")+1,arrayKey.indexOf("]"));
        //alert(">"+selectID+"<");
        $(selectID).val(w);
        $(selectID).attr("disabled",true);
        $(selectID).parent().append('<input type="hidden" name="'+arrayKey+'" value="'+w+'">');
        $(selectID+"+a.emergente").hide();
    }
}

function asteriscos(){
    $('[validar="1"]').each(function(i,v) {
        //$(this).parent().prev('label').html('<i class="fa fa-asterisk text-primary"></i>&nbsp;'+$(this).parent().prev('label').text());
        $(this).parent().prev('label').html('<code class="text-primary">*</code>'+$(this).parent().prev('label').text());
    });
}
function muestraSimilar(table,selector){
    $.post("configtablaACM.php",
        {x:"buscaSimilar",table: table, colName: selector.attr('id'), value: selector.val()},
        function(data,status){
            selector.next('.similares').remove();
            dataObj = $.parseJSON(data);
            if (dataObj.similares != '') {
                var similares = '<ul>';
                $.each(dataObj.similares, function (element, value) {
                    $.each(value, function (key, val) {
                        similares += '<li>' + val + '</li>'
                    });
                });
                similares += '</ul>';
                selector.after('<div class="alert alert-warning similares">' + similares + '</div>');
            }
        });
}