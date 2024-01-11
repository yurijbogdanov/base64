# PHP Base64 (encode/decode) Library

[![Latest Stable Version](http://poser.pugx.org/yurijbogdanov/base64/v)](https://packagist.org/packages/yurijbogdanov/base64)
[![Total Downloads](http://poser.pugx.org/yurijbogdanov/base64/downloads)](https://packagist.org/packages/yurijbogdanov/base64)
[![License](http://poser.pugx.org/yurijbogdanov/base64/license)](https://packagist.org/packages/yurijbogdanov/base64)
[![PHP Version Require](http://poser.pugx.org/yurijbogdanov/base64/require/php)](https://packagist.org/packages/yurijbogdanov/base64)


## Installation
```terminal
composer require yurijbogdanov/base64
```


## Usage
Encode:
```terminal
$content = 'hello WoRld 123 ~~~';
$encodedContent = Base64::encode($content); // aGVsbG8gV29SbGQgMTIzIH5+fg==
```

Encode with variant:
```terminal
$content = 'hello WoRld 123 ~~~';
$encodedContent = Base64::encode($content, Base64::BASE64_VARIANT_ORIGINAL); // aGVsbG8gV29SbGQgMTIzIH5+fg==
$encodedContent = Base64::encode($content, Base64::BASE64_VARIANT_ORIGINAL_NO_PADDING); // aGVsbG8gV29SbGQgMTIzIH5+fg
$encodedContent = Base64::encode($content, Base64::BASE64_VARIANT_URLSAFE); // aGVsbG8gV29SbGQgMTIzIH5-fg==
$encodedContent = Base64::encode($content, Base64::BASE64_VARIANT_URLSAFE_NO_PADDING); // aGVsbG8gV29SbGQgMTIzIH5-fg
```

Encode urlsafe (Syntactic sugar for "Base64::encode($content, Base64::BASE64_VARIANT_URLSAFE_NO_PADDING)"):
```terminal
$content = 'hello WoRld 123 ~~~';
$encodedContent = Base64::encodeUrlsafe($content); // aGVsbG8gV29SbGQgMTIzIH5-fg
```

Decode:
```terminal
$content = 'aGVsbG8gV29SbGQgMTIzIH5+fg==';
$decodedContent = Base64::decode($content); // hello WoRld 123 ~~~
```

Decode with variant:
```terminal
$decodedContent = Base64::decode("aGVsbG8gV29SbGQgMTIzIH5+fg==", Base64::BASE64_VARIANT_ORIGINAL); // hello WoRld 123 ~~~
$decodedContent = Base64::decode("aGVsbG8gV29SbGQgMTIzIH5+fg", Base64::BASE64_VARIANT_ORIGINAL_NO_PADDING); // hello WoRld 123 ~~~
$decodedContent = Base64::decode("aGVsbG8gV29SbGQgMTIzIH5-fg==", Base64::BASE64_VARIANT_URLSAFE); // hello WoRld 123 ~~~
$decodedContent = Base64::decode("aGVsbG8gV29SbGQgMTIzIH5-fg", Base64::BASE64_VARIANT_URLSAFE_NO_PADDING); // hello WoRld 123 ~~~
```

Decode urlsafe (Syntactic sugar for "Base64::decode($content, Base64::BASE64_VARIANT_URLSAFE_NO_PADDING)"):
```terminal
$content = 'aGVsbG8gV29SbGQgMTIzIH5-fg';
$decodedContent = Base64::decode($content); // hello WoRld 123 ~~~
```


## Usage via Terminal
List of commands:
```terminal
bin/base64
```

Encode:
```terminal
bin/base64 encode [CONTENT]
bin/base64 encode "hello WoRld 123 ~~~"
# Output: aGVsbG8gV29SbGQgMTIzIH5+fg==
```

Encode with variant:
```terminal
bin/base64 encode_with_variant [CONTENT] [VARIANT]
bin/base64 encode_with_variant "hello WoRld 123 ~~~" original
# Output: aGVsbG8gV29SbGQgMTIzIH5+fg==
bin/base64 encode_with_variant "hello WoRld 123 ~~~" original_no_padding
# Output: aGVsbG8gV29SbGQgMTIzIH5+fg
bin/base64 encode_with_variant "hello WoRld 123 ~~~" urlsafe
# Output: aGVsbG8gV29SbGQgMTIzIH5-fg==
bin/base64 encode_with_variant "hello WoRld 123 ~~~" urlsafe_no_padding
# Output: aGVsbG8gV29SbGQgMTIzIH5-fg
```

Encode urlsafe (Syntactic sugar for "bin/base64 encode_with_variant [CONTENT] urlsafe_no_padding"):
```terminal
bin/base64 encode_urlsafe [CONTENT]
bin/base64 encode_urlsafe "hello WoRld 123 ~~~"
# Output: aGVsbG8gV29SbGQgMTIzIH5-fg
```

Decode:
```terminal
bin/base64 decode [CONTENT]
bin/base64 decode aGVsbG8gV29SbGQgMTIzIH5+fg==
# Output: hello WoRld 123 ~~~
```

Decode with variant:
```terminal
bin/base64 decode_with_variant [CONTENT] [VARIANT]
bin/base64 decode_with_variant aGVsbG8gV29SbGQgMTIzIH5+fg== original
# Output: hello WoRld 123 ~~~
bin/base64 decode_with_variant aGVsbG8gV29SbGQgMTIzIH5+fg original_no_padding
# Output: hello WoRld 123 ~~~
bin/base64 decode_with_variant aGVsbG8gV29SbGQgMTIzIH5-fg== urlsafe
# Output: hello WoRld 123 ~~~
bin/base64 decode_with_variant aGVsbG8gV29SbGQgMTIzIH5-fg urlsafe_no_padding
# Output: hello WoRld 123 ~~~
```

Decode urlsafe (Syntactic sugar for "bin/base64 decode_with_variant [CONTENT] urlsafe_no_padding"):
```terminal
bin/base64 decode_urlsafe [CONTENT]
bin/base64 decode_urlsafe aGVsbG8gV29SbGQgMTIzIH5-fg
# Output: hello WoRld 123 ~~~
```
