<?php

namespace App\Mail;

use App\Models\Document;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailer;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Swift_Mailer;
use Swift_SmtpTransport as SmtpTransport;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\App;

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
        
        Config::set('mail.driver',env('MAIL_DRIVER', 'smtp'));
        Config::set('mail.host',$this->brand->smtp_host);
        Config::set('mail.port',$this->brand->smtp_port);
        Config::set('mail.username',$this->brand->smtp_username);
        Config::set('mail.password',$this->brand->smtp_password);
        Config::set('mail.encryption','tls');
        Config::set('mail.sendmail','/usr/sbin/sendmail -bs');

        $app = App::getInstance();
        $app->singleton('swift.transport',function ($app) {
            return new TransportManager($app);
        });
        // Assign a new SmtpTransport to SwiftMailer
        $brand_transport = new Swift_Mailer($app['swift.transport']->driver());
        // Assign it to the Laravel Mailer
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
