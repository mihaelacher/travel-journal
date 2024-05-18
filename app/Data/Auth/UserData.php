<?php

namespace App\Data\Auth;

use Illuminate\Support\Facades\Hash;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;

class UserData extends Data
{
    public ?string $password;

    public function __construct(
        #[MapInputName('sub')]
        public ?string $google_id,
        public string $email,
        public string $name,
        ?string $password,
        #[MapInputName('picture')]
        public ?string $pic
    ) {
        $this->password = isset($password) ? Hash::make($password) : null;
    }
}
