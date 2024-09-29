<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EnvioDTE extends Mailable
{
    use Queueable, SerializesModels;

    public $jsonData;
    public $pdfPath;
    public $receptorMail;


    /**
     * Create a new message instance.
     */
    public function __construct($jsonData, $pdfPath, $receptorMail)
    {
       $this->jsonData = $jsonData;
       $this->pdfPath = $pdfPath;
       $this->receptorMail = $receptorMail;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Envio DTE',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.envioDTE',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }


    public function build()
    {
        return $this->view('mail.envioDTE')
            ->subject('Envío de Documentos Electrónicos')
            ->attach($this->pdfPath, [
                'as' => 'comprobante.pdf',
                'mime' => 'application/pdf',
            ])
            ->attachData($this->jsonData, 'documento.json', [
                'mime' => 'application/json',
            ]);
    }
}
