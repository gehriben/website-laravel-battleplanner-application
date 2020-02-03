@extends('layouts.main')

@push('js')
  <script src="{{asset("js/battleplan/index.js")}}"></script>
  <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" charset="utf-8"></script>

  <script>
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
        $('.datatable').DataTable({
        "order": [[ 0, "desc" ]]
      });
    });
  </script>
@endpush

@push('css')
  <link rel="stylesheet" href="{{asset("css/battleplan/index.css")}}">
  <link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
  <style media="screen">
      .black-border{
          text-shadow: 2px 0 0 #000, 0 -1px 0 #000, 0 1px 0 #000, -1px 0 0 #000;
      }
  </style>
@endpush

@section('content')

  <div class="row">
    <div class="col-12 text-center">
      <h1>Public Battleplans</h1>
    </div>
  </div>

  <div class="row">
    <div class="col-12 text-center">

        <table id="battleplan_load_table" class="datatable" style="width:100%">
            <thead>
                <tr>
                    <th>Total Votes</th>
                    <th>Functions</th>
                    <th>ID</th>
                    <th>Map</th>
                    <th>Name</th>
                    <th>Creator</th>
                </tr>
            </thead>
            <tbody>
                @foreach($battleplans as $battleplan)
                <tr>

                    <td id="vote-value-{{$battleplan->id}}">{{$battleplan->voteSum()}}</td>

                     <td>
                            @if(Auth::user())

                      @if ($battleplan->voted(1))
                        <i class="fas fa-arrow-circle-up cursor-click vote-green" id="vote-up-{{$battleplan->id}}" onclick="vote(1,{{$battleplan->id}}, this)" data-toggle="tooltip" data-placement="top" title="Up Vote"></i>
                      @else
                        <i class="fas fa-arrow-circle-up cursor-click" id="vote-up-{{$battleplan->id}}" onclick="vote(1,{{$battleplan->id}}, this)" data-toggle="tooltip" data-placement="top" title="Up Vote"></i>
                      @endif

                       |

                      @if ($battleplan->voted(-1))
                        <i class="fas fa-arrow-circle-down cursor-click vote-red" id="vote-down-{{$battleplan->id}}" onclick="vote(-1,{{$battleplan->id}}, this)" data-toggle="tooltip" data-placement="top" title="Down Vote"></i>
                      @else
                        <i class="fas fa-arrow-circle-down cursor-click" id="vote-down-{{$battleplan->id}}" onclick="vote(-1,{{$battleplan->id}}, this)" data-toggle="tooltip" data-placement="top" title="Down Vote"></i>
                      @endif

                      |

                      <i class="fas fa-clone cursor-click" id="copy-{{$battleplan->id}}" data-toggle="tooltip" data-placement="top" title="Copy to my account" onclick="copyModal({{$battleplan->id}})"></i>

                      |

                      @endif
                     <a href="/battleplan/{{$battleplan->id}}">View Plan</a>

                    </td>

                    <td>{{$battleplan->id}}</td>
                    <td>{{ucwords($battleplan->map->name)}}</td>
                    <td>{{$battleplan->name}}</td>
                    <td>{{$battleplan->Owner->username}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
  </div>
@endsection

@push('modals')

<div class="modal" id="copy" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Copy Battleplan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="copy-id">
                <h2>Save battleplan as</h2>
                <input class="col-4 form-control inline col-12" id="battleplan_name" value="" type="text">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" name="button" class="btn btn-success" onclick="copy()">Copy</button>
            </div>
        </div>
    </div>
</div>

@endpush
