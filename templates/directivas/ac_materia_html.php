<?php
namespace html;

use gamboamartin\academico\controllers\controlador_ac_centro_educativo;
use gamboamartin\academico\controllers\controlador_ac_materia;
use gamboamartin\errores\errores;
use gamboamartin\system\html_controler;
use gamboamartin\system\system;
use gamboamartin\template\directivas;
use models\ac_materia;
use PDO;
use stdClass;


class ac_materia_html extends html_controler {

    public function select_ac_materia_id(int $cols, bool $con_registros, int $id_selected, PDO $link): array|string
    {
        $valida = (new directivas(html:$this->html_base))->valida_cols(cols:$cols);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al validar cols', data: $valida);
        }

        $modelo = new ac_materia($link);

        $select = $this->select_catalogo(cols:$cols,con_registros:$con_registros,id_selected:$id_selected,
            modelo: $modelo, label: 'Materia');
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar select', data: $select);
        }
        return $select;
    }

    protected function asigna_inputs(system $controler, stdClass $inputs): array|stdClass
    {
        $controler->inputs->select = new stdClass();
        $controler->inputs->id_asignatura = $inputs->texts->id_asignatura;
        $controler->inputs->no_creditos = $inputs->texts->no_creditos;
        $controler->inputs->clave = $inputs->texts->clave;
        $controler->inputs->descripcion = $inputs->texts->descripcion;
        $controler->inputs->select->ac_tipo_asignatura_id = $inputs->selects->ac_tipo_asignatura_id;
        $controler->inputs->select->ac_plan_estudio_id = $inputs->selects->ac_plan_estudio_id;

        return $controler->inputs;
    }

    public function genera_inputs_alta(controlador_ac_materia $controler,PDO $link): array|stdClass
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

    public function genera_inputs_modifica(controlador_ac_materia $controler,PDO $link,
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
        $inputs = new stdClass();

        $ac_tipo_asignatura_html = new ac_tipo_asignatura_html(html:$this->html_base);

        $select = $ac_tipo_asignatura_html->select_ac_tipo_asignatura_id(cols: 12, con_registros:true,
            id_selected:-1,link: $link);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar select',data:  $select);
        }

        $selects->ac_tipo_asignatura_id = $select;

        $ac_plan_estudio_html = new ac_plan_estudio_html(html:$this->html_base);

        $select = $ac_plan_estudio_html->select_ac_plan_estudio_id(cols: 12, con_registros:true,
            id_selected:-1,link: $link);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar select',data:  $select);
        }

        $selects->ac_plan_estudio_id = $select;

        $row_upd = new stdClass();

        $input = $this->id_asignatura(cols: 4,row_upd: $row_upd,value_vacio:  true);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar input text',data:  $input);
        }
        $inputs->id_asignatura = $input;

        $input = $this->no_creditos(cols: 4,row_upd: $row_upd,value_vacio:  false);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar input text',data:  $input);
        }
        $inputs->no_creditos = $input;
        
        $input = $this->clave(cols: 4,row_upd: $row_upd,value_vacio:  false);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar input text',data:  $input);
        }
        $inputs->clave = $input;

        $alta_inputs = new stdClass();

        $alta_inputs->selects = $selects;
        $alta_inputs->texts = $inputs;
        return $alta_inputs;
    }


    private function init_modifica(PDO $link, stdClass $row_upd, stdClass $params = new stdClass()): array|stdClass
    {
        $selects = new stdClass();
        $inputs = new stdClass();

        $ac_tipo_asignatura_html = new ac_tipo_asignatura_html(html:$this->html_base);

        $select = $ac_tipo_asignatura_html->select_ac_tipo_asignatura_id(cols: 12, con_registros:true,
            id_selected:$row_upd->ac_tipo_asignatura_id,link: $link);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar select',data:  $select);
        }

        $selects->ac_tipo_asignatura_id = $select;

        $ac_plan_estudio_html = new ac_plan_estudio_html(html:$this->html_base);

        $select = $ac_plan_estudio_html->select_ac_plan_estudio_id(cols: 12, con_registros:true,
            id_selected:$row_upd->ac_plan_estudio_id,link: $link);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar select',data:  $select);
        }

        $selects->ac_plan_estudio_id = $select;

        $input = $this->id_asignatura(cols: 4,row_upd: $row_upd,value_vacio:  false);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar input text',data:  $input);
        }
        $inputs->id_asignatura = $input;
        
        $input = $this->no_creditos(cols: 4,row_upd: $row_upd,value_vacio:  false);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar input text',data:  $input);
        }
        $inputs->no_creditos = $input;

        $input = $this->clave(cols: 4,row_upd: $row_upd,value_vacio:  false);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar input text',data:  $input);
        }
        $inputs->clave = $input;

        $input = $this->input_descripcion(cols: 8,row_upd: $row_upd,value_vacio:  false);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar input text',data:  $input);
        }
        $inputs->descripcion = $input;

        $alta_inputs = new stdClass();

        $alta_inputs->selects = $selects;
        $alta_inputs->texts = $inputs;
        return $alta_inputs;
    }

    public function id_asignatura(int $cols, stdClass $row_upd, bool $value_vacio): array|string
    {
        if($cols<=0){
            return $this->error->error(mensaje: 'Error cold debe ser mayor a 0', data: $cols);
        }
        if($cols>=13){
            return $this->error->error(mensaje: 'Error cold debe ser menor o igual a  12', data: $cols);
        }

        $html =$this->directivas->input_text_required(disable: false,name: 'id_asignatura',
            place_holder: 'Id Asignatura',row_upd: $row_upd, value_vacio: $value_vacio);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar input', data: $html);
        }

        $div = $this->directivas->html->div_group(cols: $cols,html:  $html);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al integrar div', data: $div);
        }

        return $div;
    }
    
    public function no_creditos(int $cols, stdClass $row_upd, bool $value_vacio): array|string
    {
        if($cols<=0){
            return $this->error->error(mensaje: 'Error cold debe ser mayor a 0', data: $cols);
        }
        if($cols>=13){
            return $this->error->error(mensaje: 'Error cold debe ser menor o igual a  12', data: $cols);
        }

        $html =$this->directivas->input_text_required(disable: false,name: 'no_creditos',
            place_holder: 'No Creditos',row_upd: $row_upd, value_vacio: $value_vacio);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar input', data: $html);
        }

        $div = $this->directivas->html->div_group(cols: $cols,html:  $html);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al integrar div', data: $div);
        }

        return $div;
    }

    public function clave(int $cols, stdClass $row_upd, bool $value_vacio): array|string
    {

        $html =$this->directivas->input_text_required(disable: false,name: 'clave',
            place_holder: 'Clave',row_upd: $row_upd, value_vacio: $value_vacio);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar input', data: $html);
        }

        $div = $this->directivas->html->div_group(cols: $cols,html:  $html);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al integrar div', data: $div);
        }

        return $div;
    }

}
