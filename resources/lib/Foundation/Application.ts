import 'reflect-metadata'
import { AsyncContainerModule, Container, injectable, interfaces,unmanaged,tagged,named,multiInject,optional,targetName,postConstruct,decorate } from 'inversify';
import getDecorators from 'inversify-inject-decorators';
import { Dispatcher } from '@/Dispatcher/Dispatcher';
import { Repository } from '@/Config/Repository';
import { ApplicationInitOptions, Configuration } from '@/types/config';
import { IServiceProvider, IServiceProviderClass } from '@/Support/ServiceProvider';
import ServiceIdentifier = interfaces.ServiceIdentifier;
import { isServiceProviderClass, makeLog } from '@/Support/utils';

const log = makeLog('Application');

export interface Application {
    events: Dispatcher;
    config: Repository<Configuration> & Configuration;
}

export class Application extends Container {
    protected static _instance: Application;

    public static get instance() {
        if ( !this._instance ) {
            this._instance = new this();
        }
        return this._instance;
    }

    /**
     * Returns a singleton
     * instance of Application
     * @return {Application}
     */
    public static getInstance() {
        return this.instance;
    }

    protected loadedProviders = {};
    protected providers = [];
    protected booted          = false;
    protected started         = false;

    public isBooted() {return this.booted;}

    public isStarted() {return this.started;}


    private constructor() {
        super({
            defaultScope      : 'Transient',
            autoBindInjectable: true,
            skipBaseClassChecks: true,
        });
        this.singleton('events', Dispatcher).addBindingGetter('events');
        this.events.any((eventName:string, ...args:any[]) => log(eventName, ' arguments: ', args))
    }

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

    protected async loadProviders(Providers: IServiceProviderClass[]): Promise<this> {
        await Promise.all(Providers.map(async Provider => this.loadProvider(Provider)));
        return this;
    }

    /**
     * Will load a provider. Part of the {@see initialize} code.
     *
     * - instantiating it
     * - adding it to the {@see loadedProviders} object, to prevent it from loading twice
     * - adding it to the {@see providers} array, to have it handled in {@see registerProviders}
     * @param Provider
     * @protected
     */
    protected async loadProvider(Provider: IServiceProviderClass): Promise<IServiceProvider> {
        // Making sure we never load a provider twice
        const name = Provider.name ?? Provider.constructor.name;
        if ( name in this.loadedProviders ) {
            return this.loadedProviders[ name ];
        }

        let provider                 = new Provider(this);

        // First we load providers that are defined in the current provider's 'providers' property
        if ( 'providers' in provider && Reflect.getMetadata('providers', provider) !== true ) {
            Reflect.defineMetadata('providers', true, provider);
            await this.loadProviders(provider.providers);
        }

        // Then we actually load the provider itself. This makes it so that
        // 1. its providers defined in the 'providers' property will load & register before this one
        this.events.emit('Application:loadProvider', Provider);
        this.loadedProviders[ name ] = provider;
        this.providers.push(provider);
        this.events.emit('Application:loadedProvider', provider);

        return provider;
    }

    /**
     * Registers all given {@see IServiceProvider} instances. Part of the {@see initialize} code.
     *
     * @param {IServiceProvider[]} providers An array of instantiated providers
     * @protected
     */
    protected async registerProviders(providers:IServiceProvider[]): Promise<this> {
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
    public async register(Provider:IServiceProvider|IServiceProviderClass): Promise<this> {
        let provider:IServiceProvider;
        if(isServiceProviderClass(Provider)) {
            provider = await this.loadProvider(Provider);
        } else {
            provider = Provider
        }
        this.events.emit('Application:registerProvider', Provider);
        if ( 'register' in provider && Reflect.getMetadata('register', provider) !== true ) {
            Reflect.defineMetadata('register', true, provider);
            await this.loadAsync(new AsyncContainerModule(() => provider.register()));
        }
        this.events.emit('Application:registeredProviders', provider);
        return this;
    };

    public async boot(): Promise<this> {
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
        this.booted = true;
        this.events.emit('Application:booted', this);
        return this;
    };

    public async start(...args:any[]): Promise<this> {
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
         *
         */
        this.events.emit('Application:started', this);
        return this;
    };


    public singleton<T>(serviceIdentifier: ServiceIdentifier<T>, constructor: new (...args: any[]) => T): this {
        this.bind(serviceIdentifier).to(constructor).inSingletonScope();
        return this;
    }

    public binding<T>(serviceIdentifier: ServiceIdentifier<T>, func: (app: this) => T, singleton: boolean = false): this {
        let binding = this.bind(serviceIdentifier).toDynamicValue(ctx => func(this));
        singleton ? binding.inSingletonScope() : binding.inTransientScope();
        return this;
    }

    public instance<T>(serviceIdentifier: ServiceIdentifier<T>, value: T): this {
        this.bind(serviceIdentifier).toConstantValue(value);
        return this;
    }

    public addBindingGetter(id: string, key: string = null): this {
        key        = key || id;
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

const app                    = Application.instance;

const { lazyInject: inject } = getDecorators(app);
export {
    app,
    inject,
    injectable, unmanaged,tagged,named,multiInject,optional,targetName,postConstruct,decorate
};
