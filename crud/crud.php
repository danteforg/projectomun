<?php
require_once '../app/model/db.class.php';
//parametro inicio es la entidad para crear el crud
$datos = array();
$pathRaiz = "../";
$pathController = $pathRaiz."app/controller/";
$pathModel = $pathRaiz."app/model/";
$pathVistas = $pathRaiz."app/views/default/";
$entidad = "";
$alias = "";
$ext =".php";

if( isset($_POST['inicio']) && !empty($_POST['inicio'])){
    if(isset($_POST['alias']) && !empty($_POST['alias'])){
        $entidad = $_POST['inicio'];
        $alias = $_POST['alias'];
        
        //creamos el archivo raiz =)
        $archivoRaiz = $pathRaiz.$alias.$ext;
        creaArchivo($archivoRaiz,archivoRaiz($entidad,$alias));
        //creamos el controller
        $archivoController = $pathController."mvc.controller$alias".$ext;
        creaArchivo($archivoController,archivoController($entidad,$alias));
   
        //obtenemos que exista la entidad
        
        $db = new database();
        $db->conectar();
        $query = "SHOW FULL COLUMNS FROM ".$entidad;
        $result = $db->exeQuery($query);
        //validamos que no exista el archivo raiz
        if($db->numero_de_filas($result) > 0){
            //obtenemos los atributos de la entidad
            while($row = mysqli_fetch_assoc($result)){
                array_push($datos, $row);
            }
            mysqli_free_result($result);
            //print_r($datos);
            //Generamos el modelo
            //archivoModel($entidad, $alias, $datos);
            
            $archivoModel = $pathModel.$entidad.".class".$ext;
            creaArchivo($archivoModel, archivoModel($entidad, $alias, $datos));
           
            //generamos las vistas
            $archivoCrear = $pathVistas.$entidad;
            if(!is_dir($archivoCrear))mkdir($archivoCrear);
            $archivoCrear .= "/v.crear".$ext;
            creaArchivo($archivoCrear, archivoVCrear($entidad, $alias, $datos));
            
            $archivoCrear = $pathVistas.$entidad."/v.simplecrear".$ext;
            creaArchivo($archivoCrear, archivoVCrear($entidad, $alias, $datos, true));
            
            $archivoBuscar = $pathVistas.$entidad."/v.buscar".$ext;
            creaArchivo($archivoBuscar, archivoVBuscar($entidad, $alias, $datos));
            
            $archivoBuscar = $pathVistas.$entidad."/v.simplebuscar".$ext;
            creaArchivo($archivoBuscar, archivoVBuscar($entidad, $alias, $datos, true));
            
            $archivoModificar = $pathVistas.$entidad."/v.modificar".$ext;
            creaArchivo($archivoModificar, archivoVModificar($entidad, $alias, $datos));
            
            $archivoModificar = $pathVistas.$entidad."/v.simplemodificar".$ext;
            creaArchivo($archivoModificar, archivoVModificar($entidad, $alias, $datos, true));
            
            $archivoVistacompleta = $pathVistas.$entidad."/v.vistacompleta".$ext;
            
        
        }else{
             echo '<div class="alert alert-danger col-lg-4" role="alert">
                Error en parametros "Alias". Consulta el manual tecnico.
                </div>';
        }
    }else{
        echo '<div class="alert alert-danger col-lg-4" role="alert">
                El alias no puede ir vacio.
                </div>';
    }
}else{
    echo '<div class="alert alert-danger col-lg-4" role="alert">
            Error en parametros "Inicia". Consulta manual.
            </div>';
}
//no requiere modificacion
function creaArchivo($path,$string){
    if( is_file($path) ){
             echo '<div class="alert alert-warning col-lg-12" role="alert">
                    El archivo '.$path.' ya existe
                </div>';
             return false;
        }else{
            $archivo = fopen($path, "w");
            if($archivo){
                fputs($archivo , $string);
                echo '<div class="alert alert-success col-lg-12" role="alert">
                    Se creo el Archivo '.$path.' correctamente
                </div>';
                fclose($archivo);
                return true;
            }else{
                echo  '<div class="alert alert-warning col-lg-12" role="alert">
                    El archivo '.$path.' no se pudo crear
                </div>';
                return false;
            }
        }
}
//no requiere modificacion
function archivoRaiz($entidad, $alias){
    $contenido =  "<?php \n/*"
            . "*Archivo Raiz de la entidad $entidad"
            . "**/\n\n"
            . "//librerias\n"
            . "require_once 'app/controller/cabecera.inc.php';\n"
            . "require_once 'app/controller/mvc.controller$alias.php';"
            . "\n"
            . "\$mvc = new mvc_controller$alias();"
            . "\n\n"        
            . "if(\$accion === 'crear'){\n"        
            . "   \$mvc->crear();\n"
            . "}else if (\$accion === 'simpleCrear'){\n"
            . "   \$mvc->simpleCrear();\n"
            . "}else if (\$accion === 'modificar'){\n"
            . "   \$mvc->modificar();\n"
            . "}else if (\$accion === 'simpleModificar'){\n"
            . "   \$mvc->simpleModificar();\n"
            . "}else if (\$accion === 'buscar'){\n"
            . "   \$mvc->buscar();\n"
            . "}else if (\$accion === 'simpleBuscar'){\n"
            . "   \$mvc->simpleBuscar();\n"
            . "}else if (\$accion === 'vistaCompleta'){\n"
            . "   \$mvc->vistaCompleta();\n"
            . "}else if (\$accion === 'Grid'){\n"
            . "   \$mvc->ObtenGrid();\n"
            . "}else if (\$accion === 'Insertar'){\n"
            . "   \$mvc->Insertar();\n"
            . "}else if (\$accion === 'Leer'){\n"
            . "   \$mvc->Leer();\n"
            . "}else if (\$accion === 'Actualizar'){\n"
            . "   \$mvc->Actualizar();\n"
            . "}else if (\$accion === 'Seleccionar'){\n" 
            . "   \$mvc->Seleccionar();\n"
            . "}else if (\$accion === 'Eliminar'){\n"
            . "   \$mvc->Eliminar();\n"
            . "}else{\n   \$mvc->pagina_notFound();\n}";
    return $contenido;
}
//no requiere modificacion
function archivoController($entidad, $alias){
    $contenido = "<?php \n"
            . "/**CONTROLLER DE LA ENTIDAD $entidad**/\n"
            . "require_once 'app/model/$entidad.class.php';\n"
            . "require_once 'app/controller/mvc.controller.php';\n"
            . "class mvc_controller$alias extends mvc_controller {\n\n"
            . "function crear(){\n"
            . "   \$pagina=\$this->load_template('Crea $alias');\n"
            . "   \$html = \$this->load_page('app/views/default/$entidad/v.crear.php');\n"
            . "   \$pagina = \$this->replace_content('/\\#CONTENIDO\\#/ms' ,\$html , \$pagina);\n"
            . "   \$this->view_page(\$pagina);\n"
            . "}\n"
            . "function simpleCrear(){\n"
            . "    \$pagina=\$this->load_template('Crea Tipoplantilla', \"simplePage.php\");\n"
            . "    \$html = \$this->load_page('app/views/default/$entidad/v.simplecrear.php');\n"
            . "    \$pagina = \$this->replace_content('/\#CONTENIDO\#/ms' ,\$html , \$pagina);\n"
            . "    \$this->view_page(\$pagina);\n"
            . "}\n"
            . "function modificar(){\n"
            . "   \$pagina=\$this->load_template('Modifica $alias');\n"
            . "   \$html = \$this->load_page('app/views/default/$entidad/v.modificar.php');\n"
            . "   \$pagina = \$this->replace_content('/\\#CONTENIDO\\#/ms' ,\$html , \$pagina);\n"
            . "   \$this->view_page(\$pagina);\n"
            . "}\n"
            . "function simpleModificar(){\n"
            . "    \$pagina=\$this->load_template('Crea Tipoplantilla', \"simplePage.php\");\n"
            . "    \$html = \$this->load_page('app/views/default/$entidad/v.simplemodificar.php');\n"
            . "    \$pagina = \$this->replace_content('/\#CONTENIDO\#/ms' ,\$html , \$pagina);\n"
            . "    \$this->view_page(\$pagina);\n"
            . "}\n"
            . "function buscar(){\n"
            . "   \$pagina=\$this->load_template('Busca $alias');\n"
            . "   \$html = \$this->load_page('app/views/default/$entidad/v.buscar.php');\n"
            . "   \$pagina = \$this->replace_content('/\\#CONTENIDO\\#/ms' ,\$html , \$pagina);\n"
            . "   \$this->view_page(\$pagina);\n"
            . "}\n"
            . "function simpleBuscar(){\n"
            . "    \$pagina=\$this->load_template('Crea Tipoplantilla', \"simplePage.php\");\n"
            . "    \$html = \$this->load_page('app/views/default/$entidad/v.simplebuscar.php');\n"
            . "    \$pagina = \$this->replace_content('/\#CONTENIDO\#/ms' ,\$html , \$pagina);\n"
            . "    \$this->view_page(\$pagina);\n"
            . "}\n"
            . "function vistaCompleta(){\n"
            . "   \$pagina=\$this->load_template('Vista completa de $alias');\n"
            . "   \$html = \$this->load_page('app/views/default/$entidad/v.vistaCompleta.php');\n"
            . "   \$pagina = \$this->replace_content('/\\#CONTENIDO\\#/ms' ,\$html , \$pagina);\n"
            . "   \$this->view_page(\$pagina);\n"
            . "}\n" 
            . "function ObtenGrid(){\n"
            . "  \$$entidad = new $entidad();\n"
            . "  \$".$entidad."->Grid();\n"
            . "}\n"
            . "function Insertar(){\n"
            . "  \$$entidad = new $entidad();\n"
            . "  \$".$entidad."->Insertar();\n"
            . "}\n"
            . "function Leer(){\n"
            . "  \$$entidad = new $entidad();\n"
            . "  \$".$entidad."->Leer();\n"
            . "}\n"
            . "function Actualizar(){\n"
            . "  \$$entidad = new $entidad();\n"
            . "  \$".$entidad."->Actualizar();\n"
            . "}\n"
            . "function Seleccionar(){\n"
            . "  \$$entidad = new $entidad();\n"
            . "  \$".$entidad."->Aeleccionar();\n"
            . "}\n"
            . "function Eliminar(){\n"
            . "  \$$entidad = new $entidad();\n"
            . "  \$".$entidad."->Eliminar();\n"
            . "}\n"
            . "}//fin clase mvc_controller$alias ";
    return $contenido;
    
}

