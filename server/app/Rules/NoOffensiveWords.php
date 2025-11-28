<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NoOffensiveWords implements ValidationRule
{
    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $badWords = [

            'idio
           ta',
            'imbeci
           l',
            'estu
           pido',
            'to
           nto',
            'ta
           rado',
            'menso',
            'pendejo',

            'gilipo
           llas',
            'cab
           ron',
            'capu
           llo',
            'm
           aricon',
            'puto',
            'puta',

            'conchet
           umare',
            '
           carajo',
            'verga',
            'coño',
            'joder',
            'mierda',


            'cagar',
            'cag
           ada',
            'malpari
           do',
            'hijodeputa',
            'desgraciado',

            'b
           astardo',
            'culero',
            '
           picha',
            'gono
           rrea',
            'pendejada',
            'baboso',

            '
           boludo',
            '
           pelotudo
           ',
            'follar
           ',
            'sexo',
            'sexual',
            'porno',

            'por
           nografia',
            'o
           rgasmo',
            'masturba
           r',
            'pene',
            'vagina',
            'clitoris',


            'c
           oito',
            'an
           al',
            'oral',
            'condon',
            'esperma',
            'eyacular',
            'ereccion',

            'pro
           stituta',
            '
           prostibulo',
            'venerea',
            'pedofilo',
            'violar',


            'pederasta',
            'reputis',
            're
           pajolero',
            'coprofagia',
            'zoofilia',

            '
           necrofili
           a',
            'pedof
           ilia',
            'p
           olla',
            'cipote',
            'nalga',
            'te
           tas',

            'c
           ulo',
            'paj
           ero',
            'pajil
           la',
            'mamada',
            'correrse',
            'espermatozoi
           de',

            'jo
           dido',
            'jodida',
            'jodidos',
            'jodidas',
        ];

        if (empty($value)) {
            return;
        }

        $normalized = mb_strtolower($value);

        foreach ($badWords as $badWord) {
            $cleanWord = preg_replace('/\s+/', '', $badWord);
            if ($cleanWord !== '' && str_contains($normalized, $cleanWord)) {
                $fail('El campo :attribute contiene palabras no permitidas.');
                return;
            }
        }
    }
}
