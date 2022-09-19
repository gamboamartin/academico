<?php
/**
 * @author Martin Gamboa Vazquez
 * @version 1.0.0
 * @created 2022-05-14
 * @final En proceso
 *
 */
namespace gamboamartin\academico\controllers;


use gamboamartin\errores\errores;
use gamboamartin\system\actions;
use gamboamartin\system\links_menu;
use gamboamartin\system\system;
use gamboamartin\template_1\html;
use html\ac_alumno_html;
use html\ac_centro_educativo_html;
use html\selects;
use links\secciones\link_ac_alumno;
use models\ac_alumno;
use models\ac_alumno_pertenece;
use models\ac_centro_educativo;
use PDO;
use stdClass;

class controlador_ac_alumno extends system {
    public string $link_ac_alumno_pertenece_alta_bd = '';
    public int $ac_alumno_id = -1;
    public stdClass $planteles ;

    public function __construct(PDO $link, html $html = new \gamboamartin\template_1\html(),
                                stdClass $paths_conf = new stdClass()){

        $modelo = new ac_alumno(link: $link);
        $html_ = new ac_alumno_html($html);
        $obj_link = new link_ac_alumno($this->registro_id);
        parent::__construct(html:$html_, link: $link,modelo:  $modelo, obj_link: $obj_link, paths_conf: $paths_conf);

        $this->titulo_lista = 'Alumno';

        $link_ac_alumno_pertenece_alta_bd = $obj_link->link_ac_alumno_pertenece_alta_bd(ac_alumno_id: $this->registro_id);
        if(errores::$error){
            $error = $this->errores->error(mensaje: 'Error al generar link sucursal alta',
                data:  $link_ac_alumno_pertenece_alta_bd);
            print_r($error);
            exit;
        }
        $this->link_ac_alumno_pertenece_alta_bd = $link_ac_alumno_pertenece_alta_bd;
        
        $keys_row_lista = $this->keys_rows_lista();
        if(errores::$error){
            $error = $this->errores->error(mensaje: 'Error al generar keys de lista',data:  $keys_row_lista);
            print_r($error);
            exit;
        }
        $this->keys_row_lista = $keys_row_lista;

        $this->ac_alumno_id = $this->registro_id;
    }

    private function keys_rows_lista(): array
    {

        $keys_row_lista = array();

            $keys = array('ac_alumno_id','ac_alumno_nombre','ac_alumno_apellido_paterno','ac_alumno_apellido_materno',
                'ac_alumno_matricula','ac_alumno_curp');

        foreach ($keys as $campo){
            $keys_row_lista = $this->key_row_lista_init(campo: $campo, keys_row_lista: $keys_row_lista);
            if(errores::$error){
                return $this->errores->error(mensaje: 'Error al inicializar key',data: $keys_row_lista);
            }
        }

        return $keys_row_lista;
    }

    private function key_row_lista_init(string $campo, array $keys_row_lista): array
    {
        $data = new stdClass();
        $data->campo = $campo;

        $campo = str_replace('ac_alumno_', '', $campo);
        $campo = str_replace('_', ' ', $campo);
        $campo = ucfirst(strtolower($campo));

        $data->name_lista = $campo;
        $keys_row_lista[]= $data;
        return $keys_row_lista;
    }


    public function alta(bool $header, bool $ws = false): array|string
    {
        $r_alta =  parent::alta(header: false); // TODO: Change the autogenerated stub
        if(errores::$error){
            return $this->retorno_error(mensaje: 'Error al generar template',data:  $r_alta, header: $header,ws:$ws);
        }

        $keys_selects = array();
        $inputs = (new ac_alumno_html(html: $this->html_base))->genera_inputs_alta(controler: $this,
            keys_selects:$keys_selects,link: $this->link);
        if(errores::$error){
            $error = $this->errores->error(mensaje: 'Error al generar inputs',data:  $inputs);
            print_r($error);
            die('Error');
        }
        return $r_alta;
    }

