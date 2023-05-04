<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Type;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort = (!empty($sort_request = $request->get('sort'))) ? $sort_request : "updated_at"; 
        $order = (!empty($order_request = $request->get('order'))) ? $order_request : "DESC"; 

        $types = Type::orderBy($sort, $order)->paginate(8)->withQueryString();
        
        return view('admin.types.index', compact('types', 'sort', 'order'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $type = new Type();
        return view('admin.types.form', compact('type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'label' => 'required|string|max:20',
            'color' => 'required|string|size:7'
        ], [
            'label.required' => 'La label è obbligatorio',
            'label.string' => 'La label deve essere una stringa',
            'label.max' => 'La label deve essere di massimo 20 caratteri',

            'color.required' => 'La label è obbligatorio',
            'color.string' => 'La label deve essere una stringa',
            'color.max' => 'La label deve essere un esadecimale 7 caratteri (es. \'#fffffff\')'

        ]);

        $type = new Type();
        $type->fill($request->all());
        $type->save();

        return to_route('admin.types.index')
            ->with('message_content', "Tipo $type->id creato con successo");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function show(Type $type)
    {
        return view('admin.types.index', compact('type')); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function edit(Type $type)
    {
        return view('admin.types.form', compact('type')); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Type $type)
    {
        $request->validate([
            'label' => 'required|string|max:20',
            'color' => 'required|string|size:7'
        ], [
            'label.required' => 'La label è obbligatorio',
            'label.string' => 'La label deve essere una stringa',
            'label.max' => 'La label deve essere di massimo 20 caratteri',

            'color.required' => 'La label è obbligatorio',
            'color.string' => 'La label deve essere una stringa',
            'color.max' => 'La label deve essere un esadecimale 7 caratteri (es. \'#fffffff\')'

        ]);
        
        $type->update($request->all());
        $type->save();

        return to_route('admin.types.index')
            ->with('message_content', "Tipo $type->id modificato con successo");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function destroy(Type $type)
    {
        $type_id = $type->id;

        // Delete child records from the "projects" table that reference the parent record
        DB::table('projects')->where('type_id', $type_id)->delete();

        // Redirect to the index page with a success message
        $type->delete();
    
        return to_route('admin.types.index')
            ->with('message_type', "danger")
            ->with('message_content', "Tipo $type_id eliminato con successo");

    }
}