//lista
function archivoModel($entidad, $alias, $datos){
    $contenido = "<?php \n"
            ."require_once 'db.class.php';\n"
            ."class $entidad extends database {\n"
            ."  private \$entidad = '".$entidad."';\n"
            ."  private \$alias = '".$alias."';\n"
            ."  private \$pk = array(".obtenLlave($datos).");\n"
            ."  private \$campos = array(".obtenCampos($datos).");\n"
            ."  private \$grid = array(".obtenGrid($datos).");\n"
            ."  function $entidad(){}\n"
            ."  function Insertar(){\n"
            ."    \$query = \" insert into \$this->entidad (".obtenCampos($datos,false).")\n"
            ."    values(\".\$this->vPOSTi(\$this->campos, \$this->alias).\")\";\n"
            ."    \$this->conectar();\n"
            ."    \$rs = \$this->exeQuery(\$query);\n"
            ."    \$msg = (\$rs)\n"
            ."    ?\"<div class='alert alert-success col-lg-12' role='alert'>Se guardó \$this->alias correctamente</div>\"\n"
            ."    :\"<div class='alert alert-warning col-lg-12' role='alert'>Error al guardar \$this->alias</div>\";\n"
            ."    \$this->desconectar();\n"
            ."    echo \$msg;\n"
            ."  }//fin insertar\n"
            ."  function Actualizar(){\n"
            ."    \$query = \" update \$this->entidad set \".\$this->vPOSTa(\$this->campos, \$this->alias). \n"
            ."    \" where \".\$this->vPOSTw(\$this->pk, \$this->alias); \n"
            ."    \$this->conectar();\n"
            ."    \$rs = \$this->exeQuery(\$query);\n"
            ."    \$msg = (\$rs)\n"
            ."    ?\"<div class='alert alert-success col-lg-12' role='alert'>Se modificó \$this->alias correctamente</div>\"\n"
            ."    :\"<div class='alert alert-warning col-lg-12' role='alert'>Error al modificar \$this->alias</div>\";\n"
            ."    \$this->desconectar();\n"
            ."    echo \$msg;\n"
            ."  }//fin actualizar\n"
            ."  function Leer(){ \n"
            ."    \$clausulas = \" where \".\$this->vPOSTw(\$this->pk, \$this->alias); \n" 
            ."    \$datos = \$this->Seleccionar('json',\$clausulas); \n"
            ."    echo \$datos;\n"
            ."  }//fin Leer\n"
            ."  function Seleccionar(\$salida = 'xml', \$clausulas = ''){\n"
            ."    \$datos = \"\";\n"
            ."    \$query = \"select \$this->entidad.* from \$this->entidad \".\$clausulas; \n"
            ."    \$this->conectar();\n"
            ."    \$rs = \$this->exeQuery(\$query);\n"
            ."    if(\$salida === 'xml'){\n"
            ."       \$datos = \$this->creaXML(\$rs);\n"
            ."    }elseif(\$salida === 'json'){\n"
            ."       \$datos = \$this->creaJSON(\$rs);\n"
            ."    }else if(\$salida === 'grid'){\n"
            ."       \$datos = \$this->creaGrid(\$this->grid, \$rs, \$this->pk, \$this->alias, \$this->entidad);\n"
            ."    }\n"
            ."    \$this->libera_resultado(\$rs);\n"
            ."    \$this->desconectar();\n"
            ."    return \$datos;\n"
            .""
            ."  }\n"
            ."  function Eliminar(){\n"
            ."    \$query = \" delete from \$this->entidad \n"
            ."    where \".\$this->vPOSTw(\$this->pk, \$this->alias); \n"
            ."    \$this->conectar();\n"
            ."    \$rs = \$this->exeQuery(\$query);\n"
            ."    \$msg = (\$rs)\n"
            ."    ?\"Se eliminó \$this->alias correctamente\"\n"
            ."    :\"Error al eliminar \$this->alias\";\n"
            ."    \$this->desconectar();\n"
            ."    echo \$msg;\n"
            ."  }\n"
            ."  function Grid(){\n"
            ."    \$cabecera = \$this->obtenCabeceraGrid(\$this->grid);\n"
            ."    \$tbl = \"<thead>\" \n"
            ."    . \$cabecera\n"
            ."    .\"</thead>\"\n"
            ."    . \"<tfoot>\"\n"
            ."    . \$cabecera\n"
            ."    . \"</tfoot>\"\n"
            ."    . \$this->Seleccionar(\"grid\");\n"
            ."    echo \$tbl;\n"
            ."  }\n"
            ."}//fin clase";
    return $contenido;
}

