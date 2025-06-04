@section('title', __('Categorias'))
@extends('layouts.app')

@section('content_header')
    <h1>{{ __('Editar Categoria') }}</h1>
@stop

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-12">
                @includeif('partials.errors')
            </div>

            <div class="col-12 col-lg-6">
                <form method="POST" action="{{ route('categorias.store') }}"  role="form" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="categoria_id" value="{{ $categoria->id }}">

                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('Información general') }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-8">
                                    <div class="form-group">
                                        <label for="description">{{ __('Descripción') }}</label>
                                        <textarea name="description" class="form-control" id="description">{{ $categoria->description }}</textarea>
                                        @error('description') <span class="error text-danger">{{ __($message) }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-success float-right ml-2">
                                <i class="nav-icon fas fa-edit"></i> &nbsp;{{ __('Editar') }}
                            </button>

                            <a href="{{ route('categorias.index') }}" class="btn btn-outline-default float-right">{{ __('Cancelar') }}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@section('adminlte_js')
    @stack('js')
    <script>

        $(document).ready(function (){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
        });
    </script>
    @yield('js')
@stop
