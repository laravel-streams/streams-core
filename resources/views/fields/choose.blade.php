<div class="modal-header">
    <button class="close" data-dismiss="modal">
        <span>&times;</span>
    </button>
    <h4 class="modal-title">{{ trans('streams::message.choose_field_type') }}</h4>
</div>

<div class="modal-body">

    {{-- {% include "streams::modals/filter" %} --}}

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
