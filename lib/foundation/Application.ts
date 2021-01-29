import { AsyncContainerModule, Container, decorate, injectable, interfaces, named, optional, postConstruct, tagged, unmanaged } from 'inversify';
import { merge }                                                                                                                from 'lodash';
import { Dispatcher }                                                                                                           from './Dispatcher';
import { ServiceProvider }                                                                                                      from './ServiceProvider';
import { Config }                                                                                                               from './Config';
import debug                                                                                                                    from 'debug';
import { autoProvide, buildProviderModule, fluentProvide, provide }                                                             from 'inversify-binding-decorators';
import createDecorators                                                                                                         from 'inversify-inject-decorators';
import { collect }                                                                                                              from './Collection';
import { IConfig }                                                                                                              from '../types';
import { Collection }                                                                                                           from 'collect.js';
import Alpine                                                                                                                   from 'alpinejs';

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

    protected static _instance: Application;

    static get instance() {
        if ( !this._instance ) {
            this._instance = new this();
        }
        return this._instance;
    }

    static set instance(instance) {
        this._instance = instance;
    }

    /**
     * Returns the singleton instance of Application
     * @return {Application}
     */
    static getInstance() {
        return this.instance;
    }

    loadedProviders: any = {};
    providers: any[]     = [];
    _booted: boolean     = false;
    _started: boolean    = false;
    events: Dispatcher;
    config: Collection<IConfig>;

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
        this.instance('config', collect<IConfig>({} as IConfig));
        this.addBindingGetter('config');
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
        this.events.emit('bootstrap', options); //this.hooks.bootstrap.call(options);

        this.instance('data', Config.proxied(options.data));
        this.addBindingGetter('data');

        await this.loadProviders(options.providers);
        this.configure(options.config);

        await this.registerProviders(this.providers);
        this.events.emit('bootstrapped', options);
        return this;
    }

    private async loadProviders(Providers) {
        log('loadProviders', { Providers });
        this.events.emit('loadProviders', Providers);
        await Promise.all(Providers.map(async Provider => this.loadProvider(Provider)));
        this.events.emit('loadedProviders', this.providers);
        return this;
    }

    boot = async () => {
        if ( this._booted ) {
            return this;
        }
        this._booted = true;
        log('boot');
        this.events.emit('boot');
        for ( const provider of this.providers ) {
            if ( 'boot' in provider && Reflect.getMetadata('boot', provider) !== true ) {
                this.events.emit('bootProvider', provider);
                Reflect.defineMetadata('boot', true, provider);
                await provider.boot();
                this.events.emit('bootedProvider', provider);
            }
        }
        this.events.emit('booted');
        return this;
    };


    getConfigDefaults(): IConfig {
        return {
            prefix    : 'streams',
            debug     : false,
            csrf      : null,
            delimiters: [ '\{\{', '}}' ],
        };
    }

    configure(config: IConfig) {
        this.config.merge(config);
        config = merge({}, this.getConfigDefaults, config);
        this.events.emit('app:configure', config);
        let instance = Config.proxied(config);
        this.instance('config', instance);
        this.events.emit('app:configured', instance);
        return this;
    }

    private async registerProviders(providers = this.providers) {
        this.events.emit('registerProviders', providers);
        await Promise.all(this.providers.map(async Provider => this.register(Provider)));
        this.events.emit('registeredProviders', providers);
        return this;
    }

    register = async (Provider) => {
        log('register', { Provider });
        this.events.emit('registerProvider', Provider);
        let provider = Provider;
        if ( Provider instanceof ServiceProvider === false ) {
            provider = await this.loadProvider(Provider);
        }
        if ( 'register' in provider && Reflect.getMetadata('register', provider) !== true ) {
            Reflect.defineMetadata('register', true, provider);
            await this.loadAsync(new AsyncContainerModule(() => provider.register()));
        }
        this.providers.push(provider);
        this.events.emit('registeredProviders', provider);
        return this;
    };

    start = async (elementOrSelector = '#app') => {
        if ( this._started ) {
            throw new Error('Cannot start Application twice');
        }
        this._started = true;
        log('start');
        this.events.emit('start');
        /* This part is ment to kick start the application. */
        /* and is currently emtpy. awaiting purpose */
        window.startLoadingAlpine();
        const comps = document.querySelectorAll('[defer-x-data]');
        for ( const comp of comps ) {
            comp.setAttribute('x-data', comp.getAttribute('defer-x-data'));
            Alpine.initializeComponent(comp);
        }
        this.events.emit('started');
        log('started');
    };

    started(cb: (app: this) => any) {
        if ( this._started ) {
            cb(this);
        } else {
            this.events.on('started', () => cb(this));
        }
    }

    ctxfactory(id, factory: (ctx: interfaces.Context) => any) {
        this.bind(id).toFactory(ctx => factory(ctx));
        return this;
    }

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

    private async loadProvider(Provider) {
        const name = Provider.name ?? Provider.constructor.name;
        if ( name in this.loadedProviders ) {
            return this.loadedProviders[ name ];
        }
        log('loadProvider', { Provider });
        this.events.emit('loadProvider', Provider);
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
        this.loadedProviders[ name ] = provider;
        this.providers.push(provider);
        this.events.emit('loadedProvider', provider);
        log('loadedProvider', { Provider });
        return provider;
    }

    factory(id, factory) {
        this.bind(id).toFactory(ctx => factory);
        return this;
    }

    //endregion
}

const app                    = Application.instance;
window.app                   = app;
const { lazyInject: inject } = createDecorators(app);
export { app, inject };
export { provide, buildProviderModule, fluentProvide, autoProvide };
export { injectable, unmanaged, optional, decorate, named, tagged, postConstruct };
