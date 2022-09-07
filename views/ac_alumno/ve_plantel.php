<?php /** @var gamboamartin\organigrama\controllers\controlador_org_empresa $controlador  controlador en ejecucion */ ?>
<?php use config\views; ?>

<main class="main section-color-primary">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                    <?php include (new views())->ruta_templates."head/title.php"; ?>
                    <?php include (new views())->ruta_templates."head/subtitulo.php"; ?>
                    <?php include (new views())->ruta_templates."mensajes.php"; ?>
                </div>
            <div class="col-lg-12">

                <?php echo $controlador->inputs->ac_centro_educativo_id; ?>
                <?php echo $controlador->inputs->ac_centro_educativo_codigo; ?>
                <?php echo $controlador->inputs->ac_centro_educativo_codigo_bis; ?>
                <?php echo $controlador->inputs->ac_centro_educativo_descripcion; ?>

                <?php echo $controlador->inputs->ac_centro_educativo_dp_estado_descripcion; ?>
                <?php echo $controlador->inputs->ac_centro_educativo_dp_municipio_descripcion; ?>
                <?php echo $controlador->inputs->ac_centro_educativo_dp_colonia_descripcion; ?>
                <?php echo $controlador->inputs->ac_centro_educativo_dp_cp_descripcion; ?>
                <?php echo $controlador->inputs->ac_centro_educativo_dp_calle_descripcion; ?>
                <?php echo $controlador->inputs->ac_centro_educativo_exterior; ?>
                <?php echo $controlador->inputs->ac_centro_educativo_interior; ?>
            </div>
        </div>
    </div>
    <br>
</main>





