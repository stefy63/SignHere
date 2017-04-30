@extends('frontend.front')
@push('assets')
<style>
#table-clients tr {
    width: 100%;
    display: inline-table;
    table-layout: fixed;
}

#table-clients table{
    #width: 100%;
    #height:300%;
    display: -moz-groupbox;
}

#table-clients tbody{
    overflow-y: scroll;
    height: 70%;
    #width: 90%;
    position: absolute;
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
                        <div id="DataTables_Table_0_filter" class="dataTables_filter">
                            <input type="search" class="form-control input-sm" placeholder="Search..." aria-controls="DataTables_Table_2">
                        </div>
                    </div>
                    <div>
                        <table class="table table-bordered table-hover" >
                            <thead>
                                <tr role="row">
                                    <th class="col-md-5">{{__('sign.index-header-col-0')}}</th>
                                    <th class="col-md-2">{{__('sign.index-header-col-1')}}</th>
                                    <th class="col-md-5">{{__('sign.index-header-col-2')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($archives as $archive)
                                <tr class="bg-info tr-client" id="{{$archive->id}}">
                                    <td>{{$archive->surname}}&nbsp;{{$archive->name}}</td>
                                    <td>@if($archive->mobile){{$archive->mobile}}@else{{$archive->phone}}@endif</td>
                                    <td>{{$archive->email}}</td>
                                </tr>
                                @foreach($archive->dossiers()->get() as $dossier)
                                <tr class="bg-warning tr-dossier dossier-{{$archive->id}}" data-dossier="{{$dossier->id}}"  id="{{$dossier->id}}" style="display: none">
                                    <td colspan="3">{{$dossier->name}}</td>
                                </tr>
                                    @foreach($dossier->documents()->get() as $document)
                                    <tr class="bg-success tr-document document-{{$dossier->id}}"  data-document="{{$document->id}}" id="{{$document->id}}" style="display: none">
                                        <td colspan="3" @if($document->signed)class="text-line-through text-danger"@endif>{{$document->name}}
                                        <div class="pull-right">
                                            <a href="{{ asset('storage')}}/documents/{{$document->filename}}" target="_blank"><i class="fa fa-file-o"></i></a>
                                        </div>
                                    </tr>
                                    @endforeach
                                @endforeach
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="pull-right">{{ $archives->links() }}</div>
                </div>
                <div class="col-lg-7 half-height">
                    <div class="ibox-title">
                        <h5>{{__('sign.sign-title')}}</h5>
                    </div>
                    <div >
                        <table class="table table-bordered table-hover" id="table-clients" >
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
                                    <td>{{$client->surname}}&nbsp;{{$client->name}}</td>
                                    <td>@if($client->mobile){{$client->mobile}}@else{{$client->phone}}@endif</td>
                                    <td>{{$client->email}}</td>
                                </tr>
                                @foreach($client->dossiers()->get() as $dossier)
                                <tr class="bg-warning tr-dossier dossier-{{$client->id}}" data-dossier="{{$dossier->id}}" id="{{$dossier->id}}" style="display: none">
                                    <td colspan="3">{{$dossier->name}}</td>
                                </tr>
                                    @foreach($dossier->documents()->get() as $document)
                                    <tr class="bg-success tr-document document-{{$dossier->id}}" data-document="{{$document->id}}" id="{{$document->id}}" style="display: none">
                                        <td colspan="3" @if($document->signed)class="text-line-through text-danger"@endif>{{$document->name}}
                                        <div class="pull-right">
                                            <a href="{{ asset('storage')}}/documents/{{$document->filename}}" target="_blank"><i class="fa fa-file-o"></i></a>
                                            &nbsp;&nbsp;&nbsp;
                                            <a data-message="{{__('sign.confirm_delete')}}" data-location="{{url('sign/destroy/'.$document->id)}}" class="confirm-toast"><i class="fa fa-trash-o text-danger"></i></a>
                                        </div>
                                    </tr>
                                    @endforeach
                                @endforeach
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="pull-right">{{ $clients->links() }}</div>
                </div>
                <div class="col-lg-7 half-height">
                    <div class="ibox-title">
                        <h5>{{__('sign.last-title')}}</h5>
                    </div>

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
                $(this).parent().find('.dossier-'+id).show(500);
    });

    $('.tr-dossier').click(function(e){
        e.stopPropagation();
        if($('.tr-document').is(':visible')) $('.tr-document').hide();
        var dossier = this.id;
        ($(this).parent().find('.document-'+dossier).is(':visible'))?
                $(this).parent().find('.document-'+dossier).hide():
                $(this).parent().find('.document-'+dossier).show(500);
    });

    $('.tr-document').click(function(e){
        e.stopPropagation();

    });

    $('.tr-document').dblclick(function(e){
        e.stopPropagation();
        //alert('procedura di firma digitale');
        var location = '{{url('sign/signing')}}'+'/'+this.id;
        console.log(location);
        window.location.replace(location)
    });
    $('div').click(function(e){
        //e.preventDefault();
        $('.tr-dossier').hide(500);
        $('.tr-document').hide(500);
    });



})
    
</script>

@endsection