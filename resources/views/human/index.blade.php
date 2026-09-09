@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <h1>{{ $viewData['title'] }}</h1>
  <a class="btn btn-primary" href="{{ route('human.create') }}">Registrar humano</a>
</div>

@if (session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-striped">
  <thead>
    <tr>
      <th>Id</th>
      <th>Nombre</th>
      <th>Cantidad de aura</th>
      <th>Jerarquía</th>
    </tr>
  </thead>
  <tbody>
    @forelse ($viewData['humans'] as $human)
      <tr>
        <td>{{ $human->getId() }}</td>
        <td>{{ $human->getName() }} @if ($human->getHierarchy() === 'legendario')<strong>Boff</strong>@endif</td>
        <td class="{{ $human->getHierarchy() === 'común' ? 'text-primary' : '' }}">{{ $human->getAura() }}</td>
        <td>{{ ucfirst($human->getHierarchy()) }}</td>
      </tr>
    @empty
      <tr>
        <td colspan="4">No hay humanos registrados.</td>
      </tr>
    @endforelse
  </tbody>
</table>
@endsection
