<HTML LANG="es">
<HEAD>
<TITLE>Proyecto No1 </TITLE>
<LINK REL="stylesheet" TYPE="text/css" HREF="css/estilo.css">
</HEAD>
<BODY>
<H1>Encuesta. Resultados.</Hl>
<?PHP
require_once ("class/procesos.php" );
$obj_encab = new encuestas();
$result_encabs = $obj_encab->listar_res_enc();
foreach ($result_encabs as $result_encab){
            $id_enc=$result_encab['id_encuesta'];
            $nom_encuesta=$result_encab['nom_encuesta'];
            $obj_resp = new encuestas();
            $result_resps = $obj_resp->listar_respuestas($id_enc);
            $totalresp=0;
            print ("<H1>$nom_encuesta</Hl>\n");
            print ("<TABLE>\n");
            print ("<TR>\n");
            print ("<TH>Respuesta</TH>\n"); 
            print ("<TH>Cantidad</TH>\n"); 
            print ("<TH>Porcentaje</TH>\n");
            print ("<TH>Representacion grafica</TH>\n");
            print("</TR>\n");
            foreach ($result_resps as $result_resp){
            $resp=$result_resp['cantidad'];
            $det=$result_resp['descripcion'];
            $totalresp=$result_resp['cantidad_total'];
            if ($totalresp == 0){
                $porcentaje = 0;
            }else{
                $porcentaje = round(($resp/$totalresp)*100,2);
            }
            print ("<TR>\n");
            print ("<TD CLASS='izquierda'>$det</TD>\n"); 
            print ("<TD CLASS='derecha'>$resp</TD>\n"); 
            print ("<TD CLASS='derecha'>$porcentaje%</TD>\n"); 
            print ("<TD CLASS='izquierda' WIDTH='400'><IMG SRC='img/puntoamarillo.gif' HEIGHT='10' WIDTH='". $porcentaje*4 ."'></TD>\n");
            print("</TR>\n");
            }
            print("</TABLE>\n");
            print("<P>Numero total de respuestas emitidas: $totalresp </P>\n");
            
        }
        print("<P><A HREF='encuesta.php'>Pagina de encuestas</A></P>\n");
?>
</BODY>
</HTML>
