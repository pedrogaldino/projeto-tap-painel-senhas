<?php

namespace App\Jobs;

use App\Entities\Senha;
use App\Services\FCMService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyUserAboutSenha implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $senha;

    public function __construct(Senha $senha)
    {
        $this->senha = $senha;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $message = 'Atenção! Sua senha ' . $this->senha->valor . ' foi chamada às ' . now()->format('d/m/Y H:i');

        FCMService::sendNotification($this->senha->notification_token, 'Senha chamada!', $message);
    }
}
