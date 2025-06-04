<?php

namespace App\Http\Controllers;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Categoria;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoriasController extends Controller
{
    // use WithPagination;

	protected $paginationTheme = 'bootstrap';
    public $selected_id, $keyWord, $nombre;

    public function index(Request $request)
    {
        $search = trim( $request->search );
        $categorias = Categoria::latest()->where([ ['is_activated', 1], ['description', 'LIKE', '%'.$search.'%'] ])->paginate(10);

        return view('categorias.index', [
            "categorias" => $categorias,
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
        return view('categorias.create');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        return view('categorias.edit', [
            'categoria' => Categoria::find($id)        
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
        request()->validate(Categoria::$rules);

        if( (int)$request->categoria_id > 0 ){
            $record = Categoria::find($request->categoria_id);
            $record->update($request->all());
            $categoriaId = $request->categoria_id;
        }else{
            $request->request->add(['created_by' => Auth::id()]);            
            $producto = Categoria::create($request->all());
            $categoriaId = $producto->id;
        }

        return redirect()->route('categorias.edit', $categoriaId );
    }

    /**
     * @param int $id
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy($id)
    {
        $record = Categoria::find($id);
        $record->update([
            'is_activated' => 0,
            'updated_by' => Auth::id()
        ]);

        return redirect()->route('categorias.index')
            ->with('success', 'Categoria deleted successfully');
    }

    public function all(Request $request)
    {
        $categorias = Categoria::where('is_activated', 1)
            ->get();

        return response()->json([
            'error' => false,
            'message' => 'Categoria',
            'data' => $categorias
        ]);
    }

    public function search(Request $request){
        // Get the search value from the request
        $search = $request->input('search');

        // Search in the title and body columns from the posts table
        $$categorias = Categoria::query()
            ->where('description', 'LIKE', "%{$search}%")
            ->get();

        // Return the search view with the resluts compacted
        return view('categorias.index', compact('categorias'));
    }
}