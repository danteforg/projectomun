<?php
 require "app/controller/cabecera.inc.php";
 require 'app/controller/mvc.controllerCheckBox.php';
$mvc = new mvc_controllerCheckBox();
/* 
 * Crear las opciones del los xml o incluso las option de un combo+
 */
 
 if(!empty($accion)){
     $mvc->cargaCheckBox($accion);
 }else{
     echo "<option>Error al cargar los check box</option>";
 }