    public function alta_alumno_pertenece_bd(bool $header, bool $ws = false){
        $this->link->beginTransaction();

        $siguiente_view = (new actions())->init_alta_bd();
        if(errores::$error){
            $this->link->rollBack();
            return $this->retorno_error(mensaje: 'Error al obtener siguiente view', data: $siguiente_view,
                header:  $header, ws: $ws);
        }


        if(isset($_POST['guarda'])){
            unset($_POST['guarda']);
        }
        if(isset($_POST['btn_action_next'])){
            unset($_POST['btn_action_next']);
        }


        $registro = $_POST;
        $registro['ac_alumno_id'] = $this->registro_id;

        $r_alta_alumno_pertenece_bd = (new ac_alumno_pertenece($this->link))->alta_registro(registro:$registro); // TODO: Change the autogenerated stub
        if(errores::$error){
            $this->link->rollBack();
            return $this->retorno_error(mensaje: 'Error al dar de alta alumno_pertenece',data:  $r_alta_alumno_pertenece_bd,
                header: $header,ws:$ws);
        }


        $this->link->commit();



        if($header){

            $retorno = (new actions())->retorno_alta_bd(registro_id:$this->registro_id,seccion: $this->tabla,
                siguiente_view: $siguiente_view);
            if(errores::$error){
                return $this->retorno_error(mensaje: 'Error al dar de alta registro', data: $r_alta_alumno_pertenece_bd,
                    header:  true, ws: $ws);
            }
            header('Location:'.$retorno);
            exit;
        }
        if($ws){
            header('Content-Type: application/json');
            echo json_encode($r_alta_alumno_pertenece_bd, JSON_THROW_ON_ERROR);
            exit;
        }

        return $r_alta_alumno_pertenece_bd;
    }

    public function asigna_plantel(bool $header, bool $ws = false){
        $r_modifica =  parent::modifica(header: false,aplica_form:  false); // TODO: Change the autogenerated stub
        if(errores::$error){
            return $this->errores->error(mensaje: 'Error al generar template',data:  $r_modifica);
        }

        $inputs = (new ac_alumno_html(html: $this->html_base))->genera_inputs_asigna_plantel(controler: $this, link: $this->link);
        if(errores::$error){
            $error = $this->errores->error(mensaje: 'Error al generar inputs',data:  $inputs);
            print_r($error);
            die('Error');
        }

        $select = $this->select_ac_alumno_id();
        if(errores::$error){
            return $this->retorno_error(mensaje: 'Error al generar select datos',data:  $select,
                header: $header,ws:$ws);
        }

        $planteles = (new ac_alumno_pertenece($this->link))->planteles(ac_alumno_id: $this->ac_alumno_id);
        if(errores::$error){
            return $this->retorno_error(mensaje: 'Error al obtener planteles',data:  $planteles, header: $header,ws:$ws);
        }

        foreach ($planteles->registros as $indice=>$plantel){

            $plantel['direccion'] = $plantel['dp_calle_descripcion'].' '.
                $plantel['ac_centro_educativo_exterior'].' '. $plantel['ac_centro_educativo_interior'].' '.
                $plantel['dp_colonia_descripcion'].' '. $plantel['dp_estado_descripcion'];

            $plantel = $this->data_plantel_btn(plantel:$plantel);
            if(errores::$error){
                return $this->retorno_error(mensaje: 'Error al asignar botones',data:  $plantel, header: $header,ws:$ws);
            }
            $planteles->registros[$indice] = $plantel;
        }

        $this->planteles = $planteles;


        return $r_modifica;
    }

    private function data_plantel_btn(array $plantel): array
    {

        $params['ac_alumno_id'] = $plantel['ac_alumno_id'];

        $btn_elimina = $this->html_base->button_href(accion:'elimina_bd',etiqueta:  'Elimina',
            registro_id:  $plantel['ac_alumno_pertenece_id'], seccion: 'ac_alumno_pertenece',style:  'danger');

        if(errores::$error){
            return $this->errores->error(mensaje: 'Error al generar btn',data:  $btn_elimina);
        }
        $plantel['link_elimina'] = $btn_elimina;


        $btn_modifica = $this->html_base->button_href(accion:'modifica_plantel',etiqueta:  'Modifica',
            registro_id:  $plantel['ac_alumno_id'], seccion: 'ac_alumno',style:  'warning', params: $params);

        if(errores::$error){
            return $this->errores->error(mensaje: 'Error al generar btn',data:  $btn_elimina);
        }
        $plantel['link_modifica'] = $btn_modifica;

        $btn_ve = $this->html_base->button_href(accion:'ve_plantel',etiqueta:  'Ver',
            registro_id:  $plantel['ac_alumno_id'], seccion: 'ac_alumno',style:  'info', params: $params);

        if(errores::$error){
            return $this->errores->error(mensaje: 'Error al generar btn',data:  $btn_elimina);
        }
        $plantel['link_ve'] = $btn_ve;
        return $plantel;
    }


    private function select_ac_alumno_id(): array|string
    {
        $select = (new ac_alumno_html(html: $this->html_base))->select_ac_alumno_id(cols:12,con_registros: true,
            id_selected: $this->registro_id,link:  $this->link, disabled: true);

        if(errores::$error){
            return $this->errores->error(mensaje: 'Error al generar select datos',data:  $select);
        }
        $this->inputs->select->ac_alumno_id = $select;

        return $select;
    }

