<?php namespace Anomaly\Streams\Platform\Support;

/**
 * Class Markdown
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Markdown extends \ParsedownExtra
{

    /**
     * Custom attributes on block quotes.
     *
     * @param $Line
     * @return array
     */
    protected function blockQuote($Line)
    {
        $Quote = parent::blockQuote($Line);

        if (preg_match(
            '/[ #]*{(' . $this->regexAttribute . '+)}[ ]*$/',
            $Quote['element']['text'][0],
            $matches,
            PREG_OFFSET_CAPTURE
        )) {
            $attributeString = $matches[1][0];

            $Quote['element']['attributes'] = $this->parseAttributeData($attributeString);

            $Quote['element']['text'][0] = substr($Quote['element']['text'][0], 0, $matches[0][1]);
        }

        return $Quote;
    }


}
