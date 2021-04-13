<?php

declare(strict_types=1);

namespace MdNotesCCGLib;

use MdNotesCCGLib\Http\HttpRequest;

interface AuthManager
{
    public function apply(HttpRequest $httpRequest): HttpRequest;
}