function archivoVCrear($entidad, $alias, $datos, $simple = false){
    //crearemos el html 
    $contenido =" <script> \n"
                ."    $(document).ready(function () {\n"
                ."        $(\"#btnSubmit\").click(function () { \n"
                ."                var options = { \n"
                ."                    beforeSubmit:  validaForm,  // pre-submit callback */\n"
                ."                    url: \"$alias.php?x=Insertar\" ,\n"
                ."                    type: \"post\",\n"
                ."                    error: error,\n"
                ."                    /*dataType: 'xml',*/\n"
                ."                    success:   respuesta  // post-submit callback \n"
                ."            }; \n"
                ."            $('#formMain').ajaxSubmit(options);\n"
                ."        });\n"
                .thereisCombo($datos)
                ."    });\n"
                .obtenComboFunctions($datos)
                ."</script>\n"
                ."<div class=\"row\">\n"
                ."    <div class=\"col-lg-12\">\n"
                ."        <div class=\"panel panel-default\">\n"
                .navegacion($simple,$alias, 'crear')
                ."            <div class=\"panel-heading\">\n"
                ."                <h4>\n"
                ."                    Crear ".custom_replace($alias)."\n"
                ."                </h4>\n"
                ."            </div>\n"
                ."            <div class=\"panel-body\">\n"
                ."                 <div class=\"row\">\n"
                ."                     <div class=\"col-lg-12\">\n"
                ."                         <form role=\"form\" enctype=\"multipart/form-data\" id=\"formMain\" class=\"form-horizontal\" >\n"
                .   obtenInputs($alias,$datos)
                ."                               <div class=\"form-group\">\n"
                ."                                    <div class=\"col-md-9 col-md-push-3\">\n"
                ."                                        <button type=\"button\" class=\"btn btn-default\" id=\"btnSubmit\">Enviar Formulario</button>\n"
                ."                                        <button type=\"reset\" class=\"btn btn-default\" id=\"btnReset\">Reset Button</button>\n"
                ."                                    </div>\n"
                ."                                </div>\n"
                ."                                <div class=\"form-group\">\n"
                ."                                    <div class=\"col-md-9 col-md-push-3\" id=\"divRespuesta\"> </div>\n"
                ."                                </div>\n"
                . "                        </form>\n"
                . "                 </div><!--row-->\n"
                . "          </div><!--div panel-body-->\n"
                . "       </div><!--div panel-default-->\n"
                . "   </div><!--col-lg-12-->\n"
                . "</div><!--row-->\n";
    return $contenido;
}

