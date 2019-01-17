<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>Connexion GEMAH</title>

    <!-- Bootstrap core CSS -->
    <link href={{ asset("assets/css/bootstrap.css") }} rel="stylesheet">
    <link href={{ asset("assets/css/connexion.css") }} rel="stylesheet">

    <!-- Custom styles for this template -->

</head>
<body>
    <main role="main" class="inner cover">
        <div class="text-sh">
            <h3>Bienvenue sur l'application</h3>
            <h1 class="cover-heading  d-none d-sm-block">GEMAH</h1>
            <h1 class="d-sm-none">GEMAH</h1>
            <p class="lead">L'application de <b>Ge</b>stion de prêt de <b>Ma</b>tériel aux enfants en situation de
                <b>H</b>andicap.
            </p>
        </div>

        <form class="form-signin" method="post">
            {{ csrf_field() }}

            @include('web._includes.flash')
            <div class="text-center mb-4">
                <h1 class="h3 mb-3 font-weight-normal">Connexion</h1>
            </div>

            <div class="form-label-group">
                <input id="inputEmail" class="form-control" name="email" type="email" placeholder="Adresse mail"
                       required autofocus>
                <label for="inputEmail"> Adresse mail</label>
            </div>

            <div class="form-label-group">
                <input id="inputPassword" class="form-control" name="password" type="password"
                       placeholder="Mot de passe" required>
                <label for="inputPassword">Mot de passe</label>
            </div>

            <button class="btn btn-lg btn-primary btn-block" type="submit">Connexion</button>
        </form>
    </main>
</body>
</html>
