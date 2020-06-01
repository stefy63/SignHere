<?php

namespace App\Mail;

use App\Models\Document;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Swift_Mailer;
use Swift_SmtpTransport as SmtpTransport;

class SendSigningDocument extends Mailable
{
    use Queueable, SerializesModels;

    protected $document;
    protected $sender;
    protected $client;
    protected $brand;
    protected $link;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Document $document)
    {
        $this->document = $document;
        $this->sender = \Auth::user();
        $this->link = url('api/v1/signing',[ 'id' => $document->id]).'?'.'api_token='.$this->sender->api_token;
        $this->client = $this->document->dossier->client;
        $acl_sender = $this->sender->acls()->first();
        $this->brand = $acl_sender->brands()->first();
        $host = ($this->brand->smtp_host)?$this->brand->smtp_host:config('mail.host');
        $port = ($this->brand->smtp_port)?$this->brand->smtp_port:config('mail.port');
        $username = ($this->brand->smtp_username)?$this->brand->smtp_username:config('mail.username');
        $password = ($this->brand->smtp_password)?$this->brand->smtp_password:config('mail.password');
        if($pos = strpos($host,'|')){
            $encryption = substr($host,$pos+1);
            $host = substr($host,0,$pos);
        } else {
            $encryption = config('mail.encryption');
        }

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
        $Fields = array('{nome}','{cognome}','{azienda}','{link}','{data}');
        $date = \Carbon\Carbon::now()->format('d/m/Y');
        $replace = array(
            $this->client->name,
            $this->client->surname,
            $this->brand->description,
            '<a href="'.$this->link.'">'.$this->link.'</a>',
            $date
        );
        $body = $this->brand->mail_templates()->first()->template;
        $body = str_replace($Fields, $replace, $body);
        return $this->view('mail.sendSigningDoc')
            ->with([
                    'body'     =>  $body
                ])
            ->to($this->document->dossier->client->email)
            ->from($this->brand->email,$this->brand->description)
            ->subject(__('sign.send_signing_doc_mail',['doc'=>$this->document->name]));
    }
}
