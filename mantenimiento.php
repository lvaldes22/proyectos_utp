<?php

require_once ("class/procesos.php" );

$titulo = 'Listado de encuestas';
?>

<?php include "templates/header.php"; ?>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <a href="crear.php"  class="btn btn-primary mt-4">Crear encuesta</a>
      <hr>
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
            <th>Encuesta</th>
            <th>Tipo</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $obj_encuestas = new encuestas();
          $result_encuestas = $obj_encuestas->listar_encuestas();
          if($result_encuestas){
            $nfilas=count($result_encuestas);
          }else {
            $nfilas=0;
          }
          if ($nfilas > 0) {
            foreach ($result_encuestas as $result_encuesta) {
              ?>
              <tr>
                <td><?php echo $result_encuesta["id_enc"]; ?></td>
                <td><?php echo $result_encuesta["nom_encuesta"]; ?></td>
                <td><?php echo $result_encuesta["tipo"]; ?></td>
                <td>
                  <a href="<?= 'borrar.php?id=' . $result_encuesta["id_enc"] ?>">Borrar</a><a></a>
                  <a href="<?= 'crear_detalle.php?id=' . $result_encuesta["id_enc"] . '&nom_enc=' . $result_encuesta["nom_encuesta"] . '&tipo=' . $result_encuesta["tipo"]?>">Detalle</a>
                  <a href="<?= 'modificar.php?id=' . $result_encuesta["id_enc"]?>">Modificar</a>
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

<?php include "templates/footer.php"; ?>