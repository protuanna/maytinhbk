<?php
/**
 * Created by PhpStorm.
 * User: MT969
 * Date: 6/5/2015
 * Time: 5:01 PM
 */

class FunctionLib {

    public static $array_allow_image = array(
        'jpg',
        'JPG',
        'png',
        'PNG',
        'jpeg',
        'JPEG'
    );

    public static $array_allow_file = array(
        'xls',
        'xlsx',
        'doc',
        'docx',
        'pdf'
    );

    public static $size_image_max = 2097152;

    public  static function numberToWord($s, $lang = 'vi') {
        $ds = 0;
        $so = $hang = array();

        $viN = array("không", "một", "hai", "ba", "bốn", "năm", "sáu", "bảy", "tám", "chín");
        $viRow = array("", "nghìn", "triệu", "tỷ");

        $enN = array("zero", "one", "two", "three", "four", "five", "six", "seven", "eight", "nine");
        $enRow = array("", "thousand", "million", "billion");

        if ($lang == 'vi') {
            $so = $viN;
            $hang = $viRow;
        } else {
            $so = $enN;
            $hang = $enRow;
        }

        $s = str_replace(",", "", $s);
        $ds = (int) $s;
        if ($ds == 0) {
            return "không ";
        }

        $i = $j = $donvi = $chuc = $tram = 0;
        $i = strlen($s);

        $Str = "";
        if ($i == 0)
            $Str = "";
        else {
            $j = 0;
            while ($i > 0) {
                $donvi = substr($s, $i - 1, 1);
                $i = $i - 1;
                if ($i > 0) {
                    $chuc = substr($s, $i - 1, 1);
                } else {
                    $chuc = -1;
                }
                $i = $i - 1;
                if ($i > 0) {
                    $tram = substr($s, $i - 1, 1);
                } else {
                    $tram = -1;
                }
                $i = $i - 1;
                if ($donvi > 0 || $chuc > 0 || $tram > 0 || $j == 3)
                    $Str = $hang[$j] . " " . $Str;
                $j = $j + 1;
                if ($j > 3)
                    $j = 1;
                if ($donvi == 1 && $chuc > 1)
                    $Str = "mốt" . " " . $Str;
                else {
                    if ($donvi == 5 && $chuc > 0)
                        $Str = "lăm" . " " . $Str;
                    else if ($donvi > 0)
                        $Str = $so[$donvi] . " " . $Str;
                }
                if ($chuc < 0)
                    break;
                else
                    if ($chuc == 0 && $donvi > 0)
                        $Str = "lẻ" . " " . $Str;
                if ($chuc == 1)
                    $Str = "mười" . " " . $Str;
                if ($chuc > 1)
                    $Str = $so[$chuc] . " " . "mươi" . " " . $Str;
                if ($tram < 0)
                    break;
                else
                    if ($tram > 0 || $chuc > 0 || $donvi > 0)
                        $Str = $so[$tram] . " " . "trăm" . " " . $Str;
            }
        }
        return strtoupper(substr($Str, 0, 1)) . substr($Str, 1, strlen($Str) - 1) . ($lang == 'vi' ? "đồng" : 'vnd');
    }
    static function debug($array) {
        if($_SERVER['HTTP_HOST'] != 'banbuonvpp.vn') {
            echo '<pre>';
            print_r($array);
            die;
        }
    }
    static function safe_title($text) {
        $text = FunctionLib::post_db_parse_html($text);
        $text = FunctionLib::stripUnicode($text);
        $text = self::_name_cleaner($text, "-");
        $text = str_replace("----", "-", $text);
        $text = str_replace("---", "-", $text);
        $text = str_replace("--", "-", $text);
        $text = trim($text, '-');
        $text = strtolower($text);
        if ($text) {
            return $text;
        } else {
            return "shop";
        }
    }

