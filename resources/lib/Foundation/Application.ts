import 'reflect-metadata';
import { AsyncContainerModule, Container, interfaces } from 'inversify';
import getDecorators from 'inversify-inject-decorators';
import { Dispatcher } from '@/Dispatcher/Dispatcher';
import { Repository } from '@/Config/Repository';
import { ApplicationInitOptions, Configuration } from '@/types/config';
import { IServiceProvider, IServiceProviderClass } from '@/Support/ServiceProvider';
import { isServiceProviderClass, makeLog } from '@/Support/utils';
import { Constructor, ServiceProvider } from '@/Support';
import ServiceIdentifier = interfaces.ServiceIdentifier;

const log = makeLog('Application');

export interface Application {
    events: Dispatcher;
    config: Repository<Configuration> & Configuration;
}

// Augment the DispatcherEvents interface with the events and payload types emitted in the application
declare module '../Dispatcher/Dispatcher' {
    export interface DispatcherEvents {
        'Application:initialize': [ ApplicationInitOptions ];
        'Application:initialized': [ Application ];
        'Application:boot': [ Application ];
        'Application:bootProvider': [ ServiceProvider ];
        'Application:bootedProvider': [ ServiceProvider ];
        'Application:booted': [ Application ];
        'Application:start': [ Application ];
        'Application:started': [ Application ];
        'Application:loadProvider': [ Constructor<ServiceProvider> ];
        'Application:loadedProvider': [ ServiceProvider ];
        'Application:registerProviders': [ Array<Constructor<ServiceProvider>> ];
        'Application:registerProvider': [ Constructor<ServiceProvider> ];
        'Application:registeredProviders': [ ServiceProvider ];
    }
}

export class Application extends Container {

    /**
     * The application instance.
     */
    protected static _instance: Application;

    /**
     * Configured service providers.
     */
    protected providers = [];

    /**
     * Loaded service providers.
     */
    protected loaded = {};

    /**
     * The booted flag.
     */
    protected booted = false;

    /**
     * The started flag.
     */
    protected started = false;

    /**
     * Get/create the instance.
     */
    public static get instance() {

        if ( !this._instance ) {
            this._instance = new this();
        }

        return this._instance;
    }

    /**
     * Return a singleton
     * instance of Application
     *
     * @return {Application}
     */
    public static getInstance() {
        return this.instance;
    }

    /**
     * Return whether the
     * application has booted.
     *
     * @returns bool
     */
    public isBooted() { return this.booted; }

    /**
     * Return whether the
     * application has started.
     *
     * @returns bool
     */
    public isStarted() { return this.started; }

    /**
     * Create a new Application instance.
     */
    private constructor() {

        super({
            defaultScope       : 'Transient',
            autoBindInjectable : true,
            skipBaseClassChecks: true,
        });

        this.singleton('events', Dispatcher).addBindingGetter('events');

        this.events.any(
            (eventName: string, ...args: any[]) => log(eventName, ' arguments: ', args),
        );
    }

    /**
     * Initialize the application.
     *
     * @param options
     * @returns
     */
    public async initialize(options: ApplicationInitOptions = {}) {

        options = {
            providers: [],
            config   : {},
            ...options,
        };

        this.events.emit('Application:initialize', options);

        this.instance('config', Repository.asProxy(options.config)).addBindingGetter('config');

        await this.loadProviders(options.providers);
        await this.registerProviders(this.providers);

        this.events.emit('Application:initialized', this);
        return this;
    }

    /**
     * Boot the application.
     *
     * @returns
     */
    public async boot(): Promise<this> {

        /**
         * Don't boot more than once!
         */
        if ( this.booted ) {
            return this;
        }

        this.events.emit('Application:boot', this);

        for ( const provider of this.providers ) {

            this.events.emit('Application:bootProvider', provider);

            if ( 'boot' in provider && Reflect.getMetadata('boot', provider) !== true ) {
                Reflect.defineMetadata('boot', true, provider);

                await this.loadAsync(new AsyncContainerModule(() => provider.boot()));
            }

            this.events.emit('Application:bootedProvider', provider);
        }

        // Booted baby!
        this.booted = true;

        this.events.emit('Application:booted', this);

        return this;
    };

    /**
     * Start the application.
     *
     * @param args
     * @returns
     */
    public async start(...args: any[]): Promise<this> {

        this.events.emit('Application:start', this);

        /* This part is ment to kick start the application. */
        /* and is currently emtpy. awaiting purpose */
        /**
         * @todo: Work out Application start
         * Different projects will have different views on what 'starting' up might be.
         * One would use React, Vue or any other way.
         * My suggestion would be that the {@see Application.initialize()} options allow for a
         * 'start' (async/Promise) callback that would be called right here, overloading it with any arguments
         * this {@see Application.start()} method has received.
         */

        this.events.emit('Application:started', this);

        return this;
    };

