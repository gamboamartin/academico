<?php /** @var gamboamartin\academico\controllers\controlador_ac_plan_estudio $controlador  controlador en ejecucion */ ?>
<?php use config\views; ?>
<?php if(isset($controlador->inputs->id)){ ?>
    <?php echo $controlador->inputs->id; ?>
<?php } ?>
<?php echo $controlador->inputs->codigo; ?>
<?php echo $controlador->inputs->codigo_bis; ?>
<?php echo $controlador->inputs->descripcion_select; ?>
<?php echo $controlador->inputs->alias; ?>
<?php echo $controlador->inputs->id_asignatura; ?>
<?php echo $controlador->inputs->no_creditos; ?>


<?php echo $controlador->inputs->select->ac_tipo_asignatura_id; ?>