<?php
/**
 * Description of functions
 *
 * @author Kamuran Dogan
 */
class functions {
    
    //Yapıcı sınıfımız tanımlandı
    public function __construct(){
    }
    
    /*
     * Url adresi verilen sayfanın içeriğini döndürür
     * $url => varchar
    */
    public function getContent($url){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        $content = curl_exec($curl);
        curl_close($curl);
        
        return $content;
    }

    /*
     * Gönderilen anahtar kelimenin içerikte kaç defa geçtiğini belirtir.
     * $key => Anahtar Kelime 
     * $content => Arama Yapılacak data
     */
    public function getCount($key,$content) {
        $count = 0;
        $keyOriginal = $key;

        //Tüm harfler küçük
        $_key[] = $keyLower = strtolower($keyOriginal);
        //Tüm harfler büyük
        $_key[] = $keyUpper = strtoUpper($keyOriginal);
        //İlk harfi büyük diğer harfleri küçük
        $_key[] = $keyUcwords = ucwords(strtolower($keyOriginal));
        
        //Yukarıda tanıımlanan üç sitring sayısıda data içerisinde aranıyor
        for($i=0;$i<3;$i++){
            //İçerik içerisinde geçen kelime sayısı hesaplanıyor
            $count = (count(explode($_key[$i],$content))-1) + $count;
        }
        
        return $count;
    }
}