function archivoVModificar($entidad, $alias, $datos, $simple = false){
    //crearemos el html 
    $contenido ="<script> \n"
                ."    $(document).ready(function () {\n"
                ."        $(\"#btnSubmit\").click(function () { \n"
                ."            var options = { \n"
                ."                beforeSubmit:  validaForm,  // pre-submit callback */\n"
                ."                url: \"$alias.php?x=Actualizar&tk=\"+\$.urlParam('tk') , \n"
                ."                type: \"post\",\n"
                ."                error: error,\n"
                ."                /*dataType: 'xml',*/\n"
                ."                success:   respuesta  // post-submit callback \n"
                ."            }; \n"
                ."            $(\"#formMain\").ajaxSubmit(options);\n"
                ."        });\n"
                ."        $(\"#btnReset\").click(function () { \n"
                ."            leerDatos(); \n"
                ."        }); \n"
                .thereisCombo($datos,"leerDatos();")
                ."    });\n"
                .obtenComboFunctions($datos,"leerDatos();")
                ."function leerDatos(){ \n"
                ."    var url = \"$alias.php?x=Leer&tk=\"+$.urlParam('tk'); \n"
                ."    $.post(url, function(data, status){ \n"
                ."        dataObj = $.parseJSON(data); \n"
                ."        llenarForm('#formMain', dataObj); \n"
                ."    }); \n"
                ."} \n"
                ."</script>\n"
                ."<div class=\"row\">\n"
                ."    <div class=\"col-lg-12\">\n"
                ."        <div class=\"panel panel-default\">\n"
                .navegacion($simple, $alias, 'modificar')
                ."            <div class=\"panel-heading\">\n"
                ."                <h4>\n"
                ."                    Modificar ".custom_replace($alias)."\n"
                ."                </h4>\n"
                ."            </div>\n"
                ."            <div class=\"panel-body\">\n"
                ."                 <div class=\"row\">\n"
                ."                     <div class=\"col-lg-12\">\n"
                ."                         <form role=\"form\" enctype=\"multipart/form-data\" id=\"formMain\" class=\"form-horizontal\" >\n"
                .   obtenInputs($alias,$datos)
                ."                               <div class=\"form-group\">\n"
                ."                                    <div class=\"col-md-9 col-md-push-3\">\n"
                ."                                        <button type=\"button\" class=\"btn btn-default\" id=\"btnSubmit\">Enviar Formulario</button>\n"
                ."                                        <button type=\"reset\" class=\"btn btn-default\" id=\"btnReset\">Reset Button</button>\n"
                ."                                    </div>\n"
                ."                                </div>\n"
                ."                                <div class=\"form-group\"\n"
                ."                                    <div class=\"col-md-9 col-md-push-3\" id=\"divRespuesta\"> </div>\n"
                ."                                </div>\n"
                . "                        </form>\n"
                . "                 </div><!--row-->\n"
                . "          </div><!--div panel-body-->\n"
                . "       </div><!--div panel-default-->\n"
                . "   </div><!--col-lg-12-->\n"
                . "</div><!--row-->\n";
    return $contenido;
}

