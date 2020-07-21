<?php


namespace App;

/** Class containing auxiliary functions */
class Common
{
    /**
     * Format decimal.
     *
     *
     * @param double $num
     * @return string
     */
    public static function decimal($num){
        return number_format($num, 2,",",".");
    }

    /**
     * Format the document (CPF | CNPJ).
     *
     * @param string $document
     * @return string
     */
    public static function formatDocument($document)
    {
        $document = preg_replace("/\D/", '', $document);

        if (strlen($document) === 11) {
            return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $document);
        }

        return preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $document);
    }
}
