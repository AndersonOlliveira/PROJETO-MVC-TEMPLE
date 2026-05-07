<!-- app/Views/home.php -->
<!DOCTYPE html>
<html>

<head>
    <title>Home</title>

</head>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Login MVC</title>
    <!-- <script type="text/javascript" src="public/jsBibliotecas/jquery.min.js"></script> -->
    <!-- <script src="/jsBibliotecas/jquery.min.js"></script> -->
</head>

<body>

    <h2>Acesso ao Sistema</h2>
    <form id="formLogin">
        <input type="email" name="email" placeholder="E-mail" required>
        <input type="password" name="senha" placeholder="Senha" required>
        <button type="submit">Entrar</button>
    </form>


    <div id="mensagem"></div>


    <?php require_once 'layout/ViewCabecalho.php'; ?>

</body>


<script src="/js/Autentication/autetin.js"></script>

</html>