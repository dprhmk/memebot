<?php

namespace App\Http\Controllers;

use App\Services\ImageService;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\User;

class BotController extends Controller
{
    protected Api $telegram;

    /**
     * Create a new controller instance.
     *
     * @param  Api $telegram
     */
    public function __construct(Api $telegram)
    {
        $this->telegram = $telegram;
    }

    /**
     * Show the bot information.
     */
    public function show(): User
    {
        $response = $this->telegram->getMe();

        return $response;
    }

    public function sendMeme()
    {
        $images = collect(glob(storage_path('app/public/images') . '/*'));
        $imageFile = \Telegram\Bot\FileUpload\InputFile::create($images->random());

        $image = $images->random();

        $imageService = new ImageService();
        $meme = $imageService->generateMeme($image, 'Коли полетіли сервера Фейсбука');

        $imageFile = \Telegram\Bot\FileUpload\InputFile::create($meme);

        $response = $this->telegram->sendPhoto([
            'chat_id' => '1314769480',
            'photo' => $imageFile,
            'caption' => 'Some caption'
        ]);

        $messageId = $response->getMessageId();
    }
}
