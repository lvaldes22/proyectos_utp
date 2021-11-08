<?php

require_once("class/procesos.php");

  $titulo = 'Listado de encuestas';
  $id = $_GET['id'];
  $nom_enc = $_GET['nom_enc'];
  $tipo = $_GET['tipo'];
  $obj_encuestas = new encuestas();
  $result_encuestas = $obj_encuestas->listar_det_encp($id);
  if($result_encuestas){
    $nfilas=count($result_encuestas);
  }else {
    $nfilas=0;
  }
if (isset($_POST['submit'])) {

  $obj_maximo = new encuestas();
  $result_maximo = $obj_maximo->buscar_maximo($id);
  foreach ($result_maximo as $result_max) {
    $id_det = $result_max['id_det'];
  }
  $det_enc=$_POST['det_encuesta'];
  $obj_insert = new encuestas();
  $result_insert = $obj_insert->insertar_det_encuesta($id,$nom_enc,$id_det,$det_enc,$tipo);
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
    $obj_encuestas = new encuestas();
    $result_encuestas = $obj_encuestas->listar_det_encp($id);
    if($result_encuestas){
      $nfilas=count($result_encuestas);
    }else {
      $nfilas=0;
    }
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
      <h2 class="mt-4">Agrega las opciones a la encuesta</h2>
      <h4 class="mt-4"><?php echo $nom_enc; ?></h4>
      <hr>
      <form method="post">
      <div class="form-group">
          <label for="det_encuesta">Opcion Encuesta</label>
          <input type="text" name="det_encuesta" id="det_encuesta" class="form-control">
        </div>
        <div class="form-group">
          <input type="submit" name="submit" class="btn btn-primary" value="Enviar">
          <a class="btn btn-primary" href="mantenimiento.php">Regresar al inicio</a>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h2 class="mt-3"><?= $titulo ?></h2>
      <table class="table">
        <thead>
          <tr>
            <th>#</th>
            <th>Detalle</th>
            <th>Tipo</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php
          
          if ($nfilas > 0) {
            foreach ($result_encuestas as $result_encuesta) {
              ?>
              <tr>
                <td><?php echo $result_encuesta["id_det"]; ?></td>
                <td><?php echo $result_encuesta["descripcion"]; ?></td>
                <td><?php echo $result_encuesta["tipo"]; ?></td>
                <td>
                  <a href="<?= 'borrar_det.php?id=' . $result_encuesta["id_det"] .'&id_enc=' . $id . '&nom_enc=' . $nom_enc . '&tipo=' . $tipo?>">Borrar</a><a></a>
                  <a href="<?= 'modificar_det.php?id=' . $result_encuesta["id_det"]?>">Modificar</a><a></a>
                </td>
              </tr>
              <?php
            }
          }
          ?>
        <tbody>
      </table>
    </div>
  </div>
</div>

<?php include 'templates/footer.php'; ?>