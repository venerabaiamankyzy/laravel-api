@extends('layouts.app')

@section('title', $type->id ? 'Modify Type ' . $type->label : 'Create Type')
    
@section('actions')
<div class="d-flex justify-content-end my-4 mx-3">
  <a href="{{ route('admin.types.index')}}" class="btn btn-success text-end mx-1">Back to list</a>
  
  {{-- @if ($type->id)
    <a 
      href="{{ route('admin.types.show', $type)}}" class="btn btn-success text-end mx-1">Show type
    </a>
  @endif --}}
</div>
@endsection

    
@section('content')

  @include('layouts.partials.errors')

  <section class="card py-2">
    <div class="card-body">
      @if ($type->id)
      <form 
        method="POST"
        action="{{ route('admin.types.update', $type) }}"
        enctype="multipart/form-data"
        class="row gy-4 gx-5 p-4">
        @method('put')
        @else 
          <form action="{{ route('admin.types.store')}}" enctype="multipart/form-data" method="POST" class="row">
        @endif

        @csrf
        <div class="row mb-3">
          <div class="col-md-2 text-end">
            <label for="label"  class="form-label">Label</label>
          </div>

          <div class="col-md-10">
            <input 
            type="text" 
            class="form-control @error('label') is-invalid @enderror" 
            id="label" 
            name="label" 
            value="{{ old('label', $type->label)}}">

            @error('label')
              <div class="invalid-feedback">
                {{ $message}}
              </div>  
            @enderror
          </div>  
        </div>

        <div class="row mb-3">
          <div class="col-md-2 text-end">
            <label for="color"  class="form-color">Color</label>
          </div>

          <div class="col-md-10">
            <input 
            type="color" 
            class="form-control @error('color') is-invalid @enderror" 
            id="color" 
            name="color" 
            value="{{ old('color', $type->color)}}">

            @error('color')
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
  
        
      
  