<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FinancialOrganization extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded;

    public function bank_accounts(){
        return $this->hasMany(BankAccountold::class);
    }
}
