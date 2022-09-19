<?php
namespace html;

use config\generales;
use gamboamartin\academico\controllers\controlador_ac_alumno;
use gamboamartin\errores\errores;
use gamboamartin\system\html_controler;
use gamboamartin\system\system;
use gamboamartin\template\directivas;
use models\ac_alumno;
use models\adm_estado_civil;
use models\adm_genero;
use models\adm_idioma;
use models\base\limpieza;
use models\dp_estado;
use PDO;
use stdClass;


class ac_alumno_html extends html_controler {

    protected function asigna_inputs(system $controler, stdClass $inputs): array|stdClass
    {
        $controler->inputs->exterior = $inputs->texts->exterior;
        $controler->inputs->interior = $inputs->texts->interior;
        $controler->inputs->nombre = $inputs->texts->nombre;
        $controler->inputs->apellido_paterno = $inputs->texts->apellido_paterno;
        $controler->inputs->apellido_materno = $inputs->texts->apellido_materno;
        $controler->inputs->matricula = $inputs->texts->matricula;
        $controler->inputs->correo = $inputs->texts->correo;
        $controler->inputs->curp = $inputs->texts->curp;
        $controler->inputs->telefono_fijo = $inputs->texts->telefono_fijo;
        $controler->inputs->telefono_movil = $inputs->texts->telefono_movil;
        $controler->inputs->fecha_nacimiento = $inputs->fecha->fecha_nacimiento;

        $controler->inputs->select = new stdClass();

        $controler->inputs->select->ac_estado_alumno_id = $inputs->selects->ac_estado_alumno_id;
        $controler->inputs->select->ac_turno_id = $inputs->selects->ac_turno_id;

        $inputs_direcciones_postales = (new inputs_html())->base_direcciones_asignacion(controler:$controler,
            inputs: $inputs);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al asignar direcciones',data:  $inputs_direcciones_postales);
        }

        $controler->inputs->select->dp_estado_nacimiento_id = $inputs->selects->dp_estado_nacimiento_id;
        $controler->inputs->select->adm_estado_civil_id = $inputs->selects->adm_estado_civil_id;
        $controler->inputs->select->adm_genero_id = $inputs->selects->adm_genero_id;
        $controler->inputs->select->adm_idioma_id = $inputs->selects->adm_idioma_id;

