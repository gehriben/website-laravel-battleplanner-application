<div class="row margin10">
    <div class="col-12">
        @if (Auth::user() == $room->Owner)
            @if ($room->battleplan && $room->battleplan->notes)
                <textarea class="form-control battleplan_notes" id="battleplan_notes">{{$room->battleplan->notes}}</textarea>
            @else
                <textarea class="form-control battleplan_notes" id="battleplan_notes"></textarea>
            @endif
        @else
            @if ($room->battleplan && $room->battleplan->notes)
                <textarea class="form-control battleplan_notes" id="battleplan_notes" disabled>{{$room->battleplan->notes}}</textarea>
            @else
                <textarea class="form-control battleplan_notes" id="battleplan_notes" disabled></textarea>
            @endif
        @endif
    </div>
</div>
