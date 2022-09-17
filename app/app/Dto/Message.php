<?php

declare(strict_types=1);

namespace App\Dto;

use App\Models\User;
use Illuminate\Support\Carbon;

class Message implements DtoInterface
{

    public function __construct(
        public User $author,
        public string $message,
        public ?User $recipient = null,
        public ?Carbon $time = null
    )
    {
    }

    public static function create(mixed $args): DtoInterface
    {
        return new static(...$args);
    }
}
