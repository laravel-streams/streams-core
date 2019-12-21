import {Application} from './Application';
import Vue from 'vue';

export class ServiceProvider {
    /**
     * @param {Application} app
     */
    constructor(app) {
        this.app = app;
        console.log('ServiceProvider', new.target.name);
    }

    vuePlugin(plugin, options = {}) {
        this.app.events.on('app:booted', () => {
            Vue.use(plugin, options);
        });
        return this;
    }
}
