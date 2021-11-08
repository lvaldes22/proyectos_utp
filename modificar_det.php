<?php

require_once("class/procesos.php");
$id = $_GET['id'];
$obj_result = new encuestas();
$results = $obj_result->listar_detalle_sp($id);
if($results){
  foreach ($results as $result) {
    $vid_enc = $result["id_encuesta"];
    $vnom_enc = $result["nom_encuesta"]; 
    $vtipo = $result["tipo"]; 
    $vdet_enc = $result["descripcion"]; 
  }
}

if (isset($_POST['submit'])) {
  $nom_det=$_POST['detalle'];
  
  $obj_update = new encuestas();
  $result_update = $obj_update->modificar_detalle($id,$nom_det);
  if($result_update){
    ?>
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <h2 class="mt-4">El registro ha sido modificado</h2>
            </div>
          </div>
        </div>
    <?php
    $obj_result = new encuestas();
    $results = $obj_result->listar_detalle_sp($id);
    if($results){
      foreach ($results as $result) {
        $vid_enc = $result["id_encuesta"];
        $vnom_enc = $result["nom_encuesta"]; 
        $vtipo = $result["tipo"]; 
        $vdet_enc = $result["descripcion"]; 
      }
    }
  }
  else{
    ?>
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <h2 class="mt-4">Error al modificar el registro</h2>
            </div>
          </div>
        </div>
    <?php
  } 
}
?>

<?php include 'templates/header.php'; ?>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h2 class="mt-4">Modificar opcion de encuesta</h2>
      <hr>
      <form method="post">
        <div class="form-group">
          <label for="encuesta">Opcion Encuesta</label>
          <input type="text" name="detalle" id="detalle" class="form-control"><?php print "Valor Actual: ".$vdet_enc; ?>
        </div>
        <div class="form-group">
          
          <input type="submit" name="submit" class="btn btn-primary" value="Enviar">
          <a class="btn btn-primary" href="<?= 'crear_detalle.php?id=' . $vid_enc  . '&nom_enc=' . $vnom_enc . '&tipo=' . $vtipo ?>">Volver al detalle de la encuesta</a>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include 'templates/footer.php'; ?>