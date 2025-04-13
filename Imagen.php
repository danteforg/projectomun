<?php 
/**Archivo Raiz de la entidad imagen**/

//librerias
require_once 'app/controller/cabecera.inc.php';
require_once 'app/controller/mvc.controllerImagen.php';
$mvc = new mvc_controllerImagen();

if($accion === 'crear'){
   $mvc->crear();
}else if ($accion === 'Insertar'){
   $mvc->Insertar();
}else if ($accion === 'Leer'){
   $mvc->Leer();
}else if ($accion === 'Seleccionar'){
   $mvc->Seleccionar();
}else if ($accion === 'Eliminar'){
   $mvc->Eliminar();
}else{
   $mvc->pagina_notFound();
}