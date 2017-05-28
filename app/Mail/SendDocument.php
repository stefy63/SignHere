<?php

namespace App\Mail;

use App\Models\Document;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendDocument extends Mailable
{
    use Queueable, SerializesModels;

    protected $document;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Document $document)
    {
        $this->document = $document;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $sender = \Auth::user();
        $client = $this->document->dossier->client;
        $acl_client = $client->acls()->first();
        $brand = $acl_client->brands()->first();

        //dd($client->name);


        return $this->view('mail.sendDoc')
           ->with([
                    'brand'     =>  $brand,
                    'client'    =>  $client,
                    'sender'    =>  $sender,
                    'document'  =>  $this->document,
                ])
            ->to($this->document->dossier->client->email)
            ->from($brand->email,$brand->description)
            ->subject(__('sign.send_doc_mail',['doc'=>$this->document->name,'date' => $this->document->date_sign]))
            ->attach(storage_path('app/public/documents/').'/'.$this->document->filename);
    }
}
