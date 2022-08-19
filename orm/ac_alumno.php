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
            'adm_estado_civil'=>$tabla,'adm_genero'=>$tabla, 'adm_idioma'=>$tabla);
        $campos_obligatorios = array();

        parent::__construct(link: $link,tabla:  $tabla, campos_obligatorios: $campos_obligatorios,
            columnas: $columnas);
    }

    public function alta_bd(): array|stdClass
    {
        unset($this->registro['dp_pais_id'],$this->registro['dp_estado_id'],$this->registro['dp_municipio_id'],
            $this->registro['dp_cp_id'],$this->registro['dp_colonia_postal_id']);
        
        $this->registro['codigo'] = $this->registro['matricula'];
        $this->registro['descripcion_select'] = $this->registro['matricula'].' '.$this->registro['nombre'].' ';
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
}