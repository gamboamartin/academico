<?php
namespace html;

use gamboamartin\academico\controllers\controlador_ac_centro_educativo;
use gamboamartin\errores\errores;
use gamboamartin\system\html_controler;
use gamboamartin\template\directivas;
use models\ac_estado_alumno;
use PDO;
use stdClass;


class ac_estado_alumno_html extends html_controler {

    public function select_ac_estado_alumno_id(int $cols, bool $con_registros, int $id_selected, PDO $link,
                                               bool $required = false): array|string
    {
        $valida = (new directivas(html:$this->html_base))->valida_cols(cols:$cols);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al validar cols', data: $valida);
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
