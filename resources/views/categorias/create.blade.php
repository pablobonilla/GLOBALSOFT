@section('title', __('Categorias'))
@extends('layouts.app')

@section('content_header')
    <h1>{{ __('Crear Categoria') }}</h1>
@stop

@section('content')
    <section class="content container-fluid">
        <form method="POST" action="{{ route('categorias.store') }}"  role="form" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-12">
                    @includeif('partials.errors')
                </div>

                <div class="col-12 col-lg-6">
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
                                        <textarea name="description" class="form-control" id="description">{{ old('description') }}</textarea>
                                        @error('description') <span class="error text-danger">{{ __($message) }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>  

                        <div class="card-footer">
                            <button type="submit" class="btn btn-success float-right ml-2">
                                <i class="nav-icon fas fa-save"></i> &nbsp;{{ __('Guardar') }}
                            </button>

                            <a href="{{ route('categorias.index') }}" class="btn btn-outline-default float-right">{{ __('Cancel') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>

    <style>
        .dropify-wrapper .dropify-message span.file-icon{
            font-size: 12px !important;
        }
    </style>
@endsection