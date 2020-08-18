<?php

declare(strict_types=1);

namespace App\models;


use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public const STATUS_NOT_DONE = 0;
    public const STATUS_DONE = 1;

    protected $casts = [
        'is_touched' => 'boolean'
    ];

    public function getFormattedStatus(): string
    {
        switch ($this->status) {
            case self::STATUS_NOT_DONE:
                return "<div style='color: red'>Не выполнено</div>";
            case self::STATUS_DONE:
                return "<div style='color: lightgreen'>Выполнено</div>";
            default:
                return "Не определено";
        }
    }

    public function isUpdatedByAdmin(): bool
    {
        return $this->is_touched;
    }
}