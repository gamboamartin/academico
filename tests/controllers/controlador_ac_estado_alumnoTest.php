<?php
namespace gamboamartin\academico\tests\controllers;

use gamboamartin\academico\controllers\controlador_ac_estado_alumno;
use gamboamartin\errores\errores;
use gamboamartin\template_1\html;
use gamboamartin\test\liberator;
use gamboamartin\test\test;

use html\ac_estado_alumno_html;
use html\org_empresa_html;

use stdClass;


class controlador_ac_estado_alumnoTest extends test {
    public errores $errores;
    private stdClass $paths_conf;
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->errores = new errores();
        $this->paths_conf = new stdClass();
        $this->paths_conf->generales = '/var/www/html/academico/config/generales.php';
        $this->paths_conf->database = '/var/www/html/academico/config/database.php';
        $this->paths_conf->views = '/var/www/html/academico/config/views.php';
    }

    /**
     */
    public function test_alta(): void
    {
        errores::$error = false;

        $_GET['seccion'] = 'cat_sat_tipo_persona';
        $_GET['accion'] = 'lista';
        $_SESSION['grupo_id'] = 1;
        $_GET['session_id'] = '1';
        //$html_ = new html();
        //$html = new ac_estado_alumno_html($html_);

        $ctl = new controlador_ac_estado_alumno(link: $this->link, paths_conf: $this->paths_conf);
        //$html = new liberator($html);


        $resultado = $ctl->alta(false);

        $this->assertIsString($resultado);
        $this->assertNotTrue(errores::$error);
        $this->assertStringContainsStringIgnoringCase("<div class='control-group col-sm-6'><label class='control-label' for='codigo'>Codigo</label><div class='controls'><input type='text' name='codigo' value='' class='form-control'  required id='codigo' placeholder='Codigo' /></div></div><div class='control-group col-sm-6'><label class='control-label' for='codigo_bis'>Codigo BIS</label><div class='controls'><input type='text' name='codigo_bis' value='' class='form-control'  required id='codigo_bis' placeholder='Codigo BIS' /></div></div><div class='control-group col-sm-12'><label class='control-label' for='descripcion'>Descripcion</label><div class='controls'><input type='text' name='descripcion' value='' class='form-control'  required id='descripcion' placeholder='Descripcion' /></div></div><div class='control-group col-sm-6'><label class='control-label' for='descripcion_select'>Descripcion Select</label><div class='controls'><input type='text' name='descripcion_select' value='' class='form-control'  required id='descripcion_select' placeholder='Descripcion Select' /></div></div><div class='control-group col-sm-6'><label class='control-label' for='alias'>Alias</label><div class='controls'><input type='text' name='alias' value='' class='form-control'  required id='alias' placeholder='Alias' /></div></div>", $resultado);

        errores::$error = false;
    }



}

