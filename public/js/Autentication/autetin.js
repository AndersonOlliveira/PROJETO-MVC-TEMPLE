 $(document).ready(function () {
     $('#formLogin').submit(function (e) {
         e.preventDefault(); // Impede a página de recarregar

         const dados = $(this).serialize();

         $.ajax({
             url: '/api/auth', // A rota que definimos no index.php
             type: 'POST',
             data: dados,
             dataType: 'json',
             success: function (response) {
                 console.warn(response);
                 if (response.success) {
                     $('#mensagem').html('<p style="color:green">' + response.message + '</p>');
                     localStorage.setItem('meu_token', response.token);
                     // Redirecionar após 2 segundos
                     setTimeout(() => {
                         window.location.href = '/home';
                     }, 2000);
                 } else {
                     $('#mensagem').html('<p style="color:red">' + response.error + '</p>');
                 }
             },
             error: function () {
                 alert('Erro ao conectar com a API. Verifique o console.');
             }
         });
     });
 });