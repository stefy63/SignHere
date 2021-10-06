<!-- DOSSIERS  -->
    
        <input type="hidden" id="dossier_id" value="0" />
        <table class="table table-bordered table-hover" id="tr-dossier">
            <thead>
                <tr>
                    <th class="col-lg-10 col-md-10 col-xs-10"></th>
                    <th class="col-lg-2 col-md-2 col-xs-2"></th>
                </tr>
            </thead>
            <tbody>
            @foreach($dossiers as $dossier)
                <tr class="tab-dossier" id="{{$dossier->id}}">
                    <td>
                       <i class="fa fa-archive"></i> {{$dossier->name}}
                    </td>
                    <td class="text-center">
                        @if(Auth::user()->hasRole('admin_documents','edit'))<a data-url="{{ url('admin_dossiers/')}}/{{$dossier->id}}/edit" class="href"><i class="fa fa-pencil"></i></a>@endif
                        @if(Auth::user()->hasRole('admin_documents','export'))<a data-url="{{ url('admin_dossiers/export/'.$dossier->id)}}" class="href text-warning text-center"><i class="fa fa-file-excel-o"></i></a>@endif
                        @if(Auth::user()->hasRole('admin_documents','destroy'))<a class="tab-dossier_a OK-button"><i class="text-danger fa fa-trash-o"></i></a>@endif
                    </td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th class="col-lg-10 col-md-10 col-xs-10"></th>
                    <th class="col-lg-2 col-md-2 col-xs-2"></th>
                </tr>
            </tfoot>
        </table>
        <div class="text-center">{{ $dossiers->links() }}</div>
