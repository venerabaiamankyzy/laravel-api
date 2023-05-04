@extends('layouts.app')

@section('title', 'Projects')

@section('actions')
<div>
  <a href="{{ route('admin.projects.create')}}" type="button" class="btn btn-outline-success ms-auto">Create project</a>
  <a href="{{ route('admin.projects.trash')}}" type="button" class="btn btn-outline-secondary ms-auto">Basket</a>
</div>

@endsection

@section('content')
<section>    
  <div class="row my-5"> 
    <form class="d-flex mb-5" role="search">
      <input class="form-control me-sm-2" type="search" name="term" placeholder="Search">
      <button class="btn btn-outline-success my-0" type="submit">Search</button>
    </form>   

    {{-- @dump($sort) --}}
    <div class="card p-3">
      <table class="table table-striped table-hover p-4 ">

        <thead>
          <tr>
            <th scope="col">
              <a 
                href="{{ route('admin.projects.index') }}?sort=id&order={{ $sort == 'id' && $order != 'DESC' ? 'DESC' : 'ASC' }}">ID
                @if ($sort == 'id')
                  <i class="bi bi-arrow-down d-inline-block @if($order == 'DESC') rotate-180 @endif"></i>
                @endif
              </a>
            </th>

            

            <th scope="col">
              <a 
                href="{{ route('admin.projects.index') }}?sort=title&order={{ $sort == 'title' && $order != 'DESC' ? 'DESC' : 'ASC' }}">Title
                @if ($sort == 'title')
                  <i class="bi bi-arrow-down d-inline-block @if($order == 'DESC') rotate-180 @endif"></i>
                @endif
              </a>
            </th>

            <th scope="col">
              Type
            </th>

            
            {{-- <th scope="col">
              <a 
                href="{{ route('admin.projects.index') }}?sort=slug&order={{ $sort == 'slug' && $order != 'DESC' ? 'DESC' : 'ASC' }}">Slug
                @if ($sort == 'slug')
                  <i class="bi bi-arrow-down d-inline-block @if($order == 'DESC') rotate-180 @endif"></i>
                @endif
              </a>
            </th> --}}

            {{-- <th scope="col">
              <a 
                href="{{ route('admin.projects.index') }}?sort=image&order={{ $sort == 'image' && $order != 'DESC' ? 'DESC' : 'ASC' }}">Image
                @if ($sort == 'image')
                  <i class="bi bi-arrow-down d-inline-block @if($order == 'DESC') rotate-180 @endif"></i>
                @endif
              </a>
            </th> --}}

            <th scope="col">
              <a 
                href="{{ route('admin.projects.index') }}?sort=text&order={{ $sort == 'text' && $order != 'DESC' ? 'DESC' : 'ASC' }}">Text
                @if ($sort == 'text')
                  <i class="bi bi-arrow-down d-inline-block @if($order == 'DESC') rotate-180 @endif"></i>
                @endif
              </a>
            </th>

            {{-- <th scope="col">
              <a 
                href="{{ route('admin.projects.index') }}?sort=link&order={{ $sort == 'link' && $order != 'DESC' ? 'DESC' : 'ASC' }}">Link
                @if ($sort == 'link')
                <i class="bi bi-arrow-down d-inline-block @if($order == 'DESC') rotate-180 @endif"></i>
                @endif
              </a>
            </th> --}}

            <th scope="col">
              <a 
                href="{{ route('admin.projects.index') }}?sort=created_at&order={{ $sort == 'created_at' && $order != 'DESC' ? 'DESC' : 'ASC' }}">Created 
                @if ($sort == 'created_at')
                <i class="bi bi-arrow-down d-inline-block @if($order == 'DESC') rotate-180 @endif"></i>
                @endif
              </a>
            </th>

            <th scope="col">
              <a 
                href="{{ route('admin.projects.index') }}?sort=updated_at&order={{ $sort == 'updated_at' && $order != 'DESC' ? 'DESC' : 'ASC' }}">Last edit
                @if ($sort == 'updated_at')
                <i class="bi bi-arrow-down d-inline-block @if($order == 'DESC') rotate-180 @endif"></i>
                @endif
              </a>
            </th>

            <th scope="col">
              Action
            </th>       
          </tr> 
        </thead>  

        <tbody>
          @forelse ($projects as $project)
          <tr>
            <th scope="row">{{$project->id}}</th>
            <td>{{ $project->getTitle(10) }}</td>
            <td>{{ $project->type?->label }}</td>
            {{-- <td>{{ $project->slug }}</td> --}}
            {{-- <td>{{ $project->image }}</td> --}}
            <td>{{ $project->getAbstract(15) }}</td>
            {{-- <td>{{ $project->link }}</td> --}}
            <td>{{ $project->created_at }}</td>
            <td>{{ $project->updated_at }}</td>
            

            <td class="action-cell">
              <a 
                href="{{route('admin.projects.show', $project)}}">
                <i class="bi bi-eye"></i>
              </a>
              {{-- <td><a href="{{route('projects.show', ['project'=$project->id])}}"><i class="bi bi-eye"></i></a></td> --}}

              <a 
                href="{{ route('admin.projects.edit', $project)}}">
                <i class="bi bi-pencil"></i>
              </a>

              <button 
                class="bi bi-trash3 text-danger btn-icon" data-bs-toggle="modal" data-bs-target="#delete-modal-{{ $project->id }}">
              </button> 
              
            </td>   
          </tr>   
          @empty  
          @endforelse 
        </tbody>
      </table>       
    </div> 
  </div>   
    {{ $projects->links('')}}    
</section>      
@endsection      
    
         
    
   

 

@section('modals')
  @forelse ($projects as $project)
    <!-- Modal -->
    <div class="modal modal-lg fade" id="delete-modal-{{ $project->id }}" tabindex="-1" aria-labelledby="delete-modal-{{ $project->id }}" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Conferma eliminazione!</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body text-start">
            Sei sicuro di voler eliminare il progetto "{{ $project->title }}" con ID "{{ $project->id }}"? <br>
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
            
            <form action="{{ route('admin.projects.destroy', $project)}}" method="POST">
                @method('delete')
                @csrf 
                
                <button type="submit" class="btn btn-danger">Elimina</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    @empty  
  @endforelse
@endsection
    
        
     
    
  
   
