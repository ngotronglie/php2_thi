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
    public function add()
    {
        if (!empty($_POST)) { // post không cần name
            $name = $_POST['name'];
            $email = $_POST['email'];
            $salary = $_POST['salary'];
            $school = $_POST['school'];
            $this->teacher->insert($name, $email, $salary, $school);
            header('Location: /teacher/');
        }

        return $this->renderView($this->folder . __FUNCTION__);
    }
    public function update($id)
    {
        $teacher = $this->teacher->getByID($id); // lấy được id teacher 
        if (empty($teacher)) {
            echo 'Không có teacher này!';
        }

        if (!empty($_POST)) { // post không cần name
            $name = $_POST['name'];
            $email = $_POST['email'];
            $salary = $_POST['salary'];
            $school = $_POST['school'];
            $this->teacher->update($id, $name, $email, $salary, $school);
            header('Location: /teacher/');
        }

        return $this->renderView($this->folder . __FUNCTION__, ['teacher' => $teacher]);
    }
    public function show($id)
    {
        $teacher = $this->teacher->getByID($id); // lấy được id teacher 
        if (empty($teacher)) {
            echo 'Không có teacher này!';
        }
        return $this->renderView($this->folder . __FUNCTION__, ['teacher' => $teacher]);
    }
    public function delete($id)
    {
        $teacher = $this->teacher->getByID($id); // lấy được id teacher 
        if (empty($teacher)) {
            echo 'Không có teacher này!';
        } else {
            $this->teacher->delete($id);
            header('location: /teacher/');
        }
    }

}
