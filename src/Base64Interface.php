<?php

declare(strict_types=1);

namespace YB\Base64;

interface Base64Interface
{
    /**
     * @throws Exception\UnsupportedVariantException
     */
    public static function encode(string $content, int $variant = null): string;

    /**
     * @throws Exception\DecodeFailedException
     * @throws Exception\UnsupportedVariantException
     */
    public static function decode(string $content, int $variant = null): string;

    public static function encodeUrlsafe(string $content): string;

    /**
     * @throws Exception\DecodeFailedException
     */
    public static function decodeUrlsafe(string $content): string;
}
