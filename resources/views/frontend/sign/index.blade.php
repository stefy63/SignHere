@extends('frontend.front')
@push('scripts')
<!-- Spinner -->
<script src="{{ asset('js/g-spinner.min.js') }}"></script>

@endpush
@push('assets')
<!-- Spinner -->
<link href="{{ asset('css/gspinner.min.css') }}" rel="stylesheet">
<style>
.tab-right tbody{
    overflow-y: auto;
}

.tab-left tbody{
    overflow-y: auto;
}

table tr td {
    overflow: hidden;
    max-width: 20vw;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.filter-container {
    position: relative;
}

.clear_filter {
    color: lightskyblue;
    font-size: 20px;
    position: absolute;
    right: -10px;
    top: 17px;
    display: none;
}
</style>
@endpush
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins col-lg-12">
            <div class="ibox-content ">
                <!-- CLIENTI IN ATTESA DI FIRMA -->
                <div class="col-lg-7" id="client">

                    <div class="pull-right">
                      <div class="onoffswitch" >
                        <input type="checkbox" class="onoffswitch-checkbox"  id="show_archive">
                        <label class="onoffswitch-label" for="show_archive">
                            <span class="onoffswitch-inner"></span>
                            <span class="onoffswitch-switch"></span>
                        </label>
                      </div>
                    </div>

                    <div class="ibox-title">
                        <h5>{{__('sign.sign-title')}}</h5>
                        <div class="filter-container">
                            <input type="search" id="clientfilter" class="form-control input-sm" data-location="{{url('sign/')}}" value="{{Session::get('clientfilter')}}"  placeholder="Search..." data-name="clientfilter">
                            <button class="clear_filter btn btn-link">
                                <i class="fa fa-times-circle-o"></i>
                            </button>
                        </div>
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
                                <tr class="bg-info tr-client" id="{{$client->id}}" data-client="{{$client->id}}">
                                    <td class="col-md-5"><i class="fa fa-user"> {{$client->surname}}&nbsp;{{$client->name}}</i></td>
                                    <td class="col-md-2">@if($client->mobile){{$client->mobile}}@else{{$client->phone}}@endif</td>
                                    <td class="col-md-5">{{$client->email}} <i class="fa fa-chevron-down pull-right"></i></td>
                                </tr>
                                @foreach($client->dossiers()->get() as $dossier)
                                    <tr class="bg-warning tr-dossier dossier-{{$client->id}}" data-dossier="{{$dossier->id}}" id="{{$dossier->id}}" style="display: none">
                                        <td colspan="3">
                                            <i class="fa fa-archive"></i> {{$dossier->name}}
                                            <div class="pull-right">
                                                <i class="fa fa-chevron-down pull-right"></i>
                                            </div>
                                        </td>
                                    </tr>
                                    @foreach($dossier->documents()->get() as $document)
                                        <tr class="bg-success tr-document document-{{$dossier->id}}" data-document="{{$document->id}}" id="{{$document->id}}" style="display: none">
                                            <td colspan="3">
                                                @if($document->readonly || $document->signed)
                                                    <i class="fa fa-check-square-o" style="color: green;"></i>
                                                @else
                                                    <i class="fa fa-minus-square-o" style="color: red;"></i>
                                                @endif
                                                &nbsp;&nbsp;{{$document->name}}
                                                <div class="pull-right">
                                                        @if($document->readonly || $document->signed )
                                                            @if(Auth::user()->hasRole('sign','send'))
                                                            <a data-message="{{__('sign.confirm_send')}}" data-location="{{url('sign/send/'.$document->id)}}" class="sendmail" data-document="{{$document->id}}"><i class="fa fa-envelope-o"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
                                                            @endif
                                                        @else
                                                            @if(Auth::user()->hasRole('sign','sendsign'))
                                                                <a data-message="{{__('sign.confirm_send')}}" data-location="{{url('sign/signing_send/'.$document->id)}}" class="sendmail" data-document="{{$document->id}}"><i class="fa fa-paper-plane-o"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
                                                            @endif
                                                            @if(Auth::user()->hasRole('sign','signing'))
                                                                <a data-location="{{url('sign/signing/'.$document->id)}}" class="href" data-document="{{$document->id}}"><i class="fa fa-pencil-square-o"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
                                                            @endif
                                                        @endif
                                                    @if(Auth::user()->hasRole('sign','download'))
                                                        <a data-location="{{Storage::disk('documents')->url($document->filename) }}" target="_blank" class="href" data-document="{{$document->id}}"><i class="fa fa-download"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
                                                    @endif
                                                    @if(Auth::user()->hasRole('sign','destroy'))
                                                        <a data-message="{{__('sign.confirm_delete')}}" data-location="{{url('sign/destroy/'.$document->id)}}" class="confirm-toast" data-document="{{$document->id}}"><i class="fa fa-trash-o text-danger"></i></a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center">{{ $clients->links() }}</div>
                </div>
                <!-- ARCHIVIO CLIENTI  -->

                <div class="col-lg-5" id="archive">
                    <div class="ibox-title">
                        <h5>{{__('sign.archive-title')}}</h5>
                        <div class="filter-container">
                            <input type="search" class="form-control input-sm" id="archivefilter" data-location="{{url('sign/')}}" value="{{Session::get('archivefilter')}}" placeholder="Search..." data-name="archivefilter">
                            <button class="clear_filter btn btn-link">
                                <i class="fa fa-times-circle-o"></i>
                            </button>
                        </div>
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
                                <tr class="bg-info tr-client" id="{{$archive->id}}" data-client="{{$archive->id}}">
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
                                                <a data-message="{{__('sign.confirm_send')}}" data-location="{{url('sign/send/'.$document->id)}}" class="confirm-toast" data-document="{{$document->id}}"><i class="fa fa-envelope-o"></i></a>&nbsp;&nbsp;
                                            @endif
                                            <a data-location="{{Storage::disk('documents')->url($document->filename) }}" target="_blank" class="href" data-document="{{$document->id}}"><i class="fa fa-download"></i></a>
                                        </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                @endforeach
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center">{{ $archives->links() }}</div>
                </div>


            </div>
        </div>
    </div>
</div>

<div class="modal" id="showModal"></div>
@push('scripts')
<script>
$(function () {

  if(!!localStorage.getItem('show-archive')) {
    var test = localStorage.getItem('show-archive');
    $('#show_archive').prop('checked', (test=='true'));
  } else {
    $('#show_archive').prop('checked', true);
  }
  setShowArchive($('#show_archive').prop('checked'));

  $('.onoffswitch-checkbox').change(function (e) {
        e.preventDefault();
        var test = $(this).prop('checked');
        localStorage.setItem('show-archive', test);
        setShowArchive(test);
    });

    function setShowArchive(show) {
        if(show) {
          $('#archive').show();
          $('#client').addClass('col-lg-7');
        } else {
          $('#archive').hide();
          $('#client').removeClass('col-lg-7');
        }
    }


    $('.href').click(function(e){
        e.stopPropagation();
        var location =  this.getAttribute('data-location');
        var target = this.getAttribute('target');
        if(target)
            window.open(location);
        else
            window.location = location;
    });

    $('.tr-client, .tr-dossier').hover(function() {
            $(this).css('cursor','pointer');
        }, function() {
            $(this).css('cursor','auto');
        });

    $('.tr-client').click(function(e){
        e.stopPropagation();
        var id = this.id;
        var visible = $(this).parent().find('.dossier-'+id).is(':visible');
        $('.tr-dossier').hide();
        $('.tr-document').hide();
        if (visible) {
            $(this).parent().find('.dossier-'+id).hide();
            localStorage.removeItem('client_id');
            localStorage.removeItem('dossier_id');
        } else {
            $(this).parent().find('.dossier-'+id).show();
            localStorage.setItem('client_id', id);
        }
    });

    $('.tr-dossier').click(function(e){
        e.stopPropagation();
        var dossier = this.id;
        var visible = $(this).parent().find('.document-'+dossier).is(':visible');
        if(visible) {
            $(this).parent().find('.document-'+dossier).hide();
            localStorage.removeItem('dossier_id');
            $('.tr-document').hide();
        } else {
            $(this).parent().find('.document-'+dossier).show();
            localStorage.setItem('dossier_id', dossier);
        }
    });

    $('.sendmail').click(function(e){
        e.stopPropagation();
        var location =  this.getAttribute('data-location');
        swal({
            title: '{{__('app.confirm-title')}}',
            text: this.getAttribute('data-message'),
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes",
            closeOnConfirm: true
        }, function () {
            setSpinnerOn();
            window.location = location;
        });
    });

    // $('.content').click(function(e){
    //   e.preventDefault();
    //   $('.tr-dossier').hide(500);
    //   $('.tr-document').hide(500);
    // });


    $('.clear_filter').click(function (e) {
        e.preventDefault();
        if ($(this).parent().find('input').attr('id') == 'clientfilter') {
          localStorage.removeItem('clientfilter');
          localStorage.removeItem('client_id');
          $('#clientfilter').val('');
        } else {
          localStorage.removeItem('archivefilter');
          $('#archivefilter').val('');
        }
        startSearch();
    });

    $('.filter-container input[type=search]').keyup(function (e) {
        if($(this).val() != '') {
            $(this).parent().find('.clear_filter').show();
        } else {
            $(this).parent().find('.clear_filter').hide();
        }
        if(e.which == 13) {
            e.stopPropagation();
            localStorage.setItem('clientfilter', $('#clientfilter').val());
            localStorage.setItem('archivefilter', $('#archivefilter').val());
            var clientfilter = (!!localStorage.getItem('clientfilter')) ? 'clientfilter=' + localStorage.getItem('clientfilter') : 'clientfilter=*';
            var archivefilter = (!!localStorage.getItem('archivefilter')) ? 'archivefilter=' + localStorage.getItem('archivefilter') : 'archivefilter=*';

            window.location =  this.getAttribute('data-location')+"?"+archivefilter+'&'+clientfilter;
        }
    });

    function startSearch() {
      var ekey = $.Event("keyup");
      ekey.which = 13;
      $('#clientfilter').trigger(ekey);
    }

    if(!!localStorage.getItem('archivefilter')) {
      $('#archivefilter').val(localStorage.getItem('archivefilter'));
      $('#archivefilter').parent().find('.clear_filter').show();
      // startSearch();
    } else {
      $('#archivefilter').parent().find('.clear_filter').hide();
    }
    if(!!localStorage.getItem('clientfilter')) {
      $('#clientfilter').val(localStorage.getItem('clientfilter'));
      $('#clientfilter').parent().find('.clear_filter').show();
      // startSearch();
    } else {
      $('#clientfilter').parent().find('.clear_filter').hide();
    }
    if(!!localStorage.getItem('client_id')) {
      $("[data-client="+localStorage.getItem('client_id')+"]").click();
      if(!!localStorage.getItem('dossier_id')) {
          $("[data-dossier="+localStorage.getItem('dossier_id')+"]").click();
      }
    }

    function setSpinnerOn() {
        $('#showModal').modal({
            fadeDuration: 1000,
            escapeClose: false,
            clickClose: false,
            showClose: false,
            backdrop: "static"
        });
        var $loader = $("#showModal");
        $loader.gSpinner();
        $loader.css({
            'position': 'absolute',
            'top' : '40%',
            'zoom' : '1'
        });
    }


})

</script>
@endpush
@endsection
