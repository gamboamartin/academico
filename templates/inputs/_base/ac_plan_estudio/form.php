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
<?php echo $controlador->inputs->id_carrera; ?>
<?php echo $controlador->inputs->clave_plan; ?>
<?php echo $controlador->inputs->calificacion_min_aprobacion; ?>


<?php echo $controlador->inputs->select->ac_nivel_id; ?>
<?php echo $controlador->inputs->select->ac_rvoe_id; ?>