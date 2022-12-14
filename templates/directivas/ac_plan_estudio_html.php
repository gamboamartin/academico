<?php
namespace html;


use gamboamartin\academico\controllers\controlador_ac_plan_estudio;
use gamboamartin\academico\models\ac_plan_estudio;
use gamboamartin\errores\errores;
use gamboamartin\system\html_controler;
use gamboamartin\system\system;
use gamboamartin\template\directivas;

use PDO;
use stdClass;


class ac_plan_estudio_html extends html_controler {

    public function select_ac_plan_estudio_id(int $cols, bool $con_registros, int $id_selected, PDO $link,
                                              bool $disabled = false, bool $required = false): array|string
    {
        $valida = (new directivas(html:$this->html_base))->valida_cols(cols:$cols);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al validar cols', data: $valida);
        }

        $modelo = new ac_plan_estudio($link);

        $select = $this->select_catalogo(cols:$cols,con_registros:$con_registros,id_selected:$id_selected,
            modelo: $modelo,  disabled: $disabled, label: 'Plan Estudio', required: $required);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar select', data: $select);
        }
        return $select;
    }

    protected function asigna_inputs(system $controler, stdClass $inputs): array|stdClass
    {
        $controler->inputs->select = new stdClass();
        $controler->inputs->id_carrera = $inputs->texts->id_carrera;
        $controler->inputs->clave_plan = $inputs->texts->clave_plan;
        $controler->inputs->calificacion_min_aprobacion = $inputs->texts->calificacion_min_aprobacion;
        $controler->inputs->select->ac_nivel_id = $inputs->selects->ac_nivel_id;
        $controler->inputs->select->ac_rvoe_id = $inputs->selects->ac_rvoe_id;

        return $controler->inputs;
    }

    protected function asigna_inputs_asigna_centro_educativo(system $controler, stdClass $inputs): array|stdClass
    {
        $controler->inputs->select = new stdClass();

        $controler->inputs->select->ac_centro_educativo_id = $inputs->selects->ac_centro_educativo_id;

        return $controler->inputs;
    }

    public function genera_inputs_alta(controlador_ac_plan_estudio $controler,array $keys_selects,PDO $link): array|stdClass
    {
        $inputs = $this->init_alta(keys_selects: $keys_selects, link: $link);
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

    protected function init_alta(array $keys_selects, PDO $link): array|stdClass
    {
        $selects = new stdClass();
        $inputs = new stdClass();

        $ac_nivel_html = new ac_nivel_html(html:$this->html_base);

        $select = $ac_nivel_html->select_ac_nivel_id(cols: 6, con_registros:true,
            id_selected:-1,link: $link);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar select',data:  $select);
        }

        $selects->ac_nivel_id = $select;
        
        $ac_rvoe_html = new ac_rvoe_html(html:$this->html_base);

        $select = $ac_rvoe_html->select_ac_rvoe_id(cols: 6, con_registros:true,
            id_selected:-1,link: $link);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar select',data:  $select);
        }

        $selects->ac_rvoe_id = $select;

        $row_upd = new stdClass();

        $input = $this->id_carrera(cols: 6,row_upd: $row_upd,value_vacio:  true);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar input text',data:  $input);
        }
        $inputs->id_carrera = $input;

        $input = $this->clave_plan(cols: 6,row_upd: $row_upd,value_vacio:  false);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar input text',data:  $input);
        }
        $inputs->clave_plan = $input;

        $input = $this->calificacion_min_aprobacion(cols: 6,row_upd: $row_upd,value_vacio:  false);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar input text',data:  $input);
        }
        $inputs->calificacion_min_aprobacion = $input;

        $alta_inputs = new stdClass();

        $alta_inputs->selects = $selects;
        $alta_inputs->texts = $inputs;
        return $alta_inputs;
    }


    private function init_modifica(PDO $link, stdClass $row_upd, stdClass $params = new stdClass()): array|stdClass
    {
        $selects = new stdClass();
        $inputs = new stdClass();

        $ac_nivel_html = new ac_nivel_html(html:$this->html_base);

        $select = $ac_nivel_html->select_ac_nivel_id(cols: 6, con_registros:true,
            id_selected:$row_upd->ac_nivel_id,link: $link);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar select',data:  $select);
        }

        $selects->ac_nivel_id = $select;

        $ac_rvoe_html = new ac_rvoe_html(html:$this->html_base);

        $select = $ac_rvoe_html->select_ac_rvoe_id(cols: 6, con_registros:true,
            id_selected:$row_upd->ac_rvoe_id,link: $link);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar select',data:  $select);
        }

        $selects->ac_rvoe_id = $select;

        $input = $this->id_carrera(cols: 4,row_upd: $row_upd,value_vacio:  false);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar input text',data:  $input);
        }
        $inputs->id_carrera = $input;
        
        $input = $this->clave_plan(cols: 6,row_upd: $row_upd,value_vacio:  false);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar input text',data:  $input);
        }
        $inputs->clave_plan = $input;

        $input = $this->calificacion_min_aprobacion(cols: 6,row_upd: $row_upd,value_vacio:  false);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar input text',data:  $input);
        }
        $inputs->calificacion_min_aprobacion = $input;

        $alta_inputs = new stdClass();

        $alta_inputs->selects = $selects;
        $alta_inputs->texts = $inputs;
        return $alta_inputs;
    }

    public function id_carrera(int $cols, stdClass $row_upd, bool $value_vacio): array|string
    {
        if($cols<=0){
            return $this->error->error(mensaje: 'Error cold debe ser mayor a 0', data: $cols);
        }
        if($cols>=13){
            return $this->error->error(mensaje: 'Error cold debe ser menor o igual a  12', data: $cols);
        }

        $html =$this->directivas->input_text_required(disabled: false,name: 'id_carrera',
            place_holder: 'Id Carrera',row_upd: $row_upd, value_vacio: $value_vacio);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar input', data: $html);
        }

        $div = $this->directivas->html->div_group(cols: $cols,html:  $html);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al integrar div', data: $div);
        }

        return $div;
    }

    public function clave_plan(int $cols, stdClass $row_upd, bool $value_vacio): array|string
    {
        if($cols<=0){
            return $this->error->error(mensaje: 'Error cold debe ser mayor a 0', data: $cols);
        }
        if($cols>=13){
            return $this->error->error(mensaje: 'Error cold debe ser menor o igual a  12', data: $cols);
        }

        $html =$this->directivas->input_text_required(disabled: false,name: 'clave_plan',
            place_holder: 'Clave Plan',row_upd: $row_upd, value_vacio: $value_vacio);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar input', data: $html);
        }

        $div = $this->directivas->html->div_group(cols: $cols,html:  $html);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al integrar div', data: $div);
        }

        return $div;
    }

    public function calificacion_min_aprobacion(int $cols, stdClass $row_upd, bool $value_vacio): array|string
    {
        if($cols<=0){
            return $this->error->error(mensaje: 'Error cold debe ser mayor a 0', data: $cols);
        }
        if($cols>=13){
            return $this->error->error(mensaje: 'Error cold debe ser menor o igual a  12', data: $cols);
        }

        $html =$this->directivas->input_text_required(disabled: false,name: 'calificacion_min_aprobacion',
            place_holder: 'Calificacion Minimo Aprobacion',row_upd: $row_upd, value_vacio: $value_vacio);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar input', data: $html);
        }

        $div = $this->directivas->html->div_group(cols: $cols,html:  $html);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al integrar div', data: $div);
        }

        return $div;
    }

    public function genera_inputs_asigna_centro_educativo(controlador_ac_plan_estudio $controler,PDO $link): array|stdClass
    {
        $inputs = $this->init_asigna_centro_educativo(link: $link, row_upd: $controler->row_upd);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar inputs',data:  $inputs);
        }

        $inputs_asignados = $this->asigna_inputs_asigna_centro_educativo(controler:$controler, inputs: $inputs);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al asignar inputs',data:  $inputs_asignados);
        }

        return $inputs_asignados;
    }

    private function init_asigna_centro_educativo(PDO $link, stdClass $row_upd): array|stdClass
    {
        $selects = $this->selects_asigna_centro_educativo(link: $link, row_upd: $row_upd);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar selects',data:  $selects);
        }

        $alta_inputs = new stdClass();

        $alta_inputs->selects = $selects;

        return $alta_inputs;
    }


    protected function selects_asigna_centro_educativo(PDO $link, stdClass $row_upd): array|stdClass
    {
        $selects = new stdClass();

        $ac_centro_educativo_html = new ac_centro_educativo_html(html:$this->html_base);

        $select = $ac_centro_educativo_html->select_ac_centro_educativo_id(cols: 6, con_registros:true,
            id_selected:$row_upd->ac_centro_educativo_id,link: $link, required: true);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar select',data:  $select);
        }

        $selects->ac_centro_educativo_id = $select;


        return $selects;
    }
}
