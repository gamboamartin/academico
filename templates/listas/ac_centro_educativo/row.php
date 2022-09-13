<?php use config\views; ?>
<?php /** @var stdClass $row  viene de registros del controler*/ ?>
<tr>
    <td><?php echo $row->ac_centro_educativo_id; ?></td>
    <td><?php echo $row->ac_centro_educativo_codigo; ?></td>
    <td><?php echo $row->ac_centro_educativo_descripcion; ?></td>
    <!-- Dynamic generated -->
    <td><?php echo $row->im_registro_patronal_descripcion; ?></td>
    <td><?php echo $row->ac_centro_educativo_exterior; ?></td>
    <td><?php echo $row->ac_centro_educativo_interior; ?></td>
    <td><?php include 'templates/botons/ac_centro_educativo/link_asigna_plan_estudio.php';?></td>

    <!-- End dynamic generated -->

    <?php include (new views())->ruta_templates.'listas/action_row.php';?>
</tr>