    public function modifica(bool $header, bool $ws = false, string $breadcrumbs = '', bool $aplica_form = true, bool $muestra_btn = true): array|string
    {
        $r_modifica =  parent::modifica(header: false,aplica_form:  false); // TODO: Change the autogenerated stub
        if(errores::$error){
            return $this->errores->error(mensaje: 'Error al generar template',data:  $r_modifica);
        }

        $inputs = (new ac_alumno_html(html: $this->html_base))->inputs_org_empresa(
            controlador_org_empresa:$this);
        if(errores::$error){
            return $this->errores->error(mensaje: 'Error al inicializar inputs',data:  $inputs);
        }

        return $r_modifica;
    }

    private function asigna_link_asigna_plantel_row(stdClass $row): array|stdClass
    {
        $keys = array('ac_alumno_id');
        $valida = $this->validacion->valida_ids(keys: $keys,registro:  $row);
        if(errores::$error){
            return $this->errores->error(mensaje: 'Error al validar row',data:  $valida);
        }

        $link_asigna_plantel = $this->obj_link->link_con_id(accion:'asigna_plantel',registro_id:  $row->ac_alumno_id,
            seccion:  $this->tabla);
        if(errores::$error){
            return $this->errores->error(mensaje: 'Error al genera link',data:  $link_asigna_plantel);
        }

        $row->link_asigna_plantel = $link_asigna_plantel;
        $row->link_asigna_plantel_style = 'info';

        return $row;
    }

    public function lista(bool $header, bool $ws = false): array
    {
        $r_lista = parent::lista($header, $ws); // TODO: Change the autogenerated stub
        if(errores::$error){
            return $this->retorno_error(mensaje: 'Error al maquetar datos',data:  $r_lista, header: $header,ws:$ws);
        }

        $registros = $this->maqueta_registros_lista(registros: $this->registros);
        if(errores::$error){
            return $this->retorno_error(mensaje: 'Error al maquetar registros',data:  $registros, header: $header,ws:$ws);
        }
        $this->registros = $registros;


        return $r_lista;
    }

    private function maqueta_registros_lista(array $registros): array
    {
        foreach ($registros as $indice=> $row){
            $row = $this->asigna_link_asigna_plantel_row(row: $row);
            if(errores::$error){
                return $this->errores->error(mensaje: 'Error al maquetar row',data:  $row);
            }
            $registros[$indice] = $row;
        }
        return $registros;
    }

