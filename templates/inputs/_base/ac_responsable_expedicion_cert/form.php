<?php /** @var gamboamartin\academico\controllers\controlador_ac_plan_estudio $controlador  controlador en ejecucion */ ?>
<?php use config\views; ?>
<?php if(isset($controlador->inputs->id)){ ?>
<?php echo $controlador->inputs->id; ?>
<?php } ?>
<?php echo $controlador->inputs->codigo; ?>
<?php echo $controlador->inputs->codigo_bis; ?>
<?php echo $controlador->inputs->descripcion_select; ?>
<?php echo $controlador->inputs->alias; ?>
<?php echo $controlador->inputs->curp; ?>
<?php echo $controlador->inputs->nombre; ?>
<?php echo $controlador->inputs->ap; ?>
<?php echo $controlador->inputs->am; ?>

<?php echo $controlador->inputs->select->org_puesto_id; ?>
