@extends('layouts.admin')

@section('title', 'Gestion des Encadreurs - SAFIR Admin')

@section('content')
    <div class="admin-page-header">
        <div>
            <h1 class="admin-page-title">Gestion des Encadreurs</h1>
            <p class="admin-page-subtitle">Gérez tous les encadreurs de l'agence SAFIR</p>
        </div>
        <a href="{{ route('admin.encadreurs.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Nouvel Encadreur
        </a>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Liste des Encadreurs ({{ $encadreurs->count() }})</h5>
            <div class="d-flex gap-2">
                <input type="text" class="form-control form-control-sm table-search" placeholder="Rechercher..." style="width: 200px;">
            </div>
        </div>
        <div class="card-body p-0">
            @if($encadreurs->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th class="sortable">Nom complet</th>
                                <th>Téléphone</th>
                                <th>Email</th>
                                <th>Spécialités</th>
                                <th>Statut</th>
                                <th>Créé le</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($encadreurs as $encadreur)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-person-circle me-2 text-primary"></i>
                                            <strong>{{ $encadreur->full_name }}</strong>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-muted">{{ $encadreur->phone_1 }}</span>
                                    </td>
                                    <td>
                                        @if($encadreur->email)
                                            <a href="mailto:{{ $encadreur->email }}" class="text-decoration-none">
                                                {{ $encadreur->email }}
                                            </a>
                                        @else
                                            <span class="text-muted">Non renseigné</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($encadreur->specialties)
                                            <span class="badge bg-info">{{ Str::limit($encadreur->specialties, 30) }}</span>
                                        @else
                                            <span class="text-muted">Non renseigné</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($encadreur->is_active)
                                            <span class="badge bg-success">Actif</span>
                                        @else
                                            <span class="badge bg-secondary">Inactif</span>
                                        @endif
                                    </td>
                                    <td class="text-muted">
                                        {{ $encadreur->created_at->format('d/m/Y') }}
                                    </td>
                                    <td class="text-end">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.encadreurs.edit', $encadreur) }}" class="btn btn-sm btn-outline-primary" title="Modifier">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.encadreurs.destroy', $encadreur) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet encadreur ?')">
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
                    <i class="bi bi-person-circle text-muted" style="font-size: 3rem;"></i>
                    <h5 class="mt-3 text-muted">Aucun encadreur trouvé</h5>
                    <p class="text-muted">Commencez par créer votre premier encadreur.</p>
                    <a href="{{ route('admin.encadreurs.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i>Créer un encadreur
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection