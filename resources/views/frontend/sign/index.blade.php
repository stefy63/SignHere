@extends('frontend.front')
@push('assets')
<style>
.tab-right tbody{
    overflow-y: auto;
    //height: 85%;
    //position: absolute;
}

.tab-left tbody{
    overflow-y: auto;
    //height: 85%;
    //position: absolute;
}
</style>
@endpush
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins col-lg-12">
            <div class="ibox-content col-lg-12">
                <div class="col-lg-5 full-height">
                    <div class="ibox-title">
                        <h5>{{__('sign.archive-title')}}</h5>
                        <!--<div id="DataTables_Table_0_filter" class="dataTables_filter">
                            <input type="search" class="form-control input-sm" placeholder="Search..." aria-controls="DataTables_Table_2">
                        </div>-->
                    </div>
                    <div>
                        <table class="table table-bordered table-hover tab-left" >
                            <thead>
                                <tr>
                                    <th class="col-md-5">{{__('sign.index-header-col-0')}}</th>
                                    <th class="col-md-2">{{__('sign.index-header-col-1')}}</th>
                                    <th class="col-md-5">{{__('sign.index-header-col-2')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($archives as $archive)
                                <tr class="bg-info tr-client" id="{{$archive->id}}">
                                    <td class="col-md-5"><i class="fa fa-user"> {{$archive->surname}}&nbsp;{{$archive->name}}</i></td>
                                    <td class="col-md-2">@if($archive->mobile){{$archive->mobile}}@else{{$archive->phone}}@endif</td>
                                    <td class="col-md-5">{{$archive->email}} <i class="fa fa-chevron-down pull-right"></i></td>
                                </tr>
                                @foreach($archive->dossiers()->get() as $dossier)
                                <tr class="bg-warning tr-dossier dossier-{{$archive->id}}" data-dossier="{{$dossier->id}}"  id="{{$dossier->id}}" style="display: none">
                                    <td colspan="3"><i class="fa fa-archive"></i> {{$dossier->name}}<i class="fa fa-chevron-down pull-right"></i></td>
                                </tr>
                                    @foreach($dossier->documents()->get() as $document)
                                    <tr class="bg-success tr-document document-{{$dossier->id}}"  data-document="{{$document->id}}" id="{{$document->id}}" style="display: none">
                                        <td colspan="3">
                                            @if($document->signed)
                                                <i class="fa fa-check-square-o" style="color: green;"></i>&nbsp;&nbsp;{{$document->name}}
                                            @else
                                                <i class="fa fa-minus-square-o" style="color: red;"></i>&nbsp;&nbsp;{{$document->name}}
                                            @endif
                                        <div class="pull-right">
                                            @if($document->signed)
                                                <a data-message="{{__('sign.confirm_send')}}" data-location="{{url('sign/send/'.$document->id)}}" class="confirm-toast"><i class="fa fa-envelope-o"></i></a>&nbsp;&nbsp;
                                            @endif
                                            <a href="{{Storage::disk('documents')->url($document->filename) }}" target="_blank"><i class="fa fa-download"></i></a>
                                        </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                @endforeach
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="pull-right">{{ $archives->links() }}</div>
                </div>
                <div class="col-lg-7 full-height">
                    <div class="ibox-title">
                        <h5>{{__('sign.sign-title')}}</h5>
                    </div>
                    <div>
                        <table class="table table-bordered table-hover tab-right">
                            <thead>
                                <tr role="row">
                                    <th class="col-md-5">{{__('sign.index-header-col-0')}}</th>
                                    <th class="col-md-2">{{__('sign.index-header-col-1')}}</th>
                                    <th class="col-md-5">{{__('sign.index-header-col-2')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($clients as $client)
                                <tr class="bg-info tr-client" id="{{$client->id}}">
                                    <td class="col-md-5"><i class="fa fa-user"> {{$client->surname}}&nbsp;{{$client->name}}</i></td>
                                    <td class="col-md-2">@if($client->mobile){{$client->mobile}}@else{{$client->phone}}@endif</td>
                                    <td class="col-md-5">{{$client->email}} <i class="fa fa-chevron-down pull-right"></i></td>
                                </tr>
                                @foreach($client->dossiers()->get() as $dossier)
                                <tr class="bg-warning tr-dossier dossier-{{$client->id}}" data-dossier="{{$dossier->id}}" id="{{$dossier->id}}" style="display: none">
                                    <td colspan="3"><i class="fa fa-archive"></i> {{$dossier->name}}<i class="fa fa-chevron-down pull-right"></i></td>
                                </tr>
                                    @foreach($dossier->documents()->get() as $document)
                                    <tr class="bg-success tr-document document-{{$dossier->id}}" data-document="{{$document->id}}" id="{{$document->id}}" style="display: none">
                                        <td colspan="3">
                                            @if($document->signed)
                                                <i class="fa fa-check-square-o" style="color: green;"></i>&nbsp;&nbsp;{{$document->name}}
                                            @else
                                                <i class="fa fa-minus-square-o" style="color: red;"></i>&nbsp;&nbsp;{{$document->name}}
                                            @endif
                                            <div class="pull-right">
                                                @if($document->signed)
                                                    <a data-message="{{__('sign.confirm_send')}}" data-location="{{url('sign/send/'.$document->id)}}" class="confirm-toast"><i class="fa fa-envelope-o"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
                                                @else
                                                    <a href="{{url('sign/signing/'.$document->id)}}"><i class="fa fa-pencil-square-o"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
                                                @endif
                                                <a href="{{Storage::disk('documents')->url($document->filename) }}" target="_blank"><i class="fa fa-download"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
                                                <a data-message="{{__('sign.confirm_delete')}}" data-location="{{url('sign/destroy/'.$document->id)}}" class="confirm-toast"><i class="fa fa-trash-o text-danger"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                @endforeach
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="pull-right">{{ $clients->links() }}</div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
$(function () {

    $('.tr-client, .tr-dossier, .tr-document').hover(function() {
            $(this).css('cursor','pointer');
        }, function() {
            $(this).css('cursor','auto');
        });

    $('.tr-client').click(function(e){
        e.stopPropagation();
        if($('.tr-dossier').is(':visible')) $('.tr-dossier').hide();
        if($('.tr-document').is(':visible')) $('.tr-document').hide();
        var id = this.id;
        ($(this).parent().find('.dossier-'+id).is(':visible'))?
                $(this).parent().find('.dossier-'+id).hide():
                $(this).parent().find('.dossier-'+id).show();
    });

    $('.tr-dossier').click(function(e){
        e.stopPropagation();
        if($('.tr-document').is(':visible')) $('.tr-document').hide();
        var dossier = this.id;
        ($(this).parent().find('.document-'+dossier).is(':visible'))?
                $(this).parent().find('.document-'+dossier).hide():
                $(this).parent().find('.document-'+dossier).show();
    });

    $('.tr-document').click(function(e){
        e.stopPropagation();
        //$(this).dblclick();
    });

    $('.tr-document').dblclick(function(e){
        e.stopPropagation();
        var location = '{{url('sign/signing')}}'+'/'+this.id;
        console.log(location);
        window.location.replace(location)
    });

    $('.content').click(function(e){
        e.preventDefault();
        $('.tr-dossier').hide(500);
        $('.tr-document').hide(500);
    });



})
    
</script>

@endsection