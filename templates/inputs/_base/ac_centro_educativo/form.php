<?php /** @var gamboamartin\academico\controllers\controlador_ac_plan_estudio $controlador  controlador en ejecucion */ ?>
<?php use config\views; ?>
<?php if(isset($controlador->inputs->id)){ ?>
    <?php echo $controlador->inputs->id; ?>
<?php } ?>
<?php echo $controlador->inputs->codigo; ?>
<?php echo $controlador->inputs->codigo_bis; ?>
<?php echo $controlador->inputs->descripcion; ?>
<?php echo $controlador->inputs->descripcion_select; ?>
<?php echo $controlador->inputs->alias; ?>


<?php echo $controlador->inputs->select->im_registro_patronal_id; ?>

<?php echo $controlador->inputs->exterior; ?>
<?php echo $controlador->inputs->interior; ?>
<?php echo $controlador->inputs->select->dp_pais_id?>
<?php echo $controlador->inputs->select->dp_estado_id?>
<?php echo $controlador->inputs->select->dp_municipio_id?>
<?php echo $controlador->inputs->select->dp_cp_id?>
<?php echo $controlador->inputs->select->dp_colonia_postal_id?>
<?php echo $controlador->inputs->select->dp_calle_pertenece_id?>
