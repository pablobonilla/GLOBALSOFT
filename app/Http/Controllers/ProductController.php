<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Discount;
use App\Models\Product;
use App\Models\Tax;
use Dflydev\DotAccessData\Data;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
//use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Livewire\WithPagination;
use Response;

class ProductController extends Controller
{
//    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        $search = trim( $request->search );
        $productos = Product::latest()->where([ ['is_activated', 1], ['description', 'LIKE', '%'.$search.'%'] ])->paginate(10);

        return view('product.index', [
            "productos" => $productos,
            'search' => $search
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        /*$categorias = Category::all()->where('is_activated', 1);
        $discounts = Discount::all()->where('is_activated', 1);
        $taxes = Tax::all()->where('is_activated', 1);

        return view('product.create', [
            "categorias" => $categorias,
            "discounts" => $discounts,
            "taxes" => $taxes
        ]);*/

        return view('product.create');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        return view('product.edit', [
            'producto' => Product::find($id),
            'categorias' => Category::all()->where('is_activated', 1),
            "discounts" => Discount::all()->where('is_activated', 1),
            "taxes" => Tax::all()->where('is_activated', 1),
            'productos' => Product::all()->where('is_activated', 1),
            'guarniciones' => DB::table('garrison')
                ->where('garrison.product_id', $id)
                ->leftJoin('product', 'product.id', '=', 'garrison.garrisons_id')
                ->select('garrison.garrisons_id', 'product.description')
                ->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        request()->validate(Product::$rules);

        if( (int)$request->product_id > 0 ){
            if ($request->hasFile('photo')) {
                $extension = $request->file('photo')->getClientOriginalExtension();
                $record = Product::find($request->product_id);

                if ( !empty($record->photo) ){
                    // Elimino la(s) imagen(es) de la carpeta 'uploads'
                    $dirimgs = public_path('images/products/'.$record->photo);

                    // Verificamos si la(s) imagen(es) existe(n) y procedemos a eliminar
                    if(File::exists($dirimgs)) {
                        File::delete($dirimgs);
                    }
                }

                // Mover el fichero a la ruta con un nuevo nombre:
                $destinationPath = public_path('images/products/');

                $namePhoto = $request->product_id ."." . $extension;
                $request->file('photo')->move($destinationPath, $namePhoto);

                // Comprobar si el fichero que se ha subido es válido
                $request->file('photo')->isValid();

                $record->update([
                    'category_id' => $request->category_id,
                    'description' => $request->description,
                    'description_large' => $request->description_large,
                    'price' => $request->price,
                    'discount_id' => $request->discount_id,
                    'tax_id' => $request->tax_id,
                    'reference' => $request->reference,
                    'configurable_product' => $request->configurable_product,
                    'is_activated' => $request->is_activated,
                    'updated_by' => Auth::id(),
                    'photo' => $namePhoto
                ]);
            }else{
                $record = Product::find($request->product_id);
                $record->update($request->all());
            }
            $productoId = $request->product_id;
        }else{
            $request->request->add(['created_by' => Auth::id()]);

            // Si queremos podemos comprobar si un determinado campo tiene un fichero asignado:
            if ($request->hasFile('photo')) {
                $extension = $request->file('photo')->getClientOriginalExtension();

                // Mover el fichero a la ruta con un nuevo nombre:
                $destinationPath = public_path('images/products/');

                $producto = Product::create($request->all());

                $namePhoto = $producto->id ."." . $extension;
                $request->file('photo')->move($destinationPath, $namePhoto);

                // Comprobar si el fichero que se ha subido es válido
                $request->file('photo')->isValid();

                $record = Product::find($producto->id);
                $record->update([
                    'photo' => $namePhoto
                ]);
                $productoId = $producto->id;
            }else{
                $producto = Product::create($request->all());
            }
        }

        return redirect()->route('producto.edit', $productoId );
    }

    /**
     * @param int $id
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy($id)
    {
        $record = Product::find($id);
        $record->update([
            'is_activated' => 0,
            'updated_by' => Auth::id()
        ]);

        return redirect()->route('producto.index')
            ->with('success', 'Producto deleted successfully');
    }

    public function all(Request $request)
    {
        $products = Product::where('is_activated', 1)
            ->with(['category','tax','discount'])
            ->get();

        return response()->json([
            'error' => false,
            'message' => 'Products',
            'data' => $products
        ]);
    }

    public function search(Request $request){
        // Get the search value from the request
        $search = $request->input('search');

        // Search in the title and body columns from the posts table
        $productos = Product::query()
            ->where('description', 'LIKE', "%{$search}%")
            ->get();

        // Return the search view with the resluts compacted
        return view('product.index', compact('productos'));
//            ->with('i', (request()->input('page', 1) - 1) * $productos->perPage());
    }

    public function allByCategory(Request $request)
    {
        if ($request->has('category_id')) $category_id = $request->category_id;
        else $category_id = 0;

        $products = Product::where(['is_activated' => 1, 'category_id' => $category_id])
            ->with(['category','tax','discount'])
            ->get();

        return response()->json([
            'error' => false,
            'message' => 'Products by category ['.$category_id.']',
            'data' => $products
        ]);
    }

    public function inventarioFisico()
    {
        return view('product.inventarioFisico', [
            'productos' => Product::all()->where('is_activated', 1),
        ]);
    }

    public function createGarrison($id, Request $request)
    {
        DB::table('garrison')->insert([
            'product_id' => $id,
            'garrisons_id' => $request->producto
        ]);

        $datos = DB::table('garrison')
            ->select('garrison.garrisons_id', 'product.description')
            ->leftJoin('product', 'product.id', '=', 'garrison.garrisons_id')
            ->where('garrison.product_id', $id)->get();
        return response()->json(['success' => true,'result' => $datos ]);
    }

    public function destroyGarrison($id, Request $request)
    {
        DB::delete('DELETE FROM garrison WHERE product_id = ? AND garrisons_id = ?',[$id, $request->producto]);

        $datos = DB::table('garrison')
            ->select('garrison.garrisons_id', 'product.description')
            ->leftJoin('product', 'product.id', '=', 'garrison.garrisons_id')
            ->where('garrison.product_id', $id)->get();
        return response()->json(['success' => true,'result' => $datos ]);
    }

    public function getQtyByProduct($id)
    {
        $datos = DB::table('product')
            ->select('qty')
            ->where('id', $id)->get();
        return response()->json(['success' => true,'result' => $datos ]);
    }

    public function savePhisicalInventory(Request $request)
    {
        $data = $request->items;
        list($m,$d,$a) = explode("/", $request->date);
        $physical_inventory_date = $a.'-'.$m.'-'.$d;

        foreach ($data as $value){
            $product_id = $value[0];
            $record = Product::find($product_id);
            $description = $record->description;
            $action = $value[2];
            $theoretical_amount = $value[3];
            $physical_amount = $value[4];
            $amount = 0;

            if( $action === "Reemplazar" ){ // Reemplazar
                $action_id = 1;
                $amount = $physical_amount;
            }else if( $action === "Incrementar" ){ // Incrementar
                $action_id = 2;
                $amount = $theoretical_amount + $physical_amount;
            }else if( $action === "Disminuir" ){ // Disminuir
                $action_id = 3;
                $amount = $theoretical_amount - $physical_amount;
            }

            DB::update('update product set qty = ? where id = ?', [$amount,$product_id]);

            DB::table('physical_inventory')->insert([
                'product_id' => $product_id,
                'description' => $description,
                'physical_inventory_date' => $physical_inventory_date,
                'theoretical_amount' => $theoretical_amount,
                'physical_amount' => $physical_amount,
                'action_id' => $action_id,
                'created_by' => Auth::id(),
                'created_at' => date("Y-m-d h:i:s")
            ]);
        }

        return response()->json(['success' => true]);
    }
}
