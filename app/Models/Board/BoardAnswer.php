<?php

namespace App\Models\Board;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class BoardAnswer extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $table = 'board_answer';
    protected $primaryKey = 'board_a_sn';
    const CREATED_AT = 'crt_dt';
    const UPDATED_AT = 'udt_dt';
    const DELETED_AT = 'del_dt';

    protected $fillable = [
        'content',
        'choose_yn',
        'crt_user_sn',
        'board_q_sn',
    ];

    //===========RELATIONSHIPS=============

    /**
     * @return BelongsTo
     */
    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_sn','crt_user_sn');
    }

    /**
     * @return BelongsTo
     */
    public function boardQuestions(): BelongsTo
    {
        return $this->belongsTo(User::class,'board_q_sn','board_q_sn');
    }
}
