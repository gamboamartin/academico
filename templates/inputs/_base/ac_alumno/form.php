<?php /** @var gamboamartin\academico\controllers\controlador_ac_plan_estudio $controlador  controlador en ejecucion */ ?>
<?php use config\views; ?>

<?php echo $controlador->inputs->nombre; ?>
<?php echo $controlador->inputs->apellido_paterno; ?>
<?php echo $controlador->inputs->apellido_materno; ?>
<?php echo $controlador->inputs->curp; ?>
<?php echo $controlador->inputs->matricula; ?>
<?php echo $controlador->inputs->correo; ?>
<?php echo $controlador->inputs->telefono_fijo; ?>
<?php echo $controlador->inputs->telefono_movil; ?>

<?php echo $controlador->inputs->select->dp_pais_id?>
<?php echo $controlador->inputs->select->dp_estado_id?>
<?php echo $controlador->inputs->select->dp_municipio_id?>
<?php echo $controlador->inputs->select->dp_cp_id?>
<?php echo $controlador->inputs->select->dp_colonia_postal_id?>
<?php echo $controlador->inputs->select->dp_calle_pertenece_id?>

<?php echo $controlador->inputs->exterior; ?>
<?php echo $controlador->inputs->interior; ?>

<?php echo $controlador->inputs->select->ac_estado_alumno_id?>
<?php echo $controlador->inputs->select->ac_turno_id?>
<?php echo $controlador->inputs->select->adm_estado_civil_id; ?>
<?php echo $controlador->inputs->select->adm_genero_id; ?>
<?php echo $controlador->inputs->select->adm_idioma_id; ?>

<?php echo $controlador->inputs->fecha_nacimiento; ?>
<?php echo $controlador->inputs->select->dp_estado_nacimiento_id?>
