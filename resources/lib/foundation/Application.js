import {
    ServiceProvider
} from './ServiceProvider';

/**
 * The main application has some similarity to laravel.
 *
 * - IoC Container
 * - Registers and boots Service Providers to provide a easy way into the application cycle and access to the IoC container
 * - The global event thread. Event listeners and dispatchers etc
 *
 * Lifecycle:
 *
 *  1. bootstrap()
 *  - This will take all the given providers and loop trough them, by loading and registering them with calling their (if existing) register function.
 *    That's the place to make bindings into the container, start event listeners, read/write cookies and local storage.
 *  - The given configuration will be sorted here
 *  - Once done it'll return a promise with the instance of the Application
 *
 *  2. boot()
 *  - This will take all the given providers and loop trough them, by loading and registering them with calling their (if existing) boot function.
 *    Additional operations can now take place because all bindings should be set
 *  - Once done it'll return a promise with the instance of the Application
 *
 *  3. start()
 *  - Starts the application. Currently based on Vue, but can just as well be for anything other then that.
 *
 *  So an simple example of what a Service Provider looks like {@see StreamsServiceProvider}
 * })
 *
 * @class
 */
export class Application {

    static get instance() {
        if (!this._instance) {
            this._instance = new this();
        }
        return this._instance;
    }

    static set instance(instance) {
        this._instance = instance;
    }

    /**
     * Returns a singleton
     * instance of Application
     * @return {Application}
     */
    static getInstance() {
        return this.instance;
    }

    /**
     * @private
     */
    constructor() {
        Application._instance = this;
        this.loadedProviders = {};
        this.providers = [];
        this.booted = false;
        this.started = false;
        //this.instance('app', this);
    }

    async loadProviders(Providers) {

        await Promise.all(Providers.map(async Provider => this.loadProvider(Provider)));

        return this;
    }

    async loadProvider(Provider) {

        if (Provider.name in this.loadedProviders) {
            return this.loadedProviders[Provider.name];
        }


        let provider = new Provider(this);

        this.loadedProviders[Provider.name] = provider;

        this.providers.push(provider);


        return provider;
    }

    async registerProviders(providers = this.providers) {

        await Promise.all(this.providers.map(async Provider => this.register(Provider)));

        return this;
    }

    async register(Provider) {

        let provider = Provider;

        if (Provider instanceof ServiceProvider === false) {
            provider = await this.loadProvider(Provider);
        }

        this.providers.push(provider);

        return this;
    };

    async boot() {

        if (this.booted) {
            return this;
        }


        for (const provider of this.providers) {
            await provider.boot();
        }

        return this;
    };


    async start(elementOrSelector = '#app') {

        /* This part is ment to kick start the application. */
        /* and is currently emtpy. awaiting purpose */


    };
}

const app = Application.instance;

export {
    app
};
