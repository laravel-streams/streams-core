<template>
    <ul>
        <li v-for="section in sections" :key="section.slug">
            <a :href="section.attributes.href" :class="{'active':section.active}">
                <!-- {!! $section->icon() !!} -->
                {{ section.title }}

                <!-- @if ($section->getLabel())    
                    <span class="tag {{ $section->getContext() }}">
                        {{ $section->getLabel() }}
                    </span>
                @endif -->
            </a>
        </li>
    </ul>
</template>

<script>
export default {
    props: {
        sections: Array,
    },
    ready() {
        console.log("Sections ready.");
    }
};
</script>
