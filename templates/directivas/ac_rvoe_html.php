<?php
namespace html;

use gamboamartin\academico\controllers\controlador_ac_rvoe;
use gamboamartin\errores\errores;
use gamboamartin\system\html_controler;
use gamboamartin\system\system;
use gamboamartin\template\directivas;
use gamboamartin\academico\models\ac_rvoe;
use PDO;
use stdClass;


class ac_rvoe_html extends html_controler {

    public function select_ac_rvoe_id(int $cols, bool $con_registros, int $id_selected, PDO $link): array|string
    {
        $valida = (new directivas(html:$this->html_base))->valida_cols(cols:$cols);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al validar cols', data: $valida);
        }

        $modelo = new ac_rvoe($link);

        $select = $this->select_catalogo(cols:$cols,con_registros:$con_registros,id_selected:$id_selected,
            modelo: $modelo, label: 'RVOE');
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar select', data: $select);
        }
        return $select;
    }

    protected function asigna_inputs(system $controler, stdClass $inputs): array|stdClass
    {
        $controler->inputs->numero = $inputs->texts->numero;
        $controler->inputs->fecha_expedicion = $inputs->fecha->fecha_expedicion;

        return $controler->inputs;
    }

    public function genera_inputs_alta(controlador_ac_rvoe $controler,PDO $link): array|stdClass
    {
        $inputs = $this->init_alta(keys_selects: array(),link: $link);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar inputs',data:  $inputs);
        }

        $inputs_asignados = $this->asigna_inputs(controler:$controler, inputs: $inputs);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al asignar inputs',data:  $inputs_asignados);
        }

        return $inputs_asignados;
    }

    public function genera_inputs_modifica(controlador_ac_rvoe $controler,PDO $link,
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
        $inputs = new stdClass();
        $fechas = new stdClass();

        $row_upd = new stdClass();

        $input = $this->numero(cols: 6,row_upd: $row_upd,value_vacio:  true);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar input text',data:  $input);
        }
        $inputs->numero = $input;

        $row_upd->fecha_expedicion = date("Y-m-d");
        $fecha = $this->fecha_expedicion(cols: 6,row_upd: $row_upd,value_vacio:  false);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar input text',data:  $input);
        }
        $fechas->fecha_expedicion = $fecha;

        $alta_inputs = new stdClass();

        $alta_inputs->texts = $inputs;
        $alta_inputs->fecha = $fechas;
        return $alta_inputs;
    }


    private function init_modifica(PDO $link, stdClass $row_upd, stdClass $params = new stdClass()): array|stdClass
    {
        $inputs = new stdClass();
        $fechas = new stdClass();

        $input = $this->numero(cols: 6,row_upd: $row_upd,value_vacio:  false);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar input text',data:  $input);
        }
        $inputs->numero = $input;

        $input = $this->fecha_expedicion(cols: 6,row_upd: $row_upd,value_vacio:  false);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar input text',data:  $input);
        }
        $fechas->fecha_expedicion = $input;

        $alta_inputs = new stdClass();

        $alta_inputs->texts = $inputs;
        $alta_inputs->fecha = $fechas;
        return $alta_inputs;
    }

    public function numero(int $cols, stdClass $row_upd, bool $value_vacio): array|string
    {
        if($cols<=0){
            return $this->error->error(mensaje: 'Error cold debe ser mayor a 0', data: $cols);
        }
        if($cols>=13){
            return $this->error->error(mensaje: 'Error cold debe ser menor o igual a  12', data: $cols);
        }

        $html =$this->directivas->input_text_required(disabled: false,name: 'numero',
            place_holder: 'Numero RVOE',row_upd: $row_upd, value_vacio: $value_vacio);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar input', data: $html);
        }

        $div = $this->directivas->html->div_group(cols: $cols,html:  $html);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al integrar div', data: $div);
        }

        return $div;
    }

    public function fecha_expedicion(int $cols, stdClass $row_upd, bool $value_vacio): array|string
    {

        if($cols<=0){
            return $this->error->error(mensaje: 'Error cold debe ser mayor a 0', data: $cols);
        }
        if($cols>=13){
            return $this->error->error(mensaje: 'Error cold debe ser menor o igual a  12', data: $cols);
        }

        $html =$this->directivas->fecha_required(disabled: false,name: 'fecha_expedicion',
            place_holder: 'Fecha Expedicion RVOE',row_upd: $row_upd, value_vacio: $value_vacio);
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
