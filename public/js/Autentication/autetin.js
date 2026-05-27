 $(document).ready(function () {
     $('#formLogin').submit(function (e) {

         localStorage.clear();
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

                     console.table(localStorage)

                     sessionStorage.setItem('meu_token', response.token);
                     // Redirecionar após 2 segundos
                     setTimeout(() => {
                         window.location.href = '/home';
                     }, 2000);
                 } else {
                     $('#mensagem').html('<p style="color:red">' + response.error + '</p>');
                 }
             },
             error: function (e) {
                 console.warn(e);
                 if (e.responseJSON && e.responseJSON.error) {
                     $('#mensagem').html('<p style="color:red">' + e.responseJSON.error + '</p>');
                 } else {
                     alert('Erro crítico ao conectar com a API.');
                 }
             }
         });
     });
 });