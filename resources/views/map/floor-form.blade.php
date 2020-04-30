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
    <li id="sample-floor-form" class="d-none col-12 text-center row" id="floor-0">
@else
    <li class="col-12 text-center row" id="floor-0">
@endif
    <i class="fas fa-bars"></i>
    <input type="file" class="col-sm form-control" id="add-floor-file" name="floor-files[]">
    <input type="hidden" class="col-sm form-control" value="{{$floorId}}" name="floor-id[]">
    <input type="text" class="col-sm  form-control" id="add-floor-name" aria-describedby="emailHelp" value="{{$floorName}}" placeholder="Floor Name" required="" name="floor-names[]">
    <i class="fas fa-trash-alt" onclick="del('floor-0')"></i>
    
    @if($floorPreview)
        <img class="floor-thumbnail-preview" src="{{$floorPreview}}" alt="">
    @endif
</li>
