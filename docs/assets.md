---
title: Assets
intro: 
---

- Introduction
    //- https://laravel.com/docs/filesystem
- Configuring Assets
    - config(streams.assets) => list what they do
- Reading Assets
    - Named assets
    - Asset Sources
        - Path of the asset in filesystem.
        - URL of an asset (allow_url_fopen must be enabled).
        //- SplFileInfo instance (To handle Laravel file uploads via Symfony\Component\HttpFoundation\File\UploadedFile)
- Editing Assets
    - 
- Outputting Assets
    - url(array $attributes = [], $secure = null)
    - urls(array $attributes = [], $secure = null)
    - tag(array $attributes = [])
    - tags(array $attributes = [])
    - script(array $attributes = [])
    - scripts(array $attributes = [])
    - style(array $attributes = [])
    - styles(array $attributes = [])
    - inline()
    - inlines()
    - path()
    - paths()
    - content()
