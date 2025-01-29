<?php

declare(strict_types=1);

namespace YB\Base64;

class Base64
{
    /**
     * VARIANT_ORIGINAL for standard (A-Za-z0-9/\+) Base64 encoding.
     * VARIANT_ORIGINAL_NO_PADDING for standard (A-Za-z0-9/\+) Base64 encoding, without = padding characters.
     * VARIANT_URLSAFE for URL-safe (A-Za-z0-9\-_) Base64 encoding.
     * VARIANT_URLSAFE_NO_PADDING for URL-safe (A-Za-z0-9\-_) Base64 encoding, without = padding characters.
     */
    public const VARIANT_ORIGINAL = 1;
    public const VARIANT_ORIGINAL_NO_PADDING = 2;
    public const VARIANT_URLSAFE = 4;
    public const VARIANT_URLSAFE_NO_PADDING = 8;
    public const VARIANTS = [
        self::VARIANT_ORIGINAL,
        self::VARIANT_ORIGINAL_NO_PADDING,
        self::VARIANT_URLSAFE,
        self::VARIANT_URLSAFE_NO_PADDING,
    ];

    /**
     * @throws Exception\UnsupportedVariantException
     */
    public static function encode(string $content, ?int $variant = null): string
    {
        if (null === $variant) {
            $variant = self::VARIANT_ORIGINAL;
        }

        if (!\in_array($variant, self::VARIANTS, true)) {
            throw new Exception\UnsupportedVariantException(\sprintf('Unsupported variant: %d', $variant));
        }

        $content = base64_encode($content);

        if ($variant & (self::VARIANT_URLSAFE | self::VARIANT_URLSAFE_NO_PADDING)) {
            $content = strtr($content, '+/', '-_');
        }

        if ($variant & (self::VARIANT_ORIGINAL_NO_PADDING | self::VARIANT_URLSAFE_NO_PADDING)) {
            $content = str_replace('=', '', $content);
        }

        return $content;
    }

    /**
     * @throws Exception\DecodeFailedException
     * @throws Exception\UnsupportedVariantException
     */
    public static function decode(string $content, ?int $variant = null): string
    {
        if (null === $variant) {
            $variant = self::VARIANT_ORIGINAL;
        }

        if (!\in_array($variant, self::VARIANTS, true)) {
            throw new Exception\UnsupportedVariantException(\sprintf('Unsupported variant: %d', $variant));
        }

        if ($variant & (self::VARIANT_URLSAFE | self::VARIANT_URLSAFE_NO_PADDING)) {
            $content = strtr($content, '-_', '+/');
        }

        if ($variant & (self::VARIANT_ORIGINAL_NO_PADDING | self::VARIANT_URLSAFE_NO_PADDING)) {
            $remainder = \strlen($content) % 4;
            if ($remainder) {
                $content .= str_repeat('=', 4 - $remainder);
            }
        }

        $content = base64_decode($content, true);
        if (false === $content) {
            throw new Exception\DecodeFailedException('Cannot decode content');
        }

        return $content;
    }

    /**
     * @throws Exception\UnsupportedVariantException
     */
    public static function encodeUrlsafe(string $content): string
    {
        return self::encode($content, self::VARIANT_URLSAFE_NO_PADDING);
    }

    /**
     * @throws Exception\DecodeFailedException
     * @throws Exception\UnsupportedVariantException
     */
    public static function decodeUrlsafe(string $content): string
    {
        return self::decode($content, self::VARIANT_URLSAFE_NO_PADDING);
    }
}
