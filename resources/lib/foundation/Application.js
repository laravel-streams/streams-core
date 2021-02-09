import {
    ServiceProvider
} from './ServiceProvider';

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
        this.loadedProviders = {};
        this.providers = [];
        this.booted = false;
        this.started = false;
    }

    async bootstrap(options = {}) {

        await this.loadProviders(options.providers);
        
        this.registerProviders(this.providers);

        return this;
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

    async registerProviders(providers) {

        await Promise.all(providers.map(async Provider => this.register(Provider)));

        return this;
    }

    async register(Provider) {

        let provider = Provider;

        provider.register();

        return this;
    };

    async boot() {

        if (this.booted) {
            return this;
        }


        for (const provider of this.providers) {
            await provider.boot();
        }

        this.booted = true;

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
