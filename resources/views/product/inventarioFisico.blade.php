@section('title', __('Inventario Físico'))
@extends('layouts.app')

@section('content_header')
    <h1>{{ __('Inventario Físico') }}</h1>
@stop

@section('content')
    <section class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-2">
                                <label for="fecha">Fecha</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-calendar"></i></div>
                                    </div>
                                    <input type="text" class="form-control datetimepicker-input" name="fecha" id="fecha" autocomplete="off" data-toggle="datetimepicker" data-target="#fecha">
                                </div>
                            </div>

                            <div class="form-group col-6">
                                <label for="productos">Productos</label>
                                <select class="form-control select2" name="productos" id="productos" style="width: 100%;">
                                    <option value="" selected>{{ __('Seleccionar Producto') }}</option>
                                    @foreach($productos as $producto)
                                        <option value="{{$producto->id}}">{{$producto->description}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-2">
                                <label for="cantTeorica">Cantidad Teórica</label>
                                <input type="number" class="form-control" name="cantTeorica" id="cantTeorica" readonly>
                            </div>

                            <div class="form-group col-3">
                                <label for="accion">Acción</label>
                                <select class="form-control select2" name="accion" id="accion" style="width: 100%;">
                                    <option value="1" selected="selected">Reemplazar</option>
                                    <option value="2">Incrementar</option>
                                    <option value="3">Disminuir</option>
                                </select>
                            </div>

                            <div class="form-group col-3">
                                <label for="cantFisica">Cantidad Física</label>
                                <input type="number" class="form-control" name="cantFisica" id="cantFisica">
                            </div>

                            <button id="agregarItem" type="button" class="btn btn-primary" style="height: 40px;margin-top: 31px;">
                                <i class="nav-icon fas fa-plus"></i> &nbsp;&nbsp; Agregar
                            </button>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-12">
                                <table id="tablePhisicalInventory" class="table table-bordered table-striped hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Descripción</th>
                                            <th>Acción</th>
                                            <th>Teórico</th>
                                            <th>Físico</th>
                                            <th>Diferencia</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-success float-right ml-2" id="Guardar">
                            <i class="nav-icon fas fa-save"></i> &nbsp;&nbsp; Guardar
                        </button>
                        <a href="{{ route('producto.inventarioFisico') }}" class="btn btn-outline-default float-right">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('adminlte_js')
    @stack('js')
    <script type="text/javascript">
        $(document).ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#productos').select2();

            $('#fecha').datetimepicker({
                format: 'L'
            });

            let table = $("#tablePhisicalInventory").DataTable({
                language: {
                    decimal: '.',
                    thousands: ',',
                },
                columnDefs: [
                    {
                        targets: -1,
                        data: null,
                        defaultContent: '<button class="btn btn-danger" title="Borrar"><i class="fa fa-trash"></i></button>',
                    },
                ],
                "responsive": true, "lengthChange": false, "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print"]
            });
            table.buttons().container().appendTo('#tablePhisicalInventory_wrapper .col-md-6:eq(0)');

            $('#tablePhisicalInventory tbody').on('click', 'button', function () {
                table.row($(this).parents('tr')).remove().draw(false);
            });


            $("#productos").change(function () {
                var product_id = $(this).val();

                if( product_id !== null ){
                    $.ajax({
                        url: '/producto/getQtyByProduct/' + product_id,
                        type: 'GET',
                        dataType: 'JSON',
                        success: function(response){
                            if( response.success ){
                                $("#cantTeorica").val(parseFloat(response.result[0].qty).toFixed(2));
                            }
                        },
                        error: function (error) {
                            console.error(error.responseText);
                        }
                    });
                }
            });

            $("#agregarItem").on("click", function () {
                var fecha = $("#fecha");
                var item = $("#productos");
                var cantTeorica = $("#cantTeorica");
                var accion = $("#accion");
                var cantFisica = $("#cantFisica");

                if( fecha.val() === "" ){
                    Swal.fire('Datos incompletos', 'Seleccione la fecha', 'warning');
                    return false;
                }

                if( item.val() == null ){
                    Swal.fire('Datos incompletos', 'Debes seleccionar el producto', 'warning');
                    return false;
                }

                if( cantTeorica.val() === "" ){
                    Swal.fire('Datos incompletos', 'Introduzca la cantidad teoría', 'warning');
                    return false;
                }

                if( accion.val() === "" ){
                    Swal.fire('Datos incompletos', 'Seleccione la acción', 'warning');
                    return false;
                }

                if( cantFisica.val() === "" ){
                    Swal.fire('Datos incompletos', 'Introduzca la cantidad física', 'warning');
                    return false;
                }

                var diferencia = 0;
                if( accion.val() === 1 ){ // Reemplazar
                    diferencia = 0;
                }else if( accion.val() === 2 ){ // Incrementar
                    diferencia = (parseFloat(cantTeorica.val())+parseFloat(cantFisica.val()));
                }else if( accion.val() === 3 ){ // Disminuir
                    diferencia = (parseFloat(cantTeorica.val())-parseFloat(cantFisica.val()));
                }

                table.row.add({ 0: item.val(), 1: item.find(':selected').text(), 2: accion.find(':selected').text(), 3:cantTeorica.val(), 4:cantFisica.val(), 5:diferencia, 6:''}).draw(false);
                cantFisica.val("");
                cantTeorica.val("");
                fecha.attr("disabled","disabled");
            });

            $("#Guardar").on("click", function (event) {
                event.preventDefault();

                var items = table.rows().data().toArray();
                var fecha = $("#fecha");

                if( fecha.val() === "" ){
                    Swal.fire('Datos incompletos', 'Seleccione la fecha', 'warning');
                    return false;
                }

                if( !(items.length > 0) ){
                    Swal.fire("Datos Incompletos", "Debes agregar los items", "warning");
                    return false;
                }

                Swal.fire({
                    title: '¿Estás seguro de actualizar el inventario?',
                    text: "¡No podrás revertir esto!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: 'green',
                    confirmButtonText: 'Si',
                    cancelButtonText: 'No'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: "{{ route('producto.savePhisicalInventory') }}",
                            type: 'POST',
                            dataType: 'JSON',
                            data:{
                                items: items,
                                date: fecha.val()
                            },
                            success: function(response){
                                if( response.success ){
                                    location.reload();
                                }
                                // else{
                                //     Swal.fire(response.title, response.message, "warning");
                                // }
                            },
                            error: function (error) {
                                console.error(error.responseText);
                            }
                        });
                    }
                });
            });
        });
    </script>
    @yield('js')
@stop
