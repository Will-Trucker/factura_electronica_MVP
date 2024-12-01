@extends('layouts.app')
@extends('layouts.navigation')
@section('content')
<div class="container mx-auto p-6 ase">
    <div class="container mx-auto p-5 rounded-lg">
        <div class="relative overflow-x-auto">
            <h2 class="text-center text-white title-event1">EVENTO DE INVALIDACION</h2>
            <div class="flex justify-center" style="margin-top: 2rem">
               <a href="{{route('nuevoEInvalidacion')}}"class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2" type="button">Individual</a>
               <a href=""class="focus:outline-none text-white bg-amber-400 hover:bg-amber-400 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2" type="button">Lotes</a>
            </div>
        </div>
    </div>
    <div class="relative overflow-x-auto sm:rounded-lg">
        <div class="mx-auto container">
            <table class="w-full text-sm text-left rtl:text-right tabla-eventC">
                <thead class="text-xs uppercase bg-gray-600">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-center text-white" style="font-size:1.2rem;">
                            Fecha
                        </th>
                        <th scope="col" class="px-6 py-3 text-center text-white" style="font-size:1.2rem;">
                            Sello de Recibido
                        </th>
                        <th scope="col" class="px-6 py-3 text-center text-white" style="font-size:1.2rem;">
                            Operaciones
                        </th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @forelse($contingencias as $contingencia) --}}
                        <tr
                            class="bg-white border-b hover:bg-gray-50">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 text-center whitespace-nowrap bg-gray-50">
                                {{-- {{ $contingencia->fechaHora }} --}}
                            </th>
                            <td class="px-6 py-4 text-center">
                                {{-- {{ $contingencia->selloRecibido }} --}}
                            </td>
                            <td class="px-6 py-4 text-center">
                                {{-- <a href="{{ route('obtenerJsonGuardadoC',['sello' => $contingencia->selloRecibido]) }}" --}}
                                    {{-- class="w-full text-white bg-amber-400 hover:bg-amber-500 focus:ring-4 focus:outline-none focus:ring-amber-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                                    target="_self">Ver
                                    JSON</a> --}}
                            </td>
                        {{-- @empty --}}
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center bg-white" style="font-size: 1.2rem;">Sin datos
                            </td>
                        </tr>
                        </tr>
                    {{-- @endforelse --}}
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
