@extends('layouts.main-bootstrap')

@push('js')

{{-- init --}}
<script type="text/javascript">
</script>
@endpush

@push('css')
<style>
body{
    color: white;
    background-color: black;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}
</style>
@endpush

@section('content')
<div class='row text-center mt-2'>
    <h2 class='col-12'>Contact Us!</h2>
</div>

<div class='row text-center mt-2'>
    <p class='col-12'>
        Having issues, want to submit maps or just want to ask us questions? Send us an email at <a href="mailto:battleplannerapp@gmail.com">Battleplannerapp@gmail.com</a>!
    </p>
</div>
@endsection

@push('modals')

@endpush
