<?php

namespace Streams\Core\Image;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Intervention\Image\Constraint;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Traits\Macroable;
use Streams\Core\Support\Facades\Images;
use Streams\Core\Support\Traits\Prototype;
use Intervention\Image\Image as InterventionImage;

abstract class Image
{
    use Macroable;
    use Prototype;

    abstract public function assetUrl(): string;

    abstract public function exists(): bool;

    abstract public function size(): int;

    abstract public function lastModified(): int;

    abstract public function data(): string;

    abstract protected function output(): Image;

    abstract protected function intervention(): InterventionImage;

    abstract public function save(InterventionImage $intervention): void;

    public function img(string $alt = null, array $attributes = []): string
    {
        $attributes = array_merge((array)$this->getPrototypeAttribute('attributes') ?: [], $attributes);

        if (!isset($attributes['src'])) {
            $attributes['src'] = $this->url();
        }

        if ($alt) {
            $attributes['alt'] = $alt;
        }

        if (!isset($attributes['alt']) && Config::get('streams.core.auto_alt', true)) {
            $attributes['alt'] = $this->altTag();
        }

        return '<img' . Arr::htmlAttributes($attributes) . '>';
    }

    public function picture(array $sources = []): string
    {
        foreach ($sources as $media => &$source) {

            $image = Images::make(Arr::pull($source, 'source', $this->source));

            $image->addAttribute('media', $media);

            foreach ($source as $method => $arguments) {
                if (is_array($arguments)) {
                    call_user_func_array([$image, $method], $arguments);
                } else {
                    call_user_func([$image, $method], $arguments);
                }
            }

            $source = $image->source();
        }

        $sources = implode("\n", $sources);

        $sources .= "\n" . $this->img();

        return "<picture>\n{$sources}\n</picture>";
    }

    protected function source(array $attributes = []): string
    {
        $attributes = array_merge(
            $this->attributes ?: [],
            ['srcset' => $this->url()],
            $attributes
        );

        return '<source' . Arr::htmlAttributes($attributes) . '>';
    }

    public function links(array $sources = []): string
    {
        foreach ($sources as &$source) {

            $image = Images::make(Arr::pull($source, 'source', $this->source));

            foreach ($source as $method => $arguments) {
                if (is_array($arguments)) {
                    call_user_func_array([$image, $method], $arguments);
                } else {
                    call_user_func([$image, $method], $arguments);
                }
            }

            $source = $image->link();
        }

        return implode("\n", $sources);
    }

    protected function link(): string
    {
        if (!isset($attributes['href'])) {
            $attributes['href'] = $this->url();
        }

        $attributes['type'] = 'image/' . $this->extension();

        return '<link' . Arr::htmlAttributes($attributes) . '>';
    }

    public function base64(): string
    {
        $extension = $this->extension();

        if ($extension == 'svg') {
            $extension = 'svg+xml';
        }

        return 'data:image/' . $extension . ';base64,' . base64_encode($this->data());
    }

    public function inline($alt = null, array $attributes = []): string
    {
        $attributes['src'] = $this->base64();

        return $this->version(false)->img($alt, $attributes);
    }

    public function url(array $parameters = [], $secure = null): string
    {
        if (
            Config::get('streams.core.version_images', true)
            && $this->version !== false
        ) {
            $parameters['v'] = is_bool($this->version) ? $this->lastModified() : $this->version;
        }

        $parameters = array_filter($parameters) ? '?' . http_build_query($parameters) : null;

        return URL::asset($this->outputImage()->assetUrl($secure) . $parameters, $secure);
    }

    public function css(): string
    {
        return 'url(' . $this->url() . ')';
    }

    public function extension(): string
    {
        if ($this->extension) {
            return $this->extension;
        }

        return $this->extension = pathinfo($this->source, PATHINFO_EXTENSION);
    }

    public function srcset(array $sources): static
    {
        $sizes = array_keys($sources);

        foreach ($sources as &$source) {

            $image = Images::make(Arr::pull($source, 'source', $this->source));

            $intrinsic = Arr::pull($source, 'intrinsic');

            if ($intrinsic && is_numeric($intrinsic)) {
                $intrinsic = $intrinsic . 'w';
            }

            foreach ($source as $method => $arguments) {
                if (is_array($arguments)) {
                    call_user_func_array([$image, $method], $arguments);
                } else {
                    call_user_func([$image, $method], $arguments);
                }
            }

            $source = implode(' ', array_filter([$image->url(), $intrinsic]));
        }

        $this->addAttribute('srcset', implode(', ', $sources));
        $this->addAttribute('sizes', implode(', ', $sizes));

        return $this;
    }

