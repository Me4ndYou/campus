<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} | Log in</title>
    <link rel="icon" href="{{ asset('images/favicon.ico') }}">
    <link href="{{ asset('css/yeti-bootstrap.min.css') }}" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mx-auto mt-4">
                <div class="card">
                    <div class="card-header">
                        <strong>Silahkan Masuk</strong>
                    </div>
                    <div class="card-body">
                        {{ show_error($errors) }}
                        <form action="{{ route('login.action') }}" method="post">
                            {{ csrf_field() }}
                            <div class="input-group mb-3">
                                <input type="text" class="form-control form-control-lg" placeholder="Username" name="username">
                            </div>
                            <div class="input-group mb-3">
                                <input type="password" class="form-control form-control-lg" placeholder="Password" name="password">
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-lg btn-primary">Masuk</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>