<?php


namespace Ngotr\Thithu1\Controllers;

use Ngotr\Thithu1\Commons\Controller;
use Ngotr\Thithu1\Models\Teacher;

class GiangvienController extends Controller
{
    private Teacher $teacher;
    private string $folder = 'teacher.';
    public function __construct()
    {
        $this->teacher = new Teacher;
    }
    public function index()
    {
        $data['teacher'] = $this->teacher->getAll();
        return $this->renderView($this->folder . __FUNCTION__, $data);
    }
}