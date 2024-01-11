<?php

declare(strict_types=1);

namespace YB\Base64\Tests;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use YB\Base64\Base64;

/**
 * @internal
 *
 * @covers \YB\Base64\Base64
 */
final class Base64Test extends TestCase
{
    /**
     * @dataProvider provideEncodeCases
     */
    public function testEncode(string $content, ?int $variant, string $expected): void
    {
        $content = hex2bin($content);
        if (false === $content) {
            throw new \ErrorException('Cannot convert content (hex2bin)');
        }

        $result = Base64::encode($content, $variant);
        Assert::assertEquals($expected, $result);
    }

    /**
     * @dataProvider provideDecodeCases
     */
    public function testDecode(string $content, ?int $variant, string $expected): void
    {
        $result = Base64::decode($content, $variant);
        $result = bin2hex($result);
        Assert::assertEquals($expected, $result);
    }

    /**
     * @dataProvider provideEncodeUrlsafeCases
     */
    public function testEncodeUrlsafe(string $content, string $expected): void
    {
        $content = hex2bin($content);
        if (false === $content) {
            throw new \ErrorException('Cannot convert content (hex2bin)');
        }

        $result = Base64::encodeUrlsafe($content);
        Assert::assertEquals($expected, $result);
    }

    /**
     * @dataProvider provideDecodeUrlsafeCases
     */
    public function testDecodeUrlsafe(string $content, string $expected): void
    {
        $result = Base64::decodeUrlsafe($content);
        $result = bin2hex($result);
        Assert::assertEquals($expected, $result);
    }

    public static function provideEncodeCases(): iterable
    {
        $content = '3e22b8a61994c7bcb8fdceaf8ca4991c4f51769ff0440a9b23fbbcd0678b32a640efa4fffbd3dff9061b3f1cf77518b798eafe9dee5ded4ef8628f873ed8d4ec';

        foreach ([null, Base64::BASE64_VARIANT_ORIGINAL] as $variant) {
            yield [$content, $variant, 'PiK4phmUx7y4/c6vjKSZHE9Rdp/wRAqbI/u80GeLMqZA76T/+9Pf+QYbPxz3dRi3mOr+ne5d7U74Yo+HPtjU7A=='];
        }

        yield [$content, Base64::BASE64_VARIANT_ORIGINAL_NO_PADDING, 'PiK4phmUx7y4/c6vjKSZHE9Rdp/wRAqbI/u80GeLMqZA76T/+9Pf+QYbPxz3dRi3mOr+ne5d7U74Yo+HPtjU7A'];

        yield [$content, Base64::BASE64_VARIANT_URLSAFE, 'PiK4phmUx7y4_c6vjKSZHE9Rdp_wRAqbI_u80GeLMqZA76T_-9Pf-QYbPxz3dRi3mOr-ne5d7U74Yo-HPtjU7A=='];

        yield [$content, Base64::BASE64_VARIANT_URLSAFE_NO_PADDING, 'PiK4phmUx7y4_c6vjKSZHE9Rdp_wRAqbI_u80GeLMqZA76T_-9Pf-QYbPxz3dRi3mOr-ne5d7U74Yo-HPtjU7A'];
    }

    public static function provideDecodeCases(): iterable
    {
        $content = '0436086c175741c0234294c2d37f4dfa10ef9e07edea7fd6f9de988da1b2dd752856747bf593740c377c2e4415c4c29566eeae4c8ca02ecf07bfe8defde62f63';

        foreach ([null, Base64::BASE64_VARIANT_ORIGINAL] as $variant) {
            yield ['BDYIbBdXQcAjQpTC039N+hDvngft6n/W+d6YjaGy3XUoVnR79ZN0DDd8LkQVxMKVZu6uTIygLs8Hv+je/eYvYw==', $variant, $content];
        }

        yield ['BDYIbBdXQcAjQpTC039N+hDvngft6n/W+d6YjaGy3XUoVnR79ZN0DDd8LkQVxMKVZu6uTIygLs8Hv+je/eYvYw', Base64::BASE64_VARIANT_ORIGINAL_NO_PADDING, $content];

        yield ['BDYIbBdXQcAjQpTC039N-hDvngft6n_W-d6YjaGy3XUoVnR79ZN0DDd8LkQVxMKVZu6uTIygLs8Hv-je_eYvYw==', Base64::BASE64_VARIANT_URLSAFE, $content];

        yield ['BDYIbBdXQcAjQpTC039N-hDvngft6n_W-d6YjaGy3XUoVnR79ZN0DDd8LkQVxMKVZu6uTIygLs8Hv-je_eYvYw', Base64::BASE64_VARIANT_URLSAFE_NO_PADDING, $content];
    }

    public static function provideEncodeUrlsafeCases(): iterable
    {
        yield [
            '3e22b8a61994c7bcb8fdceaf8ca4991c4f51769ff0440a9b23fbbcd0678b32a640efa4fffbd3dff9061b3f1cf77518b798eafe9dee5ded4ef8628f873ed8d4ec',
            'PiK4phmUx7y4_c6vjKSZHE9Rdp_wRAqbI_u80GeLMqZA76T_-9Pf-QYbPxz3dRi3mOr-ne5d7U74Yo-HPtjU7A',
        ];
    }

    public static function provideDecodeUrlsafeCases(): iterable
    {
        yield [
            'BDYIbBdXQcAjQpTC039N-hDvngft6n_W-d6YjaGy3XUoVnR79ZN0DDd8LkQVxMKVZu6uTIygLs8Hv-je_eYvYw',
            '0436086c175741c0234294c2d37f4dfa10ef9e07edea7fd6f9de988da1b2dd752856747bf593740c377c2e4415c4c29566eeae4c8ca02ecf07bfe8defde62f63',
        ];
    }
}
