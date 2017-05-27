<?php

namespace App\Mail;

use App\Models\Document;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendDocument extends Mailable
{
    use Queueable, SerializesModels;

    public $document;

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

        dd($brand->description);


        return $this->from(['from' => ['address' => $brand->email, 'name' => $brand->description]])
            //->subject('mail di prova')
            //->attach()
            //->view('view.name')
            //->with([

            //])
            ;
    }
}
