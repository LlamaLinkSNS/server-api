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

            'idiota',
            'imbecil',
            'estupido',
            'tonto',
            'tarado',
            'menso',
            'pendejo',
            'gilipollas',
            'cabron',
            'capullo',
            'maricon',
            'puto',
            'puta',
            'conchetumare',
            'carajo',
            'verga',
            'coño',
            'joder',
            'mierda',
            'cagar',
            'cagada',
            'malparido',
            'hijodeputa',
            'desgraciado',
            'bastardo',
            'culero',
            'picha',
            'gonorrea',
            'pendejada',
            'baboso',
            'boludo',
            'pelotudo',
            'follar',
            'sexo',
            'sexual',
            'porno',
            'pornografia',
            'orgasmo',
            'masturbar',
            'pene',
            'vagina',
            'clitoris',
            'coito',
            'anal',
            'oral',
            'condon',
            'esperma',
            'eyacular',
            'ereccion',
            'prostituta',
            'prostibulo',
            'venerea',
            'pedofilo',
            'violar',
            'pederasta',
            'reputis',
            'repajolero',
            'coprofagia',
            'zoofilia',
            'necrofilia',
            'pedofilia',
            'polla',
            'cipote',
            'nalga',
            'tetas',
            'culo',
            'pajero',
            'pajilla',
            'mamada',
            'correrse',
            'espermatozoide',
            'jodido',
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
