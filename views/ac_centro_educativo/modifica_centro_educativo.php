<?php /** @var gamboamartin\organigrama\controllers\controlador_org_empresa $controlador  controlador en ejecucion */ ?>
<?php use config\views; ?>

<main class="main section-color-primary">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="widget  widget-box box-container form-main widget-form-cart" id="form">
                    <form method="post" action="<?php echo $controlador->link_ac_plan_estudio_pertenece_modifica_bd; ?>" class="form-additional">
                        <?php include (new views())->ruta_templates."head/title.php"; ?>
                        <?php include (new views())->ruta_templates."head/subtitulo.php"; ?>
                        <?php include (new views())->ruta_templates."mensajes.php"; ?>

                    <?php echo $controlador->inputs->select->ac_plan_estudio_id; ?>

                    <?php echo $controlador->inputs->select->ac_centro_educativo_id; ?>

                        <div class="control-group btn-alta">
                            <div class="controls">
                                <button type="submit" class="btn btn-success" value="asigna_centro_educativo" name="btn_action_next">Modifica</button><br>
                            </div>
                        </div>

                    </form>
                </div>

            </div>

        </div>
    </div>
</main>