    static function post_db_parse_html($t = "") {
        if ($t == "") {
            return $t;
        }

        $t = str_replace("&#39;", "'", $t);
        $t = str_replace("&#33;", "!", $t);
        $t = str_replace("&#036;", "$", $t);
        $t = str_replace("&#124;", "|", $t);
        $t = str_replace("&amp;", "&", $t);
        $t = str_replace("&gt;", ">", $t);
        $t = str_replace("&lt;", "<", $t);
        $t = str_replace("&quot;", '"', $t);

        $t = preg_replace("/javascript/i", "j&#097;v&#097;script", $t);
        $t = preg_replace("/alert/i", "&#097;lert", $t);
        $t = preg_replace("/about:/i", "&#097;bout:", $t);
        $t = preg_replace("/onmouseover/i", "&#111;nmouseover", $t);
        $t = preg_replace("/onmouseout/i", "&#111;nmouseout", $t);
        $t = preg_replace("/onclick/i", "&#111;nclick", $t);
        $t = preg_replace("/onload/i", "&#111;nload", $t);
        $t = preg_replace("/onsubmit/i", "&#111;nsubmit", $t);
        $t = preg_replace("/applet/i", "&#097;pplet", $t);
        $t = preg_replace("/meta/i", "met&#097;", $t);

        return $t;
    }

    static function stripUnicode($str) {
        if (!$str)
            return false;
        $marTViet = array("à", "á", "ạ", "ả", "ã", "â", "ầ", "ấ", "ậ", "ẩ", "ẫ", "ă",
            "ằ", "ắ", "ặ", "ẳ", "ẵ", "è", "é", "ẹ", "ẻ", "ẽ", "ê", "ề"
        , "ế", "ệ", "ể", "ễ",
            "ì", "í", "ị", "ỉ", "ĩ",
            "ò", "ó", "ọ", "ỏ", "õ", "ô", "ồ", "ố", "ộ", "ổ", "ỗ", "ơ"
        , "ờ", "ớ", "ợ", "ở", "ỡ",
            "ù", "ú", "ụ", "ủ", "ũ", "ư", "ừ", "ứ", "ự", "ử", "ữ",
            "ỳ", "ý", "ỵ", "ỷ", "ỹ",
            "đ",
            "À", "Á", "Ạ", "Ả", "Ã", "Â", "Ầ", "Ấ", "Ậ", "Ẩ", "Ẫ", "Ă"
        , "Ằ", "Ắ", "Ặ", "Ẳ", "Ẵ",
            "È", "É", "Ẹ", "Ẻ", "Ẽ", "Ê", "Ề", "Ế", "Ệ", "Ể", "Ễ",
            "Ì", "Í", "Ị", "Ỉ", "Ĩ",
            "Ò", "Ó", "Ọ", "Ỏ", "Õ", "Ô", "Ồ", "Ố", "Ộ", "Ổ", "Ỗ", "Ơ"
        , "Ờ", "Ớ", "Ợ", "Ở", "Ỡ",
            "Ù", "Ú", "Ụ", "Ủ", "Ũ", "Ư", "Ừ", "Ứ", "Ự", "Ử", "Ữ",
            "Ỳ", "Ý", "Ỵ", "Ỷ", "Ỹ",
            "Đ");

        $marKoDau = array("a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a"
        , "a", "a", "a", "a", "a", "a",
            "e", "e", "e", "e", "e", "e", "e", "e", "e", "e", "e",
            "i", "i", "i", "i", "i",
            "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o"
        , "o", "o", "o", "o", "o",
            "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u",
            "y", "y", "y", "y", "y",
            "d",
            "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A"
        , "A", "A", "A", "A", "A",
            "E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E",
            "I", "I", "I", "I", "I",
            "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O"
        , "O", "O", "O", "O", "O",
            "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U",
            "Y", "Y", "Y", "Y", "Y",
            "D");

        $str = str_replace($marTViet, $marKoDau, $str);
        return $str;
    }

    static function _name_cleaner($name, $replace_string = "_") {
        return preg_replace("/[^a-zA-Z0-9\-\_]/", $replace_string, $name);
    }
}