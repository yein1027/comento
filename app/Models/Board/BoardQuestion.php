<?php

namespace App\Models\Board;

use App\Enums\Models\BoardQuestion\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class BoardQuestion extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $table = 'board_question';
    protected $primaryKey = 'board_q_sn';
    const CREATED_AT = 'crt_dt';
    const UPDATED_AT = 'udt_dt';
    const DELETED_AT = 'del_dt';

    protected $fillable = [
        'subject',
        'content',
        'category',
        'crt_user_sn',
    ];

    protected $casts = [
        'category' => Category::class,
    ];

    //===========RELATIONSHIPS=============

    /**
     * @return HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class,'user_sn','crt_user_sn');
    }

    /**
     * @return HasMany
     */
    public function boardAnswers(): HasMany
    {
        return $this->hasMany(BoardAnswer::class,'board_q_sn','board_q_sn');
    }
}
