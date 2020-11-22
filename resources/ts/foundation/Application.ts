import { AsyncContainerModule, Container, decorate, injectable, named, optional, postConstruct, tagged, unmanaged } from 'inversify';
import { merge }                                                                                                    from 'lodash';
import { Dispatcher }                                                                                               from './Dispatcher';
import { ServiceProvider }                                                                                          from './ServiceProvider';
import { Config }                                                                                                   from './Config';
import debug                                                                                                        from 'debug';
import { autoProvide, buildProviderModule, fluentProvide, provide }                                                 from 'inversify-binding-decorators';
import createDecorators                                                                                             from 'inversify-inject-decorators';

const log = debug('Application');

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
export class Application extends Container {

    /**
     * Returns the singleton instance of Application
     * @return {Application}
     */
    static getInstance() {
        return Application._instance;
    }

    static _instance: Application;
    loadedProviders: any  = {};
    providers: any[]      = [];
    booted: boolean       = false;
    started: boolean      = false;
    shuttingDown: boolean = false;
    startEnabled: boolean = true;
    events: Dispatcher;

    /**
     * @private
     */
    private constructor() {
        super({
            autoBindInjectable : false,
            defaultScope       : 'Transient',
            skipBaseClassChecks: false,
        });
        Application._instance = this;
        this.instance('app', this);
        this.singleton('events', Dispatcher);
        this.addBindingGetter('events');
        this.instance('config', {});
    }

    /**
     * Starts bootstrapping the application with the given options.
     * - This would be the place to add all your ServiceProviders
     * - Add or modify additional config
     * - Add data from the backend which you want to be accessible troughout in your javascripts
     * @param {any} _options
     * @param {any} mergeOptions
     * @return {Promise<Application>}
     */
    async bootstrap(_options, ...mergeOptions) {
        let options = merge({
            providers: [],
            config   : {},
            data     : {},
        }, _options, ...mergeOptions);
        log('bootstrap', { options });
        this.events.emit('app:bootstrap', options); //this.hooks.bootstrap.call(options);

        this.instance('data', Config.proxied(options.data));
        this.addBindingGetter('data');

        await this.loadProviders(options.providers);
        this.configure(options.config);

        await this.registerProviders(this.providers);
        this.events.emit('app:bootstrapped', options);
        return this;
    }

    private async loadProviders(Providers) {
        log('loadProviders', { Providers });
        this.events.emit('loadProviders', Providers);
        await Promise.all(Providers.map(async Provider => this.loadProvider(Provider)));
        this.events.emit('loadedProviders', this.providers);
        return this;
    }

    private async loadProvider(Provider) {
        if ( Provider.name in this.loadedProviders ) {
            return this.loadedProviders[ Provider.name ];
        }
        log('loadProvider', { Provider });
        this.events.emit('app:provider:load', Provider);
        let provider = new Provider(this);
        if ( 'configure' in provider && Reflect.getMetadata('configure', provider) !== true ) {
            const defaults = this.getConfigDefaults();
            Reflect.defineMetadata('configure', true, provider);
            await provider.configure(defaults);
        }
        if ( 'providers' in provider && Reflect.getMetadata('providers', provider) !== true ) {
            Reflect.defineMetadata('providers', true, provider);
            await this.loadProviders(provider.providers);
        }
        this.loadedProviders[ Provider.name ] = provider;
        this.providers.push(provider);
        this.events.emit('app:provider:loaded', provider);
        return provider;
    }

    getConfigDefaults() {
        return {
            prefix    : 'streams',
            debug     : false,
            csrf      : null,
            delimiters: [ '\{\{', '}}' ],
        };
    }

    configure(config) {
        config = merge({}, this.getConfigDefaults, config);
        this.events.emit('app:configure', config);
        let instance = Config.proxied(config);
        this.instance('config', instance);
        this.events.emit('app:configured', instance);
        return this;
    }

    private async registerProviders(providers = this.providers) {
        this.events.emit('app:registerProviders', providers);
        await Promise.all(this.providers.map(async Provider => this.register(Provider)));
        this.events.emit('app:registeredProviders', providers);
        return this;
    }

    register = async (Provider) => {
        log('register', { Provider });
        this.events.emit('app:provider:register', Provider);
        let provider = Provider;
        if ( Provider instanceof ServiceProvider === false ) {
            provider = await this.loadProvider(Provider);
        }
        if ( 'register' in provider && Reflect.getMetadata('register', provider) !== true ) {
            Reflect.defineMetadata('register', true, provider);
            await this.loadAsync(new AsyncContainerModule(() => provider.register()));
        }
        this.providers.push(provider);
        this.events.emit('app:provider:registered', provider);
        return this;
    };

    boot = async () => {
        if ( this.booted ) {
            return this;
        }
        log('boot');
        this.booted = true;
        this.events.emit('app:boot');
        for ( const provider of this.providers ) {
            if ( 'boot' in provider && Reflect.getMetadata('boot', provider) !== true ) {
                this.events.emit('app:provider:booting', provider);
                Reflect.defineMetadata('boot', true, provider);
                await provider.boot();
                this.events.emit('app:provider:booted', provider);
            }
        }
        this.events.emit('app:booted');
        return this;
    };


    start = async (elementOrSelector = '#app') => {
        /* This part is ment to kick start the application. */
        /* and is currently emtpy. awaiting purpose */

        this.events.emit('app:started');
        log('started');
    };


    error = async (error) => {
        log('error', { error });
        this.events.emit('app:error', error);
        throw error;
    };

    addBindingGetter(id, key = null) {
        key        = key || id;
        const self = this;
        Object.defineProperty(this, key, {
            get() {
                return self.get(id);
            },
        });
    }

    //region: ioc helpers
    alias(abstract, alias, singleton = false) {
        let binding = this.bind(alias).toDynamicValue(ctx => ctx.container.get(abstract));
        if ( singleton ) {
            binding.inSingletonScope();
        }
        return this;
    }

    bindIf(id, override, cb) {
        if ( this.isBound(id) && !override ) return this;
        cb(this.isBound(id) ? this.rebind(id) : this.bind(id));
        return this;
    }

    dynamic(id, cb) {
        return this.bind(id).toDynamicValue(ctx => {
            let req = ctx.currentRequest;
            return cb(this);
        });
    }

    singleton(id, value, override = false) {
        return this.bindIf(id, override, b => b.to(value).inSingletonScope());
    }

    binding(id, value) {
        this.bind(id).to(value);
        return this;
    }

    instance(id, value, override = false) {
        return this.bindIf(id, override, b => b.toConstantValue(value));
    }

    ctxfactory(id, factory) {
        this.bind(id).toFactory(ctx => factory(ctx));
        return this;
    }

    factory(id, factory) {
        this.bind(id).toFactory(ctx => factory);
        return this;
    }

    //endregion


    // /** @return {Storage} */
    // get storage() {
    //     return this.get('storage');
    // }
    //
    // /** @return {Cookies} */
    // get cookies() {
    //     return this.get('cookies');
    // }
    //
    // /** @return {Dispatcher} */
    // get events() {
    //     return this.get('events');
    // }
    //
    // /** @return {Config} */
    // get data() {
    //     return this.get('data');
    // }
    //
    // /** @return {Config} */
    // get config() {
    //     return this.get('config');
    // }
}

const app                    = Application._instance;
const { lazyInject: inject } = createDecorators(app);
export { app, inject };
export { provide, buildProviderModule, fluentProvide, autoProvide };
export { injectable, unmanaged, optional, decorate, named, tagged, postConstruct };
