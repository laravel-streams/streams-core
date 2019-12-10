<div class="modal__filter">

    @include('streams::modals/filter')

    <ul>
        @foreach ($fieldTypes->instances() as $fieldType)
            <li>{{$module->getNamespace('fields.create')}}
                <a href="{{ url()->route($module->getNamespace('fields.create')) . '?field_type=' . $fieldType->getNamespace() }}">
                    <strong>{{ trans($fieldType->getTitle()) }}</strong>
                    <br>
                    <small>{{ trans($fieldType->getDescription()) }}</small>
                </a>
            </li>
        @endforeach
    </ul>
</div>
