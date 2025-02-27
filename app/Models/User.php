<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Sail\SailServiceProvider;
use PhpParser\Node\Expr\FuncCall;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'salary',
        'credit_date',
        'saving_goal',
        'budget'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class)
            ->where("monthly", false);
    }

    public function recExpenses()
    {
        return $this->hasMany(Expense::class)
            ->where("monthly", true);
    }

    public function total_expenses()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        return $this->expenses->filter(function ($expense) use ($currentMonth, $currentYear) {
            return !$expense->monthly ||
                ($expense->created_at->year == $currentYear && $expense->created_at->month == $currentMonth);
        })->sum('cost');
    }

    public function expensesCategories()
    {
        return $this->hasManyThrough(Category::class, Expense::class, 'user_id', 'id', 'id', 'category_id')
            ->withSum(['expenses as total_expenses' => function ($query) {
                $query->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year);
            }], 'cost')
            ->where('expenses.user_id', $this->id)
            ->groupBy('expenses.category_id');
    }

    public function saving_progress(){
        
    }
}
