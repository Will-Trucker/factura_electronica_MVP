@extends('layouts.app')
@extends('layouts.navigation')

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
            <h2 class="title-em">RECEPTORES</h2>
            <br><br>
            <div class="flex justify-center">
                <button data-modal-target="crud-modal__receptor" data-modal-toggle="crud-modal__receptor"
                    class="block text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                    type="button">
                    Ingresar Receptor
                </button>
                <div id="crud-modal__receptor" tabindex="-1" aria-hidden="true"
                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative p-4 w-full max-w-md max-h-full">
                        <!-- Modal content -->
                        <div class="relative bg-white rounded-lg shadow">
                            <!-- Modal header -->
                            <div
                                class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                                <h3 class="text-lg font-semibold text-gray-900">
                                    Ingresar Receptor
                                </h3>
                                <button type="button"
                                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                    data-modal-toggle="crud-modal__receptor">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                            </div>
                            <!-- Modal body -->
                            <form class="p-4 md:p-5 form" action="{{route('storeRe')}}" method="POST">
                                @csrf
                                <div class="grid gap-4 mb-4 grid-cols-2">
                                    <div class="col-span-2">
                                        <label for="name"
                                            class="block mb-2 text-sm font-medium text-gray-900">Nombre</label>
                                        <input type="text" name="nombre" id="nombre"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                            value="{{ old('nombre') }}">
                                        @error('nombre')
                                            <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-span-2">
                                        <label for="name"
                                        class="block mb-2 text-sm font-medium text-gray-900">N° Documento</label>
                                        <input type="text" name="ndocumento" id="ndocumento"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                            value="{{ old('ndocumento') }}">
                                        @error('ndocumento')
                                            <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-span-2">
                                        <label for="email"
                                            class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                                        <input type="email" name="correo" id="correo"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                            value="{{ old('correo') }}">
                                        @error('correo')
                                            <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-span-2 sm:col-span-1">
                                        <label for="nrc"
                                            class="block mb-2 text-sm font-medium text-gray-900">NRC</label>
                                        <input type="text" name="nrc" id="nrc"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                            value="{{old('nrc')}}">
                                            @error('nrc')
                                            <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                                            @enderror
                                    </div>
                                    <div class="col-span-2 sm:col-span-1">
                                        <label for="departamento"
                                            class="block mb-2 text-sm font-medium text-gray-900">Departamentos</label>
                                        <select id="departamento" name="departamento"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
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
                                            class="block mb-2 text-sm font-medium text-gray-900">Municipios</label>
                                        <select id="municipio" name="municipio" id="municipio"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">

                                        </select>
                                        @error('municipio')
                                        <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-span-2 sm:col-span-1">
                                        <label for="telefono"
                                            class="block mb-2 text-sm font-medium text-gray-900">Telefono</label>
                                        <input type="text"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                            placeholder="+503 2525-2525" name="telefono"
                                            pattern="\[267][0-9]{3}-[0-9]{4}">
                                            @error('telefono')
                                            <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                                            @enderror
                                    </div>
                                    <div class="col-span-2">
                                        <label for="description"
                                            class="block mb-2 text-sm font-medium text-gray-900">Complemento
                                        </label>
                                        <textarea id="complemento" name="complemento" rows="4"
                                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"></textarea>
                                            @error('complemento')
                                            <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                                            @enderror
                                    </div>
                                </div>
                                <button type="submit"
                                    class="text-white inline-flex items-center bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
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
    <!-- table -->
    <div class="relative overflow-x-auto sm:rounded-lg ">
        <div class="mx-auto container">
            <table class="w-full text-sm text-left rtl:text-right tabla-rec">
                <thead class="text-xs uppercase bg-gray-600 ">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-center">
                            Nombre
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            NumDocumento
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            NRC
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
                            Opciones
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($receptores as $receptor)
                        <tr
                            class="bg-white border-b hover:bg-gray-50">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 text-center whitespace-nowrap bg-gray-50">
                                {{ $receptor->Nombre }}
                            </th>
                            <td class="px-6 py-4 text-center">
                                {{ $receptor->NumDocumento }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                {{ $receptor->NRC }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                {{ $receptor->idDepartamento }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                {{ $receptor->idMunicipio }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                {{ $receptor->Complemento }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <input type="button" value="Modificar" data-modal-target="crud-receptor_modificar{{$receptor->id}}"
                                    data-modal-toggle="crud-receptor_modificar{{$receptor->id}}"
                                    class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center btn-editEm">
                                <br><br>
                                <button data-modal-target="crud-receptor_eliminar{{$receptor->id}}"
                                    data-modal-toggle="crud-receptor_eliminar{{$receptor->id}}"
                                    class="block text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                                    type="button">
                                    Eliminar
                                </button>
                                @include('receptor.edit')
                                @include('receptor.eliminar')
                            </td>
                        </tr>
                        @empty
                        <th colspan="10">Sin datos</th>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endsection

    @section('customJS')
        <script>
            $(document).ready(function() {
                $('#departamento').change(function() {
                    var idDepartamento = $(this).val(); // Obtener el valor del departamento seleccionado
                    if (idDepartamento) {
                        $.ajax({
                            url: '/municipios/' +
                            idDepartamento, // Llamar al endpoint con el idDepartamento
                            type: 'GET',
                            dataType: 'json',
                            success: function(data) {
                                $('#municipio').empty(); // Limpiar el campo de municipios
                                $('#municipio').append(
                                    '<option class="text-center">Elige un municipio</option>');
                                $.each(data, function(key, value) {
                                    $('#municipio').append('<option value="' + value
                                        .codMunicipio + '">' + value.nombreMunicipio +
                                        '</option>');
                                });
                            },
                            error: function(xhr, status, error) {
                                console.error('AJAX Error:', status,
                                error); // Registrar cualquier error
                            }
                        });
                    } else {
                        $('#municipio').empty(); // Limpiar el campo si no hay departamento seleccionado
                        $('#municipio').append('<option class="text-center">Elige un municipio</option>');
                    }
                });
            });
        </script>
    @endsection
