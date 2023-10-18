<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialInformation extends Model
{
    use HasFactory;

    protected $hidden = ['id', 'user_id', 'created_at'];

    protected $fillable = ['job', 'income_range', 'salary_range', 'fund_source', 'initial_capital', 'wealth_source', 'goals_to_join', 'preferer_market', 'lose_range', 'monthly_saving_range', 'target_range'];
}
