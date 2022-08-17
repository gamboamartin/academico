<?php
namespace html;

use gamboamartin\academico\controllers\controlador_ac_centro_educativo;
use gamboamartin\academico\controllers\controlador_ac_plan_estudio;
use gamboamartin\errores\errores;
use gamboamartin\system\html_controler;
use gamboamartin\system\system;
use PDO;
use stdClass;


class ac_plan_estudio_html extends html_controler {

    protected function asigna_inputs(system $controler, stdClass $inputs): array|stdClass
    {
        $controler->inputs->select = new stdClass();

        $controler->inputs->select->ac_nivel_id = $inputs->selects->ac_nivel_id;

        return $controler->inputs;
    }

    public function genera_inputs_alta(controlador_ac_plan_estudio $controler,PDO $link): array|stdClass
    {
        $inputs = $this->init_alta(link: $link);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar inputs',data:  $inputs);
        }

        $inputs_asignados = $this->asigna_inputs(controler:$controler, inputs: $inputs);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al asignar inputs',data:  $inputs_asignados);
        }

        return $inputs_asignados;
    }

    public function genera_inputs_modifica(controlador_ac_plan_estudio $controler,PDO $link,
                                            stdClass $params = new stdClass()): array|stdClass
    {
        $inputs = $this->init_modifica(link: $link, row_upd: $controler->row_upd, params: $params);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar inputs',data:  $inputs);

        }
        $inputs_asignados = $this->asigna_inputs(controler:$controler, inputs: $inputs);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al asignar inputs',data:  $inputs_asignados);
        }

        return $inputs_asignados;
    }

    private function init_alta(PDO $link): array|stdClass
    {
        $selects = new stdClass();

        $ac_nivel_html = new ac_nivel_html(html:$this->html_base);

        $select = $ac_nivel_html->select_ac_nivel_id(cols: 12, con_registros:true,
            id_selected:-1,link: $link);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar select',data:  $select);
        }

        $selects->ac_nivel_id = $select;

        $alta_inputs = new stdClass();

        $alta_inputs->selects = $selects;
        return $alta_inputs;
    }


    private function init_modifica(PDO $link, stdClass $row_upd, stdClass $params = new stdClass()): array|stdClass
    {
        $selects = new stdClass();

        $ac_nivel_html = new ac_nivel_html(html:$this->html_base);

        $select = $ac_nivel_html->select_ac_nivel_id(cols: 12, con_registros:true,
            id_selected:$row_upd->ac_nivel_id,link: $link);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar select',data:  $select);
        }

        $selects->ac_nivel_id = $select;

        $alta_inputs = new stdClass();

        $alta_inputs->selects = $selects;
        return $alta_inputs;
    }

}
