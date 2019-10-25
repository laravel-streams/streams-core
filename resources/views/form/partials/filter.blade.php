<input
        value="{{ $fieldType->value }}"
        class="{{ $fieldType->class }}"
        name="{{ $fieldType->getInputName() }}"
        type="{{ $fieldType->config('type', 'text') }}"
        placeholder="{{ $fieldType->placeholder }}">
