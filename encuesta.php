<HTML LANG="es">
    <HEAD>
        <TITLE>Laboratorio 10.1</TITLE>
        <LINK REL="stylesheet" TYPE="text/css" HREF="css/estilo.css">
</HEAD>
<BODY>
<?PHP
require_once("class/procesos.php");
$obj_detalle = new encuestas();
$result_dets = $obj_detalle->listar_det_enc();
$obj_encabezado = new encuestas();
$result_res = $obj_encabezado->listar_res_enc();
$obj_insert = new encuestas();
if(array_key_exists('enviar', $_POST)){
    $nombre=$_REQUEST['nombre'];
    $cedula=$_REQUEST['cedula'];
    foreach ($result_res as $result_r){
        $cod=$result_r['id_encuesta'];
        if(isset($_POST[$cod])){
            /*echo "Si selecciono alguna opcion para este valor: ".$cod."<br>"; */
                if (is_array($_POST[$cod])) {
                    $selected = '';
                    $num_countries = count($_POST[$cod]);
                    $current = 0;
                    foreach ($_POST[$cod] as $key => $value) {
                        $id_enc = $cod;
                        $id_det_enc = $value;
                        $result_insert = $obj_insert->insertar_resp($id_enc,$id_det_enc,$nombre,$cedula);
                    }
                }
        }else {
                /*echo "No selecciono ninguna opcion en este valor: ".$cod."<br>";*/
        }
    }
    if($result_insert){
        print ("<P>Su encuesta ha sido registrada. Gracias por participar</P>\n");
        print("<A HREF='reporte.php'>Ver resultados</A>\n");
        print("<A HREF='encuesta.php'>Crear otra escuesta</A>\n");
    }
    else{
        print ("<A HREF='reporte.php'>Error al actualizar su encuesta</A>\n");
    }  
}
else{

?>
<FORM ACTION="encuesta.php" METHOD="POST">
<H1>Encuesta</H1>
</BR>
<H3>Nombre</H3>
<INPUT TYPE="TEXTBOX" NAME="nombre" VALUE="" REQUIRED><BR>
</BR>
<H3>Cedula</H3>
<INPUT TYPE="TEXTBOX" NAME="cedula" VALUE="" REQUIRED><BR>
<?PHP
    $titulo="noasignado";
    if($result_dets){
        foreach ($result_dets as $result_det){
            if ($titulo!=$result_det['nom_encuesta']){
                $titulo=$result_det['nom_encuesta'];
                print ("<H2><P>$titulo</P></H2>\n");
            }
            if($result_det['tipo']=='RB'){

?>   
                <INPUT TYPE="RADIO" NAME=<?php echo $result_det['id_encuesta']?>[] VALUE=<?php echo $result_det['id_det']?> REQUIRED><?php echo $result_det['descripcion']?><BR>
                <?PHP
            }
            else{
                ?>
                <INPUT TYPE="CHECKBOX" NAME=<?php echo $result_det['id_encuesta']?>[] VALUE=<?php echo $result_det['id_det']?>><?php echo $result_det['descripcion']?><BR>
                </BR>
    <?PHP
        }    
    }
}
    ?>
    </BR>
    <INPUT TYPE="SUBMIT" NAME="enviar" VALUE="Guardar">
</FORM>
<A HREF="reporte.php">Ver resultados</A>
<?PHP
}    
?>
</BODY>
</HTML>