<div class="row text-center">
  @foreach($atk_operators as $operator)
    @if($operator)
      <div class="col-md-3 col-xs-12 top-buffer cursor-click" data-toggle="modal" data-target="#opModal" onclick="app.engine.changeOperatorSlot($('#EditingOperatorSlot').val(),{{$operator->id}})">
          <div class="container text-center map-container">

              <div class="row">
                  <div class="col-12">
                    <img src="{{$operator->icon}}" class="map-thumb">
                  </div>
              </div>

              <div class="row">
                <div class="col-12">
                    <div class="map-name stroke-text">
                      {{ucwords($operator->name)}}
                    </div>
                </div>
              </div>

          </div>
      </div>
    @endif
  @endforeach
</div>
