<?php
namespace html;

use gamboamartin\errores\errores;
use gamboamartin\system\html_controler;
use gamboamartin\template\directivas;
use models\ac_estado_alumno;
use PDO;



class ac_estado_alumno_html extends html_controler {

    /**
     * Genera un select de estado de alumno
     * @param int $cols N columnas css
     * @param bool $con_registros Si con registros entonces integra las registros para un select con options
     * @param int|null $id_selected Id preseleccionado que funcionara como selected
     * @param PDO $link Conexion a la base de datos
     * @param bool $required Si required agrega atributo required a input select
     * @return array|string
     * @version 0.119.11
     */
    public function select_ac_estado_alumno_id(int $cols, bool $con_registros, int|null $id_selected, PDO $link,
                                               bool $required = false): array|string
    {
        $valida = (new directivas(html:$this->html_base))->valida_cols(cols:$cols);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al validar cols', data: $valida);
        }

        if(is_null($id_selected)){
            $id_selected = -1;
        }

        $modelo = new ac_estado_alumno($link);

        $select = $this->select_catalogo(cols:$cols,con_registros:$con_registros,id_selected:$id_selected,
            modelo: $modelo, label: 'Estado Alumno', required: $required);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar select', data: $select);
        }
        return $select;
    }

}
