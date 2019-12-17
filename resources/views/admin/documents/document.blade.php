<!-- DOCUMENTS  -->
   
        <div class="">
            <input type="hidden" id="document_id" value="0"/>
            <table class="table table-bordered table-hover" id="tr-document">
                <thead>
                    <tr>
                        <th class="col-lg-1 col-md-1 col-xs-1"></th>
                        <th class="col-lg-9 col-md-9 col-xs-9"></th>
                        <th class="col-lg-2 col-md-2 col-xs-2"></th>
                    </tr>
                </thead>
                <tbody>
                @foreach($documents as $document)
                    <tr id="{{$document->id}}">
                        <td>
                            @if(Auth::user()->hasRole('admin_documents','show'))<a href="{{ asset('storage')}}/documents/{{$document->filename}}" target="_blank"><i class="fa fa-download"></i></a> @endif
                        </td>
                        <td class="@if($document->signed) text-line-through text-danger @endif" id="{{$document->id}}">
                            {{$document->name}}
                        </td>
                        <td>
                            @if(Auth::user()->hasRole('admin_documents','edit'))<a data-url="{{ url('admin_documents/')}}/{{$document->id}}/edit" class="href"><i class="fa fa-pencil"></i></a>@endif
                            @if(Auth::user()->hasRole('sign','send'))<a data-message="{{__('sign.confirm_send')}}" data-location="{{url('sign/send/'.$document->id)}}" class="confirm-toast"><i class="fa fa-envelope-o"></i></a>@endif
                            @if(Auth::user()->hasRole('admin_documents','destroy'))<a class="tab-document_a OK-button"><i class="text-danger fa fa-trash-o"></i></a>@endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th class="col-lg-1 col-md-1 col-xs-1"></th>
                        <th class="col-lg-9 col-md-9 col-xs-9"></th>
                        <th class="col-lg-2 col-md-2 col-xs-2"></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    