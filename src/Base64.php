<?php

declare(strict_types=1);

namespace YB\Base64;

final class Base64 implements Base64Interface
{
    /**
     * BASE64_VARIANT_ORIGINAL for standard (A-Za-z0-9/\+) Base64 encoding.
     * BASE64_VARIANT_ORIGINAL_NO_PADDING for standard (A-Za-z0-9/\+) Base64 encoding, without = padding characters.
     * BASE64_VARIANT_URLSAFE for URL-safe (A-Za-z0-9\-_) Base64 encoding.
     * BASE64_VARIANT_URLSAFE_NO_PADDING for URL-safe (A-Za-z0-9\-_) Base64 encoding, without = padding characters.
     */
    public const BASE64_VARIANT_ORIGINAL = 1;
    public const BASE64_VARIANT_ORIGINAL_NO_PADDING = 2;
    public const BASE64_VARIANT_URLSAFE = 4;
    public const BASE64_VARIANT_URLSAFE_NO_PADDING = 8;
    public const BASE64_VARIANTS = [
        self::BASE64_VARIANT_ORIGINAL,
        self::BASE64_VARIANT_ORIGINAL_NO_PADDING,
        self::BASE64_VARIANT_URLSAFE,
        self::BASE64_VARIANT_URLSAFE_NO_PADDING,
    ];

    public static function encode(string $content, int $variant = null): string
    {
        if (null === $variant) {
            $variant = self::BASE64_VARIANT_ORIGINAL;
        }

        if (!\in_array($variant, self::BASE64_VARIANTS, true)) {
            throw new Exception\UnsupportedVariantException(sprintf('Unsupported variant: %d', $variant));
        }

        $content = base64_encode($content);

        if ($variant & (self::BASE64_VARIANT_URLSAFE | self::BASE64_VARIANT_URLSAFE_NO_PADDING)) {
            $content = strtr($content, '+/', '-_');
        }

        if ($variant & (self::BASE64_VARIANT_ORIGINAL_NO_PADDING | self::BASE64_VARIANT_URLSAFE_NO_PADDING)) {
            $content = str_replace('=', '', $content);
        }

        return $content;
    }

    public static function decode(string $content, int $variant = null): string
    {
        if (null === $variant) {
            $variant = self::BASE64_VARIANT_ORIGINAL;
        }

        if (!\in_array($variant, self::BASE64_VARIANTS, true)) {
            throw new Exception\UnsupportedVariantException(sprintf('Unsupported variant: %d', $variant));
        }

        if ($variant & (self::BASE64_VARIANT_URLSAFE | self::BASE64_VARIANT_URLSAFE_NO_PADDING)) {
            $content = strtr($content, '-_', '+/');
        }

        if ($variant & (self::BASE64_VARIANT_ORIGINAL_NO_PADDING | self::BASE64_VARIANT_URLSAFE_NO_PADDING)) {
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

    public static function encodeUrlsafe(string $content): string
    {
        return self::encode($content, self::BASE64_VARIANT_URLSAFE_NO_PADDING);
    }

    public static function decodeUrlsafe(string $content): string
    {
        return self::decode($content, self::BASE64_VARIANT_URLSAFE_NO_PADDING);
    }
}
