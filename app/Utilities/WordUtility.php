<?php
namespace App\Utilities;

class WordUtility 
{
    public function wordFrequency($string)
    {
        $string = $this->stripPunctuation($string);
        $string = $this->stringToLowerCase($string);

        $parts = preg_split('/[\s]+/', $string);

        return array_count_values($parts);
    }

    public function stripPunctuation($string)
    {
        //return preg_replace('/[[:punct:]]+/','',$string);
        //return preg_replace('/[^\P{P}\']+/u','',$string);
        //return preg_replace('/(\w[^\P{P}]\w)|[^\P{P}](\w)|(\w)[^\P{P}]/mu','$1$3$2',$string);
        return preg_replace('/(\w[^\P{P}]\w)|[^\P{P}](\w)|(\w)[^\P{P}]+|([ ])[^\P{P}]+\s/mu','$1$3$2$4',$string);
    }

    public function stringToLowerCase($string)
    {
        return strtolower($string);
    }
}