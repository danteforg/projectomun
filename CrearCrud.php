<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require 'app/model/db.class.php';
$db = new database();
$query = "show tables";
$db->conectar();
$result = $db->exeQuery($query);

?>

<html>
    <!-- Bootstrap Core CSS -->
    <link href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
     <!-- jQuery -->
   <script src="bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    
    <script src="js/general.js"></script>
    
    
    <script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function(){
            $("#inicio").change(function(){
                $(".alert").remove()
                if($(this).val() != -1){
                    $("#Alias").val($(this).val().alias());
                }else{
                    muestraMensajeA("alert-danger", $(this), "Opcion no valida")
                }
            })
            $("#btnGenrar").click(function (){
                if( confirm("�Realmente desea GENERAR EL CRUD?") ){
                    muestraLoading($(this));
                    $.post("crud/crud.php", {inicio: $("#inicio").val(), alias:$("#Alias").val()}, 
                        function(rt,st){
                            $("#debug").append("<br>-------------<br>"+rt)
                        }) 
                }
            })
            
          // alert() 
        });
    </script>
    <body>
        <div class="row">
            <div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Mantenimiento de Usuario
			</div>
                </div>
                <div class="col-lg-2">
                    Seleccionar Entidad:
                </div>
                <div class="col-lg-3">
                    <select class="form-control" id="inicio">
                        <option value="-1">----seleccionar----</option>
                        <?php
                            //print_r($result);
                            while($row = mysqli_fetch_array($result)){
                               
                                echo "<option value='".$row['Tables_in_muni']."'>".
                                        $row['Tables_in_muni']."</option>";
                            }
                            mysqli_free_result($result);
                            $db->desconectar();
                                    
                        ?>
                    </select>
                </div>
                <div class="col-lg-3">
                    <input type="text" placeholder="Alias de la entidad" id="Alias" vacio="no" class="form-control" />
                    <ul>
                        <li>Sin espacios.</li>
                        <li>Primer letra de cada palabra en mayúsculas.</li>
                    </ul>
                </div>
                <div class="col-lg-4">
                    <input type="button" class="btn btn-primary" id="btnGenrar" value="GENERAR CRUD" />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8">
                <div class="col-lg-1"></div>
                <div class="col-lg-10">
                    aqui los resultados
                    
                </div>
                <div class="col-lg-1"></div>
            </div>
            <div class="col-lg-4">
                
                    <div class="col-lg-12" id="debug">aqui veremos que poner, como configuracion</div>
                
            </div>
        </div>
    </body>
</html>