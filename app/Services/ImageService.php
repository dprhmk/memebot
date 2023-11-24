<?php

namespace App\Services;

use Intervention\Image\Facades\Image;

class ImageService
{
    public function generateMeme(string $imgPath, string $text): string
    {
        $pic = ImageCreateFromjpeg($imgPath);//исходное изображение можно загрузить из файла и на него наложить текст
//        dd($pic);
//        $pic = imagecreatetruecolor(500,500);//или изображение можно создать в данном случаи первый параметр x=500 пикселей и y=500 пикселей(второй параметр)
        Header("Content-type: image/jpeg");//укажем серверный заголовок, что выводимый скриптом контент является изображением
        $blackColor = ImageColorAllocate($pic, 0, 0, 0); //Создадим чёрный цвет в изображении
        $font = resource_path('fonts/pixpopenei.ttf');

        $texts = $this->getTextHalfs($text);



        ImageTTFtext($pic, 30, 0, 300, 70, $blackColor, $font, $texts[0]);
        ImageTTFtext($pic, 30, 0, 300, 580, $blackColor, $font, $texts[1]);

        $name = 'meme_' . uniqid() . '.jpg';
        $path = storage_path('app/public/memes/' . $name);
        Imagejpeg($pic, $path);
        ImageDestroy($pic); //освобождаем память изображения в переменной
        return $path;
    }

    private function getTextHalfs(string $text): array
    {
        // Находим индекс конца слова в первой половине текста
        $firstHalfEndIndex = mb_strrpos(mb_substr($text, 0, mb_strlen($text) / 2), ' ');

        // Если конец слова найден, разделяем текст
        if ($firstHalfEndIndex !== false) {
            $firstHalf = mb_substr($text, 0, $firstHalfEndIndex);
            $secondHalf = mb_substr($text, $firstHalfEndIndex + 1);
        } else {
            // Если конец слова не найден, разделение по середине
            $firstHalf = mb_substr($text, 0, mb_strlen($text) / 2);
            $secondHalf = mb_substr($text, mb_strlen($text) / 2);
        }

        return [
            $firstHalf, $secondHalf
        ];
    }
}
