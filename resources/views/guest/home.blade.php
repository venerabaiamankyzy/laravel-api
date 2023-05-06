@extends('layouts.guest')
@section('content')

@section('content')
<div class="container">
    <h2 class="fs-4 text-secondary my-4">
        {{ __('Dashboard') }}
    </h2>
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header">Progetti piu recenti</div>

                <div class="card-body">  
									<div class="card"></div>
									@forelse ( $recent_projects as  $recent_project)
											<h1>{{ $recent_project->title}}</h1>
											<p>{{ $recent_project->text}}</p>
											<img src="{{ $recent_project->image}}" alt="">
											<p>{{ $recent_project->link}}</p>
											@if ($recent_project->type)
											{!! $recent_project->type->getBadgeHTML() !!}
											@else 
											Untyped           
											@endif 
											<p>{{ $recent_project->type->label}}</p>
									@empty           
                 	@endforelse   
                 @dump($recent_projects)
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@endsection