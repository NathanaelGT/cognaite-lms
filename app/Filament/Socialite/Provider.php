<?php

namespace App\Filament\Socialite;

use Closure;
use DutchCodingCompany\FilamentSocialite\Provider as BaseProvider;

class Provider extends BaseProvider
{
    /**
     * @var ?Closure(): string
     */
    protected ?Closure $resolveLabelUsing = null;

    /**
     * @param ?Closure(): string $resolveLabelUsing
     */
    public function resolveLabelUsing(?Closure $resolveLabelUsing): static
    {
        $this->resolveLabelUsing = $resolveLabelUsing;

        return $this;
    }

    public function getLabel(): string
    {
        return value($this->resolveLabelUsing) ?? parent::getLabel();
    }
}
