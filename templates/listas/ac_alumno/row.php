<?php use config\views; ?>
<?php /** @var stdClass $row  viene de registros del controler*/ ?>
<tr>
    <td><?php echo $row->ac_alumno_id; ?></td>
    <td><?php echo $row->ac_alumno_nombre; ?></td>
    <td><?php echo $row->ac_alumno_apellido_paterno; ?></td>
    <!-- Dynamic generated -->
    <td><?php echo $row->ac_alumno_apellido_materno; ?></td>
    <td><?php echo $row->ac_alumno_matricula; ?></td>
    <td><?php echo $row->ac_alumno_curp; ?></td>
    <td><?php include 'templates/botons/ac_alumno/link_asigna_plantel.php';?></td>

    <!-- End dynamic generated -->

    <?php include (new views())->ruta_templates.'listas/action_row.php';?>
</tr>
