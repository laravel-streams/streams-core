<?php

namespace Anomaly\Streams\Platform\Image;

use Anomaly\Streams\Platform\Support\Presenter;

/**
 * Class ImageResolver
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ImageFactory
{

    public function make(Image $image)    
    {
        $source = $image->getSource();
        
        if ($source instanceof Presenter) {
            $source = $source->getObject();
        }

        if ($source instanceof FieldType) {
            $source = $source->getValue();
        }

        // Replace path prefixes.
        if (is_string($source) && str_contains($source, '::')) {
            $source = $this->paths->realPath($source);

            $this->setOriginal(basename($source));
            $this->setExtension(pathinfo($source, PATHINFO_EXTENSION));
        }

        if (is_string($source) && str_is('*://*', $source) && !starts_with($source, ['http', 'https'])) {
            $this->setOriginal(basename($source));
            $this->setExtension(pathinfo($source, PATHINFO_EXTENSION));
        }

        if ($source instanceof FileInterface) {

            /* @var FileInterface $source */
            $this->setOriginal($source->getName());
            $this->setExtension($source->getExtension());

            $this->setWidth($source->getWidth());
            $this->setHeight($source->getHeight());

            if ($alt = array_get($source->getAttributes(), 'alt_text')) {
                $this->addAttribute('alt', $alt);
            }

            if ($title = array_get($source->getAttributes(), 'title')) {
                $this->addAttribute('title', $title);
            }
        }

        if ($source instanceof FilePresenter) {

            /* @var FilePresenter|FileInterface $source */
            $source = $source->getObject();

            $this->setOriginal($source->getName());
            $this->setExtension($source->getExtension());

            $this->setWidth($source->getWidth());
            $this->setHeight($source->getHeight());

            if ($alt = array_get($source->getAttributes(), 'alt_text')) {
                $this->addAttribute('alt', $alt);
            }

            if ($title = array_get($source->getAttributes(), 'title')) {
                $this->addAttribute('title', $title);
            }
        }

        $this->image = $source;

        return $this;
    }
}
