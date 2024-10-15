@extends('layouts.app')

@section('content')
    <div class="container-md p-5">
        <h1 class="title-1">Tokens</h1>
        @if (isset($ultimo['fechaGeneracion']) && $ultimo['fechaGeneracion'] >= date('d-m-Y'))
            <div class="alert alert-success alert-token-successful">
                Token Activo
            </div>
         @else
            <div class="alert alert-danger alert-token">
                No tiene un Token Activo
            </div>
        @endif
        <div class="cont1">
            <button type="button" class="btn btn-info button-addtoken" onclick="cambiarSeccion(1)" id="token-button"
                style="font-size: 1.2rem; font-weight:bold;">Registrar</button>
        </div>
        <form action="{{route('guardartoken')}}" method="post">
           @csrf
            <div class="mt-3" id="divisiones">
                <div class="d-none" id="tokenSection">
                    <h2 class="title-2">Crear Token</h2>
                    <div class="row">
                        <div class="col">
                            <div class="card-body">
                                <div class="form-group row">
                                        <label for="nit" class="col-sm-3 col-form-label cont-label">NIT</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-lg" id="nit" name="nit" value="06142803901121" aria-describedby="inputGroup-sizing-default">
                                    </div>
                                </div>
                                <hr class="mx-n3">
                                <div class="form-group row">
                                    <label for="clave" class="col-sm-3 col-form-label">Clave</label>
                                    <div class="col-sm-9">
                                        <input type="password" class="form-control form-control-lg" id="clave" name="clave" value="iDJWKWGC@459bzM" aria-describedby="inputGroup-sizing-default">
                                    </div>
                                </div>
                                <hr class="mx-n3">
                                <div class="px-5 py-4 text-center">
                                  <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-danger btn-lg">ENVIAR</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <form action="" class="form-api">
            <div class="form-group forms-cont">
                <label for="lastToken" class="title-apike">API KEY</label>
                <textarea class="form-control text-area1" aria-label="With textarea" id="apikey" cols="10" rows="5" style="outline: 0;">   {{ $ultimo['token'] ?? 'Usted no tiene Tokens Activados' }}</textarea>
            </div>
        </form>
        <div class="table-wrappers">
            <table class="fla-table">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Token</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tokens as $registro)
                        <tr>
                            <th>{{ $registro['fechaGeneracion'] }}</th>
                            <th>
                                <textarea name="" id="" cols="100" rows="4">{{ $registro['token'] }}</textarea>
                            </th>
                        </tr>
                    @empty
                        <th colspan="2">Datos inexistentes</th>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <br><br>
@endsection
