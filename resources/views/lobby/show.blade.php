@extends('layouts.main')

@push('js')

<script type="text/javascript">
    const LOBBY = {!! json_encode($lobby->toArray(), JSON_HEX_TAG) !!}

    $.ajax({
        method: "POST",
        url: `/lobby/${LOBBY["connection_string"]}/request-battleplan`,
        data: {},
        success: function (result) {
            console.log(result);
        }.bind(this),
        
        error: function (result) {
            console.log(result);
        }

    });
    
</script>
@endpush

@push('css')

@endpush

@section('content')
<?php phpinfo(); ?>
hello world?!

@endsection

@push('modals')

@endpush
