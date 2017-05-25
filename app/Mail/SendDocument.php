<?php

namespace App\Mail;

use App\models\Acl;
use App\Models\Brand;
use App\Models\Document;
use App\User;
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
        $client_acl = $this->document->dossier->client->acls;

        //$brand = Acl::getMyBrands()->get();
        $brand = $client_acl->brand;
        $client = $this->document->dossier->client;


dd($client_acl);
        return $this->from(['from' => ['address' => 'example@example.com', 'name' => 'App Name']])
            ->subject()
            ->attach()
            ->view('view.name')
            ->with([

            ]);
    }
}
