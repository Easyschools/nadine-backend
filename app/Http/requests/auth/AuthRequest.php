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
                return $this->forgetPasswordRules();
            case 'reset-password':
                return $this->resetPasswordRules();
            default:
                return [];
        }
    }

    private function registerRules()
    {
        return [
            'name' => 'required',
            'slug' => 'required|unique:users,slug|alpha_dash',
            'email' => 'required|unique:users,email',
            'phone'=>'required|digits:11',
            'password' => 'required|min:8|confirmed'
        ];
    }

    private function loginRules()
    {
        return [
            'phone' => 'required|exists:users,phone',
            'password' => 'required|min:8'
        ];
    }

    public function changePasswordRules()
    {
        return [
            'old_password' => 'required|min:8',
            'password' => 'required|min:8|confirmed',
        ];
    }

    public function forgetPasswordRules()
    {
        return [
            'email' => 'required|exists:users,email',
        ];
    }

    public function resetPasswordRules()
    {
        return [
            // 'email' => 'required|exists:users,email|email',
            'token' => 'required|exists:password_resets,token',
            'new_password' => 'required|min:8',
            'confirm_password' => 'required|min:8|same:new_password',

            // 'hashToken'=> 'exists:users'
        ];
    }
}
