<?php
	/**
		Parte del index del desarrollo, 
	**/
	//error_reporting(0);
	//debemos crear de cabecera
	//validar la sesion, si no esta lista debe pedir el login
        require 'app/controller/cabecera.inc.php';
        require 'app/controller/mvc.controllerIndex.php';
	//	

     //se instancia al controlador generico
	$mvc = new mvc_controllerIndex();
	
	//debemos crear todos los metodos genericos, al final se llaman igual y seran ocupados
	/*
		
	*/

	if( $accion == 'buscar' ) //muestra el modulo del buscador
	{	
			$mvc->buscador();	
	}else{
		$mvc->pagina_notFound();
	}
	

?>