<?php
namespace gamboamartin\academico\tests\templates\directivas;

use gamboamartin\errores\errores;
use gamboamartin\template_1\html;

use gamboamartin\test\test;

use html\ac_estado_alumno_html;


use html\ac_tipo_asignatura_html;
use stdClass;


class ac_tipo_asignatura_htmlTest extends test {
    public errores $errores;
    private stdClass $paths_conf;
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->errores = new errores();
    }

    /**
     */
    public function test_select_ac_tipo_asignatura_id(): void
    {
        errores::$error = false;

        $_GET['seccion'] = 'cat_sat_tipo_persona';
        $_GET['accion'] = 'lista';
        $_SESSION['grupo_id'] = 1;
        $_GET['session_id'] = '1';
        $html_ = new html();
        $html = new ac_tipo_asignatura_html($html_);
        //$html = new liberator($html);

        $cols = '1';
        $con_registros = true;
        $id_selected = -1;
        $link = $this->link;

        $resultado = $html->select_ac_tipo_asignatura_id($cols, $con_registros, $id_selected, $link);
        $this->assertIsString($resultado);
        $this->assertNotTrue(errores::$error);
        $this->assertStringContainsStringIgnoringCase("l-label' for='ac_tipo_asignatura_id'", $resultado);

        errores::$error = false;
    }



}