    public function quality(int $quality): static
    {
        $this->quality = $quality;

        return $this;
    }

    public function rename(string $filename): static
    {
        $this->filename = $filename;

        return $this;
    }

    public function version(bool|string $version = true): static
    {
        $this->version = $version;

        return $this;
    }

    public function addAlteration(string $method, array $arguments = []): static
    {
        if ($method == 'resize') {
            $this->guessResizeArguments($arguments);
        }

        $alterations = $this->alterations;

        $alterations[$method] = $arguments;

        $this->alterations = $alterations;

        return $this;
    }

    protected function guessResizeArguments(array &$arguments): void
    {
        $arguments = array_pad($arguments, 3, null);

        if (end($arguments) instanceof \Closure) {
            return;
        }

        if (array_pop($arguments) !== false) {
            $arguments[] = function (Constraint $constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            };
        }
    }

    public function addAttribute(string $name, string|array $value): static
    {
        $attributes = $this->getPrototypeAttribute('attributes', []);

        $attributes[$name] = $value;

        $this->setPrototypeAttribute('attributes', $attributes);

        return $this;
    }

    protected function isAlteration(string $method): bool
    {
        return in_array($method, [
            'blur',
            'brightness',
            'colorize',
            'resizeCanvas',
            'contrast',
            'copy',
            'crop',
            'fit',
            'flip',
            'gamma',
            'greyscale',
            'grayscale',
            'heighten',
            'insert',
            'interlace',
            'invert',
            'limitColors',
            'pixelate',
            'opacity',
            'resize',
            'rotate',
            'amount',
            'widen',
            'orientate',
            'text',
        ]);
    }

    protected function altTag(): string
    {
        $name = $this->filename ?: $this->getPrototypeAttribute('original');

        return ucwords(
            Str::humanize(
                basename($name, '.' . pathinfo($name, PATHINFO_EXTENSION)),
                '^a-zA-Z0-9'
            )
        );
    }

    protected function shouldPublish(Image $output): bool
    {
        if (!$output->exists()) {
            return true;
        }

        if ($output->lastModified() < $this->lastModified()) {
            return true;
        }

        if (Config::get('app.debug') && Request::isNoCache()) {
            return true;
        }

        return false;
    }

    protected function publish(Image $output): void
    {
        $intervention = $this->intervention();

        if (
            function_exists('exif_read_data')
            && $intervention->exif('Orientation') > 1
        ) {
            $intervention->orientate();
        }

        foreach ($this->alterations ?: [] as $method => $arguments) {
            if (is_array($arguments)) {
                call_user_func_array([$intervention, $method], $arguments);
            } else {
                call_user_func([$intervention, $method], $arguments);
            }
        }

        $output->save($intervention);
    }

    protected function outputImage(): Image
    {
        $output = $this->output();

        if ($this->shouldPublish($output)) {
            $this->publish($output);
        }

        return $output;
    }

    protected function filename(): string
    {
        if ($this->filename) {
            return $this->filename;
        }

        if (!$this->alterations && !$this->quality) {
            return $this->getPrototypeAttribute('original');
        }

        return md5($this->getPrototypeAttribute('original')
            . json_encode([$this->alterations, $this->quality]))
            . '.' . $this->extension();
    }

    public function __call(string $method, array $parameters = [])
    {
        if ($this->isAlteration($method)) {

            if ($method == 'grayscale') {
                $method = 'greyscale';
            }

            return $this->addAlteration($method, $parameters);
        }

        if ($this->hasMacro(Str::snake($method))) {

            $macro = static::$macros[$method];

            if ($macro instanceof \Closure) {
                return call_user_func_array(
                    $macro->bindTo($this, static::class),
                    $parameters
                );
            }

            return $macro(...$parameters);
        }

        $this->addAttribute($method, array_shift($parameters));

        return $this;
    }

    public function __toString(): string
    {
        return $this->img();
    }
}
