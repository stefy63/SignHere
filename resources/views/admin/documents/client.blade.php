<!-- CLIENTS  -->
<div>
    
    <input type="hidden" id="client_id" value="0"/>
    <table class="table table-bordered table-hover" id="tr-client" cellspacing="0">
        <thead>
            <tr>
                <th class="col-lg-12 col-md-12 col-xs-12"></th>
            </tr>
        </thead>
        <tbody class="tbody-client" >
        @foreach($clients as $client)
            <tr class="tab-client"  id="{{$client->id}}">
                <td>
                    <i class="fa fa-user"></i>&nbsp;&nbsp; {{$client->surname}} {{$client->name}}
                    @if(Auth::user()->hasRole('admin_clients','edit'))
                    <a data-url="{{ url('admin_clients/')}}/{{$client->id}}/edit" class="href"><i class="fa fa-pencil pull-right"></i></a>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th></th>
            </tr>
        </tfoot>
    </table>
    <div class="text-center">{{ $clients->links() }}</div>
</div>

