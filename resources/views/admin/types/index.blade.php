@extends('layouts.app')

@section('title', 'Tipi')

@section('actions')
<div>
  <a href="{{ route('admin.types.create')}}" type="button" class="btn btn-outline-success ms-auto">Create new type</a>
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
                href="{{ route('admin.types.index') }}?sort=id&order={{ $sort == 'id' && $order != 'DESC' ? 'DESC' : 'ASC' }}">ID
                @if ($sort == 'id')
                  <i class="bi bi-arrow-down d-inline-block @if($order == 'DESC') rotate-180 @endif"></i>
                @endif
              </a>
            </th>            

            <th scope="col">
              <a 
                href="{{ route('admin.types.index') }}?sort=label&order={{ $sort == 'label' && $order != 'DESC' ? 'DESC' : 'ASC' }}">Label
                @if ($sort == 'label')
                  <i class="bi bi-arrow-down d-inline-block @if($order == 'DESC') rotate-180 @endif"></i>
                @endif
              </a>
            </th>
            
            <th scope="col">
              <a 
                href="{{ route('admin.types.index') }}?sort=color&order={{ $sort == 'color' && $order != 'DESC' ? 'DESC' : 'ASC' }}">Color
                @if ($sort == 'color')
                  <i class="bi bi-arrow-down d-inline-block @if($order == 'DESC') rotate-180 @endif"></i>
                @endif
              </a>
            </th>

            <th scope="col">
              Pill  
            </th>

            <th scope="col">
              <a 
                href="{{ route('admin.types.index') }}?sort=created_at&order={{ $sort == 'created_at' && $order != 'DESC' ? 'DESC' : 'ASC' }}">Created 
                @if ($sort == 'created_at')
                <i class="bi bi-arrow-down d-inline-block @if($order == 'DESC') rotate-180 @endif"></i>
                @endif
              </a>
            </th>

            <th scope="col">
              <a 
                href="{{ route('admin.types.index') }}?sort=updated_at&order={{ $sort == 'updated_at' && $order != 'DESC' ? 'DESC' : 'ASC' }}">Last edit
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
          @forelse ($types as $type)
          <tr>
            <th scope="row">{{$type->id}}</th>
            <td>{{ $type->label }}</td>
            <td>
              {{-- <span class="color-preview" style="background-color: {{ $type->color }}"></span> --}}
              {{ $type->color }} 
            </td> 
            <td>
              <span class="badge rounded-pill" style="background-color: {{ $type->color}} ">{{ $type->label }}</span>
            </td>           
            <td>{{ $type->created_at }}</td>
            <td>{{ $type->updated_at }}</td>
            

            <td class="action-cell">
              {{-- <a 
                href="{{route('admin.types.show', $type)}}">
                <i class="bi bi-eye"></i>
              </a> --}}
              
              <a 
                href="{{ route('admin.types.edit', $type)}}">
                <i class="bi bi-pencil"></i>
              </a>

              <a 
                href="#"
                class="text-danger " data-bs-toggle="modal" data-bs-target="#delete-type-modal-{{ $type->id }}">
                <i class="bi bi-trash3 btn-icon"></i>
              </a>  
              
            </td>   
          </tr>   
          @empty  
          @endforelse 
        </tbody>
      </table>       
    </div> 
  </div>   
    {{ $types->links('')}}     
</section>      
@endsection      
    
         
    
   

 

@section('modals')
  @forelse ($types as $type)
    <!-- Modal -->
    <div class="modal modal-lg fade" id="delete-type-modal-{{ $type->id }}" tabindex="-1" aria-labelledby="delete-type-modal-{{ $type->id }}" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="delete-category-modal-{{ $type->id}}-label">Conferma eliminazione di tipo!</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body text-start">
            Sei sicuro di voler eliminare il tipo "{{ $type->label }}" con ID "{{ $type->id }}"? <br>
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
            
            <form action="{{ route('admin.types.destroy', $type)}}" method="POST">
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
    
        
     
    
  
   
