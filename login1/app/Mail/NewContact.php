<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewContact extends Mailable
{
    use Queueable, SerializesModels;
 //I la mail arriva al controller
//il controller verfica che va bene
//i crea un nuovo oggetto mail e quindi un nuovo new contact, per farlo devo creare una nuova variabile publica che chiamo lead

//1 creo il lead
    public $lead;



    /**
     * Create a new message instance.
     *
     * @return void
     */

     //2 lo metto nel costruttore il lead che passo e' una nuova entita della tabella
     //lead e' un oggetto che conterra le informazioni che ho stabilito nella tabella, quindi nome email e message
     //si crea il lead quando il form viene verificato e il dato salvato nella tabella
     //il lead che gli opasso alla funzione e' quello del model Lead che devo creare e della tabella che ho creto
    public function __construct($_lead)
    {
    $this->lead = $_lead;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Nuovo Contatto',
            replyTo: $this->lead->email,
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            //nel content gestisco la view dell'html relativa al blade . non ce bisogno di fare il compact glielo passa implicitamente
            view: 'mail.new-contact',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}