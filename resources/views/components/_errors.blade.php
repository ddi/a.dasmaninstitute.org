<div class="alert d-flex bgc-red-l3 brc-red-m4 border-1 border-l-0 pl-3 radius-l-0" role="alert">
    <div class="position-tl h-102 border-l-4 brc-red mt-n1px"></div>
    <i class="fa fa-exclamation-triangle mr-3 text-180 text-danger-m2"></i>

    <span class="align-self-center text-dark-tp3 text-120">
        @foreach ($errors->all() as $error)
            {{ $error }}
        @endforeach
    </span>
</div>
