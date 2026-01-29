<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP CRUD PROJECT</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

</head>

<body>

    <div class="min-h-screen bg-slate-100 flex items-center justify-center">
        <?php
          session_start();
          if(isset($_GET['create'])) {
               include_once "./views/create-user.php";
          }elseif(isset($_GET['e-id'])) {
              include_once "./views/edit-user.php";
          }else {
            include_once "./views/list-user.php";
          }

           ?>

    </div>
</body>

</html>