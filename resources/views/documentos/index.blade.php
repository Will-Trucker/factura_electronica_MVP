@extends('layouts.app')

@section('content')
    <!-- Docs Table -->
    <div class="container mx-auto p-5 rounded-lg">
        <div class="mb-4">
            @if (session()->has('descargarjson'))
                <meta http-equiv="refresh" content="5;url='/obtenerdoc'">
            @endif

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('mensaje'))
                <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-lg">
                    {{ session('mensaje') }}
                    <a href="{{ route('reenviar') }}" class="underline text-blue-600 hover:text-blue-800">Reenviar DTE</a>
                </div>
            @endif
            @if (session('observ'))
                <div class="mb-4 p-4 bg-blue-100 text-red-800 rounded-lg">
                    {{ session('observ') }}
                </div>
            @endif
            <center>
                <div class="flex justify-center items-center mb-4" style="margin-left:8rem;margin-top:3rem;">
                    <form action="{{ route('filtrarDocs') }}" method="get"
                        class="flex w-full max-w-3xl items-center space-x-4">
                        <div class="flex items-center space-x-2">
                            <label for="tipoDocumento" class="text-white whitespace-nowrap" style="font-size:1.2rem;">Tipo
                                DTE</label>
                            <select
                                class="form-select block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                name="tipoDeDocumento" id="tipoDocumento" onchange="cambiarTipoDoc()">
                                <option value="1" class="bg-gray-100" selected>Factura Electrónica</option>
                                <option value="3" class="bg-gray-100">Comprobante de Crédito Fiscal Electrónico
                                </option>
                                <option value="4">Nota de Remisión Electrónica</option>
                                <option value="5">Nota de Crédito Electrónica</option>
                                <option value="6">Nota de Débito Electrónica</option>
                                <option value="7">Comprobante de Retención Electrónico</option>
                                <option value="8">Comprobante de Liquidación Electrónico</option>
                                <option value="9">Documento Contable de Liquidación Electrónico</option>
                                <option value="11" class="bg-gray-100">Factura de Exportación Electrónica</option>
                                <option value="14" class="bg-gray-100">Factura de Sujeto Excluido Electrónica</option>
                                <option value="15">Comprobante de Donación Electrónico</option>
                            </select>
                        </div>
                        <button type="submit"
                            class="btn btn-primary bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-md shadow-md">Filtrar</button>
                    </form>
                </div>
            </center>
        </div>
    </div>

    <div class="relative overflow-x-auto sm:rounded-lg ">
        <h2 class="text-center title-doc">HISTORIAL DE DOCUMENTOS</h2>
        <div class="mx-auto container">
            <table class="w-full text-sm text-left rtl:text-right tabla-docs">
                <thead class="text-xs uppercase bg-gray-600" >
                    <tr>
                        <th scope="col" class="px-6 py-3 text-center text-white" style="font-size:1.2rem;">
                            Fecha
                        </th>
                        <th scope="col" class="px-6 py-3 text-center text-white" style="font-size:1.2rem;">
                            Codigo de Generacion
                        </th>
                        <th scope="col" class="px-6 py-3 text-center text-white" style="font-size:1.2rem;">
                            Sello de Recibido
                        </th>
                        <th scope="col" class="px-6 py-3 text-center text-white" style="font-size:1.2rem;">
                            TipoDTE
                        </th>
                        <th scope="col" class="px-6 py-3 text-center text-white" style="font-size:1.2rem;">
                            Operaciones
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($documentos as $documento)
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row"
                            class="px-6 py-4 font-medium text-gray-900 text-center whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                            {{$documento->fhProcesamiento}}
                        </th>
                        <td class="px-6 py-4 text-center">
                           {{$documento->codigoGeneracion}}
                        </td>
                        <td class="px-6 py-4 text-center">
                            {{$documento->selloRecibido}}
                        </td>
                        <td class="px-6 py-4 text-center">
                            {{$documento->tipoDte}}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('obtenerpdf', ['codGeneracion' => $documento->codigoGeneracion]) }}"
                                class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" target="_self">Ver
                                PDF</a>
                                <br>
                                <br>
                                <br>

                            <a href="{{ route('verJson', ['codGeneracion' => $documento->codigoGeneracion]) }}"
                                class="w-full text-white bg-amber-400 hover:bg-amber-500 focus:ring-4 focus:outline-none focus:ring-amber-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-amber-600 dark:hover:bg-amber-500 dark:focus:ring-amber-300" target="_self">Ver
                                JSON</a>
                                <br>
                                <br>
                                <br>
                            <a href="{{ route('mandarComprobantes', ['codGeneracion' => $documento->codigoGeneracion]) }}"
                                class="w-full text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-900" target="_self">Email</a>
                        </td>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">Sin datos</td>
                        </tr>
                        @endforelse
@endsection
