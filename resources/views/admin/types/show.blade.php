@extends('layouts.app')

@section('title', $type->label)
    
@section('actions')
<div class="d-flex justify-content-end my-4 mx-3">
  <a href="{{ route('admin.types.index')}}" class="btn btn-success text-end">Back to type list</a>
  <a href="{{ route('admin.types.edit', $type)}}" class="btn btn-success text-end mx-2">Modify Type</a>
</div>
@endsection

@section('content')
  <section class="card">    
    <div class="card-body">
      
      <p>
        <strong>Type: </strong>
        <span class="badge rounded-pill" style="background-color: {{ $type->color}} ">{{ $type->label }}</span>
      </p>  
    </div>
  </section>  
@endsection
    
  
    
