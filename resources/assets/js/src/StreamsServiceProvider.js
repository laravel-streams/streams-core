import Buttons from '../components/Buttons.vue';
import Button from '../components/Button.vue';
import Table from '../components/Table.vue';

import Form from '../components/Form.vue';
import FormField from '../components/FormField.vue';

import {ServiceProvider} from './ServiceProvider';

export class StreamsServiceProvider extends ServiceProvider {
    boot(){
        
        Vue.component('cp-buttons', Buttons);
        Vue.component('cp-button', Button);

        Vue.component('cp-table', Table);

        Vue.component('cp-form', Form);
        Vue.component('cp-form-field', FormField);
    }
}
