import { Application } from './Application';

export class ServiceProvider {
    
    constructor(app) {
        this.app = app;
    }

    async register() {
        console.log('Registering');
    }

    async boot() {
        console.log('Bootering');
    }
}
