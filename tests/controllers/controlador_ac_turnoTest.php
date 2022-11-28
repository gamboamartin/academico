<?php
namespace gamboamartin\academico\tests\controllers;

use gamboamartin\academico\controllers\controlador_ac_estado_alumno;
use gamboamartin\academico\controllers\controlador_ac_turno;
use gamboamartin\errores\errores;

use gamboamartin\test\test;


use stdClass;


class controlador_ac_turnoTest extends test {
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
    public function test_modifica_bd(): void
    {
        errores::$error = false;

        $_GET['seccion'] = 'ac_turno';
        $_GET['accion'] = 'lista';
        $_SESSION['grupo_id'] = 1;
        $_SESSION['usuario_id'] = 2;
        $_GET['session_id'] = '1';
        //$html_ = new html();
        //$html = new ac_estado_alumno_html($html_);

        $ctl = new controlador_ac_turno(link: $this->link, paths_conf: $this->paths_conf);
        //$html = new liberator($html);

        $ctl->registro_id = '1';
        $_POST['codigo'] = 'x';
        $resultado = $ctl->modifica_bd(false, false);


        $this->assertIsObject($resultado);
        $this->assertNotTrue(errores::$error);


        errores::$error = false;
    }

    public function test_status(): void
    {
        errores::$error = false;

        $_GET['seccion'] = 'ac_turno';
        $_GET['accion'] = 'lista';
        $_SESSION['grupo_id'] = 1;
        $_SESSION['usuario_id'] = 2;
        $_GET['session_id'] = '1';
        //$html_ = new html();
        //$html = new ac_estado_alumno_html($html_);

        $ctl = new controlador_ac_turno(link: $this->link, paths_conf: $this->paths_conf);
        //$html = new liberator($html);

        $ctl->registro_id = 1;

        $resultado = $ctl->status(false, false);
        $this->assertIsObject($resultado);
        $this->assertNotTrue(errores::$error);
        $this->assertStringContainsStringIgnoringCase('Exito al ejecutar sql del modelo ac_turno',$resultado->mensaje);
        errores::$error = false;
    }



}

