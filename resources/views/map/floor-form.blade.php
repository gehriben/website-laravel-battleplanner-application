<!--
<div id="sample-floor" class="form-group d-none">
    <h3 class="text-center">Add Floor to list</h3>
    <div class="col-12 text-center new-floor-block row">
        <input type="file" class="col-sm form-control" id="add-floor-file" required>
        <input type="hidden" class="col-sm form-control" value="" name="floor-id[]">
        <input type="text" class="col-sm  form-control" id="add-floor-name" aria-describedby="emailHelp" placeholder="Floor Name" required>
    </div>
</div> -->

@if(!$floorId)
<li id="sample-floor-form" class="d-none text-center row justify-content-center" id="floor-0">
@else
<li class="text-center row justify-content-center" id="floor-0">
@endif
  <input type="file" class="col-12 col-md-3 form-control" id="add-floor-file" name="floor-files[]">
  <input type="text" class="col-12 col-md-3  form-control" id="add-floor-name" aria-describedby="emailHelp" value="{{$floorName}}" placeholder="Floor Name" required="" name="floor-names[]">
  <input type="number" class="col-12 col-md-3 form-control" id="floor-number" value="{{$floorId}}" name="floor-id[]">
  <button type="button" class="btn btn-secondary" onclick="del(this)">Delete</button>

  @if($floorPreview)
  <img class="floor-thumbnail-preview" src="{{$floorPreview}}" alt="">
  @endif
</li>
