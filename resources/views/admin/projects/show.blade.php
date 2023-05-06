@extends('layouts.app')

@section('title', $project->title)
    
@section('actions')
<div class="d-flex justify-content-end my-4 mx-3">
  <a href="{{ route('admin.projects.index')}}" class="btn btn-success text-end">Back to list</a>
  <a href="{{ route('admin.projects.edit', $project)}}" class="btn btn-success text-end mx-2">Modify project</a>
</div>
@endsection

@section('content')
  <section class="card clearfix mx-3">
    {{-- @dump($project) --}}
    <div class="card-body">
      {{-- @dump($project->type?->label) --}}
      <figure class="float-end ms-5 mb-3">
        <img src="{{ $project->getImageUri() }}" alt="{{ $project->slug}}" width="300">
          <figcaption>
            <p class="text-muted text-secondary m-0">{{ $project->slug}}</p>
          </figcaption>
      </figure>

      <div class="row">
        <div class="col-3">
          <p>
            <strong>Tipo:</strong><br>
            @if ($project->type)
              {!! $project->type->getBadgeHTML() !!}
            @else 
              Untyped           
            @endif        
          </p>
        </div>

        <div class="col-3">
          <p>
            <strong>Technologies:</strong><br>
            @forelse ($project->technologies as $technology)
                {!! $technology->getBadgeHTML() !!}
            @empty
              No technology associated 
            @endforelse  
        </p>
        </div>

        <div class="col-3">
          <p>
            <strong>Created: </strong> <br>{{ $project->created_at }}
        </p>
        </div>

        <div class="col-3">
          <p>
            <strong>Last edit: </strong> <br>{{ $project->updated_at }}
        </p>
        </div>
      </div>
      

      

      <p>
        <strong>Contenuto:</strong>

        <p>{{ $project->link}}</p>
        <p>{{ $project->text}}</p>
      </p>  
    </div>
  </section>  
@endsection
    
  
    