    /**
     * Load service providers.
     *
     * @param Providers
     * @returns
     */
    protected async loadProviders(Providers: IServiceProviderClass[]): Promise<this> {

        await Promise.all(
            Providers.map(async Provider => this.loadProvider(Provider)),
        );

        return this;
    }

    /**
     * Load the given provider.
     *
     * @param Provider
     * @returns
     */
    protected async loadProvider(Provider: IServiceProviderClass): Promise<IServiceProvider> {

        /**
         * Check if the provider has already been loaded.
         */
        const name = Provider.name ?? Provider.constructor.name;

        if ( name in this.loaded ) {
            return this.loaded[ name ];
        }

        /**
         * Instantiate the provider.
         */
        let provider = new Provider(this);

        /**
         * Check if the provider has
         * other providers to load
         * and load those first.
         */
        if ( 'providers' in provider && Reflect.getMetadata('providers', provider) !== true ) {

            Reflect.defineMetadata('providers', true, provider);

            await this.loadProviders(provider.providers);
        }

        /**
         * Now load the provider itself.
         */
        this.events.emit('Application:loadProvider', Provider);

        this.loaded[ name ] = provider;
        this.providers.push(provider);

        this.events.emit('Application:loadedProvider', provider);

        return provider;
    }

    /**
     * Register all given providers.
     *
     * @param {IServiceProvider[]} providers An array of instantiated providers
     * @returns this
     */
    protected async registerProviders(providers: IServiceProvider[]): Promise<this> {

        this.events.emit('Application:registerProviders', providers);

        await Promise.all(providers.map(async Provider => this.register(Provider)));

        this.events.emit('Application:registeredProviders', providers);

        return this;
    }

    /**
     * Register a Service Provider, if not instantiated, it will load the providers instance.
     *
     * @see IServiceProvider
     * @see IServiceProviderClass
     * @see loadProvider
     * @param {IServiceProvider|IServiceProviderClass} Provider
     */
    public async register(Provider: IServiceProvider | IServiceProviderClass): Promise<this> {

        let provider: IServiceProvider;

        if ( isServiceProviderClass(Provider) ) {
            provider = await this.loadProvider(Provider);
        } else {
            provider = Provider;
        }

        this.events.emit('Application:registerProvider', Provider);

        if ( 'register' in provider && Reflect.getMetadata('register', provider) !== true ) {
            Reflect.defineMetadata('register', true, provider);
            await this.loadAsync(new AsyncContainerModule(() => provider.register()));
        }

        this.events.emit('Application:registeredProviders', provider);

        return this;
    };

    /**
     * Register a singleton bindng.
     *
     * @param serviceIdentifier
     * @param constructor
     * @returns
     */
    public singleton<Type>(
        serviceIdentifier: ServiceIdentifier<Type>,
        constructor: new (...args: any[]) => Type,
    ): this {

        this.bind(serviceIdentifier).to(constructor).inSingletonScope();

        return this;
    }

    /**
     * Register a binding.
     *
     * @param serviceIdentifier
     * @param func
     * @param singleton
     * @returns
     */
    public binding<Type>(
        serviceIdentifier: ServiceIdentifier<Type>,
        func: (app: this) => Type,
        singleton: boolean = false,
    ): this {

        let binding = this.bind(serviceIdentifier).toDynamicValue(ctx => func(this));

        singleton ? binding.inSingletonScope() : binding.inTransientScope();

        return this;
    }

    /**
     * Register an instance binding.
     *
     * @param serviceIdentifier
     * @param value
     * @returns
     */
    public instance<Type>(
        serviceIdentifier: ServiceIdentifier<Type>,
        value: Type,
    ): this {

        this.bind(serviceIdentifier).toConstantValue(value);

        return this;
    }

    /**
     * Add a getter for the binding.
     *
     * @param id
     * @param key
     * @returns
     */
    public addBindingGetter(id: string, key: string = null): this {

        key = key || id;

        const self = this;

        Object.defineProperty(self, key, {
            get() {
                return self.get(id);
            },
            configurable: true,
            enumerable  : true,
        });

        return this;
    }
}

const app = Application.instance;

const { lazyInject: inject } = getDecorators(app);

export {
    app,
    inject,
};
