<?php
namespace html;

use gamboamartin\academico\controllers\controlador_ac_centro_educativo;
use gamboamartin\errores\errores;
use gamboamartin\system\html_controler;
use gamboamartin\system\system;
use gamboamartin\template\directivas;
use models\base\limpieza;
use models\im_registro_patronal;
use PDO;
use stdClass;


class ac_centro_educativo_html extends html_controler {

    protected function asigna_inputs(system $controler, stdClass $inputs): array|stdClass
    {
        $controler->inputs->exterior = $inputs->texts->exterior;
        $controler->inputs->interior = $inputs->texts->interior;

        $controler->inputs->select = new stdClass();

        $controler->inputs->select->im_registro_patronal_id = $inputs->selects->im_registro_patronal_id;

        $inputs_direcciones_postales = (new inputs_html())->base_direcciones_asignacion(controler:$controler,
            inputs: $inputs);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al asignar direcciones',data:  $inputs_direcciones_postales);
        }

        return $controler->inputs;
    }

    public function genera_inputs_alta(controlador_ac_centro_educativo $controler,PDO $link): array|stdClass
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

    public function genera_inputs_modifica(controlador_ac_centro_educativo $controler,PDO $link,
                                           stdClass $params = new stdClass()): array|stdClass
    {
        $init = (new limpieza())->init_modifica_ac_alumno(controler: $controler);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al inicializa datos',data:  $init);
        }

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
        $selects = $this->selects_alta(link: $link);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar selects',data:  $selects);
        }

        $texts = $this->texts_alta(row_upd: new stdClass(), value_vacio: true);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar selects',data:  $texts);
        }

        $alta_inputs = new stdClass();

        $alta_inputs->selects = $selects;
        $alta_inputs->texts = $texts;

        return $alta_inputs;
    }

    protected function selects_alta(PDO $link): array|stdClass
    {
        $selects = new stdClass();
        $row_upd = new stdClass();

        $selects = (new selects())->direcciones(html: $this->html_base,link:  $link,row:  $row_upd,selects:  $selects);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar selects de domicilios',data:  $selects);
        }

        $select = $this->select_im_registro_patronal_id(cols: 12, con_registros:true,
            id_selected:-1,link: $link);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar select',data:  $select);
        }

        $selects->im_registro_patronal_id = $select;

        return $selects;
    }

    private function selects_modifica(PDO $link, stdClass $row_upd): array|stdClass
    {
        $selects = new stdClass();

        $selects = (new selects())->direcciones(html: $this->html_base,link:  $link,row:  $row_upd,selects:  $selects, required:'true');
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar selects de domicilios',data:  $selects);
        }

        $select = $this->select_im_registro_patronal_id(cols: 12, con_registros:true,
            id_selected:$row_upd->im_registro_patronal_id,link: $link);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar select',data:  $select);
        }

        $selects->im_registro_patronal_id = $select;

        return $selects;
    }

    private function init_modifica(PDO $link, stdClass $row_upd, stdClass $params = new stdClass()): array|stdClass
    {
        $selects = $this->selects_modifica(link: $link, row_upd: $row_upd);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar selects',data:  $selects);
        }

        $texts = $this->texts_alta(row_upd: $row_upd, value_vacio: false);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar selects',data:  $texts);
        }

        $alta_inputs = new stdClass();

        $alta_inputs->selects = $selects;
        $alta_inputs->texts = $texts;

        return $alta_inputs;
    }

    private function texts_alta(stdClass $row_upd, bool $value_vacio, stdClass $params = new stdClass()): array|stdClass
    {
        $texts = new stdClass();

        $in_exterior = $this->input_exterior(cols: 6,row_upd: $row_upd,value_vacio:  $value_vacio);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar input',data:  $in_exterior);
        }
        $texts->exterior = $in_exterior;

        $in_interior = $this->input_interior(cols: 6,row_upd:  $row_upd,value_vacio:  $value_vacio);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar input',data:  $in_exterior);
        }
        $texts->interior = $in_interior;

        return $texts;
    }

    public function select_im_registro_patronal_id(int $cols, bool $con_registros, int $id_selected, PDO $link): array|string
    {
        $valida = (new directivas(html:$this->html_base))->valida_cols(cols:$cols);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al validar cols', data: $valida);
        }

        $modelo = new im_registro_patronal($link);

        $select = $this->select_catalogo(cols:$cols,con_registros:$con_registros,id_selected:$id_selected,
            modelo: $modelo, label: 'Registro Patronal', required:'true');
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar select', data: $select);
        }
        return $select;
    }

    public function input_exterior(int $cols, stdClass $row_upd, bool $value_vacio): array|string
    {

        if($cols<=0){
            return $this->error->error(mensaje: 'Error cold debe ser mayor a 0', data: $cols);
        }
        if($cols>=13){
            return $this->error->error(mensaje: 'Error cold debe ser menor o igual a  12', data: $cols);
        }

        $html =$this->directivas->input_text_required(disable: false,name: 'exterior',place_holder: 'Num Ext',row_upd: $row_upd,
            value_vacio: $value_vacio, required:'true');
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar input', data: $html);
        }

        $div = $this->directivas->html->div_group(cols: $cols,html:  $html);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al integrar div', data: $div);
        }

        return $div;
    }

    public function input_interior(int $cols, stdClass $row_upd, bool $value_vacio): array|string
    {

        if($cols<=0){
            return $this->error->error(mensaje: 'Error cold debe ser mayor a 0', data: $cols);
        }
        if($cols>=13){
            return $this->error->error(mensaje: 'Error cold debe ser menor o igual a  12', data: $cols);
        }

        $html =$this->directivas->input_text_required(disable: false,name: 'interior',place_holder: 'Num Int',row_upd: $row_upd,
            value_vacio: $value_vacio, required:'true');
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
