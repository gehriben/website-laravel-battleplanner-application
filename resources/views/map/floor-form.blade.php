@if(!$floorId)
<li id="sample-floor-form" class="d-none text-center row justify-content-center mb-2" id="floor-0">
@else
<li class="text-center row justify-content-center mb-2" id="floor-0">
@endif
  @if($floorPreview)
  <img class="col-auto d-none d-md-block floor-thumbnail-preview" src="{{$floorPreview}}" alt="">
  @endif
  <input type="hidden" name="floor-ids[]" value="{{$floorId}}">
  <input type="file" class="col-6 col-xl-3 form-control" id="add-floor-file" name="floor-files[]">
  <input type="text" class="col-4 col-xl-3  form-control" id="add-floor-name" aria-describedby="emailHelp" value="{{$floorName}}" placeholder="Floor Name" required="" name="floor-names[]">
  <input type="number" class="col-4 col-xl-3 form-control" id="floor-number" required value="{{$floorOrder}}" name="floor-orders[]">
  <button type="button" class="btn btn-secondary" onclick="del(this)">Delete</button>
</li>