function archivoVBuscar($entidad, $alias, $datos, $simple = false){
    //crearemos el html 
    $contenido =" <script> \n"
                ."    $(document).ready(function () {\n"
                ."         $.post(\"$alias.php\",{x:'Grid'},function(rt,st){\n"
                ."              tabla = $('#tablaDatos').html(rt).DataTable(optDataTable);\n"
                ."              eventoBtn(tabla);\n"
                ."          })\n"
                ."    });\n"
                ."</script>\n"
                ."<div class=\"row\">\n"
                ."    <div class=\"col-lg-12\">\n"
                ."        <div class=\"panel panel-default\">\n"
                .navegacion($simple, $alias, 'buscar')
                ."            <div class=\"panel-heading\">\n"
                ."                <h4>\n"
                ."                    Buscar ".custom_replace($alias)."\n"
                ."                </h4>\n"
                ."            </div>\n"
                ."            <div class=\"panel-body\">\n"
                ."                 <div class=\"row\">\n"
                ."                     <div class=\"col-lg-12\">\n"
                ."                         <form role=\"form\" enctype=\"multipart/form-data\" id=\"formMain\" class=\"form-horizontal\" >\n"
                ."                              <table id=\"tablaDatos\" class=\"display table\" cellspacing=\"0\" width=\"100%\">\n"
                ."                              </table>\n"
                ."                          </form>\n"
                . "                 </div><!--row-->\n"
                . "          </div><!--div panel-body-->\n"
                . "       </div><!--div panel-default-->\n"
                . "   </div><!--col-lg-12-->\n"
                . "</div><!--row-->\n";
    return $contenido;
}

