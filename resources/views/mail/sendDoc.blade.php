<div>
    <p>{!! __('sign.header_mail') !!}<span>{{$document->date_sign}}</span></p>
    <p>{!! __('sign.body_mail') !!}</p>
    <p>{!! __('sign.footer_mail') !!}<span>{{$sender->surname}}  {{$sender->name}}</span></p>
    <p><span>{{$brand->description}}</span></p>
</div>