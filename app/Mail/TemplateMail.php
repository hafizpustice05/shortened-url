<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TemplateMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $subject;
    public $body;
    protected $placeholders;
    /**
     * Attachment info
     *
     * @var array(
     *   "path" => "app/public/example.jpeg",
     *   "as" => "example.jpeg",
     *   "withMime" => "image/jpeg",
     * )
     */
    protected array $attachmentInfo;

    public function __construct($template, $placeholders = [], array $attachmentInfo = [])
    {
        $this->subject = $template->subject;
        $this->body = $this->replacePlaceholders($template->body, $placeholders);
        $this->placeholders = $placeholders;
        $this->$attachmentInfo = $attachmentInfo;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.template-mail',
            with: [
                'subject' => $this->subject,
                'body' => $this->body,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        if (count($this->attachmentInfo)) {
            return [
                Attachment::fromPath($this->attachmentInfo["path"])
                    ->as($this->attachmentInfo["as"])
                    ->withMime($this->attachmentInfo["withMime"]),
            ];
        }
        return [];
    }

    private function replacePlaceholders($template, $placeholders)
    {
        foreach ($placeholders as $key => $value) {
            $template = str_replace("{{$key}}", $value, $template);
        }

        return $template;
    }
}
