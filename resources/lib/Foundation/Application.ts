import { AsyncContainerModule, Container, interfaces } from 'inversify';
import getDecorators from 'inversify-inject-decorators';
import { Dispatcher } from '@/Dispatcher/Dispatcher';
import { Repository } from '@/Config/Repository';
import { Config } from '@/types/config';
import { IServiceProvider, IServiceProviderClass } from '@/Support/ServiceProvider';
import ServiceIdentifier = interfaces.ServiceIdentifier;


export interface ApplicationInitOptions {
    providers?: IServiceProviderClass[];
    config?: Config;
}

export interface Application {
    events: Dispatcher;
    config: Repository<Config>;
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
    protected providers;
    protected booted          = false;
    protected started         = false;

    public isBooted() {return this.booted;}

    public isStarted() {return this.started;}


    private constructor() {
        super({
            defaultScope      : 'Transient',
            autoBindInjectable: true,
        });
        this.singleton('events', Dispatcher).addBindingGetter('events');
        this.singleton('config', Repository.asProxy()).addBindingGetter('config');

    }

    public async initialize(options: ApplicationInitOptions = {}) {
        options = {
            providers: [],
            config   : {},
            ...options,
        };
        this.events.emit('Application:initialize', options);
        this.config.set(options.config);

        await this.loadProviders(options.providers);
        await this.registerProviders(this.providers);

        this.events.emit('Application:initialized', this);
        return this;
    }

    protected async loadProviders(Providers: IServiceProviderClass[]): Promise<this> {
        await Promise.all(Providers.map(async Provider => this.loadProvider(Provider)));
        return this;
    }

    protected async loadProvider(Provider: IServiceProviderClass): Promise<IServiceProvider> {
        const name = Provider.name ?? Provider.constructor.name;
        if ( name in this.loadedProviders ) {
            return this.loadedProviders[ name ];
        }
        this.events.emit('Application:loadProvider', Provider);
        let provider                 = new Provider(this);
        this.loadedProviders[ name ] = provider;
        this.providers.push(provider);
        this.events.emit('Application:loadedProvider', provider);

        // load providers that are defined in the current provider's 'providers' property
        if ( 'providers' in provider && Reflect.getMetadata('providers', provider) !== true ) {
            Reflect.defineMetadata('providers', true, provider);
            await this.loadProviders(provider.providers);
        }
        return provider;
    }


    protected async registerProviders(providers): Promise<this> {
        await Promise.all(providers.map(async Provider => this.register(Provider)));
        this.events.emit('Application:registerProviders', providers);
        await Promise.all(providers.map(async Provider => this.register(Provider)));
        this.events.emit('Application:registeredProviders', providers);
        return this;
    }

    public async register(Provider): Promise<this> {
        let provider = await this.loadProvider(Provider);
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

    public async start(): Promise<this> {
        this.events.emit('Application:start', this);
        /* This part is ment to kick start the application. */
        /* and is currently emtpy. awaiting purpose */

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
};
