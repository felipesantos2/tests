<?php

declare(strict_types=1);

namespace app\dtos;

final readonly class CreateUserDTO
{
    public string $name;

    public ?string $email;

    public ?string $cpf;

    public ?string $password;

    public bool|int|null $status;

    public function __construct() {}

    public function filled(
        string $name,
        ?string $email,
        ?string $cpf = null,
        ?string $password = null,
        bool|int|null $status = null,
    ) {
        $this->name = $name;
        $this->email = $email;
        $this->cpf = $cpf;
        $this->password = $password;
        $this->status = $status;
    }
}
