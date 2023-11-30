<?php

namespace App\Telegram;

use DefStudio\Telegraph\Facades\Telegraph;
use DefStudio\Telegraph\Handlers\WebhookHandler;
use DefStudio\Telegraph\Keyboard\Button;
use DefStudio\Telegraph\Keyboard\Keyboard;
use DefStudio\Telegraph\Models\TelegraphChat;
use Illuminate\Support\Stringable;

class Handler extends WebhookHandler
{
    public function start(): void
    {
//        Log::info($this->messageId);
        $this->chat->message('Радий тебе бачити!')
            ->keyboard($this->keyboard())
            ->send();
    }

    private function keyboard(): Keyboard
    {
        return Keyboard::make()
            ->button('Рандомний мем')
                ->width(50)
                ->action('random_meme');
    }

    public function random_meme(): void
    {
        $response = \Illuminate\Support\Facades\Http::get('https://meme-api.com/gimme');
        $data = $response->json();
        $this->chat->photo($data['url'])
            ->keyboard($this->keyboard())
            ->send();
    }

    public function dice(): void
    {
//        $this->chat->dice(\DefStudio\Telegraph\Enums\Emojis::SLOT_MACHINE)
        $this->chat->dice()
            ->keyboard($this->keyboard())
            ->send();
    }

    public function info(): void
    {
        $this->chat->message('Цей бот створеннний для генерації мемів. Поки що це дуже альфа версія')
            ->keyboard($this->keyboard())
            ->send();
    }

    protected function handleUnknownCommand(Stringable $text): void
    {
        $this->chat->message('Невідома команда')
            ->keyboard($this->keyboard())
            ->send();
    }

    protected function handleChatMessage(Stringable $text): void
    {
        $this->chat->message('')
            ->keyboard($this->keyboard())
            ->send();
    }

    public function coffee_time(): void
    {
        $chats = TelegraphChat::query()->get();

        foreach($chats as $chat) {
            $chat->message('Пора на каву :)')->send();
        }
    }
}
