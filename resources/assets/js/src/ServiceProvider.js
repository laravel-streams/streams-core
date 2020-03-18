import {Application} from './Application';
import Vue from 'vue';

export class ServiceProvider {
    
    /**
     * Create a new ServiceProvider instance.
     * 
     * @param {Application} app
     */
    constructor(app) {
        this.app = app;
    }
}