    public function ve_plantel(bool $header, bool $ws = false): array|stdClass
    {

        $keys = array('ac_alumno_id','registro_id');
        $valida = $this->validacion->valida_ids(keys: $keys, registro: $_GET);
        if(errores::$error){
            return $this->retorno_error(mensaje: 'Error al validar GET',data:  $valida, header: $header,ws:$ws);
        }

        $planteles = (new ac_alumno_pertenece($this->link))->planteles(ac_alumno_id: $_GET['ac_alumno_id']);
        if(errores::$error){
            return $this->retorno_error(mensaje: 'Error al obtener planteles',data:  $planteles, header: $header,ws:$ws);
        }

        $ac_centro_educativo_id = $planteles->registros[0]['ac_centro_educativo_id'];
        $ac_centro_educativo = (new ac_centro_educativo($this->link))->registro(registro_id:$ac_centro_educativo_id,
            columnas_en_bruto: true, retorno_obj: true);
        if(errores::$error){
            return $this->retorno_error(mensaje: 'Error al obtener centro educativo',data:  $ac_centro_educativo,
                header: $header,ws:$ws);
        }

        $html = (new ac_centro_educativo_html(html: $this->html_base));

        $centro_educativo_codigo_disabled = $params->centro_educativo_codigo->disabled ?? true;

        $ac_centro_educativo_codigo = $html->input_codigo(cols: 4,row_upd:  $ac_centro_educativo, value_vacio: false,
            disabled: $centro_educativo_codigo_disabled);
        if(errores::$error){
            return $this->errores->error(mensaje: 'Error al obtener centro_educativo_codigo select',data:  $ac_centro_educativo_codigo);
        }

        $centro_educativo_codigo_bis_disabled = $params->centro_educativo_codigo_bis->disabled ?? true;
        $ac_centro_educativo_codigo_bis = $html->input_codigo_bis(cols: 4,row_upd:  $ac_centro_educativo, value_vacio: false,
            disabled: $centro_educativo_codigo_bis_disabled);
        if(errores::$error){
            return $this->errores->error(mensaje: 'Error al obtener centro_educativo_codigo_bis',
                data:  $ac_centro_educativo_codigo_bis);
        }

        $centro_educativo_descripcion_disabled = $params->centro_educativo_descripcion->disabled ?? true;
        $ac_centro_educativo_descripcion = $html->input_descripcion(cols: 12,row_upd:  $ac_centro_educativo, value_vacio: false,
            disabled: $centro_educativo_descripcion_disabled);
        if(errores::$error){
            return $this->errores->error(mensaje: 'Error al obtener descripcion',data:  $ac_centro_educativo_descripcion);
        }


        $centro_educativo_exterior_disabled = $params->centro_educativo_exterior->disabled ?? true;
        $ac_centro_educativo_exterior = $html->input_exterior(cols: 6, row_upd:  $ac_centro_educativo,
            value_vacio: false, disabled: $centro_educativo_exterior_disabled);
        if(errores::$error){
            return $this->errores->error(mensaje: 'Error al obtener $ac_centro_educativo_exterior',data:  $ac_centro_educativo_exterior);
        }

        $centro_educativo_interior_disabled = $params->centro_educativo_interior->disabled ?? true;
        $ac_centro_educativo_interior = $html->input_interior(cols: 6, row_upd:  $ac_centro_educativo,
            value_vacio: false, disabled: $centro_educativo_interior_disabled);
        if(errores::$error){
            return $this->errores->error(mensaje: 'Error al obtener $ac_centro_educativo_interior',data:  $ac_centro_educativo_interior);
        }

        $centro_educativo_id_disabled = $params->ac_centro_educativo_id->disabled ?? true;
        $ac_centro_educativo_id = $html->input_id(cols: 4,row_upd:  $ac_centro_educativo, value_vacio: false,
            disabled: $centro_educativo_id_disabled);
        if(errores::$error){
            return $this->errores->error(mensaje: 'Error al obtener centro_educativo_id select',data:  $ac_centro_educativo_id);
        }

        $ac_centro_id = $planteles->registros[0]['ac_centro_educativo_id'];
        $ac_centro_educativo = (new ac_centro_educativo($this->link))->registro(registro_id:$ac_centro_id,
            retorno_obj: true);
        if(errores::$error){
            return $this->retorno_error(mensaje: 'Error al obtener centro educativo',data:  $ac_centro_educativo,
                header: $header,ws:$ws);
        }

        $selects = new stdClass();

        $params = new stdClass();
        $params->dp_pais_id = new stdClass();
        $params->dp_pais_id->disabled = true;
        $params->dp_estado_id = new stdClass();
        $params->dp_estado_id->disabled = true;
        $params->dp_municipio_id = new stdClass();
        $params->dp_municipio_id->disabled = true;
        $params->dp_cp_id = new stdClass();
        $params->dp_cp_id->disabled = true;
        $params->dp_colonia_postal_id = new stdClass();
        $params->dp_colonia_postal_id->disabled = true;
        $params->dp_calle_pertenece_id = new stdClass();
        $params->dp_calle_pertenece_id->disabled = true;

        $selects = (new selects())->direcciones(html: $this->html_base,link:  $this->link,row:  $ac_centro_educativo,
            selects:  $selects,params: $params);
        if(errores::$error){
            return $this->errores->error(mensaje: 'Error al generar selects de domicilios',data:  $selects);
        }

        $this->inputs = new stdClass();
        $this->inputs->select = new stdClass();
        $this->inputs->ac_centro_educativo_id = $ac_centro_educativo_id;
        $this->inputs->ac_centro_educativo_codigo = $ac_centro_educativo_codigo;
        $this->inputs->ac_centro_educativo_codigo_bis = $ac_centro_educativo_codigo_bis;
        $this->inputs->ac_centro_educativo_descripcion = $ac_centro_educativo_descripcion;
        $this->inputs->ac_centro_educativo_exterior = $ac_centro_educativo_exterior;
        $this->inputs->ac_centro_educativo_interior = $ac_centro_educativo_interior;

        $this->inputs->select->dp_pais_id = $selects->dp_pais_id;
        $this->inputs->select->dp_estado_id = $selects->dp_estado_id;
        $this->inputs->select->dp_municipio_id = $selects->dp_municipio_id;
        $this->inputs->select->dp_cp_id = $selects->dp_cp_id;
        $this->inputs->select->dp_colonia_postal_id = $selects->dp_colonia_postal_id;
        $this->inputs->select->dp_calle_pertenece_id = $selects->dp_calle_pertenece_id;

        return $planteles;
    }

}
