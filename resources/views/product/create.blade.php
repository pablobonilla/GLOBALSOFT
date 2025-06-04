@section('title', __('Productos'))
@extends('layouts.app')

@section('content_header')
    <h1>{{ __('Crear Producto') }}</h1>
@stop

@section('content')
    <section class="content container-fluid">
        <form method="POST" action="{{ route('producto.store') }}"  role="form" enctype="multipart/form-data">
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
                                        <label for="category_id">{{ __('Categorías') }} <span style="color: red;">*</span></label>
                                        <select class="form-control select2" name="category_id" id="category_id" style="width: 100%;">
                                            <option value="" selected>{{ __('Seleccionar categoría') }}</option>
                                            @foreach ($categorias as $categoria)
                                                <option value="{{ $categoria->id }}" @if($categoria->category_id == old('category_id')) @endif>{{ $categoria->description }}</option>
                                            @endforeach;
                                        </select>
                                        @error('category_id') <span class="error text-danger">{{ __($message) }}</span> @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="description">{{ __('Nombre') }} <span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" name="description" id="description" value="{{ old('description') }}">
                                        @error('description') <span class="error text-danger">{{ __($message) }}</span> @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="description_large">{{ __('Descripción') }}</label>
                                        <textarea name="description_large" class="form-control" id="description_large">{{ old('description_large') }}</textarea>
                                        @error('description_large') <span class="error text-danger">{{ __($message) }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-4">
                                    <input type="file" id="photo" name="photo" class="dropify" data-height="190" data-allowed-file-extensions="jpg jpeg png bmp gif svg webp" data-default-file="" />
                                    @error('photo') <span class="error text-danger">{{ __($message) }}</span> @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-4">
                                    <label for="price">{{ __('Precio de venta') }} <span style="color: red;">*</span></label>
                                    <input type="number" class="form-control" name="price" id="price" step="any" value="{{ number_format(old('price'), 2) }}">
                                    @error('price') <span class="error text-danger">{{ __($message) }}</span> @enderror
                                </div>

                                <div class="form-group col-4">
                                    <label for="discount_id">{{ __('Descuentos') }}</label>
                                    <select class="form-control select2" name="discount_id" id="discount_id" style="width: 100%;">
                                        <option value="0" selected>{{ __('Sin descuento') }}</option>
{{--                                        @foreach ($discounts as $discount)--}}
{{--                                            <option value="{{ $discount->id }}" @if($discount->id == old('discount_id')) selected="selected"@endif>{{ $discount->description }}</option>--}}
{{--                                        @endforeach;--}}
                                    </select>
                                    @error('discount_id') <span class="error text-danger">{{ __($message) }}</span> @enderror
                                </div>

                                <div class="form-group col-4">
                                    <label for="tax_id">{{ __('Impuestos') }}</label>
                                    <select class="form-control select2" name="tax_id" id="tax_id" style="width: 100%;">
                                        <option value="0" selected>{{ __('Sin impuesto') }}</option>
{{--                                        @foreach ($taxes as $tax)--}}
{{--                                            <option value="{{ $tax->id }}" @if($tax->id == old('tax_id')) selected="selected"@endif>{{ $tax->description }}</option>--}}
{{--                                        @endforeach;--}}
                                    </select>
                                    @error('tax_id') <span class="error text-danger">{{ __($message) }}</span> @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="reference">{{ __('Referencia') }}</label>
                                    <input type="text" class="form-control" name="reference" id="reference" value="{{ old('reference') }}">
                                    @error('reference') <span class="error text-danger">{{ __($message) }}</span> @enderror
                                </div>

                                <div class="form-group col-3">
                                    <label for="configurable_product">{{ __('Producto configurable') }}</label>
                                    <select class="form-control select2" name="configurable_product" id="configurable_product" style="width: 100%;">
                                        <option value="1">{{ __('Si') }}</option>
                                        <option value="0" selected="selected">{{ __('No') }}</option>
                                    </select>
                                    @error('configurable_product') <span class="error text-danger">{{ __($message) }}</span> @enderror
                                </div>

                                <div class="form-group col-3">
                                    <label for="is_activated">{{ __('Estado') }}</label>
                                    <select class="form-control select2" name="is_activated" id="is_activated" style="width: 100%;">
                                        <option value="1" selected="selected">{{ __('Activo') }}</option>
                                        <option value="0">{{ __('Inactivo') }}</option>
                                    </select>
                                    @error('is_activated') <span class="error text-danger">{{ __($message) }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-success float-right ml-2">
                                <i class="nav-icon fas fa-save"></i> &nbsp;{{ __('Guardar') }}
                            </button>

                            <a href="{{ route('producto.index') }}" class="btn btn-outline-default float-right">{{ __('Cancel') }}</a>
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

@section('adminlte_js')
    @stack('js')
    <script>
        $('.select2').select2();
        $('.dropify').dropify({
            messages: {
                'default': 'Arrastre y suelte un archivo aquí o haga click',
                'replace': 'Arrastre y suelte o haga click para reemplazar',
                'remove':  'Eliminar'
            }
        });
    </script>
    @yield('js')
@stop
