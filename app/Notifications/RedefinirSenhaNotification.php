<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;



class RedefinirSenhaNotification extends Notification
{
    use Queueable;
    public $token;
    public $tenantSlug;
    public $email;
    public $nome;
    public $dominio;

    /**
     * Create a new notification instance.
     */
    public function __construct($token,$email,$nome, $dominio )
    {
        $this->token = $token;
        $this->email = $email;
        $this->nome = $nome;
        $this->dominio = $dominio;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {

        // Construindo a URL com o subdomínio
        $url = 'http://'.$this->dominio.'.localhost:8000/password/reset/'.$this->token.'?email='.urlencode($notifiable->email);




        $minutos=config('auth.passwords.'.config('auth.defaults.passwords').'.expire');
        return (new MailMessage)
        ->subject(Lang::get('Redefinição de senha'))
        ->greeting(Lang::get('Olá, '.$this->nome. '!'))
        ->line(Lang::get('Você está recebendo essa mensagem porque recebemos uma solicitação de redefinição de senha para o email"'.$this->email.'".'))
        ->action(Lang::get('Clique aqui para redefinir'), $url)
        ->line(Lang::get('O link para redefinir a senha expira em '.$minutos.' minutos'))
        ->line(Lang::get('Se você não solicitou uma redefinição de senha, nenhuma ação é necessária.'))
        ->salutation('Atenciosamente, '.config('app.name'));

    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
