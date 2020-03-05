<div class="competitive">
    <h1>
        <strong>
            <center>Saved Maps</center>
        </strong>
    </h1>
</div>
<hr>
<div class="row">
    <div class="col-12">

        <table id="battleplan_load_table" style="width:100%">
            <thead>
                <tr>
                    <th>Map</th>
                    <th>Name</th>
                    <th>Functions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($battleplans as $battleplan)
                <tr>
                    <td>{{ucwords($battleplan->map->name)}}</td>
                    <td>{{$battleplan->name}}</td>
                    <td>
                        <div class="row">
                            <div class="col-12">
                                <button type="button" class="btn btn-danger col-12" onclick="app.engine.deleteBattlePlan({{$battleplan->id}})">Delete</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="button" class="btn btn-success col-12" onclick="app.engine.loadBattlePlan({{$battleplan->id}})" data-dismiss="modal">Load</button>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>