//no requiere modificaciones
function obtenLlave( $datos ){
    $campos = "";
    $max = sizeof ($datos);
    $cont = 1;
    //echo "tamaño del arreglo ".sizeof ($datos);
    foreach($datos as $campo){
        if($campo['Key'] == 'PRI'){
            $campos .= "'".$campo['Field']."'";
            $cont++;
        }else if($campo['Key'] == 'PRI' && $cont > 1){
            $campos .= ($cont++ < $max)?",":"";
            $campos .= "'".$campo['Field']."'";
        }else{ $cont++; }   
    }return $campos;
      
}
//no requiere modificaciones
function obtenCampos($datos, $ban = true){
    $campos = "";
    $max = sizeof ($datos);
    $cont = 1;
    //echo "tamaño del arreglo ".sizeof ($datos);
    foreach($datos as $campo){
        $campos .= ($ban)? "'".$campo['Field']."'": $campo['Field'] ;
        //$campos .= "'" .$campo['Field'] ."'" ;
        $campos .= ($cont++ < $max)?",":"";
    }
    //Quita 'fechaCreacion' de los campos
    //$campos = str_replace(",fechaCreacion", "", $campos);
    //$campos = str_replace(",'fechaCreacion'", "", $campos);
    return $campos;
}
//no requiere modificaciones
function obtenGrid($datos){
    $campos = "";
    $max = sizeof ($datos);
    $cont = 1;
    //echo "tamaño del arreglo ".sizeof ($datos);
    foreach($datos as $campo){
        $campos .= "'".$campo['Field']."'=>'".custom_replace($campo['Field'])."'";
        $campos .= ($cont++ < $max)?",":"";
    }
    //Quita 'fechaCreacion' de los campos
    $campos = str_replace(",'fechaCreacion'=>'Fecha Creacion'", "", $campos);
    return $campos;
}
//no requiere modificaciones
function thereisCombo($datos,$callback = ""){
    $thereisCombo = "";
    foreach($datos as $dato){
        if ( $dato['Key'] == "MUL" ){
            $thereisCombo .= "        $(\"#".$dato['Field']." + a.emergente\").fancybox({afterClose: function(){ carga_".$dato['Field']."(); }});\n";
        }
    }
    if ($thereisCombo != ""){
        $pre = "        _cargaCombo();\n";
        $post = "";        
    } else {
        $pre = "";
        $post = "        $callback;\n";
    }
    return $pre.$thereisCombo.$post;
}
//no requiere modificacion
function obtenComboFunctions($datos,$callback = ""){
    $comboFunc = "";
    $functions = "";
    foreach($datos as $dato){
        if ( $dato['Key'] == "MUL" ){
            $comboFunc .="function carga_".$dato['Field']."(){\n"
                       ."    var deferred = new \$.Deferred();\n"
                       ."    \$.post(\"configCmb.php\",{x:\"carga_".$dato['Field']."\"},\n"
                       ."        function(rt,st){\n"
                       ."            \$(\"#".$dato['Field']."\").html(rt);\n"
                       ."            deferred.resolve();;\n"
                       ."        });\n"
                       ."    return deferred.promise();\n"
                       . "}\n";
            if ($functions != ""){
                $functions .= ",";
            }
            $functions .="carga_".$dato['Field']."()";
        }
    }
    if ($functions != ""){
        $cargaCombo = "function _cargaCombo(){\n"
                   . "    \$.when($functions)\n"
                   . "        .done(function(){\n"
                   . "            $callback\n"
                   . "        });\n"
                   . "}\n";
    } else {
        $cargaCombo = "";
    }
    return $comboFunc.$cargaCombo;
}
function obtenInputs($alias,$datos){
    $input ="";
    $first = 1;
    $readonly = "";
    foreach($datos as $dato){
        if ($first==1){
            $validar = 0;
            $first = 0;
            $readonly = "readonly";
        } else {
            $validar = ($dato['Null'] == "NO")?1:0;
            $readonly = "";
        }
        $aliasCombo = str_replace("id","",$dato['Field']);
        $max = obtenMaxlength( $dato['Type'] ) ;       
        if ( $dato['Field'] == "activo" ){
            //Si el campo se llama 'activo' crea un input tipo radio >>>
            $input .="                         <div class=\"form-group\">\n"
                ."                              <label class=\"control-label col-md-3\" for=\"".$dato['Field']."\">Activo</label>\n"
                ."                              <div class=\"col-md-9\">\n"
                ."                                  <label class=\"radio-inline\" for=\"".$dato['Field']."1\">\n"
                ."                                      <input type=\"radio\" name=\"".$alias."[".$dato['Field']."]\" id=\"".$dato['Field']."1\" value=\"1\" checked>Activo\n"
                ."                                  </label>\n"
                ."                                  <label class=\"radio-inline\" for=\"".$dato['Field']."2\">\n"
                ."                                      <input type=\"radio\" name=\"".$alias."[".$dato['Field']."]\" id=\"".$dato['Field']."2\" value=\"2\">Inactivo\n"
                ."                                  </label>\n"
                ."                              </div>\n"
                ."                          </div>\n";
        } else if ( $dato['Key'] == "MUL" ){
            $aliasCombo = str_replace("id","",$dato['Field']);
            $input .="                         <div class=\"form-group\">\n"
                ."                              <label class=\"control-label col-md-3\" for=\"".$dato['Field']."\">".custom_replace($dato['Field'])."</label>\n"
                ."                              <div class=\"col-md-9\">\n"
                ."                                  <select name=\"".$alias."[".$dato['Field']."]\" validar=\"$validar\" id=\"".$dato['Field']."\"  class=\"form-control\">\n"
                ."                                  </select>\n"
                ."                                  <a class=\"emergente fancybox.iframe\" href=\"$aliasCombo.php?x=simpleCrear\" >Agregar un valor nuevo</a>\n"
                ."                              </div>\n"
                ."                         </div>\n";
        } else if ( $dato['Field'] == "fechaCreacion" ){
            // Si el campo se llama 'fechaCreacion' no crea ningún input >>>
        } else if ( $dato['Type'] == "TEXT" ){
            $input .="                         <div class=\"form-group\">\n"
                ."                              <label class=\"control-label col-md-3\" for=\"".$dato['Field']."\">".custom_replace($dato['Field'])."</label>\n"
                ."                              <div class=\"col-md-9\">\n"
                ."                                  <textarea name=\"".$alias."[".$dato['Field']."]\" placeholder=\"".custom_replace($dato['Field'])."\" validar=\"$validar\" id=\"".$dato['Field']."\" maxlength=\"$max\" class=\"form-control\" $readonly></textarea>\n"
                ."                              </div>\n"
                ."                         </div>\n";
        } else {
            //Si no, crea un input tipo text >>>
            $input .="                         <div class=\"form-group\">\n"
                ."                              <label class=\"control-label col-md-3\" for=\"".$dato['Field']."\">".custom_replace($dato['Field'])."</label>\n"
                ."                              <div class=\"col-md-9\">\n"
                ."                                  <input name=\"".$alias."[".$dato['Field']."]\" placeholder=\"".custom_replace($dato['Field'])."\" validar=\"$validar\" id=\"".$dato['Field']."\" maxlength=\"$max\" class=\"form-control\" $readonly>\n"
                ."                              </div>\n"
                ."                         </div>\n";
        }
    }
    return $input;
}

