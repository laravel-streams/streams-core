import 'reflect-metadata';
import { Container, injectable, interfaces, unmanaged, tagged, named, multiInject, optional, targetName, postConstruct, decorate } from 'inversify';
import { Dispatcher } from '@/Dispatcher/Dispatcher';
import { Repository } from '@/Config/Repository';
import { ApplicationInitOptions, Configuration } from '@/types/config';
import { IServiceProvider, IServiceProviderClass } from '@/Support/ServiceProvider';
import ServiceIdentifier = interfaces.ServiceIdentifier;
export interface Application {
    events: Dispatcher;
    config: Repository<Configuration> & Configuration;
}
export declare class Application extends Container {
    protected static _instance: Application;
    static get instance(): Application;
    /**
     * Returns a singleton
     * instance of Application
     * @return {Application}
     */
    static getInstance(): Application;
    protected loadedProviders: {};
    protected providers: any[];
    protected booted: boolean;
    protected started: boolean;
    isBooted(): boolean;
    isStarted(): boolean;
    private constructor();
    initialize(options?: ApplicationInitOptions): Promise<this>;
    protected loadProviders(Providers: IServiceProviderClass[]): Promise<this>;
    /**
     * Will load a provider. Part of the {@see initialize} code.
     *
     * - instantiating it
     * - adding it to the {@see loadedProviders} object, to prevent it from loading twice
     * - adding it to the {@see providers} array, to have it handled in {@see registerProviders}
     * @param Provider
     * @protected
     */
    protected loadProvider(Provider: IServiceProviderClass): Promise<IServiceProvider>;
    /**
     * Registers all given {@see IServiceProvider} instances. Part of the {@see initialize} code.
     *
     * @param {IServiceProvider[]} providers An array of instantiated providers
     * @protected
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
    boot(): Promise<this>;
    start(...args: any[]): Promise<this>;
    singleton<T>(serviceIdentifier: ServiceIdentifier<T>, constructor: new (...args: any[]) => T): this;
    binding<T>(serviceIdentifier: ServiceIdentifier<T>, func: (app: this) => T, singleton?: boolean): this;
    instance<T>(serviceIdentifier: ServiceIdentifier<T>, value: T): this;
    addBindingGetter(id: string, key?: string): this;
}
declare const app: Application;
declare const inject: (serviceIdentifier: string | symbol | interfaces.Newable<any> | interfaces.Abstract<any>) => (proto: any, key: string) => void;
export { app, inject, injectable, unmanaged, tagged, named, multiInject, optional, targetName, postConstruct, decorate };
