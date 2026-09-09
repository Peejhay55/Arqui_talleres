@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
<h1>{{ $viewData['title'] }}</h1>

@if ($viewData['humans']->count() < 2)
  <div class="alert alert-warning mt-4">Se necesitan al menos dos humanos para iniciar una batalla.</div>
@else
  <div class="row mt-4">
    @foreach ($viewData['humans'] as $human)
      <div class="col-md-6">
        <div class="card mb-3">
          <div class="card-body">
            <h2 class="card-title">{{ $human->getName() }}</h2>
            <p class="card-text">Cantidad de aura: {{ $human->getAura() }}</p>
          </div>
        </div>
      </div>
    @endforeach
  </div>
  <div class="alert alert-info">{{ $viewData['battleResult'] }}</div>
@endif
@endsection
