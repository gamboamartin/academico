<?php
namespace models;
use base\orm\modelo;
use gamboamartin\errores\errores;
use PDO;
use stdClass;

class ac_alumno extends modelo{
    public function __construct(PDO $link){
        $tabla = __CLASS__;
        $columnas = array($tabla=>false,'ac_estado_alumno'=>$tabla,'ac_turno'=>$tabla,'dp_calle_pertenece'=>$tabla,
            'dp_colonia_postal'=>'dp_calle_pertenece','dp_cp'=>'dp_colonia_postal','dp_municipio'=>'dp_cp',
            'dp_estado'=>'dp_municipio','dp_pais'=>'dp_estado', 'adm_estado_civil'=>$tabla,'adm_genero'=>$tabla,
            'adm_idioma'=>$tabla, );
        $campos_obligatorios = array();

        $tipo_campos['telefono_fijo'] = 'telefono_mx';
        $tipo_campos['telefono_movil'] = 'telefono_mx';
        $tipo_campos['correo'] = 'correo';

        parent::__construct(link: $link,tabla:  $tabla, campos_obligatorios: $campos_obligatorios,
            columnas: $columnas,tipo_campos: $tipo_campos);
    }

    public function alta_bd(): array|stdClass
    {
        unset($this->registro['dp_pais_id'],$this->registro['dp_estado_id'],$this->registro['dp_municipio_id'],
            $this->registro['dp_cp_id'],$this->registro['dp_colonia_postal_id']);

        $this->registro['codigo'] = $this->registro['matricula'];
        $this->registro['descripcion_select'] = $this->registro['matricula'].' - '.$this->registro['nombre'].' ';
        $this->registro['descripcion_select'] .= $this->registro['apellido_paterno'].' ';
        $this->registro['descripcion_select'] .= $this->registro['apellido_materno'];
        $alias = $this->registro['apellido_paterno'].' '. $this->registro['apellido_materno'];
        $this->registro['alias'] = strtoupper($alias);

        $r_alta_bd = parent::alta_bd();
        if(errores::$error){
            return $this->error->error('Error al dar de alta registro',$r_alta_bd);
        }

        return  $r_alta_bd;
    }

    public function modifica_bd(array $registro, int $id, bool $reactiva = false): array|stdClass
    {
        unset($registro['dp_pais_id'],$registro['dp_estado_id'],$registro['dp_municipio_id'],
            $registro['dp_cp_id'],$registro['dp_colonia_postal_id']);

        $registro['codigo'] = $registro['matricula'];
        $registro['descripcion_select'] = $registro['matricula'].' - '.$registro['nombre'].' ';
        $registro['descripcion_select'] .= $registro['apellido_paterno'].' ';
        $registro['descripcion_select'] .= $registro['apellido_materno'];
        $alias = $registro['apellido_paterno'].' '. $registro['apellido_materno'];
        $registro['alias'] = strtoupper($alias);
        
        $r_modifica_bd = parent::modifica_bd($registro, $id, $reactiva);
        if(errores::$error){
            return $this->error->error('Error al dar de modificar registro',$r_modifica_bd);
        }
        
        return $r_modifica_bd;
    }
}