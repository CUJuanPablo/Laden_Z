<!DOCTYPE html>
<html lang="en">
    <head> <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-kjU+l4N0Yf4ZOJErLsIcvOU2qSb74wXpOhqTvwVx3OElZRweTnQ6d31fXEoRD1Jy" crossorigin="anonymous"></script>
        <!-- Styles --> 
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    </head>
    <body>
        <div class="card text-center" style="background-color: E9FFE5">
            <div class="card-header">
               <h3>Megci</h3>
            </div>
            <div class="card-body">
              <h5 class="card-title">Hola, hemos dado respuesta a tu solicitud</h5>
              <p class="card-text">Tu contraseña es:</p>
              <p style="font-weight: bold;">
                Megci2022
              </p>
              <a href="{{ $mail->link ."/pedidos/nuevoPedido" }}" class="btn btn-primary">Ir a Megci!</a> 

              {{-- <a href="{{ $mail->link ."/newPassword/".$mail->id.'/'.$mail->token }}" class="btn btn-primary">Click me!</a> --}}
            </div>
            <div class="card-footer text-muted">
                
            </div>
          </div>

    </body>
     
</html>  
