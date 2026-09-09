@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
<h1>{{ $viewData['title'] }}</h1>

@if ($errors->any())
  <div class="alert alert-danger">
    <ul class="mb-0">
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

<form method="POST" action="{{ route('human.store') }}" class="mt-4">
  @csrf
  <div class="mb-3">
    <label class="form-label" for="name">Nombre</label>
    <input class="form-control" id="name" name="name" type="text" value="{{ old('name') }}" required>
  </div>
  <div class="mb-3">
    <label class="form-label" for="aura">Cantidad de aura</label>
    <input class="form-control" id="aura" name="aura" type="number" min="0" value="{{ old('aura') }}" required>
  </div>
  <div class="mb-3">
    <label class="form-label" for="hierarchy">Jerarquía</label>
    <select class="form-select" id="hierarchy" name="hierarchy" required>
      <option value="">Seleccione una jerarquía</option>
      @foreach ($viewData['hierarchies'] as $hierarchy)
        <option value="{{ $hierarchy }}" @selected(old('hierarchy') === $hierarchy)>{{ ucfirst($hierarchy) }}</option>
      @endforeach
    </select>
  </div>
  <button class="btn btn-primary" type="submit">Registrar humano</button>
</form>
@endsection
