<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Project;
use App\Models\Type;
use App\Models\Technology;


use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        if($request->has('term')) {
            $term = $request->get('term');
            $projects = Project::where('title', 'LIKE', "%$term%")->paginate(8)->withQueryString();
        }else {
            $sort = (!empty($sort_request = $request->get('sort'))) ? $sort_request : "updated_at"; 
            $order = (!empty($order_request = $request->get('order'))) ? $order_request : "DESC"; 

             $projects = Project::orderBy($sort, $order)->paginate(8)->withQueryString();
        }
       
        return view('admin.projects.index', compact('projects', 'sort', 'order'));
    }
 
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {              
            $project = new Project;
            $types = Type::orderBy('label')->get();
            $technologies = Technology::orderBy('label')->get();
            // $project_technologies = [];
            return view('admin.projects.form', compact('project', 'types', 'technologies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'title' => 'required|string|max:50',
            'text'=> 'required|string',
            'image' => 'nullable|image|mimes:jpg,png,jpeg',
            'link'  => 'required|url',
            'type_id' => 'nullable|exists:types,id',
            'technologies' => 'nullable|exists:technologies,id'
            

        ],[
            'title.required' => 'Il titolo è obbligatorio',
            'title.string' => 'Il titolo ldeve essere una stringa',
            'title.max' => 'Il titolo puo avere 50 caratteri',
            'image.image' => 'Il file deve essere un\'immagine',
            'image.mimes' => 'Le estensioni accettate per l\'immagine sono jpg,png,jpeg',
            'link.required' => 'Il link è obbligatorio',
            'link.url' => 'Il link deve essere un link valido',
            'type_id.exists' => 'L\'id del tipo non è valido',
            'technologies.exists' => 'Le tecnologie selezionate non sono valide'
             
        ]);
        
        $data = $request->all(); 
        // il storage
        if(Arr::exists( $data, 'image')) {
            $path = Storage::put('uploads/projects', $data['image']);
            $data['image'] = $path;
        }

        // dd($data);

        $project = new Project;
        $project->fill($data);
        $project->slug = Project::generateSlug($project->title);
        // $project->slug = $project->id . '-' . Str::of($project->title)->slug('-');
        // $project->image = $path; // per salvare nel database il primo metodo
        $project->save();

        //Attach
        if(Arr::exists($data, "technologies")) 
            $project->technologies()->attach($data["technologies"]);

        return to_route('admin.projects.show', $project)
        ->with('message_content', "Progetto $project->id creato con successo");

        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {   
        $types = Type::orderBy('label')->get();
        $technologies = Technology::orderBy('label')->get();
        $project_technologies = $project->technologies->pluck('id')->toArray();
        // dd($project_technologies);
        return view('admin.projects.form', compact('project', 'types', 'technologies', 'project_technologies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        // dd($request->all());
        //validiamo il form
        $request->validate([
            'title' => 'required|string|max:50',
            'text'=> 'required|string',
            'image' => 'nullable|image|mimes:jpg,png,jpeg',
            'link'  => 'required|url',
            'is_published' => 'boolean',
            'type_id.exists' => 'L\'id del tipo non è valido',
            'technologies' => 'nullable|exists:technologies,id'
        ],[
            'title.required' => 'Il titolo è obbligatorio',
            'title.string' => 'Il titolo ldeve essere una stringa',
            'title.max' => 'Il titolo puo avere 50 caratteri',
            'image.image' => 'Il file deve essere un\'immagine',
            'image.mimes' => 'Le estensioni accettate per l\'immagine sono jpg, png, jpeg',
            'link.required' => 'Il link è obbligatorio',
            'link.url' => 'Il link deve essere un link valido',
            'type_id.exists' => 'L\'id del tipo non è valido',
            'technologies.exists' => 'Le tecnologie selezionate non sono valide'
            
        ]);

        //Raffiniamo i dati che c'è arrivano per salvare correttamente in DB
        $data = $request->all(); 
        $data["slug"] = Project::generateSlug($data["title"]);
        $data["is_published"] = $request->has("is_published") ? 1 : 0;
        // dd($data);  
         
        // il storage
        //gestiamo le immagini 
        if(Arr::exists( $data, 'image')) {
            if($project->image) Storage::delete($project->image);
            $path = Storage::put('uploads/projects', $data['image']);
            $data['image'] = $path;
        }    

        $project->update($data); // riempe e salva
        // $project->fill($data); // solo riempe senza salvare
        // $project->save();

        //sync
        if(Arr::exists($data, "technologies")) 
            $project->technologies()->sync($data["technologies"]);
        else 
            $project->technologies()->detach();

        return to_route('admin.projects.show', $project)
            ->with('message_content', "Progetto $project->id modificato con successo");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        // $project = Project::findOrFail($id);
        $id_project = $project->id;
        
        $project->delete();

        return to_route('admin.projects.index')     
        // return redirect()->route('admin.projects.index');
            ->with('messsage_type', "danger")
            ->with('message_content', "Project $id_project spostato nel cestino");
    }


    /**
     * Display a listing of the trashed resource.
     * 
     *  @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function trash(Request $request
    ) { 

        $sort = (!empty($sort_request = $request->get('sort'))) ? $sort_request : "updated_at"; 
        $order = (!empty($order_request = $request->get('order'))) ? $order_request : "DESC"; 


         $projects = Project::onlyTrashed()->orderBy($sort, $order)->paginate(8);//->withQueryString()

       
        // dd($project);
        return view('admin.projects.trash', compact('projects', 'sort', 'order'));
    }


       /**
     * Force delete the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(Int $id)
    {
        $project =Project::where('id', $id)->onlyTrashed()->first();

        // $id_project = $project->id; // non ci serve piu perche passa gia id
        
        if($project->image) Storage::delete($project->image); //l'immagine elimino solo nel forcedelete
        $project->technologies()->detach();
        $project->forceDelete();

        return to_route('admin.projects.trash')     
        // return redirect()->route('admin.projects.index');
            ->with('messsage_type', "danger")
            ->with('message_content', "Project $id eleminato definitivamente");
    }

      /**
     * Restore the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function restore(Int $id)
    {
        $project =Project::where('id', $id)->onlyTrashed()->first();
        $project->restore();

        return to_route('admin.projects.index')     
            ->with('message_content', "Project $id ripristinato");
    }
} 