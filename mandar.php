<?php
require('app/model/fpdf/fpdf.php');

                $pdf = new FPDF();
              switch (date("n")) {
                case 1:
                  $Mes = "Enero";
                  break;
                case 2:
                  $Mes = "Febrero";
                  break;
                case 3:
                  $Mes = "Marzo";
                  break;
                case 4:
                  $Mes = "Abril";
                  break;
                case 5:
                  $Mes = "Mayo";
                  break;
                case 6:
                  $Mes = "Junio";
                  break;
                case 7:
                  $Mes = "Julio";
                  break;
                case 8:
                  $Mes = "Agosto";
                  break;
                case 9:
                  $Mes = "Septiembre";
                  break;
                case 10:
                  $Mes = "Octubre";
                  break;
                case 11:
                  $Mes = "Noviembre";
                  break;
                case 12:
                  $Mes = "Diciembre";
                  break;
              }
              $rep = $_POST['idprocedimiento'];

              $conexion = mysqli_connect('localhost', 'root', '','mydb');
              //CALLE
              $sql = "select ca.nombre as Calle, co.nombre AS Colonia, us.nombre as Usuario 
              from reporte as r
              INNER JOIN calle as ca ON r.idCalle = ca.idCalle
              INNER JOIN colonia AS co ON r.idColonia = co.idColonia
              INNER JOIN usuario AS us ON r.idUsuarioB = us.idUsuario 
              where r.idprocedimiento ='$rep'";
              $resultado = mysqli_query($conexion,$sql) or die("No se encontro nada".mysqli_error($conexion));
              while($fila = mysqli_fetch_array($resultado)){
              //El resultado de la consulta estarán en nombre y apellido, entonces:
              $Calle= $fila['Calle'];
              $Colonia= $fila['Colonia'];
              $Identificacion= $fila['Usuario'];
              }


              $Dia = date("j");
              $nombre = $_POST['procedimiento']['nombreCivil'];
              
              //print_r($nombre);
             // echo $nombre ." ". $rep;
              //$Identificacion = $fila['Usuario'];
              $numero_Calle = $_POST['numero_Calle'];
              //$Calle = $fila['Calle'];
              //$Colonia = $fila['Colonia'];
              $horario1 = $_POST['procedimiento']['hInicio'];
              $horario2 = $_POST['procedimiento']['hFinal'];
              $dias = $_POST['procedimiento']['recoleccion'];
              
              $horarios = $horario1.' - '.$horario2;
              $pdf2=$_POST['pdf'];
              $comercio = $_POST['procedimiento']['comercio'];
              $licencia = $_POST['procedimiento']['licencia'];
              $comb = $Calle.', #'.$numero_Calle;
            if (isset($_POST['create_pdf'])) {
              if($_POST['pdf'] == 1){
                  $pdf->AddPage();
                  $pdf->Image('images/ayu.png',0,0,210,300);
                  $pdf->SetFont('Arial','B',8);
                  //dia
                  $pdf->Text(143,53,$Dia);
                  //mes
                  $pdf->Text(153,53,$Mes);
                  //Nombre
                  $pdf->Text(42,67.5,$nombre);
                  //Identificación
                  $pdf->Text(53,71.5,$Identificacion);
                  //Domicilio
                  $pdf->Text(43,75,$comb);
                  //Colonia
                  $pdf->Text(42,79,$Colonia);
                  //Hora 
                  $pdf->Text(66,152.5,$horarios);
                  //Dias
                  $pdf->Text(130,152.5, $dias);
                  $pdf->Output();
              }else if($pdf2==2){
                  $pdf->AddPage();
                  $pdf->Image('images/vit1.png',0,0,210,300);
                  $pdf->SetFont('Arial','B',8);
                  //dia
                  $pdf->Text(141,59,$Dia);
                  //mes
                  $pdf->Text(151,59,$Mes);
                  //Nombre
                  $pdf->Text(44,75.5,$nombre);
                  //Identificación
                  $pdf->Text(58,80,$Identificacion);
                  //Comercio
                  $pdf->Text(71,84,$comercio);
                  //Domicilio
                  $pdf->Text(46,88,$comb);
                  //Licencia
                  $pdf->Text(76,92.5,$licencia);
                  //Dias
                  $pdf->Text(80,185.5,$dias);
                  //Hora inicio
                  $pdf->Text(158,185.5,$horario1);
                  //Hora final
                  $pdf->Text(173,185.5,$horario2);
                  $pdf->AddPage();
                  $pdf->Image('images/vit2.png',0,0,210,300);
                  $pdf->Output();
 
}
              }
           
           

?>