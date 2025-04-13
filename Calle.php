<?php 
/**Archivo Raiz de la entidad calle**/

//librerias
require_once 'app/controller/cabecera.inc.php';
require_once 'app/controller/mvc.controllerCalle.php';
$mvc = new mvc_controllerCalle();

if($accion === 'crear'){
   $mvc->crear();
}else if ($accion === 'simpleCrear'){
   $mvc->simpleCrear();
}else if ($accion === 'modificar'){
   $mvc->modificar();
}else if ($accion === 'simpleModificar'){
   $mvc->simpleModificar();
}else if ($accion === 'buscar'){
   $mvc->buscar();
}else if ($accion === 'simpleBuscar'){
   $mvc->simpleBuscar();
}else if ($accion === 'vistaCompleta'){
   $mvc->vistaCompleta();
}else if ($accion === 'Grid'){
   $mvc->ObtenGrid();
}else if ($accion === 'Insertar'){
   $mvc->Insertar();
}else if ($accion === 'Leer'){
   $mvc->Leer();
}else if ($accion === 'Actualizar'){
   $mvc->Actualizar();
}else if ($accion === 'Seleccionar'){
   $mvc->Seleccionar();
}else if ($accion === 'Eliminar'){
   $mvc->Eliminar();
}else{
   $mvc->pagina_notFound();
}