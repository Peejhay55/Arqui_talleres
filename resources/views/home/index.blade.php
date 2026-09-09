@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
<div class="text-center">
  <h1>Humanos farmeadores de aura</h1>
  <div class="d-flex flex-column gap-3 align-items-center mt-4">
    <a class="btn btn-primary" href="{{ route('human.create') }}">Registrar humanos</a>
    <a class="btn btn-secondary" href="{{ route('human.index') }}">Listar humanos</a>
    <a class="btn btn-dark" href="{{ route('human.battle') }}">Batalla de humanos</a>
  </div>
</div>
@endsection
