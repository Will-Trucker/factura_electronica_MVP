@extends('layouts.app')

@section('content')
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
            <h2 class="title-em">EMISORES</h2>
            <br><br>
            <div class="flex justify-center">
                <!-- Modal toggle -->
                <button data-modal-target="crud-modal" data-modal-toggle="crud-modal"
                    class="block text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800"
                    type="button">
                    Ingresar Emisor
                </button>
                <!-- Main modal -->
                <div id="crud-modal" tabindex="-1" aria-hidden="true"
                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative p-4 w-full max-w-md max-h-full">
                        <!-- Modal content -->
                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                            <!-- Modal header -->
                            <div
                                class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    Ingresar Emisor
                                </h3>
                                <button type="button"
                                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                    data-modal-toggle="crud-modal">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                            </div>
                            <!-- Modal body -->
                            <form class="p-4 md:p-5 form" action="{{route('storeEm')}}" method="POST">
                               @csrf
                                <div class="grid gap-4 mb-4 grid-cols-2">
                                    <div class="col-span-2">
                                        <label for="name"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre</label>
                                        <input type="text" name="nombre" id="nombre"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="{{old('nombre')}}">
                                            @error('nombre')
                                            <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                                            @enderror
                                    </div>
                                    <div class="col-span-2">
                                        <label for="nombrecomercial"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre
                                            Comercial</label>
                                        <input type="text" name="nombrecomercial" id="nombrecomercial"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="{{old('nombrecomercial')}}">
                                            @error('nombrecomercial')
                                            <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                                            @enderror
                                    </div>
                                    <div class="col-span-2">
                                        <label for="email"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                                        <input type="email" name="correo" id="correo"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="{{old('correo')}}">
                                            @error('correo')
                                            <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                                            @enderror
                                    </div>
                                    <div class="col-span-2 sm:col-span-1">
                                        <label for="nit"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIT</label>
                                        <input type="text" name="nit" id="nit"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                            placeholder="" value="{{old('nit')}}">
                                            @error('nit')
                                            <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                                            @enderror
                                    </div>
                                    <div class="col-span-2 sm:col-span-1">
                                        <label for="nrc"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NRC</label>
                                        <input type="text" name="NRC" id="NRC"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="{{'NRC'}}">
                                            @error('NRC')
                                            <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                                            @enderror
                                    </div>
                                    <div class="col-span-2 sm:col-span-1">
                                        <label for="actividad"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Actividad
                                            Comercial</label>
                                        <select id="actividad" name="actividad"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                            <option class="text-center">Elige una Actividad Económica</option>
                                            @foreach ($actividades as $actividad)
                                            <option value="{{$actividad['codigoGiro']}}">{{$actividad['nombreGiro']}}</option>
                                            @endforeach
                                        </select>
                                        @error('actividad')
                                        <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-span-2 sm:col-span-1">
                                        <label for="departamento"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Departamentos</label>
                                        <select id="departamento" name="departamento"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                            <option class="text-center"> Elige un departamento </option>
                                            @foreach ($departments as $depart)
                                            <option value="{{$depart['codigoDepartamento']}}">{{$depart['nombreDepartamento']}}</option>
                                            @endforeach
                                        </select>
                                        @error('departamento')
                                        <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-span-2 sm:col-span-1">
                                        <label for="municipio"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Municipios</label>
                                        <select id="municipio" name="municipio"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">

                                        </select>
                                        @error('municipio')
                                            <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-span-2 sm:col-span-1">
                                        <label for="telefono"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Telefono</label>
                                        <input type="text"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                            placeholder="+503 2525-2525" name="telefono" id="telefono"
                                            pattern="\[267][0-9]{3}-[0-9]{4}">
                                            @error('telefono')
                                            <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                                            @enderror
                                    </div>
                                    <div class="col-span-2">
                                        <label for="description"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Complemento
                                        </label>
                                        <textarea id="complemento" name="complemento" rows="4"
                                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>
                                            @error('complemento')
                                            <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                                            @enderror
                                    </div>
                                </div>
                                <button type="submit"
                                    class="text-white inline-flex items-center bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                                    <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    Registrar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
        <!-- Table Crud -->
        <div class="relative overflow-x-auto sm:rounded-lg ">
            <div class="mx-auto container">
                <table class="w-full text-sm text-left rtl:text-right tabla-em">
                    <thead class="text-xs uppercase bg-gray-600 ">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-center">
                                Nombre
                            </th>
                            <th scope="col" class="px-6 py-3 text-center">
                                Nombre Comercial
                            </th>
                            <th scope="col" class="px-6 py-3 text-center">
                                NIT
                            </th>
                            <th scope="col" class="px-6 py-3 text-center">
                                Departamento
                            </th>
                            <th scope="col" class="px-6 py-3 text-center">
                                Municipio
                            </th>
                            <th scope="col" class="px-6 py-3 text-center">
                                Complemento
                            </th>
                            <th scope="col" class="px-6 py-3 text-center">
                                Actividad Economica
                            </th>
                            <th scope="col" class="px-6 py-3 text-center">
                                Email
                            </th>
                            <th scope="col" class="px-6 py-3 text-center">
                                Opciones
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($emisores as $emisor)
                            <tr
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 text-center whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                                    {{ $emisor->Nombre }}
                                </th>
                                <td class="px-6 py-4 text-center">
                                    {{ $emisor->NombreComercial }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    {{ $emisor->NIT }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if (isset($departments[$emisor->idDepartamento]))
                                        {{ $departments[$emisor->idDepartamento]->nombreDepartamento }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    {{ $emisor->idMunicipio }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    {{ $emisor->Complemento }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if (isset($actividades[$emisor->idActividadEconomica]))
                                        {{ $actividades[$emisor->idActividadEconomica]->nombreGiro }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center asd">
                                    {{ $emisor->Correo }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    {{-- <input type="button" value="Editar" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 btn-editEm" data-modal-target="crud-modal" data-modal-toggle="crud-modal">
                        <br><br>
                        <input type="button" value="Eliminar" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 btn-deleteEm"  data-modal-target="popup-modal" data-modal-toggle="popup-modal"> --}}
                                    <input type="button" value="Modificar" data-modal-target="crud-modal_modificar{{$emisor['id']}}"
                                        data-modal-toggle="crud-modal_modificar{{$emisor['id']}}"
                                        class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 btn-editEm">
                                    <br><br>
                                    <button data-modal-target="popup-modal{{$emisor['id']}}" data-modal-toggle="popup-modal{{$emisor['id']}}"
                                        class="block text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800"
                                        type="button">
                                        Eliminar
                                    </button>
                                    @include('emisor.edit')
                                    @include('emisor.eliminar')

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endsection
        @section('customJS')
            <script>
                $(document).ready(function() {
                    $('#departamento').change(function() {
                        var idDepartamento = $(this).val(); // Obtén el valor del departamento seleccionado
                        if (idDepartamento) {
                            $.ajax({
                                url: '/municipios/' +
                                idDepartamento, // Llama al endpoint con el idDepartamento
                                type: 'GET',
                                dataType: 'json',
                                success: function(data) {
                                    $('#municipio').empty(); // Limpia el campo de municipios
                                    $('#municipio').append(
                                        '<option class="text-center">Elige un municipio</option>');
                                    $.each(data, function(key, value) {
                                        $('#municipio').append('<option value="' + value
                                            .codMunicipio + '">' + value.nombreMunicipio +
                                            '</option>');
                                    });
                                }
                            });
                        } else {
                            $('#municipio').empty(); // Limpia el campo si no hay departamento seleccionado
                            $('#municipio').append('<option class="text-center">Elige un municipio</option>');
                        }
                    });
                });
            </script>
        @endsection
