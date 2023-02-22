<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/login.css')}}">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;700&display=swap" rel="stylesheet">
    <title>Connexion</title>
  </head>
  <body>

    <!--Area de imagen -->
    <div class="side-login-image">
        <div class="side-text-area">
            <h4 class=" m-0">Bienvenido</h4>
            <p class=" m-0">A tu CONNE<SPan>XION</SPan></p>
        </div>
    </div>
    <!--Area de imagen -->
    <div class="side-login-panel">
      <div class="side-login-content">
        <p class=" m-0">conne<span>xion</span></p>
        @yield('login')
      </div>
    </div>
    <!-- Optional JavaScript; choose one of the two! -->

    <script src="{{asset('js/app.js')}}"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
  </body>
</html>
