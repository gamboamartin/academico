<?php /** @var gamboamartin\organigrama\controllers\controlador_org_empresa $controlador  controlador en ejecucion */ ?>
<?php use config\views; ?>

<main class="main section-color-primary">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="widget  widget-box box-container form-main widget-form-cart" id="form">
                    <form method="post" action="<?php echo $controlador->link_ac_plan_estudio_pertenece_alta_bd; ?>" class="form-additional">
                        <?php include (new views())->ruta_templates."head/title.php"; ?>
                        <?php include (new views())->ruta_templates."head/subtitulo.php"; ?>
                        <?php include (new views())->ruta_templates."mensajes.php"; ?>

                    <?php echo $controlador->inputs->select->ac_plan_estudio_id; ?>

                    <?php echo $controlador->inputs->select->ac_centro_educativo_id; ?>

                        <div class="control-group btn-alta">
                            <div class="controls">
                                <button type="submit" class="btn btn-success" value="asigna_plantel" name="btn_action_next">Alta</button><br>
                            </div>
                        </div>

                    </form>
                </div>

            </div>

        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="widget widget-box box-container widget-mylistings">

                    <div class="">
                        <table class="table table-striped footable-sort" data-sorting="true">
                            <th>Id</th>
                            <th>Matricula Alumno</th>
                            <th>Nombre Alumno</th>
                            <th>Apellido Paterno</th>
                            <th>Apellido Materno</th>
                            <th>Fecha Ingreso</th>
                            <th>Plantel</th>

                            <th>Ver</th>
                            <th>Modifica</th>
                            <th>Elimina</th>

                            <tbody>
                            <?php foreach ($controlador->centros_educativos->registros as $centro_educativo){
                                ?>
                            <tr>
                                <td><?php echo $centro_educativo['ac_alumno_pertenece_id']; ?></td>
                                <td><?php echo $centro_educativo['ac_alumno_matricula']; ?></td>
                                <td><?php echo $centro_educativo['ac_alumno_nombre']; ?></td>
                                <td><?php echo $centro_educativo['ac_alumno_apellido_paterno']; ?></td>
                                <td><?php echo $centro_educativo['ac_alumno_apellido_materno']; ?></td>
                                <td><?php echo $centro_educativo['ac_alumno_pertenece_fecha_ingreso']; ?></td>
                                <td><?php echo $centro_educativo['direccion']; ?></td>

                                <td><?php echo $centro_educativo['link_ve']; ?></td>
                                <td><?php echo $centro_educativo['link_modifica']; ?></td>
                                <td><?php echo $centro_educativo['link_elimina']; ?></td>

                            </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                        <div class="box-body">
                            * Total registros: <?php echo $controlador->centros_educativos->n_registros; ?><br />
                            * Fecha Hora: <?php echo $controlador->fecha_hoy; ?>
                        </div>
                    </div>
                </div> <!-- /. widget-table-->
            </div><!-- /.center-content -->
        </div>
    </div>


</main>





