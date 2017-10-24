<div>
    <p>{!! __('sign.header_mail') !!}<span>{{$document->date_sign}}</span></p>
    <p>{!! __('sign.body_mail') !!}<span>{{$brand->description}}</span></p>
    <p>{!! __('sign.footer_mail') !!}<span>{{$client->surname}}  {{$client->name}}</span></p>
</div>