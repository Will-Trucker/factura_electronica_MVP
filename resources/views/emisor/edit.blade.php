<div id="crud-modal_modificar{{$emisor['id']}}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full modal-emi">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Editar Emisor</h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="crud-modal_modificar{{$emisor['id']}}">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <form class="p-4 md:p-5 form-editEm" action="{{route('modificar_emisor')}}" method="POST">
                @method('PUT')
                @csrf
                <input type="hidden" name="idemisor" value="{{ $emisor->id }}">
                <div class="grid gap-4 mb-4 grid-cols-2">
                    <div class="col-span-2">
                        <label for="name"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre</label>
                        <input type="text" name="nombre" id="nombre"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            value="{{$emisor['Nombre']}}">
                            @error('nombre')
                                    <div class="text-red-600 mt-1 text-sm">{{ $message }}</div>
                            @enderror
                    </div>
                    <div class="col-span-2">
                        <label for="nombrecomercial"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre Comercial</label>
                        <input type="text" name="nombrecomercial" id="nombrecomercial"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            value="{{$emisor['NombreComercial']}}">
                            @error('nombrecomercial')
                            <div class="text-red-600 mt-1 text-sm">{{ $message }}</div>
                            @enderror
                    </div>
                    <div class="col-span-2">
                        <label for="email"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                        <input type="email" name="correo" id="correo"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 ase" value="{{$emisor['Correo']}}">
                            @error('correo')
                            <div class="text-red-600 mt-1 text-sm">{{ $message }}</div>
                            @enderror
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <label for="nit"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIT</label>
                        <input type="text" name="nit" id="nit"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="" value="{{$emisor['NIT']}}">
                            @error('nit')
                            <div class="text-red-600 mt-1 text-sm">{{ $message }}</div>
                            @enderror
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <label for="nrc"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NRC</label>
                        <input type="text" name="NRC" id="NRC"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="{{$emisor['NRC']}}">
                            @error('NRC')
                            <div class="text-red-600 mt-1 text-sm">{{ $message }}</div>
                            @enderror
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <label for="actividad"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Actividad Comercial</label>
                        <select id="actividad" name="actividad"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option class="text-center">Elige una Actividad Económica</option>
                            @foreach ($actividades as $actividad)
                            <option value="{{$actividad['codigoGiro']}}" {{$emisor['idActividadEconomica'] == $actividad['codigoGiro'] ? 'selected' : ''}}>{{$actividad['nombreGiro']}}</option>
                            @endforeach
                        </select>
                        @error('actividad')
                            <div class="text-red-600 mt-1 text-sm">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <label for="departamento"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Departamentos</label>
                        <select id="departamento" name="departamento"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option class="text-center">Elige un Departamento</option>
                            @foreach ($departments as $depart)
                            <option value="{{ $depart['codigoDepartamento'] }}" {{ $emisor['idDepartamento'] == $depart['codigoDepartamento'] ? 'selected' : '' }}>
                                {{ $depart['nombreDepartamento'] }}
                            </option>
                            @endforeach
                        </select>
                        @error('departamento')
                        <div class="text-red-600 mt-1 text-sm">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <label for="municipio"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Municipios</label>
                        <select id="municipio" name="municipio"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            @foreach ($municipios as $municipio)
                            <option value="{{$municipio['codMunicipio']}}">{{$municipio['nombreMunicipio']}}</option>
                            @endforeach
                        </select>
                        @error('municipio')
                        <div class="text-red-600 mt-1 text-sm">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <label for="telefono"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Telefono</label>
                        <input type="text"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="+503 2525-2525" name="telefono" pattern="\[267][0-9]{3}-[0-9]{4}" value="{{$emisor['Telefono']}}">
                            @error('telefono')
                            <div class="text-red-600 mt-1 text-sm">{{ $message }}</div>
                            @enderror
                    </div>
                    <div class="col-span-2">
                        <label for="description"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Complemento
                        </label>
                        <textarea id="complemento" name="complemento" rows="4"
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" >{{$emisor->Complemento}}</textarea>
                            @error('complemento')
                            <div class="text-red-600 mt-1 text-sm">{{ $message }}</div>
                            @enderror
                    </div>
                </div>
                <button type="submit" class="text-white inline-flex items-center bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                    <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                    </svg>
                    Editar
                </button>
            </form>
        </div>
    </div>
</div>
