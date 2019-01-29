<div class="card mb-3">
    <div class="card-header gemah-bg-primary">
        {{ $title }}
    </div>

    <div class="card-body">
        <a href="{{ route( $route, $id) }}" type="btn" class="btn btn-outline-primary" target="_blank">
            <i class="fas fa-arrow-alt-circle-left"></i>
            Accéder à {{ $nom }}
        </a>
    </div>
</div>