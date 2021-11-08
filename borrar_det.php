<?php

include 'templates/header.php';
require_once("class/procesos.php");

$obj_eliminar = new encuestas();
$obj_validar = new encuestas();

$id = $_GET['id'];
$id_enc = $_GET['id_enc'];
$nom_enc = $_GET['nom_enc'];
$tipo =  $_GET['tipo'];

$result_validar = $obj_validar->validar_resp_det_sp($id_enc,$id);
foreach ($result_validar as $result_valid) {
  $count_validar = $result_valid["registros"]; 
}
if($count_validar > 0){
   ?>
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <h3 class="mt-4">No se puede eliminar el registro porque esta siendo utilizado.</h3>
              <a class="btn btn-primary" href="<?= 'crear_detalle.php?id=' . $id_enc  . '&nom_enc=' . $nom_enc . '&tipo=' . $tipo ?>">Volver al detalle de la encuesta</a>
            </div>
          </div>
        </div>
    <?php
}else{
      $result_eliminar = $obj_eliminar->eliminar_detalle($id,$id_enc);  
      if($result_eliminar){
        
          ?>
                <div class="container">
                  <div class="row">
                    <div class="col-md-12">
                      <h2 class="mt-4">El registro ha sido eliminado</h2>
                      <a class="btn btn-primary" href="<?= 'crear_detalle.php?id=' . $id_enc  . '&nom_enc=' . $nom_enc . '&tipo=' . $tipo ?>">Volver al detalle de la encuesta</a>
                    </div>
                  </div>
                </div>
            <?php
        }
        else{
          ?>
                <div class="container">
                  <div class="row">
                    <div class="col-md-12">
                      <h2 class="mt-4">Error al eliminar el registro</h2>
                      <a class="btn btn-primary" href="<?= 'crear_detalle.php?id=' . $id_enc  . '&nom_enc=' . $nom_enc . '&tipo=' . $tipo ?>">Volver al detalle de la encuesta</a>
                    </div>
                  </div>
                </div>
            <?php
        }  
  }

?>
<?php include 'templates/footer.php'; ?>