@extends('layouts.app')
@extends('layouts.navigation')
@section('content')
    <div class="flex justify-center">
        <button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal"
            class="block text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center token-btn"
            type="button">
            Registrar Tokens
        </button>

        <!-- Modal -->
        <div id="authentication-modal" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                        <h3 class="text-xl font-semibold text-gray-900">
                            Registrar Tokens
                        </h3>
                        <button type="button"
                            class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                            data-modal-hide="authentication-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                        <div class="p-4 md:p-5">
                            <form class="space-y-4" action="{{ route('guardartoken') }}" method="POST">
                                @csrf
                                <div>
                                    <label for="email"
                                        class="block mb-2 text-sm font-medium text-gray-900">NIT</label>
                                    <input type="text" name="nit" id="nit"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                        value="06142803901121" />
                                </div>
                                <div>
                                    <label for="password"
                                        class="block mb-2 text-sm font-medium text-gray-900">API KEY</label>
                                    <input type="password" name="clave" id="clave" placeholder=""
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                        required value="iDJWKWGC@459bzM" />
                                </div>
                                <button type="submit"
                                    class="w-full text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Generar</button>
                            </form>
                        </div>
                </div>
            </div>
        </div>
    </div>
    @if (isset($ultimo['fechaGeneracion']) && $ultimo['fechaGeneracion'] >= date('d-m-Y'))
        <div class="p-4 mb-4 text-xl text-green-700 bg-green-100 rounded-lg text-center mt-5"
            role="alert">
            <span class="font-medium">Token Activo</span>
        </div>
        <div class="form-api mt-3 flex flex-col items-center">
            <label for="lastToken" class="title-apike">API KEY</label>
            <br>
            <textarea class="form-control text-area1 mt-2 w-full max-w-3xl" aria-label="With textarea" id="apikey" cols="80" rows="5" style="outline: 0;">{{ $ultimo['token'] ?? 'Usted no tiene Tokens Activados' }}</textarea>


        </div>

    @else
        <div class="p-4 mb-4 text-xl text-red-700 bg-red-100 rounded-lg text-center mt-5" role="alert">
            <span class="font-medium">No tiene un Token Activo</span>
        </div>
    @endif
        <!-- table -->
        <div class="relative overflow-x-auto sm:rounded-lg ">
            <div class="mx-auto container">
                <table class="w-full text-sm text-left rtl:text-right tabla-tok">
                    <thead class="text-xs uppercase bg-gray-600 ">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-center">
                                Fecha
                            </th>
                            <th scope="col" class="px-6 py-3 text-center">
                                Token
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tokens as $registro)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap text-center">{{$registro['fechaGeneracion']}}</th>
                            <td class="px-6 py-4 text-center"><textarea name="" id="" cols="100" rows="4">{{$registro['token']}}</textarea></td>
                        @empty
                        <tr>
                            <td colspan="2" class="text-center px-6 py-4">No hay tokens registrados</td>
                        </tr>
                        @endforelse
                        {{-- <tr
                            class="bg-white border-b hover:bg-gray-50">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap text-center">
                                00/00/00
                            </th>
                            <td class="px-6 py-4 text-center">
                                <textarea name="" id="" cols="100" rows="4"></textarea>
                            </td>
                        </tr> --}}
                    </tbody>
                </table>
            </div>
        @endsection
