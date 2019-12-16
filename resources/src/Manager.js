import {Application} from './Application';
import {app} from './app';

export class Manager {
    /**
     *
     * @param {Application} app
     */
    constructor(app) {
        this.app = app;
        this.customCreators = [];
        this.drivers = [];
    }

    getDefaultDriver() {
        throw new Error('This should be implemented in the child class');
    }

    driver(driver = null) {
        if ( driver === null ) {
            driver = this.getDefaultDriver();
        }
        if ( driver in this.drivers ) {
            return this.drivers[driver];
        }
        return this.createDriver(driver);
    }


    createDriver(driver) {

    }

    extend(driver, callback) {
        this.customCreators[driver] = callback;
    }

    getDrivers() {
    }

    getProxy(){
        const proxy = new Proxy(manager, {
            get(target, p, receiver) {
                if(target[p] !== undefined){
                    return target[p];
                }
                const driver=target.driver();
                if(driver[p] !== undefined){
                    return driver[p];
                }
                throw new Error('Property does not exist: ' + p)
            }
        })
        return proxy;
    }
}


export class StorageManager extends Manager {

    getDefaultDriver() {
        return 'local';
    }
}

class StorageDriver {
    get(key, defaultValue=null, options={}) {
        throw new Error('Not implemented');
    }

    has(key) {
        throw new Error('Not implemented');
    }

    set(key, value) {
        throw new Error('Not implemented');
    }

    unset(key) {
        throw new Error('Not implemented');
    }

    clear() {
        throw new Error('Not implemented');
    }
}

let manager = new StorageManager(app);
manager = manager.getProxy();

manager.extend('local', function () {
    return new LocalStorage();
});


export class LocalStorage {

}