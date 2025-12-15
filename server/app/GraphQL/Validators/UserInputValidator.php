<?php

namespace App\GraphQL\Validators;

use Nuwave\Lighthouse\Validation\Validator;
use Illuminate\Validation\Rule;

class UserInputValidator extends Validator
{
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
            'input.name' => [
                'required',
                'string',
                'min:2',
                'max:60',
                'regex:/^[\pL\sáéíóúÁÉÍÓÚñÑ]+$/u',
            ],
            'input.username' => [
                'required',
                'string',
                'min:3',
                'max:20',
                'regex:/^[a-zA-Z0-9._-]+$/',
                Rule::unique('users', 'username'),
            ],
            'input.pronouns' => [
                'nullable',
                'string',
                'min:2',
                'max:20',
            ],
            'input.email' => [
                'required',
                'email',
                Rule::unique('users', 'email'),
            ],
            'input.password' => [
                'required',
                'string',
                'min:8',
            ],
            'input.date_of_birth' => [
                'required',
                'date',
                'before:today',
            ],
            'input.biography' => [
                'nullable',
                'string',
                'max:500',
            ],
            'input.avatar_path' => [
                'nullable',
                'string',
            ],
            'input.cover_image_path' => [
                'nullable',
                'string',
            ],
            'input.social_networks' => [
                'nullable',
                'array',
            ],
            'input.social_networks.*' => [
                'string',
                'max:50',
            ],
            'input.social_network_usernames' => [
                'nullable',
                'array',
            ],
            'input.social_network_usernames.*' => [
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

        $data = $validator->getData();
        $input = $data['input'] ?? [];

        $fieldsToCheck = [
            'name' => $input['name'] ?? null,
            'username' => $input['username'] ?? null,
            'biography' => $input['biography'] ?? null,
        ];

        foreach ($fieldsToCheck as $field => $value) {
            if (empty($value)) {
                continue;
            }

            if ($this->containsBadWord($value, $blacklist)) {
                $validator->errors()->add(
                    "input.{$field}",
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
