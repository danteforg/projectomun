<?php
    error_reporting(0);
    require 'app/controller/mvc.controllerUsuario.php';
    if(isset($_GET['acceder']) && $_GET['acceder'] == 'true'){
            $mvc = new mvc_controllerUsuario();
            $mvc->accede();
    }
    $x = "";
    if (isset($_GET['x']) && !empty( $_GET['x'] )){
        $x = "x=".$_GET['x'];
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Municipio</title>

    <!-- Bootstrap Core CSS -->
    <link href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Inicio de sesion Municipio</h3>
                    </div>
                    <div class="panel-body">
                        <form action="?acceder=true&<?php echo $x; ?>" id="formLogin" method="POST" role="form">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Usuario" name="usuario" 
                                           id="usuario" type="usuario" autofocus value="<?php echo $_POST['usuario'] ?>" >
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Contraseña" name="password" id="password" type="password" >
                                </div>
                                
                                <input type="submit" id="btnAcceder" class="btn btn-lg btn-info btn-block" value="ACCEDER" />
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>

	 <!-- Libreria con funciones Generales JavaScript -->
    <script src="js/general.js"></script>
	<script>
		$(document).ready(function(){
			$("#btnAcceder").click(function(){
				$(".alert-danger").remove()
                                bandera = true;
				if($("#usuario").val() == ""){
                                        $("#usuario").after("<div class='alert alert-danger' role='alert'>El usuario no puede ir vacio!!</div>");
                                        bandera = false;
				}
				if($("#password").val() == ""){
                                        $("#password").after("<div class='alert alert-danger' role='alert'>La contraseña no puede ir vacia!!</div>");
                                        bandera = false;
				}
                                if( bandera )
                                    $("#formLogin").submit();
			})
			
		})
	</script>
</body>

</html>
