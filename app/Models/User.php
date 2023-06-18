<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\Models\User\UserForm;
use App\Models\Board\BoardAnswer;
use App\Models\Board\BoardQuestion;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public $table = 'users';
    protected $primaryKey = 'user_sn';

    const CREATED_AT = 'crt_dt';
    const UPDATED_AT = 'udt_dt';
    const DELETED_AT = 'del_dt';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'provider_id',
        'name',
        'email',
        'password',
        'user_form',
        'cat_breed',
        'cat_age',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'user_form' => UserForm::class,
        ];


    //===========RELATIONSHIPS=============

    /**
     * @return BelongsTo
     */
    public function boardQuestions(): BelongsTo
    {
        return $this->belongsTo(BoardQuestion::class,'user_sn','crt_user_sn');
    }

    /**
     * @return HasMany
     */
    public function boardAnswers(): HasMany
    {
        return $this->hasMany(BoardAnswer::class,'user_sn','user_sn');
    }
}