//lista
function obtenMaxlength($string){
    $string = str_replace("int(","",$string);
    $string = str_replace("varchar(","",$string);
    $string = str_replace("char(","",$string);
    $string = str_replace(")", "", $string);
    $string = (is_numeric($string))?$string:100;
    return $string;
}

//lista
function navegacion($simple = false, $alias = "", $activo = "" ){
    if ($simple) {
        $simpleCrear = '';
        $simpleBuscar = '';
        if ($activo == 'crear') {
            $simpleCrear = 'class="active"';
        } else if ($activo == 'buscar') {
            $simpleBuscar = 'class="active"';
        }
        return "              <div class=\"bs-example\" data-example-id=\"nav-tabs-with-dropdown\">\n"
        . "                    <ul class=\"nav nav-tabs\">\n"
        . "                        <li $simpleCrear role=\"presentation\"><a href=\"$alias.php?x=simpleCrear\">Crear</a></li>\n"
        . "                        <li $simpleBuscar role=\"presentation\"><a href=\"$alias.php?x=simpleBuscar\">Buscar</a></li>\n"
        . "                    </ul>\n"
        . "                </div>\n";
    } else {
        $crear = '';
        $buscar = '';
        $vistaCompleta = '';
        if ($activo == 'crear') {
            $crear = 'class="active"';
        } else if ($activo == 'buscar') {
            $buscar = 'class="active"';
        } else if ($activo == 'vistaCompleta') {
            $vistaCompleta = 'class="active"';
        }
        return "              <div class=\"bs-example\" data-example-id=\"nav-tabs-with-dropdown\">\n"
        . "                    <ul class=\"nav nav-tabs\">\n"
        . "                        <li $crear role=\"presentation\"><a href=\"?x=crear\">Crear</a></li>\n"
        . "                        <li $buscar role=\"presentation\"><a href=\"?x=buscar\">Buscar</a></li>\n"
        . "                    </ul>\n"
        . "                </div>\n";
    }
}
//lista
function custom_replace($str){
    //Inserta espacio antes de cada mayúscula
    $str = preg_replace('/(\w+)([A-Z])/U', '\\1 \\2', $str);
    //Primer caracter de la cadena a mayúscula
    $str = ucfirst($str);
    
    //Palabras con acentos
    $str = str_replace("Observacion", "Observación", $str);
    $str = str_replace("Descripcion", "Descripción", $str);
    $str = str_replace("Abreviacion", "Abreviación", $str);
    $str = str_replace("Electronico", "Electrónico", $str);
    $str = str_replace("Numero", "Número", $str);
    $str = str_replace("Pais", "País", $str);
    $str = str_replace("Codigo", "Código", $str);
    $str = str_replace("Articulo", "Artículo", $str);
    //Correción de remplazos equivocados
    $str = str_replace("Observaciónes", "Observaciones", $str);
    
    //Return
    return $str;
}