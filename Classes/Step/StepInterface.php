<?php

declare(strict_types=1);

namespace Breadlesscode\Backups\Step;

interface StepInterface
{
    public function backup(): bool;
    public function restore(): bool;
    public function getRestoreWarning(): ?string;
}
