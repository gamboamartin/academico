<?php
namespace gamboamartin\academico\models;
use base\orm\modelo;
use gamboamartin\errores\errores;
use PDO;
use stdClass;

class ac_plan_estudio extends modelo{
    public function __construct(PDO $link){
        $tabla = 'ac_plan_estudio';
        $columnas = array($tabla=>false,'ac_nivel'=>$tabla, 'ac_rvoe' => $tabla);
        $campos_obligatorios = array('ac_nivel_id', 'ac_rvoe_id');

        parent::__construct(link: $link,tabla:  $tabla, campos_obligatorios: $campos_obligatorios,
            columnas: $columnas);

        $this->NAMESPACE = __NAMESPACE__;
    }

    public function alta_bd(): array|stdClass
    {
        $this->registro['codigo_bis'] = $this->registro['codigo'];
        $this->registro['descripcion_select'] = $this->registro['id_carrera'].' - '.$this->registro['descripcion'].
            ' - '.$this->registro['codigo'];
        $alias = $this->registro['id_carrera'].' '. $this->registro['descripcion'];
        $this->registro['alias'] = strtoupper($alias);

        $r_alta_bd = parent::alta_bd();
        if(errores::$error){
            return $this->error->error('Error al dar de alta registro',$r_alta_bd);
        }

        return  $r_alta_bd;
    }

    public function modifica_bd(array $registro, int $id, bool $reactiva = false): array|stdClass
    {
        $registro['codigo_bis'] = $registro['codigo'];
        $registro['descripcion_select'] = $registro['id_carrera'].' - '.$registro['descripcion'].
            ' - '.$registro['codigo'];
        $alias = $registro['id_carrera'].' '. $registro['descripcion'];
        $registro['alias'] = strtoupper($alias);

        $r_modifica_bd = parent::modifica_bd($registro, $id, $reactiva);
        if(errores::$error){
            return $this->error->error('Error al dar de modificar registro',$r_modifica_bd);
        }

        return $r_modifica_bd;
    }
}