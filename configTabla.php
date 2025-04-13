<?php
 require "app/controller/cabecera.inc.php";
 require 'app/controller/mvc.controllerTabla.php';
$mvc = new mvc_controllerTabla();
/* 
 * Crear las opciones del tablas dentro de un formulario
 */
 
 if(!empty($accion)){
     $mvc->cargaTabla($accion);
 }else{
     echo "<option>Error al cargar la tabla</option>";
 }

