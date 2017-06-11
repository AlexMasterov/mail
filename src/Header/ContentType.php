<?php
declare(strict_types=1);

namespace Genkgo\Mail\Header;

use Genkgo\Mail\HeaderInterface;

final class ContentType implements HeaderInterface
{
    /**
     * @var string
     */
    private $contentType;
    /**
     * @var string
     */
    private $charset;

    /**
     * From constructor.
     * @param string $contentType
     * @param string $charset
     */
    public function __construct(string $contentType, string $charset = '')
    {
        $this->contentType = $contentType;

        if ($charset === '' && substr($contentType, 0, 5) === 'text/') {
            $charset = 'UTF-8';
        }

        $this->charset = $charset;
    }

    /**
     * @return HeaderName
     */
    public function getName(): HeaderName
    {
        return new HeaderName('Content-Type');
    }

    /**
     * @return HeaderValue
     */
    public function getValue(): HeaderValue
    {
        if ($this->charset === '') {
            return new HeaderValue($this->contentType);
        }

        return (new HeaderValue($this->contentType))
            ->withParameter(
                new HeaderValueParameter(
                    'charset',
                    $this->charset
                )
            );
    }

    /**
     * @return ContentType
     */
    public static function unknown(): ContentType
    {
        return new self('application/octet-stream', '');
    }
}