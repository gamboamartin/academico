<?php use config\views; ?>
<?php /** @var stdClass $row  viene de registros del controler*/ ?>
<tr>
    <td><?php echo $row->ac_plan_estudio_id; ?></td>
    <td><?php echo $row->ac_plan_estudio_codigo; ?></td>
    <td><?php echo $row->ac_plan_estudio_descripcion; ?></td>
    <!-- Dynamic generated -->
    <td><?php echo $row->ac_nivel_descripcion; ?></td>
    <td><?php echo $row->ac_plan_estudio_clave_plan; ?></td>
    <td><?php echo $row->ac_rvoe_numero; ?></td>
    <td><?php include 'templates/botons/ac_plan_estudio/link_asigna_centro_educativo.php';?></td>

    <!-- End dynamic generated -->

    <?php include (new views())->ruta_templates.'listas/action_row.php';?>
</tr>
