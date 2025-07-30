@extends('layouts.admin')

@section('title', 'Gestion des Services - SAFIR Admin')

@section('content')
    <div class="admin-page-header">
        <div>
            <h1 class="admin-page-title">Gestion des Services</h1>
            <p class="admin-page-subtitle">Gérez tous les services proposés par l'agence SAFIR</p>
        </div>
        <a href="{{ route('admin.services.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Nouveau Service
        </a>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Liste des Services ({{ $services->count() }})</h5>
            <div class="d-flex gap-2">
                <input type="text" class="form-control form-control-sm table-search" placeholder="Rechercher..." style="width: 200px;">
            </div>
        </div>
        <div class="card-body p-0">
            @if($services->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th class="sortable">Titre</th>
                                <th>Description courte</th>
                                <th>Prix</th>
                                <th>Statut</th>
                                <th>Créé le</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($services as $service)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="{{ $service->icon ?? 'bi bi-grid-3x3-gap' }} me-2 text-primary"></i>
                                            <strong>{{ $service->title }}</strong>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-muted">
                                            {{ Str::limit($service->short_description, 50) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($service->price)
                                            @if(is_numeric($service->price))
                                                <span class="badge bg-success">{{ number_format($service->price) }} FCFA</span>
                                            @else
                                                <span class="badge bg-info">{{ $service->price }}</span>
                                            @endif
                                        @else
                                            <span class="text-muted">Sur devis</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($service->is_active)
                                            <span class="badge bg-success">Actif</span>
                                        @else
                                            <span class="badge bg-secondary">Inactif</span>
                                        @endif
                                        @if($service->is_featured)
                                            <span class="badge bg-warning ms-1">En vedette</span>
                                        @endif
                                    </td>
                                    <td class="text-muted">
                                        {{ $service->created_at->format('d/m/Y') }}
                                    </td>
                                    <td class="text-end">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('services.show', $service) }}" class="btn btn-sm btn-outline-info" target="_blank" title="Voir sur le site">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-sm btn-outline-primary" title="Modifier">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-grid-3x3-gap text-muted" style="font-size: 3rem;"></i>
                    <h5 class="mt-3 text-muted">Aucun service trouvé</h5>
                    <p class="text-muted">Commencez par créer votre premier service.</p>
                    <a href="{{ route('admin.services.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i>Créer un service
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection