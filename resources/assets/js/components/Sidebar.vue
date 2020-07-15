<template>
    <div id="sidebar">
        <ul v-for="link in links" :key="link.slug">
            <li v-for="section in link.sections" :key="section.slug">
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
    </div>
</template>

<script>
export default {
    props: {
        links: Array,
    },
    ready() {
        console.log("Sidebar ready.");
    }
};
</script>
