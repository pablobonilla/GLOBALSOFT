{{--@section('title', __('Categorias'))--}}
@extends('layouts.app')

@section('content_header')
    <h1>{{ __('Categorias') }}</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <form class="m-0" action="{{ route('categorias.index') }}" method="GET">
                                <div class="form-row align-items-center">
                                    <div class="col-auto">
                                        <label class="sr-only" for="search">search</label>
                                        <input type="text" class="form-control mb-2" name="search" id="search" placeholder="{{ __('Buscar Categoria') }}"  value="{{ $search }}">
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-info mb-2">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="float-right">
                            <a href="{{ route('categorias.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                <i class="fa fa-plus"></i>  {{ __('Agregar Categoria') }}
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                <tr>
                                    <th>{{ __('ID') }}</th>
                                    <th>{{ __('Descripción') }}</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categorias as $categoria)
                                        <tr>
                                            <td>{{ $categoria->id }}</td>
                                            <td>{{ $categoria->description }}</td>

                                            <td>
                                                <form action="{{ route('categorias.destroy',$categoria->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-success" href="{{ route('categorias.edit',$categoria->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Editar') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> {{ __('Eliminar') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex">
                                {{ $categorias->links() }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="float-end"></div>

            </div>
        </div>
    </div>
@stop

<script>

</script>

@section('adminlte_js')
    @stack('js')
    <script>
        $(document).ready(function (){
            @if ($message = Session::get('success'))
                Swal.fire('Success!', '{{ __($message) }}', 'success');
            @endif
        });
    </script>
    @yield('js')
@stop
