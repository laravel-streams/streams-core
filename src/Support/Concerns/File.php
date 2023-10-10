<?php

namespace Streams\Core\Support\Concners\File;

interface File
{
    public function getRelativePath(): string;
    public function getRelativePathName(): string;

    public function getFilename(): string;
    public function getName(): string;

    public function getMimeType(): ?string;
    public function getAlt(): ?string;
}
