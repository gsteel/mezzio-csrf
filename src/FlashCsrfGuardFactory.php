<?php

declare(strict_types=1);

namespace Mezzio\Csrf;

use Mezzio\Flash\FlashMessageMiddleware;
use Mezzio\Flash\FlashMessagesInterface;
use Psr\Http\Message\ServerRequestInterface;

class FlashCsrfGuardFactory implements CsrfGuardFactoryInterface
{
    private string $attributeKey;

    public function __construct(string $attributeKey = FlashMessageMiddleware::FLASH_ATTRIBUTE)
    {
        $this->attributeKey = $attributeKey;
    }

    public function createGuardFromRequest(ServerRequestInterface $request): CsrfGuardInterface
    {
        $flashMessages = $request->getAttribute($this->attributeKey, false);
        if (! $flashMessages instanceof FlashMessagesInterface) {
            throw Exception\MissingFlashMessagesException::create();
        }

        return new FlashCsrfGuard($flashMessages);
    }
}
