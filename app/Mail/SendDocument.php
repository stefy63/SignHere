<?php

namespace App\Mail;

use App\Models\Document;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Swift_Mailer;
use Swift_SmtpTransport as SmtpTransport;

class SendDocument extends Mailable
{
    use Queueable, SerializesModels;

    protected $document;
    protected $sender;
    protected $client;
    protected $brand;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Document $document)
    {
        $this->document = $document;
        $this->sender = \Auth::user();
        $this->client = $this->document->dossier->client;
        $this->acl_client = $this->client->acls()->first();
        $this->brand = $this->acl_client->brands()->first();

        $host = ($this->brand->smtp_host)?$this->brand->smtp_host:config('mail.host');
        $port = ($this->brand->smtp_port)?$this->brand->smtp_port:config('mail.port');
        $username = ($this->brand->smtp_username)?$this->brand->smtp_username:config('mail.username');
        $password = ($this->brand->smtp_password)?$this->brand->smtp_password:config('mail.password');
        $encryption = config('mail.encryption');
        /*if(!$encryption) {
            switch ($port){
                case 25:
                    $encryption = null;
                    break;
                case 465:
                    $encryption = 'ssl';
                    break;
                case (587):
                    $encryption = 'tls';
                    break;
                default:
                    $encryption = null;
            }
        }*/


        $transport = SmtpTransport::newInstance( $host, $port);
        $transport->setUsername($username);
        $transport->setPassword($password);
        $transport->setEncryption($encryption);
        $brand_transport = new Swift_Mailer($transport);

        \Mail::setSwiftMailer($brand_transport);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->view('mail.sendDoc')
            ->with([
                    'brand'     =>  $this->brand,
                    'client'    =>  $this->client,
                    'sender'    =>  $this->sender,
                    'document'  =>  $this->document,
                ])
            ->to($this->document->dossier->client->email)
            ->from($this->brand->email,$this->brand->description)
            ->subject(__('sign.send_doc_mail',['doc'=>$this->document->name,'date' => $this->document->date_sign]))
            ->attach(storage_path('app/public/documents/').'/'.$this->document->filename);
    }
}
