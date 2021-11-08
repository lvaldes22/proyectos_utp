<?php

require_once("class/procesos.php");

if (isset($_POST['submit'])) {
  $nom_enc=$_POST['encuesta'];
  $tipo=$_POST['tipo'];
  $obj_insert = new encuestas();
  $result_insert = $obj_insert->insertar_encuesta($nom_enc,$tipo);
  if($result_insert){
    ?>
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <h2 class="mt-4">El registro ha sido agregado</h2>
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
              <h2 class="mt-4">Error al crear el registro</h2>
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
      <h2 class="mt-4">Crea una encuesta</h2>
      <hr>
      <form method="post">
        <div class="form-group">
          <label for="encuesta">Encuesta</label>
          <input type="text" name="encuesta" id="encuesta" class="form-control">
        </div>
        <div class="form-group">
          <label for="tipo">Tipo</label>
          <select name="tipo" id="tipo" class="form-control">
          <option value="RB">RadioButton</option>
          <option value="CB">CheckBox</option>
        </select>
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