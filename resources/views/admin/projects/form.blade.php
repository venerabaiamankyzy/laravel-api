@extends('layouts.app')

@section('title', $project->id ? 'Modify Project' : 'Create project')
    
@section('actions')
<div class="d-flex justify-content-end my-4 mx-3">
  <a href="{{ route('admin.projects.index')}}" class="btn btn-success text-end mx-1">Back to list</a>
  
  @if ($project->id)
    <a 
      href="{{ route('admin.projects.show', $project)}}" class="btn btn-success text-end mx-1">Show project
    </a>
  @endif
</div>
@endsection

    
@section('content')

  @include('layouts.partials.errors')

  <section class="card py-2">
    <div class="card-body">
      @if ($project->id)
      <form 
        method="POST"
        action="{{ route('admin.projects.update', $project) }}"
        enctype="multipart/form-data"
        class="row gy-4 gx-5 p-4">
        @method('put')
        @else 
          <form action="{{ route('admin.projects.store')}}" enctype="multipart/form-data" method="POST" class="row">
        @endif

        @csrf
        <div class="row mb-3">
          <div class="col-md-2 text-end">
            <label for="title"  class="form-label">Title</label>
          </div>

          <div class="col-md-10">
            <input 
            type="text" 
            class="form-control @error('title') is-invalid @enderror" 
            id="title" 
            name="title" 
            value="{{ old('title', $project->title)}}">

            @error('title')
              <div class="invalid-feedback">
                {{ $message}}
              </div>  
            @enderror
          </div>  
        </div>

        <div class="row mb-3">
          <div class="col-md-2 text-end">
            <label for="type_id"  class="form-label">Type</label>
          </div>

          <div class="col-md-10">
            <select name="type_id" id="type_id" class="form-select @error('type_id') is-invalid @enderror>
              <option value="">Non tipizzato</option>
              @foreach ($types as $type)
                <option @if(old('type_id', $project->type_id) == $type->id) selected @endif value="{{ $type->id}}">{{ $type->label }}</option>
              @endforeach
            
            </select>
          </div>  
        </div>

        <div class="row mb-3">
          <div class="col-md-2 text-end">
            <label for="is_published"  class="form-label">Published</label>
          </div>

          <div class="col-md-10">
            <input 
            type="checkbox" 
            class="form-check-control @error('is_published') is-invalid @enderror" @checked(old('is_published', $project->is_published))
            value="1"
            id="is_published" 
            name="is_published">

            @error('is_published')
              <div class="invalid-feedback">
                {{ $message}}
              </div>  
            @enderror
          </div>  
        </div>
          
        <div class="row mb-3">
          <div class="col-md-2 text-end">
            <label for="image" class="form-label">Image</label>
          </div>
          
            <div class="col-md-8">
              <input 
                type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image"
              > 
              @error('image')
                <div class="invalid-feedback">
                  {{ $message}}
                </div>  
              @enderror
            </div>  

            <div class="col-md-2">
              <img src="{{ $project->getImageUri() }}" class="img-fluid" alt="" id="image-preview">
            </div>
          
        </div>
            
        <div class="row mb-3">
          <div class="col-md-2 text-end">
            <label for="text" class="form-label">Description</label>
          </div>
          <div class="col-md-10">
            <textarea name="text" id="text" class="form-control
               @error('text') is-invalid @enderror"
              rows="5">{{ old('text', $project->text) }}</textarea>
            @error('text')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
            @enderror
          </div>
        </div>
            
        <div class="row mb-3">
          <div class="col-md-2 text-end">
            <label for="link" class="form-label">Link</label>
          </div>
          <div class="col-md-10">
            <input type="text" 
              class="form-control @error('link') is-invalid @enderror" 
              id="link" 
              name="link" 
              value="{{ old('link', $project->link)}}">
            @error('link')
              <div class="invalid-feedback">
                {{ $message}}
              </div>  
            @enderror           
          </div>
        </div>  

        <div class="row">
          <div class="offset-2 col-8">
            <input type="submit" class="btn btn-outline-success" value="Save"/>
          </div>    
        </div>
      </form>  
    </div>      
  </section>           
@endsection
     {{-- is-invalid - il bordino rosso       --}}
   
@section('scripts')
  <script>
    const imageInputEl = document.getElementById('image');
    const imagePreviewEl = document.getElementById('image-preview');
    const placeholder = imagePreviewEl.src;

    imageInputEl.addEventListener('change', () => {
      if (imageInputEl.files && imageInputEl.files[0]) {
        const reader = new FileReader();
        reader.readAsDataURL(imageInputEl.files[0]);

        reader.onload = e => {
          imagePreviewEl.src = e.target.result;
        }
      } else imagePreviewEl.src = placeholder;
    })
  </script>
@endsection
        
        
      
  