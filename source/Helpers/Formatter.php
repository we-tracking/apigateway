<?php

namespace Source\Helpers;

class Formatter{
    /**
     * Subistitui :keys que existem em um valor de uma array por seu conteudo
     * 
     * @param string|array $subject que possui a string a ser substituida
     * @param array $replace valores que irao substituirs pela :chave
     */
    public static function replace(string|array $subject, array $replace)
    {

        if (is_array($subject)) {
            foreach ($subject as $key => $value) {
                $subject[$key] = self::replace($value, $replace);
            }
            return $subject;
        }

        foreach ($replace as $key => $value) {
            $subject = str_replace(":{$key}", $value, $subject);
        }

        return $subject ?? "";
    }


}