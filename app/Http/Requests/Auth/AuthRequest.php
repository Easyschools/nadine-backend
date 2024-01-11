<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $k = count($this->segments());
        $endPoint = $this->segment($k);
        switch ($endPoint) {
            case 'register':
                return $this->registerRules();
            case 'login':
                return $this->loginRules();
            case 'change-password':
                return $this->changePasswordRules();
            case 'forget-password':
                return $this->forgetPassword();
            case 'reset-password':
                return $this->resetPassword();
            case 'check-code':
                return $this->checkCode();
            default:
                return [];
        }
    }

    private function registerRules()
    {
        $rules = [
            'name' => 'nullable',
            'phone' => 'nullable|digits:11|unique:users,phone',
            'email' => 'nullable|unique:users,email',
            'password' => 'nullable|min:8|confirmed',
            'type_login' => 'required|in:customer,guest',
        ];

        // If type_login is 'customer', make all fields required
        if ($this->all()['type_login'] === 'customer') {
            $rules['name'] = 'required';
            $rules['phone'] = 'required|digits:11|unique:users,phone';
            $rules['email'] = 'required|unique:users,email';
            $rules['password'] = 'required|min:8|confirmed';
        }

        return $rules;
    }

    private function loginRules()
    {
        return [
            'phone' => 'required|exists:users,phone',
            'password' => 'required|min:8',
        ];
    }

    public function changePasswordRules()
    {
        return [
            'old_password' => 'required|min:8',
            'password' => 'required|min:8|confirmed',
        ];
    }


    private function forgetPassword()
    {
        return [
            // 'phone' => 'required|exists:users,phone',
            'email' => 'required|exists:users,email',
        ];
    }

    private function resetPassword()
    {
        return [
            // 'phone' => 'required|exists:users,phone',
            'email' => 'required|exists:users,email',
            'password' => 'required|min:8|max:22|confirmed',
            'code' => 'required|exists:password_resets,token',
        ];
    }


    private function checkCode()
    {
        return [
            'phone' => 'required|min:11|exists:users,phone',
            'code' => 'required|exists:password_resets,token',
        ];
    }
}
