<?php

namespace App\Http\Services;

use \Faker\Provider\Base;

/**
 * Class FakerProductService
 * @package App\Http\Services
 */
class FakerProductService extends Base
{
    protected static $formats = [
        '{{product}}',
    ];

    protected static $product = ['Бумага', 'Density Toner Kruse', 'Бумага SvetoCopy',
        'Муфта Clutch Canon', 'Блок фотобарабана Drum Unit Canon', 'Площадка тормозная HP LJ 2200',
        'Бушинг резинового вала LJ P3005', 'Магнитный вал', 'Подшипник HP LJ 1200',
        'Бушинг привода картриджа HP LJ', 'Ракель HP LJ', 'Блок формирования изображения', 'Тонер HP LJ',
        'Блок проявки Panasonic', 'Бумага SRА3 90г', 'Датчик Sensor GP1A71A Riso',
        'Держатель Bracket Suction Motor Riso', 'Подшипник BEARING', 'Отделитель тефлонового вала Konica',
        'Отсек для отработанного тонера Minolta-QMS 2300', 'Плата PWB Assembly bizhub C224 A161H00108',
        'Вал в сборе Xerox WC7120 059K53485', 'Шестереня Minolta EP1054', 'Головка печатающая EPSON',
        'Крепеж сенсора Mita', 'Печка Kyocera FUSER UNIT'];

    /**
     * Метод по назвнию товара $name_product получает html страницу с описанием и фотографией с сайта
     *
     * @link https://ac4print.ru
     * @param null $name_product
     * @return mixed
     */
    private function getProduct($name_product = null)
    {
        $ac4print_url ='https://ac4print.ru/index.php?route=product/search'
        .'&filter_name=%s&filter_sub_category=true&filter_description=true';

        $url = sprintf($ac4print_url, str_replace(' ', '%20', $name_product));

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $out = curl_exec($curl);
        curl_close($curl);
        $pattern = '~(<div class=\"image\">+(<a[^>]+href=\"(.+?)\"[^>]*>.*?)<\/div>)~';
        preg_match_all($pattern, $out, $product);
        if (isset($product[3][0])) {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $product[3][0]);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $out = curl_exec($curl);
            curl_close($curl);
            return $out;
        }
    }

    /**
     * Метод парсит html страницу товара $product_data и получает описание товара
     *
     * @param null $product_data
     * @return mixed
     */
    private function getDescriptionText($product_data = null)
    {
        $product_data = preg_replace("|[\s]+|s", " ", $product_data);
        $pattern = '/.*(<div.*id=\"tab-description\".*?>(.*?)<\/div>)/';
        preg_match_all($pattern, $product_data, $description);
        if (isset($description[2][0])) {
            return preg_replace("/&nbsp;/", " ", strip_tags($description[2][0]));
        }
    }

    /**
     * Метод парсит html страницу товара $product_data и получает фотографию товара
     *
     * @param null $dir
     * @param null $product_data
     * @param bool $fullPath
     * @return bool|\RuntimeException|string
     */
    private function getPhoto($dir = null, $product_data = null, $fullPath = true)
    {
        $pattern = '~(<div class=\"image\">+(<a[^>]+href=\"(.+?)\"[^>]*>.*?)<\/div>)~';
        preg_match_all($pattern, $product_data, $image_url);
        if (isset($image_url[3][0])) {
            $dir = is_null($dir) ? sys_get_temp_dir() : $dir; // GNU/Linux / OS X / Windows compatible

            if (!is_dir($dir) || !is_writable($dir)) {
                throw new \InvalidArgumentException(sprintf('Cannot write to directory "%s"', $dir));
            }

            $name = md5(uniqid(empty($_SERVER['SERVER_ADDR']) ? '' : $_SERVER['SERVER_ADDR'], true));
            $filename = $name . '.jpg';
            $filepath = $dir . DIRECTORY_SEPARATOR . $filename;

            $success = false;

            $url_img = str_replace(' ', '%20', $image_url[3][0]);
            if (function_exists('curl_exec')) {
                $fp = fopen($filepath, 'w');
                $ch = curl_init($url_img);
                curl_setopt($ch, CURLOPT_FILE, $fp);
                $success = curl_exec($ch);
                curl_close($ch);
                fclose($fp);
            } elseif (ini_get('allow_url_fopen')) {
                $success = copy($url_img, $filepath);
            } else {
                return new \RuntimeException('The image formatter downloads an image from a remote HTTP server.
                 Therefore, it requires that PHP can request remote hosts, either via cURL or fopen()');
            }

            if (!$success) {
                return false;
            }

            return $fullPath ? $filepath : $filename;
        }

        return false;
    }

    /**
     * Метод получает по наименованию товара его описание с сайта
     *
     * @link https://ac4print.ru
     * @param null $name_product
     * @return mixed
     */
    public function descriptionText($name_product = null)
    {
        $product_data = preg_replace("|[\s]+|s", " ", $this->getProduct($name_product));
        return $this->getDescriptionText($product_data);
    }

    /**
     * Метод получает по наименованию товара его фотографию с сайта
     *
     * @link https://ac4print.ru
     * @param null $dir
     * @param null $name_product
     * @param bool $fullPath
     * @return bool|\RuntimeException|string
     */
    public function photo($dir = null, $name_product = null, $fullPath = true)
    {
        $product_data = $this->getProduct($name_product);
        return $this->getPhoto($dir, $product_data, $fullPath);
    }

    /**
     * Метод получает по наименованию товара его описание и фотографию с сайта
     *
     * @link https://ac4print.ru
     * @param null $dir
     * @param null $name_product
     * @param bool $fullPath
     * @return array
     */
    public function goods($dir = null, $name_product = null, $fullPath = true)
    {
        if ($name_product) {
            $product_data = $this->getProduct($name_product);
            return [
                'name' => $name_product,
                'description' => $this->getDescriptionText($product_data),
                'photo' => $this->getPhoto($dir, $product_data, $fullPath)
            ];
        }
    }

    /**
     * Метод возвращает сучайным образом наименование товара
     *
     * @return mixed
     */
    public static function product()
    {
        return static::randomElement(static::$product);
    }
}
