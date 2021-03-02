import { Application } from './Application';

export class ServiceProvider {
    
    constructor(app) {
        this.app = app;
    }

    register() {
        //console.log('Registering');
    }

    boot() {
        //console.log('Booting');
    }
}
