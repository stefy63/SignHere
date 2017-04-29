@extends('frontend.front')

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
                    <div id="DataTables_Table_2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                        <table class="table table-bordered table-hover" id="DataTables_Table_2">
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
                                        @if(!$document->readonly)<a href="{{ asset('storage')}}/documents/{{$document->filename}}" target="_blank"><i class="fa fa-file-o"></i></a>@endif
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
                <div class="col-lg-7">
                    <div class="ibox-title">
                        <h5>{{__('sign.sign-title')}}</h5>
                    </div>
                    <div >
                        <table class="table table-bordered table-hover " id="table-clients" >
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
                                        @if(!$document->readonly)<a href="{{ asset('storage')}}/documents/{{$document->filename}}" target="_blank"><i class="fa fa-file-o"></i></a>@endif
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
                <!--<div class="col-lg-8 half-height">
                    <div class="ibox-title">
                        <h5>{{__('sign.last-title')}}</h5>
                    </div>
                </div>-->
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
        if($('.tr-dossier').is(':visible')) $('.tr-dossier').hide(500);
        if($('.tr-document').is(':visible')) $('.tr-document').hide(500);
        var id = this.id;
        ($(this).parent().find('.dossier-'+id).is(':visible'))?
                $(this).parent().find('.dossier-'+id).hide(500):
                $(this).parent().find('.dossier-'+id).show(500);
    });

    $('.tr-dossier').click(function(e){
        e.stopPropagation();
        if($('.tr-document').is(':visible')) $('.tr-document').hide(500);
        var dossier = this.id;
        ($(this).parent().find('.document-'+dossier).is(':visible'))?
                $(this).parent().find('.document-'+dossier).hide(500):
                $(this).parent().find('.document-'+dossier).show(500);
    });

    $('.tr-document').click(function(e){
        e.stopPropagation();

    });

    $('.tr-document').dblclick(function(e){
        e.stopPropagation();
        alert('procedura di firma digitale');

    });
    $('div').click(function(e){
        //e.preventDefault();
        $('.tr-dossier').hide(500);
        $('.tr-document').hide(500);
    });



})
    
</script>

@endsection