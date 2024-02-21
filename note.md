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

15: vào `Teacher/index.blade.php` nhúng bootstrap table
[Table bootstrap ](https://www.w3schools.com/bootstrap5/tryit.asp?filename=trybs_table_basic&stacked=h)

16: hoanf chinhr danh sach

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
