@extends('layouts.app')
@extends('layouts.navigation')

@section('content')
    <!-- No hacer caso a esto -->
    {{-- <h1 class="hidden">La Fecha y Hora Es: {{ $fechahora->format('Y-m-d H:i:s') }} </h1>
    <h1 class="hidden">La zona horaria es: {{ $fechahora->timezoneName }}</h1> --}}
    <!-- Ejemplo con Carbon -->
    {{-- <h1 class="hidden">La fecha con carbon es: {{ $fechaHoraC->format('Y-m-d H:i:s') }}</h1>
    <h1 class="hidden">La zona horaria es: {{ $fechaHoraC->timezoneName }}</h1> --}}
    <!-- Ejemplo con propiedad dateTime -->
    <h1 class="hidden">{{ now()->format('Y-m-d H:i:s') }}</h1>
    <h1 class="hidden">{{ now()->timezoneName }}</h1>
    <div class="container mx-auto p-6 ase">
        <div class="max-w-md mx-auto mt-16">
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">ERROR</strong>
                    <ul class="mt-1 ml-4 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (session('success'))
                <div class="mb-4 border-l-4 border-green-500 bg-green-100 text-green-700 p-4 rounded">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 border-l-4 border-red-500 bg-red-100 text-red-700 p-4 rounded">
                    <p>{{ session('error') }}</p>
                </div>
            @endif
        </div>
        <h2 class="mb-4 font-bold text-white text-center" style="font-size:1.8rem;">Contingencia Por Lotes
        </h2>
        <section class="" style="margin-top: -2rem;">
            <div class="py-8 px-4 mx-auto max-w-2xl lg:py-16">
                <form action="{{ route('generarContingencia') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="detallesfactura" value="" id="detallesfactura">
                    <input name="nombreComercial" type="text" class="hidden" aria-label="Sizing example input"
                        aria-describedby="inputGroup-sizing-default" id="nombreComercial">
                    <input name="emisornrc" id="emisornrc" type="text" class="hidden" aria-label="Sizing example input"
                        aria-describedby="inputGroup-sizing-default">
                    <input name="emisordepartamento" id="emisordepartamento" type="text" class="hidden"
                        aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                    <input name="emisormunicipio" id="emisormunicipio" type="text" class="hidden"
                        aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                    <input name="complemento" id="complemento" type="text" class="hidden"
                        aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                    <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">

                        <div class="sm:col-span-2">
                            <select name="emisor" id="emisor" onBlur="traerEmisor()"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                                <option selected="">Seleccione un Emisor</option>
                                @foreach ($emisores as $emisor)
                                    <option value="{{ $emisor['id'] }}">{{ $emisor['Nombre'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="sm:col-span-2">
                            <label for="name"
                                class="block mb-2 text-sm font-medium text-white">Nombre</label>
                            <input type="text" name="emisornombre" id="emisorNombre"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Digita tu nombre" required="">
                        </div>
                        <div class="w-full">
                            <label for="brand" class="block mb-2 text-sm text-white font-medium">NIT
                                (Emisor)</label>
                            <input type="text" name="emisornit" id="emisornit"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="nit" required="">
                        </div>
                        <div class="w-full">
                            <label for="price" class="block mb-2 text-sm font-medium text-white">Nombre
                                Responsable</label>
                            <input type="text"name="nombrecomercial" id="nombreComercial"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                required="" placeholder="Nombre quien emite el evento">
                        </div>
                        <div>
                            <label for="category" class="block mb-2 text-sm font-medium text-white">Tipo
                                Documento</label>
                            <input name="actividademisor" id="actividademisor" type="text" class="hidden"
                                aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                            <select id="actividad" name="actividad"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                                <option value="36">NIT</option>
                                <option value="13">DUI</option>
                                <option value="2">CARNET DE RESIDENCIA</option>
                                <option value="3">PASAPORTE</option>
                                <option value="37">OTRO</option>
                            </select>
                        </div>
                        <div>
                            <label for="item-weight"
                                class="block mb-2 text-sm font-medium text-white">Documento del
                                Responsable</label>
                            <input type="text" name="emisornit" id="emisornit"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Documento del quien emite el evento" required="">
                        </div>
                        <div>
                            <label for="item-weight"
                                class="block mb-2 text-sm font-medium text-white">Telefono</label>
                            <input type="text" name="emisortelefono" id="emisortelefono"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="+503 2525-2525" name="telefono" pattern="\[267][0-9]{3}-[0-9]{4}"
                                required="">
                        </div>
                        <div>
                            <label for="item-weight"
                                class="block mb-2 text-sm font-medium text-white">Correo</label>
                            <input name="emisorcorreo" id="emisorcorreo" type="email"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Correo electrónico" style="text-transform:none;">
                        </div>
                        <div>
                            <label for="item-weight"
                                class="block mb-2 text-sm font-medium text-white">Tipo de DTE</label>
                            <select id="tipoDeDocumento"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5"
                                name="tipoDeDocumento">
                                <option selected="">Seleccione un tipo de DTE</option>
                                <option value="01" selected>Factura</option>
                                <option value="03">Comprobante de Crédito Fiscal</option>
                                <option value="04">Nota de Remisión</option>
                                <option value="05">Nota de Crédito</option>
                                <option value="06">Nota de Débito</option>
                                <option value="07">Comprobante de Retención</option>
                                <option value="08">Comprobante de Liquidación</option>
                                <option value="09">Documento Contable de Liquidación</option>
                                <option value="11">Factura de Exportación</option>
                                <option value="14">Factura de Sujeto Excluido</option>
                                <option value="15">Comprobante de Donación</option>
                            </select>
                        </div>
                        <div>
                            <label for="item-weight"
                                class="block mb-2 text-sm font-medium text-white">Tipo de
                                Contingencia</label>
                            <select
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5"
                                name="tipocontingencia" id="tipocontingencia">
                                <option selected="">Seleccione un tipo de Contingencia</option>
                                @foreach ($tiposCont as $tipoCont)
                                    <option value="{{ $tipoCont['id'] }}">{{ $tipoCont['tipoContingencia'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="sm:col-span-2">
                            <label for="item-weight"
                                class="block mb-2 text-sm font-medium text-white">Fechas</label>
                            <div class="flex items-center">
                                <div class="relative">
                                    <input name="fechainicio" id="fechainicio" type="date" value={{ now() }}
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                        aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                                </div>
                                <span class="mx-4 text-white">A</span>
                                <div class="relative">
                                    <input name="fechafin" id="fechafin" type="date" value={{ now() }}
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                        aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                                </div>
                            </div>
                        </div>
                        <div class="sm:col-span-2">
                            <label for="description"
                                class="block mb-2 text-sm font-medium text-white">Motivo
                                Contingencia</label>
                            <textarea id="motivocontingencia" rows="8"
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500"
                                placeholder="Describa su problema" name="motivocontingencia"></textarea>
                        </div>
                        <div class="sm:col-span-2">
                            <label for="archivo"
                                class="block mb-2 text-sm font-medium text-white">Archivo</label>
                            <input class="block w-full mb-5 text-sm text-gray-900  rounded-lg cursor-pointer bg-gray-50"
                                id="documentos" name="documentos[]" type="file">
                        </div>
                    </div>
                    <div class="flex justify-center">
                        <button type="submit"
                            class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            Enviar
                        </button>
                    </div>
                </form>
            </div>
        </section>
    </div>

@endsection
