<input type="text" id="opInput" class="col-12" onkeyup="search('opInput', 'opIconList')" placeholder="Search by names..">

<ul id="opIconList">
    @foreach($all_operators as $operator)
      @if($operator)
        <li>
          <img src="{{$operator->icon}}" draggable="true" ondragstart="app.engine.drag(event)"  alt="" height="50px" width="50px">
          <a href="#">{{$operator->name}}</a>
        </li>
      @endif
    @endforeach
</ul>
