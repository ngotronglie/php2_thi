<?php

namespace Ngotr\thithu1\Commons;

use eftec\bladeone\BladeOne;

class Controller
{
    public function renderView($view, $data = [])
    {
        $templatePath = __DIR__ . '/../views';
        $compiledPath = __DIR__ . '/compiles';
        $blade = new BladeOne($templatePath, $compiledPath);
        echo $blade->run($view, $data); // it calls /views/hello.blade.php
    }
}