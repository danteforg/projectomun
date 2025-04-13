<?php
    require 'app/controller/cabecera.inc.php';
    require 'app/controller/mvc.controllerUsuario.php';

     //se instancia al controlador  
    $mvc = new mvc_controllerUsuario();

	
    if( $accion == 'perfil' ) {
        $mvc->perfil();
    }else if($accion === 'simpleCrear'){
        $mvc->simpleCrear();
    }else if($accion === 'crear'){
       $mvc->crear();
    }else if($accion === 'mapa'){
       $mvc->mapa();
    }else if ($accion === 'modificar'){
       $mvc->modificar();
    }else if ($accion === 'buscar'){
     $mvc->buscar();
    }else if ($accion === 'vistaCompleta'){
       $mvc->vistaCompleta();
    }else if ($accion === 'Grid'){
       $mvc->ObtenGrid();
    }else if ($accion === 'Insertar'){
       $mvc->Insertar();
    }else if ($accion === 'Leer'){
       $mvc->Leer();
    }else if ($accion === 'LeerP'){
       $mvc->LeerP();
    }else if ($accion === 'Actualizar'){
       $mvc->Actualizar();
    }else if ($accion === 'Seleccionar'){
       $mvc->Seleccionar();
    }else if ($accion === 'Eliminar'){
       $mvc->Eliminar();
    }else if ($accion === 'cerrarSesion'){
       $mvc->cerrarSesion();
    }else{
       $mvc->pagina_notFound();
    }
?>