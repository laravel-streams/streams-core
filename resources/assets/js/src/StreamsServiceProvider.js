import Buttons from '../components/Buttons.vue';
import Button from '../components/Button.vue';

import Table from '../components/Table.vue';
import TableViews from '../components/TableViews.vue';
import TableFilters from '../components/TableFilters.vue';
import TableHeading from '../components/TableHeading.vue';

import Form from '../components/Form.vue';
import FormField from '../components/FormField.vue';

import {ServiceProvider} from './ServiceProvider';

export class StreamsServiceProvider extends ServiceProvider {
    boot(){
        
        Vue.component('cp-buttons', Buttons);
        Vue.component('cp-button', Button);

        Vue.component('cp-table', Table);
        Vue.component('cp-table-views', TableViews);
        Vue.component('cp-table-filters', TableFilters);
        Vue.component('cp-table-heading', TableHeading);

        Vue.component('cp-form', Form);
        Vue.component('cp-form-field', FormField);
    }
}
