<?php namespace Anomaly\Streams\Platform\View\Support;

use Twig\Token;
use Twig\TokenParser\AbstractTokenParser;

/**
 * Class CompressHtmlTokenParser
 *
 * HUGE thanks to @zvineyard for his work on a
 * simple and fast HTML compression technique!
 *
 * @link   https://github.com/zvineyard
 * @link   http://pyrocms.com/
 * @author Zack Vineyard
 * @author Ryan Thompson <ryan@pyrocms.com>
 * @author PyroCMS, Inc. <support@pyrocms.com>
 */
class CompressHtmlTokenParser extends AbstractTokenParser
{

    /**
     * Parse the token.
     *
     * @param Token $token
     * @return CompressHtmlNode
     */
    public function parse(Token $token)
    {
        $line_number = $token->getLine();

        $stream = $this->parser->getStream();

        $stream->expect(Token::BLOCK_END_TYPE);

        $body = $this->parser->subparse([$this, 'decideHtmlCompressEnd'], true);

        $stream->expect(Token::BLOCK_END_TYPE);

        $nodes = ['content' => $body];

        return new CompressHtmlNode($nodes, [], $line_number, $this->getTag());
    }

    /**
     * Get the tag.
     *
     * @return string
     */
    public function getTag()
    {
        return 'htmlcompress';
    }

    /**
     * Get the closing tag decision.
     *
     * @param Token $token
     * @return bool
     */
    public function decideHtmlCompressEnd(Token $token)
    {
        return $token->test('endhtmlcompress');
    }
}
