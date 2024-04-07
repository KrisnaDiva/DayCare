<?php
require_once __DIR__ . '/../db/middleware.php';
guest();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
<div class="row justify-content-center">
    <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">
        <div class="text-center my-5">
            <img src="https://getbootstrap.com/docs/5.0/assets/brand/bootstrap-logo.svg" alt="logo" width="100">
        </div>
        <div class="card shadow-lg">
            <div class="card-header text-center">
                <h1 class="fs-4 card-title fw-bold">Login</h1>
            </div>
            <div class="card-body p-4">
                <form action="../db/queries/Login.php" method="POST">
                    <div class="mb-3">
                        <label class="mb-2 text-muted" for="email">E-Mail</label>
                        <input id="email" type="email" class="form-control" name="email" value="" required>
                        <div class="invalid-feedback">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="mb-2 text-muted" for="password">Password</label>
                        <input id="password" type="password" class="form-control" name="password" required>
                        <div class="invalid-feedback">
                        </div>
                    </div>
                    <div class="d-grid">
                        <button class="btn btn-primary" type="submit">Login</button>
                    </div>
                </form>
            </div>
            <div class="card-footer py-3 border-0">
                <div class="text-center">
                    Already have an account? <a href="register.php" class="text-dark">Register</a>
                </div>
            </div>
        </div>
        <div class="text-center mt-5 text-muted">
            Copyright &copy; 2017-2021 &mdash; Your Company
        </div>
    </div>
</div>
</body>
</html>