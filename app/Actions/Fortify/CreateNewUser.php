<?php

namespace App\Actions\Fortify;

use App\Models\Membership;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use Usernotnull\Toast\Concerns\WireToast;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;
    use WireToast;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'dni' => ['required', 'string', 'max:8', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        // Datos
        $token = 'apis-token-11587.OZhpnnRAE0c06mr4RMIfswNvqBPAwAN0';
        $dni = $input['dni'];

        // Iniciar llamada a API
        $curl = curl_init();

        // Buscar dni
        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://api.apis.net.pe/v2/reniec/dni?numero=' . $dni,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 2,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => [
                'Referer: https://apis.net.pe/consulta-dni-api',
                'Authorization: Bearer ' . $token
            ],
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        $persona = json_decode($response, true);

        if (isset($persona['message']) && in_array($persona['message'], ['dni no valido', 'not found'])) {
            toast()->danger('El DNI no es válido, ingrese nuevamente', 'Mensaje de error')->push();

            throw new \Illuminate\Validation\ValidationException(Validator::make([], []));
        }

        toast()->success('DNI encontrado y validado correctamente', 'Mensaje de éxito')->push();

        $cuentaFree = Membership::where('plan', 'Lite')->first();

        $user = User::create([
            'name' => $input['name'],
            'dni' => $input['dni'],
            'membership_id' => $cuentaFree->id,
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);

        $user->assignRole('Usuario');

        return $user;
    }
}
