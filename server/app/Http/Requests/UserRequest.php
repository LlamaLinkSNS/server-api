<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    private function getBadWords(): array
    {
        return [
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
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'min:2',
                'max:60',
                'regex:/^[\pL\sáéíóúÁÉÍÓÚñÑ]+$/u',
            ],
            'username' => [
                'required',
                'string',
                'min:3',
                'max:20',
                'regex:/^[a-zA-Z0-9._-]+$/',
                Rule::unique('users', 'username'),
            ],
            'pronouns' => [
                'nullable',
                'string',
                'min:2',
                'max:20',
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email'),
            ],
            'password' => [
                'required',
                'string',
                'min:8',
            ],
            'date_of_birth' => [
                'required',
                'date',
                'before:today',
            ],
            'biography' => [
                'nullable',
                'string',
                'max:500',
            ],
            'avatar_path' => [
                'nullable',
                'string',
            ],
            'cover_image_path' => [
                'nullable',
                'string',
            ],
            'social_networks' => [
                'nullable',
                'array',
            ],
            'social_networks.*' => [
                'string',
                'max:50',
            ],
            'social_network_usernames' => [
                'nullable',
                'array',
            ],
            'social_network_usernames.*' => [
                'string',
                'max:50',
            ],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator): void {
            $this->validateContentAgainstBadWords($validator);
        });
    }

    private function validateContentAgainstBadWords($validator): void
    {
        $blacklist = array_map('mb_strtolower', $this->getBadWords());

        $fieldsToCheck = [
            'name' => $this->input('name'),
            'username' => $this->input('username'),
            'biography' => $this->input('biography'),
        ];

        foreach ($fieldsToCheck as $field => $value) {
            if (empty($value)) {
                continue;
            }

            if ($this->containsBadWord($value, $blacklist)) {
                $validator->errors()->add(
                    $field,
                    "El campo {$field} contiene palabras no permitidas."
                );
            }
        }
    }

    private function containsBadWord(string $value, array $blacklist): bool
    {
        $normalized = mb_strtolower($value);

        foreach ($blacklist as $badWord) {
            if ($badWord !== '' && str_contains($normalized, $badWord)) {
                return true;
            }
        }

        return false;
    }
}
