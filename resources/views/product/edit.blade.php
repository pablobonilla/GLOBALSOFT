@section('title', __('Productos'))
@extends('layouts.app')

@section('content_header')
    <h1>{{ __('Editar Producto') }}</h1>
@stop

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-12">
                @includeif('partials.errors')
            </div>

            <div class="col-12 col-lg-6">
                <form method="POST" action="{{ route('producto.store') }}"  role="form" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $producto->id }}">

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
{{--                                            @foreach($categorias as $categoria)--}}
{{--                                                <option value="{{$categoria->id}}" @if($producto->category_id== $categoria->id) selected="selected"@endif>{{$categoria->description}}</option>--}}
{{--                                            @endforeach--}}
                                        </select>
                                        @error('category_id') <span class="error text-danger">{{ __($message) }}</span> @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="description">{{ __('Nombre') }} <span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" name="description" id="description" value="{{ $producto->description }}">
                                        @error('description') <span class="error text-danger">{{ __($message) }}</span> @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="description_large">{{ __('Descripción') }}</label>
                                        <textarea name="description_large" class="form-control" id="description_large">{{ $producto->description_large }}</textarea>
                                        @error('description_large') <span class="error text-danger">{{ __($message) }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-4">
                                    <input type="file" id="photo" name="photo" class="dropify" data-height="190" data-allowed-file-extensions="jpg jpeg png bmp gif svg webp" data-default-file="{{ asset('images/products/'.$producto->photo) }}" />
                                    @error('photo') <span class="error text-danger">{{ __($message) }}</span> @enderror
                                    <div class="row pt-2">
                                        <div class="col-7">
                                            <h6><b>{{ __('Precio') }}</b></h6>
                                            <span>RD$ {{ number_format($producto->price, 2) }}</span>
                                        </div>
                                        <div class="col-5">
                                            <h6><b>{{ __('Existencia') }}</b></h6>
                                            <span>{{ $producto->qty }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-4">
                                    <label for="price">{{ __('Precio de venta') }} <span style="color: red;">*</span></label>
                                    <input type="number" class="form-control" name="price" id="price" step="any" value="{{ number_format($producto->price, 2) }}">
                                    @error('price') <span class="error text-danger">{{ __($message) }}</span> @enderror
                                </div>

                                <div class="form-group col-4">
                                    <label for="discount_id">{{ __('Descuentos') }}</label>
                                    <select class="form-control select2" name="discount_id" id="discount_id" style="width: 100%;">
                                        <option value="0" selected>{{ __('Sin descuento') }}</option>
{{--                                        @foreach ($discounts as $discount)--}}
{{--                                            <option value="{{ $discount->id }}" @if( $discount->id == $producto->discount_id ) selected="selected"@endif>{{ $discount->description }}</option>--}}
{{--                                        @endforeach;--}}
                                    </select>
                                    @error('discount_id') <span class="error text-danger">{{ __($message) }}</span> @enderror
                                </div>

                                <div class="form-group col-4">
                                    <label for="tax_id">{{ __('Impuestos') }}</label>
                                    <select class="form-control select2" name="tax_id" id="tax_id" style="width: 100%;">
                                        <option value="0" selected>{{ __('Sin impuesto') }}</option>
{{--                                        @foreach ($taxes as $tax)--}}
{{--                                            <option value="{{ $tax->id }}" @if( $tax->id == $producto->tax_id ) selected="selected"@endif>{{ $tax->description }}</option>--}}
{{--                                        @endforeach;--}}
                                    </select>
                                    @error('tax_id') <span class="error text-danger">{{ __($message) }}</span> @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="reference">{{ __('Referencia') }}</label>
                                    <input type="text" class="form-control" name="reference" id="reference" value="{{ $producto->reference }}">
                                    @error('reference') <span class="error text-danger">{{ __($message) }}</span> @enderror
                                </div>

                                <div class="form-group col-3">
                                    <label for="configurable_product">{{ __('Producto configurable') }}</label>
                                    <select class="form-control select2" name="configurable_product" id="configurable_product" style="width: 100%;">
                                        <option value="1" @if( $producto->configurable_product == 1 ) selected="selected"@endif>{{ __('Si') }}</option>
                                        <option value="0" @if( $producto->configurable_product == 0 ) selected="selected"@endif>{{ __('No') }}</option>
                                    </select>
                                    @error('configurable_product') <span class="error text-danger">{{ __($message) }}</span> @enderror
                                </div>

                                <div class="form-group col-3">
                                    <label for="is_activated">{{ __('Estado') }}</label>
                                    <select class="form-control select2" name="is_activated" id="is_activated" style="width: 100%;">
                                        <option value="1" @if( $producto->is_activated == 1 ) selected="selected"@endif>{{ __('Activo') }}</option>
                                        <option value="0" @if( $producto->is_activated == 0 ) selected="selected"@endif>{{ __('Inactivo') }}</option>
                                    </select>
                                    @error('is_activated') <span class="error text-danger">{{ __($message) }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-success float-right ml-2">
                                <i class="nav-icon fas fa-edit"></i> &nbsp;{{ __('Editar') }}
                            </button>

                            <a href="{{ route('producto.index') }}" class="btn btn-outline-default float-right">{{ __('Cancelar') }}</a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-6">
                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('Guarniciones') }}</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body" style="display: block;">
                        <div class="row">
                            <div class="form-group col-5">
                                <label for="productos">{{ __('Productos') }}</label>
                                <select class="form-control select2" name="productos" id="productos" style="width: 100%;">
                                    <option value="" selected>{{ __('Seleccionar Producto') }}</option>
                                    @foreach($productos as $producto)
                                        <option value="{{$producto->id}}">{{$producto->description}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-2 align-self-center">
                                <button type="button" class="btn btn-info" id="addGarrison">
                                    <i class="nav-icon fas fa-plus"></i> &nbsp;{{ __('Agregar') }}
                                </button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="thead">
                                        <tr>
                                            <th>{{ __('Descripción') }}</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="garrison">
                                        @foreach($guarniciones as $guarnicion)
                                            <tr>
                                                <td>{{$guarnicion->description}}</td>
                                                <td>
                                                    <button data-id="{{$guarnicion->garrisons_id}}" type="button" class="btn btn-danger btn-sm deleteGarrison"><i class="fa fa-fw fa-trash"></i> Delete</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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

        $(document).ready(function (){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            $("#addGarrison").on("click", function(e){
                e.preventDefault();

                let producto = $("#productos").val();

                if( producto === '' || producto === '' || producto === 'undefined' ){
                    Swal.fire("Debes seleccionar el producto", "Favor intentar de nuevo", "warning");
                    return false;
                }

                $.ajax({
                    url: "{{ route('producto.createGarrison', $producto->id) }}",
                    type: 'post',
                    dataType: 'JSON',
                    data: {
                        producto: producto
                    },
                    success: function(response){
                        if( response.success ){
                            let data = response.result;
                            let html = '';
                            $.each(data, function(i, item) {
                                html += '<tr>';
                                html += '<td>'+ item.description +'</td>';
                                html += '<td>';
                                html += '<button data-id="'+ item.garrisons_id + '" type="button" class="btn btn-danger btn-sm deleteGarrison"><i class="fa fa-fw fa-trash"></i> Delete</button>';
                                html += '</td>';
                                html += '</tr>';
                            });
                            $("#garrison").empty().html(html);
                        }
                    },
                    error: function (error) {
                        console.error(error.responseText);
                    }
                });
            });

            $("#garrison").on("click", ".deleteGarrison", function (){
                let garrison_id = $(this).attr('data-id');

                if( !(parseInt(garrison_id) > 0) ){
                    Swal.fire("Debes seleccionar una guarnición", "Favor intentar de nuevo", "warning");
                    return false;
                }

                $.ajax({
                    url: "{{ route('producto.destroyGarrison',$producto->id) }}",
                    type: 'post',
                    dataType: 'JSON',
                    data: {
                        producto: garrison_id
                    },
                    success: function(response){
                        if( response.success ){
                            let data = response.result;
                            let html = '';
                            $.each(data, function(i, item) {
                                html += '<tr>';
                                    html += '<td>'+ item.description +'</td>';
                                    html += '<td>';
                                        html += '<button data-id="'+ item.garrisons_id + '" type="button" class="btn btn-danger btn-sm deleteGarrison"><i class="fa fa-fw fa-trash"></i> Delete</button>';
                                    html += '</td>';
                                html += '</tr>';
                            });
                            $("#garrison").empty().html(html);
                        }
                    },
                    error: function (error) {
                        console.error(error.responseText);
                    }
                });
            });
        });
    </script>
    @yield('js')
@stop
