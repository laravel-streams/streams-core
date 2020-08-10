---
title: Streams
handle: streams
intro: A Stream is a data-model configuration.
---

A Stream is a basic `json` file that describes a data's schema, source, and qualities using with minimal input required from you. The detail and versatility supported inside these configuration files however, is extensive.

## Basic Configuration

You can use the following basic configuration example to get started exploring Streams and some music.

This is a minimally viable Stream definition :-) 

```json
// streams/music.json
{
	"name": "Music",
	"fields": {
		"title": "string",
		"artist": "string",
		"embed": "textarea",
		"link": "url",
	}
}
```

## Creating Entries

You can get started right away creating entries by simply creating a JSON file

```json
// streams/data/music/ava-adore.json
{
	"data": {
		"title": "Ava Adore",
		"artist": "The Smashing Pumpkins",
		"embed": "<iframe src="https://open.spotify.com/embed/track/6bVB2MGR7LcotAIB1vfpw6" width="300" height="380" frameborder="0" allowtransparency="true" allow="encrypted-media"></iframe>"
		"link": "https://open.spotify.com/track/6bVB2MGR7LcotAIB1vfpw6?si=xj196F1uQ5GTz6z4W0MM9w"
	}
}
```

### Via Streams Manager

```php
Streams::entries('music')->create([
	"id": "diamond-eyes",
	"title": "Diamond Eyes",
	"artist": "Deftones",
	"embed": "<iframe src="https://open.spotify.com/embed/track/6nmDEbjMZru5j55HIkX2yZ" width="300" height="380" frameborder="0" allowtransparency="true" allow="encrypted-media"></iframe>"
	"link": "https://open.spotify.com/track/6nmDEbjMZru5j55HIkX2yZ?si=SzI4jcofQwW5ZJbWRvhdzA"
]);
```

### Via Control Panel

> TBD

- `/cp/streams/music/create`
- `/cp/streams/music/edit/ava-adore`

## Fetching Entries

You can now fetch entry data from the Stream:

```blade
@foreach (Streams::entries('music')->get() as $song)
    <h3>{{ $song->title }} <small>{{ $song }}</small></h3>
    {!! $song->expand('url')->link('Listen', [
	    '_target' => 'blank',
    ]) !!}
@endforeach
```

### Via API

> TBD

- `/api/streams/music'
- `/api/streams/music/beauty-and-the-grim'

### Via Graph-QL

> TBD

```json
{
  music(id: "the-motherload") {
    title
    artist
    link(link: Listen, target: blank)
  }
}
```

## Updating Entries

Besides simply editing the `json` file manually you can also programmatically update entries.

```php
$entry = Streams::make('pages')->find('myfeelingshavefeelings');

$entry->artist = 'Bilmuri';
$entry->link = 'https://open.spotify.com/track/5gBQmRUJa29eBwgLMF4wTP?si=W7fvMPmkSnqvyDCXmytpDQ';

$entry->save();
```

### Deleting Entries

Just like manually deleting the `json` file, deleting entries programmatically is super tough.

```php
$entry = Streams::make('pages')->find('rickroll');

$entry->delete();
```
