# Mail

- [Introduction](#introduction)
- [Localization](#localization)
    - [Translatable Messages](#translatable-messages)

<hr>

<a name="introduction"></a>
## Introduction

Sending mail in PyroCMS work exactly the same as [mail in Laravel](https://laravel.com/docs/5.1/mail).

<hr>

<a name="localization"></a>
## Localization

PyroCMS adds localization to Laravel's mail service. Sending translated mail is nearly identical to sending normal mail and safely falls back if a translated message view is not available.

<a name="translatable-messages"></a>
### Translatable Messages

To get started sending translatable messages simply send a message using a template in the `message` like `module::message/example`.

<div class="alert alert-info">
<strong>Note:</strong> Translating mail is attempted **only** when the view resides within the "message" directory.
</div>

This will attempt to locate the translated view at `module::message/{$locale}/example` where `$locale` is the current locale. If the view does not exist the mailer will automatically look for the same message in the fallback locale directory. If _that_ view does not exist then the path will be used literally as it was originally passed in.

	\Mailer::send('module::message/welcome', compact('user'), function(Message $message) use ($user) {
		$message->from('hello@app.com', 'Your Application');
		$message->to($user->email, $user->name)->subject('Welcome!');
	});

You can also force the mailer to use a specific `locale` by passing it into the view path like normal. If the provided path contains a locale but *does not exist* then the fallback locale will be used.

	// Falls back to 'module::message/en/welcome'
	\Mailer::send('module::message/fr/welcome', compact('user'), function(Message $message) use ($user) {
		$message->from('hello@app.com', 'Your Application');
		$message->to($user->email, $user->name)->subject('Welcome!');
	});