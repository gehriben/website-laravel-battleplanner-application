<div class="row text-center">
  @foreach($def_operators as $operator)
    @if($operator)
        {{-- {{dd($room->Owner == Auth::User())}} --}}
      @if ($room->Owner == Auth::User())
          <div class="col-md-3 col-xs-12 top-buffer cursor-click" data-toggle="modal" data-target="#opModal" onclick="app.engine.changeOperatorSlot($('#EditingOperatorSlot').val(),{{$operator->id}})">
      @else
          <div class="col-md-3 col-xs-12 top-buffer">
      @endif
            <div class="container text-center map-container">
            <img src="{{$operator->icon}}" class="map-thumb">
            <div class="map-name stroke-text">
              {{ucwords($operator->name)}}
            </div>
          </div>
      </div>
    @endif
  @endforeach
</div>
