<?php
namespace html;


use gamboamartin\academico\models\ac_tipo_asignatura;
use gamboamartin\errores\errores;
use gamboamartin\system\html_controler;
use gamboamartin\template\directivas;

use PDO;



class ac_tipo_asignatura_html extends html_controler {

    /**
     * Genera un select de tipo asignatura
     * @param int $cols N cols css
     * @param bool $con_registros Si con registros
     * @param int|null $id_selected Identificador
     * @param PDO $link Conexion a la base de datos
     * @return array|string
     * @version 0.124.12
     */
    public function select_ac_tipo_asignatura_id(int $cols, bool $con_registros, int|null $id_selected, PDO $link): array|string
    {
        $valida = (new directivas(html:$this->html_base))->valida_cols(cols:$cols);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al validar cols', data: $valida);
        }

        $modelo = new ac_tipo_asignatura($link);

        if(is_null($id_selected)){
            $id_selected = -1;
        }

        $select = $this->select_catalogo(cols:$cols,con_registros:$con_registros,id_selected:$id_selected,
            modelo: $modelo, label: 'Tipo Asignatura');
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar select', data: $select);
        }
        return $select;
    }

}
