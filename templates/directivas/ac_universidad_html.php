<?php
namespace html;

use gamboamartin\academico\controllers\controlador_ac_universidad;
use gamboamartin\errores\errores;
use gamboamartin\system\html_controler;
use gamboamartin\system\system;
use gamboamartin\template\directivas;
use models\ac_universidad;
use PDO;
use stdClass;


class ac_universidad_html extends html_controler {

    public function select_ac_universidad_id(int $cols, bool $con_registros, int $id_selected, PDO $link): array|string
    {
        $valida = (new directivas(html:$this->html_base))->valida_cols(cols:$cols);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al validar cols', data: $valida);
        }

        $modelo = new ac_universidad($link);

        $select = $this->select_catalogo(cols:$cols,con_registros:$con_registros,id_selected:$id_selected,
            modelo: $modelo, label: 'Universidad');
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar select', data: $select);
        }
        return $select;
    }

    protected function asigna_inputs(system $controler, stdClass $inputs): array|stdClass
    {
        $controler->inputs->select = new stdClass();
        $controler->inputs->no_serie_cer = $inputs->texts->no_serie_cer;
        $controler->inputs->id_campus = $inputs->texts->id_campus;
        $controler->inputs->select->ac_responsable_expedicion_cert_id = $inputs->selects->ac_responsable_expedicion_cert_id;

        return $controler->inputs;
    }

    public function genera_inputs_alta(controlador_ac_universidad $controler,PDO $link): array|stdClass
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

    public function genera_inputs_modifica(controlador_ac_universidad $controler,PDO $link,
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

        $ac_responsable_expedicion_cert_html = new ac_responsable_expedicion_cert_html(html:$this->html_base);

        $select = $ac_responsable_expedicion_cert_html->select_ac_responsable_expedicion_cert_id(cols: 12,
            con_registros:true, id_selected:-1,link: $link);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar select',data:  $select);
        }

        $selects->ac_responsable_expedicion_cert_id = $select;

        $row_upd = new stdClass();

        $input = $this->id_campus(cols: 12,row_upd: $row_upd,value_vacio:  true);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar input text',data:  $input);
        }
        $inputs->id_campus = $input;

        $input = $this->no_serie_cer(cols: 12,row_upd: $row_upd,value_vacio:  false);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar input text',data:  $input);
        }
        $inputs->no_serie_cer = $input;

        $alta_inputs = new stdClass();

        $alta_inputs->selects = $selects;
        $alta_inputs->texts = $inputs;
        return $alta_inputs;
    }


    private function init_modifica(PDO $link, stdClass $row_upd, stdClass $params = new stdClass()): array|stdClass
    {
        $selects = new stdClass();
        $inputs = new stdClass();

        $ac_responsable_expedicion_cert_html = new ac_responsable_expedicion_cert_html(html:$this->html_base);

        $select = $ac_responsable_expedicion_cert_html->select_ac_responsable_expedicion_cert_id(cols: 12,
            con_registros:true, id_selected:$row_upd->ac_responsable_expedicion_cert_id,link: $link);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar select',data:  $select);
        }

        $selects->ac_responsable_expedicion_cert_id = $select;

        $input = $this->id_campus(cols: 12,row_upd: $row_upd,value_vacio:  true);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar input text',data:  $input);
        }
        $inputs->id_campus = $input;

        $input = $this->no_serie_cer(cols: 12,row_upd: $row_upd,value_vacio:  false);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar input text',data:  $input);
        }
        $inputs->no_serie_cer = $input;

        $alta_inputs = new stdClass();

        $alta_inputs->selects = $selects;
        $alta_inputs->texts = $inputs;
        return $alta_inputs;
    }

    public function id_campus(int $cols, stdClass $row_upd, bool $value_vacio): array|string
    {
        if($cols<=0){
            return $this->error->error(mensaje: 'Error cold debe ser mayor a 0', data: $cols);
        }
        if($cols>=13){
            return $this->error->error(mensaje: 'Error cold debe ser menor o igual a  12', data: $cols);
        }

        $html =$this->directivas->input_text_required(disable: false,name: 'id_campus',
            place_holder: 'ID Campus',row_upd: $row_upd, value_vacio: $value_vacio);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar input', data: $html);
        }

        $div = $this->directivas->html->div_group(cols: $cols,html:  $html);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al integrar div', data: $div);
        }

        return $div;
    }

    public function no_serie_cer(int $cols, stdClass $row_upd, bool $value_vacio): array|string
    {
        if($cols<=0){
            return $this->error->error(mensaje: 'Error cold debe ser mayor a 0', data: $cols);
        }
        if($cols>=13){
            return $this->error->error(mensaje: 'Error cold debe ser menor o igual a  12', data: $cols);
        }

        $html =$this->directivas->input_text_required(disable: false,name: 'no_serie_cer',
            place_holder: 'No Serie Certificado',row_upd: $row_upd, value_vacio: $value_vacio);
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
