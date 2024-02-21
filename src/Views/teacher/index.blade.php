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
        <a class="btn btn-primary" href="teacher/add">theem moi</a>
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
                            <a class="btn btn-info" href="teacher/{{ $item['id'] }}/show">Show</a>
                            <a class="btn btn-warning" href="/teacher/{{ $item['id'] }}/update">update</a>
                            <a class="btn btn-danger" href="/teacher/{{ $item['id'] }}/delete">delete</a>
                        </th>

                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>

</body>

</html>
