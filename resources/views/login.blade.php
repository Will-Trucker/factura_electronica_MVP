<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite([ 'resources/js/app.js', 'resources/js/web3.js'])
    {{-- <script src="/main.js" type="module"></script> --}}
</head>
<body>
<section class="vh-100" style="background-color: #9A616D;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col col-xl-10">
        <div class="card" style="border-radius: 1rem;">
          <div class="row g-0">
            <div class="col-md-6 col-lg-5 d-none d-md-block">
              <img src="https://images.pexels.com/photos/4386177/pexels-photo-4386177.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1"
                alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem;" />
            </div>
            <div class="col-md-6 col-lg-7 d-flex align-items-center">
              <div class="card-body p-4 p-lg-5 text-black">

                <form method="POST" action="iniciarSesion">
            
                  <div class="d-flex align-items-center mb-3 pb-1">
                    <i class="fas fa-cubes fa-2x me-3" style="color: #ff6219;"></i>
                    <span class="h1 fw-bold mb-0">MVP DTE Laravel</span>
                  </div>

                  <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Inicia sesion en tu cuenta</h5>
                  @csrf
                  @if(session('success'))
                <div class="alert alert-success">
                {{ session('success') }}
                </div>
                @endif
                @if(session('error'))
                <div class="alert alert-danger">
                {{ session('error') }}
                </div>
                @endif
                  <div class="form-outline mb-4">
                    <input type="text" name="user" id="form2Example17" class="form-control form-control-lg" />
                    <label class="form-label" for="form2Example17">Usuario</label>
                  </div>

                  <div class="form-outline mb-4">
                    <input type="password" name="password" id="form2Example27" class="form-control form-control-lg" />
                    <label class="form-label" for="form2Example27">Contraseña</label>
                  </div>
                  <input type="hidden" value=0 name="cuentaEth" id="cuentaEth">
                  <div class="pt-1 mb-4">
                    <button class="btn btn-dark btn-lg btn-block" type="submit" id="iniciarsesion">Iniciar Sesion</button>
                  </div>
                  <div class="pt-1 mb-4">
                    <button class="btn btn-dark btn-lg btn-block" type="button" id="web3boton">Web3</button>
                  </div>
                  <p class="mb-5 pb-lg-2" style="color: #393f81;">No tienes una cuenta? <a href="registro"
                      style="color: #393f81;">Registrate</a></p>
                 
                </form>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</body>
</html>