import 'reflect-metadata';
import { Container, interfaces } from 'inversify';
import { Dispatcher } from '../Dispatcher/Dispatcher';
import { Repository } from '../Config/Repository';
import { ApplicationInitOptions, Configuration } from '../types/config';
import { IServiceProvider, IServiceProviderClass } from '../Support/ServiceProvider';
import { Constructor, ServiceProvider } from '../Support';
import ServiceIdentifier = interfaces.ServiceIdentifier;
export interface Application {
    events: Dispatcher;
    config: Repository<Configuration> & Configuration;
}
declare module '../Dispatcher/Dispatcher' {
    interface DispatcherEvents {
        'Application:initialize': [ApplicationInitOptions];
        'Application:initialized': [Application];
        'Application:boot': [Application];
        'Application:bootProvider': [ServiceProvider];
        'Application:bootedProvider': [ServiceProvider];
        'Application:booted': [Application];
        'Application:start': [Application];
        'Application:started': [Application];
        'Application:loadProvider': [Constructor<ServiceProvider>];
        'Application:loadedProvider': [ServiceProvider];
        'Application:registerProviders': [Array<Constructor<ServiceProvider>>];
        'Application:registerProvider': [Constructor<ServiceProvider>];
        'Application:registeredProviders': [ServiceProvider];
    }
}
export declare class Application extends Container {
    /**
     * The application instance.
     */
    protected static _instance: Application;
    /**
     * Configured service providers.
     */
    protected providers: any[];
    /**
     * Loaded service providers.
     */
    protected loaded: {};
    /**
     * The booted flag.
     */
    protected booted: boolean;
    /**
     * The started flag.
     */
    protected started: boolean;
    /**
     * Get/create the instance.
     */
    static get instance(): Application;
    /**
     * Return a singleton
     * instance of Application
     *
     * @return {Application}
     */
    static getInstance(): Application;
    /**
     * Return whether the
     * application has booted.
     *
     * @returns bool
     */
    isBooted(): boolean;
    /**
     * Return whether the
     * application has started.
     *
     * @returns bool
     */
    isStarted(): boolean;
    /**
     * Create a new Application instance.
     */
    private constructor();
    /**
     * Initialize the application.
     *
     * @param options
     * @returns
     */
    initialize(options?: ApplicationInitOptions): Promise<this>;
    /**
     * Boot the application.
     *
     * @returns
     */
    boot(): Promise<this>;
    /**
     * Start the application.
     *
     * @param args
     * @returns
     */
    start(...args: any[]): Promise<this>;
    /**
     * Load service providers.
     *
     * @param Providers
     * @returns
     */
    protected loadProviders(Providers: IServiceProviderClass[]): Promise<this>;
    /**
     * Load the given provider.
     *
     * @param Provider
     * @returns
     */
    protected loadProvider(Provider: IServiceProviderClass): Promise<IServiceProvider>;
    /**
     * Register all given providers.
     *
     * @param {IServiceProvider[]} providers An array of instantiated providers
     * @returns this
     */
    protected registerProviders(providers: IServiceProvider[]): Promise<this>;
    /**
     * Register a Service Provider, if not instantiated, it will load the providers instance.
     *
     * @see IServiceProvider
     * @see IServiceProviderClass
     * @see loadProvider
     * @param {IServiceProvider|IServiceProviderClass} Provider
     */
    register(Provider: IServiceProvider | IServiceProviderClass): Promise<this>;
    /**
     * Register a singleton bindng.
     *
     * @param serviceIdentifier
     * @param constructor
     * @returns
     */
    singleton<Type>(serviceIdentifier: ServiceIdentifier<Type>, constructor: new (...args: any[]) => Type): this;
    /**
     * Register a binding.
     *
     * @param serviceIdentifier
     * @param func
     * @param singleton
     * @returns
     */
    binding<Type>(serviceIdentifier: ServiceIdentifier<Type>, func: (app: this) => Type, singleton?: boolean): this;
    /**
     * Register an instance binding.
     *
     * @param serviceIdentifier
     * @param value
     * @returns
     */
    instance<Type>(serviceIdentifier: ServiceIdentifier<Type>, value: Type): this;
    /**
     * Add a getter for the binding.
     *
     * @param id
     * @param key
     * @returns
     */
    addBindingGetter(id: string, key?: string): this;
}
declare const app: Application;
declare const inject: (serviceIdentifier: string | symbol | interfaces.Newable<any> | interfaces.Abstract<any>) => (proto: any, key: string) => void;
export { app, inject, };
