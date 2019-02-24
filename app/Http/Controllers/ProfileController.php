<?php

namespace App\Http\Controllers;

use App\Rules\PasswordCorrect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function editProfile()
    {
        return view('user.profile');
    }

    public function saveProfile()
    {
        $validated_data = $this->validatedRequest();
        $user = $this->request->user();

        if (isset($validated_data['new_password'])) {
            $validated_data['password'] = $validated_data['new_password'];
        }

        if (!$user->update($validated_data)) {
            $this->makeValidator()->errors()->add('errors', 'Failed to update profile');

            return redirect('profile');
        }

        return redirect('profile')->with('message', 'Profile updated');
    }

    protected function validationRules()
    {
        return [
            'email' => [
                'required',
                'email',
                'between:1,255',
                Rule::unique('users', 'email')->ignore($this->request->user()->id),
            ],
            'full_name' => [
                'required',
                'string',
            ],
            'username' => [
                'required',
                'alpha_num',
                Rule::unique('users', 'username')->ignore($this->request->user()->id),
            ],
            'current_password' => [
                'required',
                new PasswordCorrect($this->request->user()),
            ],
            'new_password' => [
                'sometimes',
                'confirmed',
            ],
        ];
    }

    protected function makeValidator()
    {
        $validator = Validator::make($this->request->all(), $this->validationRules());
        $validator->sometimes('new_password', 'different:current_password', function ($input) {
            return isset($input->current_password);
        });

        return $validator;
    }

    protected function validatedRequest()
    {
        return $this->makeValidator()->validate();
    }
}
