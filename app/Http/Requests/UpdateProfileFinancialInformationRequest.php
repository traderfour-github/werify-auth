<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileFinancialInformationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'job' => 'string',
            'income_range' => 'integer',
            'salary_range' => 'integer',
            'fund_source' => 'integer',
            'initial_capital' => 'integer',
            'wealth_source' => 'integer',
            'goals_to_join' => 'integer',
            'preferer_market' => 'string',
            'lose_range' => 'integer',
            'monthly_saving_range' => 'integer',
            'target_range' => 'integer',

        ];
    }
}
