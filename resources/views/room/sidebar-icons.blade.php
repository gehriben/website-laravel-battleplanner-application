<input type="text" id="iconInput" class="col-12" onkeyup="search('iconInput', 'iconList')" placeholder="Search by names..">

<ul id="iconList">
    @foreach ($gadgets as $key => $gadget)
      @if($gadget->icon)
        <li>
          <img src="{{$gadget->icon}}" draggable="true" ondragstart="app.engine.drag(event)"  alt="" height="50px" width="50px">
          <a href="#">{{$gadget->name}}</a>
        </li>
      @endif
    @endforeach
</ul>

@push('js')
  <script>
    function search(inputBar, listToSearch) {
        // Declare variables
        var input, filter, ul, li, a, i;
        input = document.getElementById(inputBar);
        filter = input.value.toUpperCase();
        ul = document.getElementById(listToSearch);
        li = ul.getElementsByTagName('li');

        // Loop through all list items, and hide those who don't match the search query
        for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("a")[0];
            if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
                li[i].style.display = "";
            } else {
                li[i].style.display = "none";
            }
        }
    }
    </script>
@endpush