        return $controler->inputs;
    }

    protected function asigna_inputs_asigna_plantel(system $controler, stdClass $inputs): array|stdClass
    {
        $controler->inputs->fecha_ingreso = $inputs->fecha->fecha_ingreso;

        $controler->inputs->select = new stdClass();

        $controler->inputs->select->ac_centro_educativo_id = $inputs->selects->ac_centro_educativo_id;

        return $controler->inputs;
    }

    public function inputs_org_empresa(controlador_ac_alumno $controlador_org_empresa,
                                       stdClass $params = new stdClass()): array|stdClass
    {
        $init = (new limpieza())->init_modifica_ac_alumno(controler: $controlador_org_empresa);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al inicializa datos',data:  $init);
        }


        $inputs = $this->genera_inputs_modifica(controler: $controlador_org_empresa,
            link: $controlador_org_empresa->link, params: $params);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar inputs',data:  $inputs);
        }
        return $inputs;
    }

    public function genera_inputs_alta(controlador_ac_alumno $controler,array $keys_selects,PDO $link): array|stdClass
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

    public function genera_inputs_asigna_plantel(controlador_ac_alumno $controler,PDO $link): array|stdClass
    {
        $inputs = $this->init_asigna_plantel(link: $link, row_upd: $controler->row_upd);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar inputs',data:  $inputs);
        }

        $inputs_asignados = $this->asigna_inputs_asigna_plantel(controler:$controler, inputs: $inputs);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al asignar inputs',data:  $inputs_asignados);
        }

        return $inputs_asignados;
    }

    public function genera_inputs_modifica(controlador_ac_alumno $controler,PDO $link,
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
        $selects = $this->selects_alta(keys_selects: $keys_selects, link: $link);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar selects',data:  $selects);
        }

        $texts = $this->texts_alta(row_upd: new stdClass(), value_vacio: true);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar selects',data:  $texts);
        }

        $fecha_nac = $this->fec_fecha_nacimiento(cols: 6,row_upd: new stdClass(), value_vacio: true);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar selects',data:  $texts);
        }
        $fecha = new stdClass();
        $fecha->fecha_nacimiento = $fecha_nac;

        $alta_inputs = new stdClass();

        $alta_inputs->selects = $selects;
        $alta_inputs->texts = $texts;
        $alta_inputs->fecha = $fecha;

        return $alta_inputs;
    }

    private function init_asigna_plantel(PDO $link, stdClass $row_upd): array|stdClass
    {
        $selects = $this->selects_asigna_plantel(link: $link, row_upd: $row_upd);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar selects',data:  $selects);
        }

        $fecha_nac = $this->fec_fecha_ingreso(cols: 6, row_upd: new stdClass(), value_vacio: true);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar fecha',data:  $fecha_nac);
        }
        $fecha = new stdClass();
        $fecha->fecha_ingreso = $fecha_nac;

        $alta_inputs = new stdClass();

        $alta_inputs->selects = $selects;
        $alta_inputs->fecha = $fecha;

        return $alta_inputs;
    }

    protected function texts_alta(stdClass $row_upd, bool $value_vacio, stdClass $params = new stdClass()): array|stdClass
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
        
        $in_nombre = $this->input_nombre(cols: 4,row_upd:  $row_upd,value_vacio:  $value_vacio);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar input',data:  $in_exterior);
        }
        $texts->nombre = $in_nombre;

        $in_apellido_paterno = $this->input_apellido_paterno(cols: 4,row_upd:  $row_upd,value_vacio:  $value_vacio);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar input',data:  $in_exterior);
        }
        $texts->apellido_paterno = $in_apellido_paterno;
        
        $in_apellido_materno = $this->input_apellido_materno(cols: 4,row_upd:  $row_upd,value_vacio:  $value_vacio);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar input',data:  $in_exterior);
        }
        $texts->apellido_materno = $in_apellido_materno;
        
        $in_matricula = $this->input_matricula(cols: 6,row_upd:  $row_upd,value_vacio:  $value_vacio);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar input',data:  $in_exterior);
        }
        $texts->matricula = $in_matricula;  
        
        $in_correo = $this->input_correo(cols: 12,row_upd:  $row_upd,value_vacio:  $value_vacio);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar input',data:  $in_exterior);
        }
        $texts->correo = $in_correo;    
        
        $in_curp = $this->input_curp(cols: 6,row_upd:  $row_upd,value_vacio:  $value_vacio);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar input',data:  $in_exterior);
        }
        $texts->curp = $in_curp;
        
        $in_telefono_fijo = $this->input_telefono_fijo(cols: 6,row_upd:  $row_upd,value_vacio:  $value_vacio);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar input',data:  $in_exterior);
        }
        $texts->telefono_fijo = $in_telefono_fijo;
        
        $in_telefono_movil = $this->input_telefono_movil(cols: 6,row_upd:  $row_upd,value_vacio:  $value_vacio);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar input',data:  $in_exterior);
        }
        $texts->telefono_movil = $in_telefono_movil;

        return $texts;
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

        $fecha_nac = $this->fec_fecha_nacimiento(cols: 6,row_upd: $row_upd, value_vacio: false);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar selects',data:  $texts);
        }

        $fecha = new stdClass();
        $fecha->fecha_nacimiento = $fecha_nac;

        $alta_inputs = new stdClass();

        $alta_inputs->selects = $selects;
        $alta_inputs->texts = $texts;
        $alta_inputs->fecha = $fecha;

        return $alta_inputs;
    }

    protected function selects_alta(array $keys_selects, PDO $link): array|stdClass
    {
        $selects = new stdClass();
        $row_upd = new stdClass();

        $params = new stdClass();
        $params->dp_pais_id = new stdClass();
        $params->dp_pais_id->cols = 4;
        $params->dp_pais_id->required = true;
        $params->dp_estado_id = new stdClass();
        $params->dp_estado_id->cols = 4;
        $params->dp_estado_id->required = true;
        $params->dp_municipio_id = new stdClass();
        $params->dp_municipio_id->cols = 4;
        $params->dp_municipio_id->required = true;
        $params->dp_cp_id = new stdClass();
        $params->dp_cp_id->required = true;
        $params->dp_colonia_postal_id = new stdClass();
        $params->dp_colonia_postal_id->required = true;
        $params->dp_calle_pertenece_id = new stdClass();
        $params->dp_calle_pertenece_id->cols = 12;
        $params->dp_calle_pertenece_id->required = true;
        $selects = (new selects())->direcciones(html: $this->html_base,link:  $link,row:  $row_upd,selects:  $selects,
            params: $params);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar selects de domicilios',data:  $selects);
        }

        $ac_estado_alumno_html = new ac_estado_alumno_html(html:$this->html_base);

        $select = $ac_estado_alumno_html->select_ac_estado_alumno_id(cols: 4, con_registros:true,
            id_selected:-1,link: $link, required: true);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar select',data:  $select);
        }

        $selects->ac_estado_alumno_id = $select;

        $ac_turno_html = new ac_turno_html(html:$this->html_base);

        $select = $ac_turno_html->select_ac_turno_id(cols: 4, con_registros:true,
            id_selected:-1,link: $link);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar select',data:  $select);
        }

        $selects->ac_turno_id = $select;


        $select = $this->select_dp_estado_nacimiento_id(cols: 6, con_registros:true,
            id_selected:-1,link: $link,required: true);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar select',data:  $select);
        }

        $selects->dp_estado_nacimiento_id = $select;

        $select = $this->select_adm_estado_civil_id(cols: 4, con_registros:true,
            id_selected:-1,link: $link, required: true);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar select',data:  $select);
        }

        $selects->adm_estado_civil_id = $select;

        $select = $this->select_adm_genero_id(cols: 6, con_registros:true,
            id_selected:-1,link: $link, required: true);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar select',data:  $select);
        }

        $selects->adm_genero_id = $select;

        $select = $this->select_adm_idioma_id(cols: 6, con_registros:true,
            id_selected:-1,link: $link, required: true);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar select',data:  $select);
        }

        $selects->adm_idioma_id = $select;

        return $selects;
    }

    protected function selects_asigna_plantel(PDO $link, stdClass $row_upd): array|stdClass
    {
        $selects = new stdClass();

        $ac_centro_educativo_html = new ac_centro_educativo_html(html:$this->html_base);

        $select = $ac_centro_educativo_html->select_ac_centro_educativo_id(cols: 6, con_registros:true,
            id_selected:-1,link: $link, required: true);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar select',data:  $select);
        }

        $selects->ac_centro_educativo_id = $select;


        return $selects;
    }

    private function selects_modifica(PDO $link, stdClass $row_upd): array|stdClass
    {
        $selects = new stdClass();

        $params = new stdClass();
        $params->dp_pais_id = new stdClass();
        $params->dp_pais_id->cols = 4;
        $params->dp_pais_id->required = true;
        $params->dp_estado_id = new stdClass();
        $params->dp_estado_id->cols = 4;
        $params->dp_estado_id->required = true;
        $params->dp_municipio_id = new stdClass();
        $params->dp_municipio_id->cols = 4;
        $params->dp_municipio_id->required = true;
        $params->dp_calle_pertenece_id = new stdClass();
        $params->dp_calle_pertenece_id->cols = 12;
        $params->dp_calle_pertenece_id->required = true;

        $selects = (new selects())->direcciones(html: $this->html_base,link:  $link,row:  $row_upd,selects:  $selects,
            params: $params);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar selects de domicilios',data:  $selects);
        }

        $ac_estado_alumno_html = new ac_estado_alumno_html(html:$this->html_base);

        $select = $ac_estado_alumno_html->select_ac_estado_alumno_id(cols: 4, con_registros:true,
            id_selected:$row_upd->ac_estado_alumno_id,link: $link);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar select',data:  $select);
        }

        $selects->ac_estado_alumno_id = $select;

        if(!isset($row_upd->ac_turno_id)){
            $row_upd->ac_turno_id = -1;
        }

        $ac_turno_html = new ac_turno_html(html:$this->html_base);
        $select = $ac_turno_html->select_ac_turno_id(cols: 4, con_registros:true,
            id_selected:$row_upd->ac_turno_id,link: $link);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar select',data:  $select);
        }

        $selects->ac_turno_id = $select;


        $select = $this->select_dp_estado_nacimiento_id(cols: 6, con_registros:true,
            id_selected:$row_upd->dp_estado_nacimiento_id,link: $link);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar select',data:  $select);
        }

        $selects->dp_estado_nacimiento_id = $select;

        $select = $this->select_adm_estado_civil_id(cols: 4, con_registros:true,
            id_selected:$row_upd->adm_estado_civil_id,link: $link);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar select',data:  $select);
        }

        $selects->adm_estado_civil_id = $select;

        $select = $this->select_adm_genero_id(cols: 6, con_registros:true,
            id_selected:$row_upd->adm_genero_id,link: $link);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar select',data:  $select);
        }

        $selects->adm_genero_id = $select;

        $select = $this->select_adm_idioma_id(cols: 6, con_registros:true,
            id_selected:$row_upd->adm_idioma_id,link: $link);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar select',data:  $select);
        }

        $selects->adm_idioma_id = $select;

        return $selects;
    }

    public function select_adm_estado_civil_id(int $cols, bool $con_registros, int $id_selected, PDO $link,
                                               bool $required = false): array|string
    {
        $valida = (new directivas(html:$this->html_base))->valida_cols(cols:$cols);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al validar cols', data: $valida);
        }

        $modelo = new adm_estado_civil($link);

        $select = $this->select_catalogo(cols:$cols,con_registros:$con_registros,id_selected:$id_selected,
            modelo: $modelo, label: 'Estado Civil', required: $required);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar select', data: $select);
        }
        return $select;
    }

    public function select_adm_genero_id(int $cols, bool $con_registros, int $id_selected, PDO $link,
                                         bool $required = false): array|string
    {
        $valida = (new directivas(html:$this->html_base))->valida_cols(cols:$cols);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al validar cols', data: $valida);
        }

        $modelo = new adm_genero($link);

        $select = $this->select_catalogo(cols:$cols,con_registros:$con_registros,id_selected:$id_selected,
            modelo: $modelo, label: 'Genero', required: $required);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar select', data: $select);
        }
        return $select;
    }
    
    public function select_adm_idioma_id(int $cols, bool $con_registros, int $id_selected, PDO $link,
                                         bool $required = false): array|string
    {
        $valida = (new directivas(html:$this->html_base))->valida_cols(cols:$cols);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al validar cols', data: $valida);
        }

        $modelo = new adm_idioma($link);

        $select = $this->select_catalogo(cols:$cols,con_registros:$con_registros,id_selected:$id_selected,
            modelo: $modelo, label: 'Idioma', required: $required);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar select', data: $select);
        }
        return $select;
    }

    public function select_dp_estado_nacimiento_id(int $cols, bool $con_registros,int|null $id_selected, PDO $link,
                                                   bool $disabled = false, array $filtro = array(),
                                                   bool $required = false): array|string
    {
        $valida = (new directivas(html:$this->html_base))->valida_cols(cols:$cols);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al validar cols', data: $valida);
        }

        $modelo = new dp_estado($link);
        if(is_null($id_selected) || $id_selected === -1){
            $generales = new generales();
            if(isset($generales->defaults['dp_estado_nacimiento']['id'])) {
                $id_selected = $generales->defaults['dp_estado_nacimiento']['id'];
            }
        }
        $select = $this->select_catalogo(cols: $cols, con_registros: $con_registros, id_selected: $id_selected,
            modelo: $modelo, disabled: $disabled, filtro: $filtro, label: 'Estado Nacimiento',
            name: 'dp_estado_nacimiento_id',required: $required);
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
            value_vacio: $value_vacio);
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

        $html =$this->directivas->input_text(disable: false,name: 'interior',place_holder: 'Num Int',required: false,
            row_upd: $row_upd, value_vacio: $value_vacio);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar input', data: $html);
        }

        $div = $this->directivas->html->div_group(cols: $cols,html:  $html);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al integrar div', data: $div);
        }

        return $div;
    }
    
    public function input_nombre(int $cols, stdClass $row_upd, bool $value_vacio): array|string
    {

        if($cols<=0){
            return $this->error->error(mensaje: 'Error cold debe ser mayor a 0', data: $cols);
        }
        if($cols>=13){
            return $this->error->error(mensaje: 'Error cold debe ser menor o igual a  12', data: $cols);
        }

        $html =$this->directivas->input_text_required(disable: false,name: 'nombre',place_holder: 'Nombre',row_upd: $row_upd,
            value_vacio: $value_vacio);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar input', data: $html);
        }

        $div = $this->directivas->html->div_group(cols: $cols,html:  $html);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al integrar div', data: $div);
        }

        return $div;
    }
    
    public function input_apellido_paterno(int $cols, stdClass $row_upd, bool $value_vacio): array|string
    {

        if($cols<=0){
            return $this->error->error(mensaje: 'Error cold debe ser mayor a 0', data: $cols);
        }
        if($cols>=13){
            return $this->error->error(mensaje: 'Error cold debe ser menor o igual a  12', data: $cols);
        }

        $html =$this->directivas->input_text_required(disable: false,name: 'apellido_paterno',
            place_holder: 'Apellido 1',row_upd: $row_upd, value_vacio: $value_vacio);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar input', data: $html);
        }

        $div = $this->directivas->html->div_group(cols: $cols,html:  $html);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al integrar div', data: $div);
        }

        return $div;
    }
    
    public function input_apellido_materno(int $cols, stdClass $row_upd, bool $value_vacio): array|string
    {

        if($cols<=0){
            return $this->error->error(mensaje: 'Error cold debe ser mayor a 0', data: $cols);
        }
        if($cols>=13){
            return $this->error->error(mensaje: 'Error cold debe ser menor o igual a  12', data: $cols);
        }

        $html =$this->directivas->input_text(disable: false,name: 'apellido_materno',place_holder: 'Apellido 2',
            required: false, row_upd: $row_upd, value_vacio: $value_vacio);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar input', data: $html);
        }

        $div = $this->directivas->html->div_group(cols: $cols,html:  $html);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al integrar div', data: $div);
        }

        return $div;
    }
    
    public function input_matricula(int $cols, stdClass $row_upd, bool $value_vacio): array|string
    {

        if($cols<=0){
            return $this->error->error(mensaje: 'Error cold debe ser mayor a 0', data: $cols);
        }
        if($cols>=13){
            return $this->error->error(mensaje: 'Error cold debe ser menor o igual a  12', data: $cols);
        }

        $html =$this->directivas->input_text_required(disable: false,name: 'matricula',place_holder: 'Matricula',row_upd: $row_upd,
            value_vacio: $value_vacio);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar input', data: $html);
        }

        $div = $this->directivas->html->div_group(cols: $cols,html:  $html);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al integrar div', data: $div);
        }

        return $div;
    }
    
    public function input_correo(int $cols, stdClass $row_upd, bool $value_vacio): array|string
    {

        if($cols<=0){
            return $this->error->error(mensaje: 'Error cold debe ser mayor a 0', data: $cols);
        }
        if($cols>=13){
            return $this->error->error(mensaje: 'Error cold debe ser menor o igual a  12', data: $cols);
        }

        $html =$this->directivas->input_text_required(disable: false,name: 'correo',place_holder: 'Correo',row_upd: $row_upd,
            value_vacio: $value_vacio);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar input', data: $html);
        }

        $div = $this->directivas->html->div_group(cols: $cols,html:  $html);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al integrar div', data: $div);
        }

        return $div;
    }
    
    public function input_curp(int $cols, stdClass $row_upd, bool $value_vacio): array|string
    {

        if($cols<=0){
            return $this->error->error(mensaje: 'Error cold debe ser mayor a 0', data: $cols);
        }
        if($cols>=13){
            return $this->error->error(mensaje: 'Error cold debe ser menor o igual a  12', data: $cols);
        }

        $html =$this->directivas->input_text_required(disable: false,name: 'curp',place_holder: 'CURP',row_upd: $row_upd,
            value_vacio: $value_vacio);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar input', data: $html);
        }

        $div = $this->directivas->html->div_group(cols: $cols,html:  $html);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al integrar div', data: $div);
        }

        return $div;
    }
    
    public function input_telefono_fijo(int $cols, stdClass $row_upd, bool $value_vacio): array|string
    {

        if($cols<=0){
            return $this->error->error(mensaje: 'Error cold debe ser mayor a 0', data: $cols);
        }
        if($cols>=13){
            return $this->error->error(mensaje: 'Error cold debe ser menor o igual a  12', data: $cols);
        }

        $html =$this->directivas->input_text(disable: false,name: 'telefono_fijo',place_holder: 'Telefono Fijo',
            required: false, row_upd: $row_upd, value_vacio: $value_vacio);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar input', data: $html);
        }

        $div = $this->directivas->html->div_group(cols: $cols,html:  $html);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al integrar div', data: $div);
        }

        return $div;
    }

    public function input_telefono_movil(int $cols, stdClass $row_upd, bool $value_vacio): array|string
    {

        if($cols<=0){
            return $this->error->error(mensaje: 'Error cold debe ser mayor a 0', data: $cols);
        }
        if($cols>=13){
            return $this->error->error(mensaje: 'Error cold debe ser menor o igual a  12', data: $cols);
        }

        $html =$this->directivas->input_text(disable: false,name: 'telefono_movil',place_holder: 'Telefono Movil',
            required: false, row_upd: $row_upd, value_vacio: $value_vacio);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar input', data: $html);
        }

        $div = $this->directivas->html->div_group(cols: $cols,html:  $html);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al integrar div', data: $div);
        }

        return $div;
    }

    public function fec_fecha_nacimiento(int $cols, stdClass $row_upd, bool $value_vacio): array|string
    {

        if($cols<=0){
            return $this->error->error(mensaje: 'Error cold debe ser mayor a 0', data: $cols);
        }
        if($cols>=13){
            return $this->error->error(mensaje: 'Error cold debe ser menor o igual a  12', data: $cols);
        }

        $html =$this->directivas->fecha_required(disable: false,name: 'fecha_nacimiento',
            place_holder: 'Fecha nacimiento',row_upd: $row_upd, value_vacio: $value_vacio);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar input', data: $html);
        }

        $div = $this->directivas->html->div_group(cols: $cols,html:  $html);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al integrar div', data: $div);
        }

        return $div;
    }

    public function fec_fecha_ingreso(int $cols, stdClass $row_upd, bool $value_vacio): array|string
    {

        if($cols<=0){
            return $this->error->error(mensaje: 'Error cold debe ser mayor a 0', data: $cols);
        }
        if($cols>=13){
            return $this->error->error(mensaje: 'Error cold debe ser menor o igual a  12', data: $cols);
        }

        $html =$this->directivas->fecha_required(disable: false,name: 'fecha_ingreso',
            place_holder: 'Fecha ingreso',row_upd: $row_upd, value_vacio: $value_vacio);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar input', data: $html);
        }

        $div = $this->directivas->html->div_group(cols: $cols,html:  $html);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al integrar div', data: $div);
        }

        return $div;
    }

    public function select_ac_alumno_id(int $cols, bool $con_registros, int $id_selected, PDO $link,
                                        bool $disabled = false, bool $required = false): array|string
    {
        $valida = (new directivas(html:$this->html_base))->valida_cols(cols:$cols);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al validar cols', data: $valida);
        }

        $modelo = new ac_alumno($link);

        $select = $this->select_catalogo(cols:$cols,con_registros:$con_registros, id_selected:$id_selected,
            modelo: $modelo,disabled: $disabled, label: 'Alumno', required: $required);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar select', data: $select);
        }
        return $select;
    }
}
