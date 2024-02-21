**1: vào teminal cd đến dự án**
**2: viết `composer init` sau đó require `require 'vendor/autoload.php';` vào `index.php`**
**3: cài đặt 2 thư viện bramus và blade**

**4: tạo file**

- `helper.php ` để debug
- `router.php` để chứa đường dẫn ,
- `env.php` để viết tên kết nối với db,
- `.htaccess` là đường dẫn đẹp hơn,
- folder `compiles` để nó render ra view
  **5: trong src tạo folder**
- `Controllers`:
- `Views`:
- `Commons`: đặt các file cà class dùng chung
- `Models`: viết câu lệnh sql
  **6: vào router.php đi coppy cái này**

```php
<?php
// Create Router instance
$router = new \Bramus\Router\Router();

// Define routes
// ...

// Run it!
$router->run();
```

copy cái này nữa

```php
<?php
$router->mount('/movies', function() use ($router) {

    // will result in '/movies/'
    $router->get('/', function() {
        echo 'movies overview';
    });

    // will result in '/movies/id'
    $router->get('/(\d+)', function($id) {
        echo 'movie id ' . htmlentities($id);
    });

});
```

**7: vào `src/Commons` viết file `Controller.php` mục đích để viết renderview**
**8: Copy của bladeone chỗ _Explicit definition_**

```php
$views = __DIR__ . '/views';
$cache = __DIR__ . '/cache';
$blade = new BladeOne($views,$cache,BladeOne::MODE_DEBUG); // MODE_DEBUG allows to pinpoint troubles.
echo $blade->run("hello",array("variable1"=>"value1")); // it calls /views/hello.blade.php

```

sau đó trỏ và bladeone() để viết lại 2 biến là

```php

<?php

namespace Ngotr\thithu1\Commons;

use eftec\bladeone\BladeOne;

class Controller
{
    public function renderView($view, $data = [])
    {
        $templatePath = __DIR__ . '/../views';
        $compiledPath = __DIR__ . '/cache';
        $blade = new BladeOne($templatePath, $compiledPath);
        echo $blade->run($view, $data); // it calls /views/hello.blade.php
    }
}

```

**9: vào router.php đi copy đường dẫn `mount`, `get`**

```php
<?php
use Bramus\Router\Router;

$router = new Router();

// Define routes // định nghĩa đường dẫn
// ...
$router->get('/', function () {
    echo 'This is HomePages';
});
$router->mount('/movies', function () use ($router) {

    $router->get('/', function () {
        echo 'movies overview';
    });


});

// Run it!
$router->run();

```

**10: Vào folder `Controlers` tạo file `GiangvienController.php` kế thừa `Controler` để viết $this->renderView()**

| _file này có mục đích là liên kết renderview của Views_

```php
<?php


namespace Ngotr\Thithu1\Controllers;

use Ngotr\thithu1\Commons\Controller;

class GiangvienController extends Controller
{
    public function index()
    {
        return $this->renderView(__FUNCTION__);
    }
}
```

sau đó ra router.php viết như sau

```php
$router->get('/', GiangvienController::class . '@index');
```

- _lưu ý đường dẫn compiles khi nó render ra view_
  **11: Vào folder `Commons` tạo 1 file `Model.php` để cho các class Model khác kế thừa lại: mục đích là làm kết nối cơ sở dữ liệu**

```php
<?php

namespace Ngotr\Thithu1\Commons;

use PDO;
use PDOException;

class Model
{
    protected \PDO|null $conn;
    public function __construct()
    {
        $host = DB_HOST;
        $port = DB_PORT;
        $dbname = DB_USERNAME;
        $username = DB_NAME;
        $password = DB_PASSWORD;

        try {
            $conn = new \PDO("mysql:host=$host;port=$port;dbname=$dbname", $username, $password);

            $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $conn->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
        } catch (PDOException $PDOException) {
            echo "Kết nối thất bại: " . $PDOException->getMessage();
            die;
        }

    }
    public function __destruct()
    {
        $this->conn = null;
    }
}

```

**12: trong thư mục Models tạo file `Teacher.php` kế thừa file `Model.php`: mục đích để vết Sql đọc thêm sửa xóa**

- GetAll
- GetById
- Update
- delete
  **13: vào View/Teacher tạo 4 file**
- add.blade.php
- update.blade.php
- show.blade.php
- index.blade.php

**14: vào `Controllers/TeacherController.php` viết crud**

```php
<?php


namespace Ngotr\Thithu1\Controllers;

use Ngotr\Thithu1\Commons\Controller;
use Ngotr\Thithu1\Models\Teacher;

class GiangvienController extends Controller
{
    private Teacher $teacher; // tạo 1 đối tượng teacher
    private string $folder = 'teacher.'; // tạo cho compiles
    public function __construct() // luôn luôn khởi tạo 1 đối tượng
    {
        $this->teacher = new Teacher;
    }
    public function index()
    {
        $data['teacher'] = $this->teacher->getAll();
        return $this->renderView($this->folder . __FUNCTION__, $data);
    }
}

```

