<?php

namespace App\Mail;

use App\Models\Pemesanan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TiketEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $pemesanan;

    /**
     * Create a new message instance.
     */
    public function __construct(Pemesanan $pemesanan)
    {
        $this->pemesanan = $pemesanan;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Tiket Wisata Lapade - ' . $this->pemesanan->kode_pemesanan,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.tiket',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        try {
            // Generate PDF tiket dengan custom paper size (105mm width, auto height)
            $pdf = \PDF::loadView('pdf.tiket', ['pemesanan' => $this->pemesanan])
                ->setPaper([0, 0, 297.64, 841.89], 'portrait'); // 105mm x auto (A4 height max)
            
            // Simpan PDF temporary
            $filename = 'Tiket-' . $this->pemesanan->kode_pemesanan . '.pdf';
            $pdfPath = storage_path('app/temp/' . $filename);
            
            // Buat folder temp jika belum ada
            if (!file_exists(storage_path('app/temp'))) {
                mkdir(storage_path('app/temp'), 0755, true);
            }
            
            $pdf->save($pdfPath);
            
            return [
                \Illuminate\Mail\Mailables\Attachment::fromPath($pdfPath)
                    ->as($filename)
                    ->withMime('application/pdf'),
            ];
        } catch (\Exception $e) {
            \Log::error('Gagal generate PDF tiket: ' . $e->getMessage());
            return [];
        }
    }
}
