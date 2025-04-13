<?php
 require "app/controller/cabecera.inc.php";
 require 'app/controller/mvc.controllerCombo.php';
$mvc = new mvc_controllerCombo();
/* 
 * Crear las opciones del los xml o incluso las option de un combo+
 */
 
 if(!empty($accion)){
     $mvc->cargaCombo($accion);
 }else{
     echo "<option>Error al cargar el combo</option>";
 }