**15: vào `Teacher/index.blade.php` nhúng bootstrap table [Table bootstrap ](https://www.w3schools.com/bootstrap5/tryit.asp?filename=trybs_table_basic&stacked=h)**

**16: hoanf chinhr danh sach**

```php
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

    <div class="container mt-3">
        <h2>Danh sách </h2>
        <a class="btn btn-primary" href="/add">theem moi</a>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>name</th>
                    <th>Email</th>
                    <th>salary</th>
                    <th>school</th>
                    <th>action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($teacher as $key => $item)
                    <tr>
                        <th>{{ $key + 1 }}</th>
                        <th>{{ $item['name'] }}</th>
                        <th>{{ $item['email'] }}</th>
                        <th>{{ $item['salary'] }}</th>
                        <th>{{ $item['school'] }}</th>
                        <th>
                            <a class="btn btn-info" href="/show">Show</a>
                            <a class="btn btn-warning" href="/{{ $item['id'] }}/update">update</a>
                            <a class="btn btn-danger" href="/{{ $item['id'] }}/delete">delete</a>
                        </th>

                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>

</body>

</html>

```

**17: Vào lấy Table trong w3school**

```php
<!DOCTYPE html>

<html lang="en">

<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

    <div class="container mt-3">
        <h2>Stacked form</h2>
        <form action="" method="POST">
            <div class="mb-3 mt-3">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" placeholder="Enter name" name="name">
            </div>
            <div class="mb-3">
                <label for="email">email</label>
                <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
            </div>
            <div class="mb-3">
                <label for="salary">salary</label>
                <input type="number" class="form-control" id="salary" placeholder="Enter salary" name="salary">
            </div>
            <div class="mb-3">
                <label for="school">school</label>
                <input type="text" class="form-control" id="school" placeholder="Enter school" name="school">
            </div>

            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

</body>

</html>

```

- sau đó hoàn thiện trang add.blade.php

  - Luu ý : chú ý label ,name, method
  - vết thêm function vào GiangvienController

  ```php
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
  ```

**18: viết hàm update bản chất giống create**

- lấy được id teacher cần sửa
- lấy dc dữ liệu của teacher cần sửa
- dùng lại Post để update lại
- sql update

```php
// TeacherController
public function update($id, $name, $email, $salary, $school)
    {
        try {
            $sql = "
                UPDATE teacher
                                SET name = :name,
                                    email = :email,
                                    salary = :salary,
                                    school = :school
                WHERE id = :id
            ";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':salary', $salary);
            $stmt->bindParam(':school', $school);

            $stmt->execute();
        } catch (\Exception $e) {
            echo 'ERROR: ' . $e->getMessage();
            die;
        }
    }
```

```php
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

    <div class="container mt-3">
        <h2>update form</h2>
        <form action="" method="POST">
            <div class="mb-3 mt-3">
                <label for="name">Name</label>
                <input value="{{ $teacher['name'] }}" type="text" class="form-control" id="name"
                    placeholder="Enter name" name="name">
            </div>
            <div class="mb-3">
                <label for="email">email</label>
                <input value="{{ $teacher['email'] }}" type="email" class="form-control" id="email"
                    placeholder="Enter email" name="email">
            </div>
            <div class="mb-3">
                <label for="salary">salary</label>
                <input value="{{ $teacher['salary'] }}" type="number" class="form-control" id="salary"
                    placeholder="Enter salary" name="salary">
            </div>
            <div class="mb-3">
                <label for="school">school</label>
                <input value="{{ $teacher['school'] }}" type="text" class="form-control" id="school"
                    placeholder="Enter school" name="school">
            </div>

            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

</body>

</html>


```

**19: Show**

- Chuyển từ update qua và xóa đi empy($\_POST)
- không cần viết sql trong models , chỉ lấy dc id rồi hiện thông tin ra
- vào GiangvienController coppy Update

```php
public function show($id)
    {
        $teacher = $this->teacher->getByID($id); // lấy được id teacher
        if (empty($teacher)) {
            echo 'Không có teacher này!';
        }
        return $this->renderView($this->folder . __FUNCTION__, ['teacher' => $teacher]);
    }
```

```php
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

    <div class="container mt-3">
        <h2>chi tiết</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>name</th>
                    <th>Email</th>
                    <th>salary</th>
                    <th>school</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $teacher['id'] }}</td>
                    <td>{{ $teacher['name'] }}</td>
                    <td>{{ $teacher['email'] }}</td>
                    <td>{{ $teacher['salary'] }}</td>
                    <td>{{ $teacher['school'] }}</td>
                </tr>


            </tbody>
        </table>
    </div>

</body>

</html>


```

**20: delete**

- get id
- delete teacher

```php
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

```
