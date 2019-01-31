<div class="col-12 mb-3">
    <div class="card">
        <div class="card-header gemah-bg-primary d-flex justify-content-between align-items-center">
            {{ $title }}
            <a data-toggle="collapse" href="#{{$id}}" aria-expanded="true"
               aria-controls="{{$id}}" id="filtre" style="text-decoration:none; color:#FFFFFF">
                <i class="fa fa-chevron-down pull-right"></i>
            </a>
        </div>
        <div id="{{$id}}" class="collapse card-body" aria-labelledby="filtre">
            <div class="table-responsive">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>