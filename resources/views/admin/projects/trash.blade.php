@extends('layouts.app')

@section('title', 'Trash Projects')

@section('actions')
<div>
  <a href="{{ route('admin.projects.index')}}" type="button" class="btn btn-outline-success ms-auto">Torna alla lista</a>
</div>

@endsection

@section('content')
<section>    
  <div class="row my-5"> 
  
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
              <a 
                href="{{ route('admin.projects.index') }}?sort=deleted_at&order={{ $sort == 'deleted_at' && $order != 'DESC' ? 'DESC' : 'ASC' }}">Date of cancel
                @if ($sort == 'deleted_at')
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
            {{-- <td>{{ $project->slug }}</td> --}}
            {{-- <td>{{ $project->image }}</td> --}}
            <td>{{ $project->getAbstract(15) }}</td>
            {{-- <td>{{ $project->link }}</td> --}}
            <td>{{ $project->created_at }}</td>
            <td>{{ $project->updated_at }}</td>
            <td>{{ $project->deleted_at }}</td>
            

            <td class="action-cell align-items-center">
              {{-- <a 
                href="{{route('admin.projects.show', $project)}}">
                <i class="bi bi-eye"></i>
              </a> --}}
              {{-- <td><a href="{{route('projects.show', ['project'=$project->id])}}"><i class="bi bi-eye"></i></a></td> --}}

              {{-- <a 
                href="{{ route('admin.projects.edit', $project)}}">
                <i class="bi bi-pencil"></i>
              </a> --}}

                {{-- icon for delete--}}
              <a href="#"
                class="text-danger" data-bs-toggle="modal" data-bs-target="#delete-modal-{{ $project->id }}">
                <i class="bi bi-trash3 btn-icon"></i>
               </a> 
                {{-- icon for reset--}}
              <a href="#"
                class="text-success" data-bs-toggle="modal" data-bs-target="#restore-modal-{{ $project->id }}">
                <i class="bi bi-arrow-repeat btn-icon fs-5"></i>
               </a> 
              
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
    <!-- modal for delete-->
    <div class="modal modal-lg fade" id="delete-modal-{{ $project->id }}" tabindex="-1" aria-labelledby="delete-modal-{{ $project->id }}" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Conferma eliminazione!</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body text-start">
            Sei sicuro di voler eliminare definitivamente il progetto "{{ $project->title }}" con ID "{{ $project->id }}"? <br>
            L'operazione non è reversibile.
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
            
            <form action="{{ route('admin.projects.force-delete', $project)}}" method="POST"> 
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
  {{-- modal for reset--}}
  @forelse ($projects as $project)
    <!-- Modal -->
    <div class="modal modal-lg fade" id="restore-modal-{{ $project->id }}" tabindex="-1" aria-labelledby="restore-modal-{{ $project->id }}" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Conferma eliminazione!</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body text-start">
            Sei sicuro di voler ripristinare il progetto "{{ $project->title }}" con ID "{{ $project->id }}"?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Annulla</button>
            
            <form action="{{ route('admin.projects.restore', $project)}}" method="POST"> 
                @method('put')
                @csrf 
                
                <button type="submit" class="btn btn-success">Ripristina</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    @empty  
  @endforelse
@endsection
  
        
     
    
  
   
