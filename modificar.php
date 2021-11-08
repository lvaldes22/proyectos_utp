<?php

require_once("class/procesos.php");
$id = $_GET['id'];
$obj_result = new encuestas();
$results = $obj_result->listar_encuestas_sp($id);
if($results){
  foreach ($results as $result) {
    $vnom_enc = $result["nom_encuesta"]; 
    $vtipo = $result["tipo"]; 
  }
}

if (isset($_POST['submit'])) {
  $nom_enc=$_POST['encuesta'];
  $tipo=$_POST['tipo'];
  $obj_update = new encuestas();
  $result_update = $obj_update->modificar_encuesta($id,$nom_enc,$tipo);
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
    $results = $obj_result->listar_encuestas_sp($id);
    if($results){
      foreach ($results as $result) {
        $vnom_enc = $result["nom_encuesta"]; 
        $vtipo = $result["tipo"]; 
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
      <h2 class="mt-4">Modificar la encuesta</h2>
      <hr>
      <form method="post">
        <div class="form-group">
          <label for="encuesta">Encuesta</label>
          <input type="text" name="encuesta" id="encuesta" class="form-control"><?php print "Valor Actual: ".$vnom_enc; ?>
        </div>
        <div class="form-group">
          <label for="tipo">Tipo</label>
          <select name="tipo" id="tipo" class="form-control">
            <option value="RB">RadioButton</option>
            <option value="CB">CheckBox</option>
          </select><?php print "Valor Actual: ".$vtipo; ?>
        </div>
        <div class="form-group">
          
          <input type="submit" name="submit" class="btn btn-primary" value="Enviar">
          <a class="btn btn-primary" href="mantenimiento.php">Regresar al inicio</a>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include 'templates/footer.php'; ?>