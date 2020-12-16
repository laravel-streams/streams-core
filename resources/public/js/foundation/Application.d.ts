import { Container, decorate, injectable, named, optional, postConstruct, tagged, unmanaged } from 'inversify';
import { Dispatcher } from './Dispatcher';
import { autoProvide, buildProviderModule, fluentProvide, provide } from 'inversify-binding-decorators';
import { IConfig } from './types';
import { Collection } from 'collect.js';
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
export declare class Application extends Container {
    protected static _instance: Application;
    static get instance(): Application;
    static set instance(instance: Application);
    /**
     * Returns the singleton instance of Application
     * @return {Application}
     */
    static getInstance(): Application;
    loadedProviders: any;
    providers: any[];
    booted: boolean;
    started: boolean;
    shuttingDown: boolean;
    startEnabled: boolean;
    events: Dispatcher;
    config: Collection<IConfig>;
    /**
     * @private
     */
    private constructor();
    /**
     * Starts bootstrapping the application with the given options.
     * - This would be the place to add all your ServiceProviders
     * - Add or modify additional config
     * - Add data from the backend which you want to be accessible troughout in your javascripts
     * @param {any} _options
     * @param {any} mergeOptions
     * @return {Promise<Application>}
     */
    bootstrap(_options: any, ...mergeOptions: any[]): Promise<this>;
    private loadProviders;
    private loadProvider;
    getConfigDefaults(): IConfig;
    configure(config: IConfig): this;
    private registerProviders;
    register: (Provider: any) => Promise<this>;
    boot: () => Promise<this>;
    start: (elementOrSelector?: string) => Promise<void>;
    error: (error: any) => Promise<never>;
    addBindingGetter(id: any, key?: any): void;
    alias(abstract: any, alias: any, singleton?: boolean): this;
    bindIf(id: any, override: any, cb: any): this;
    dynamic(id: any, cb: any): import("inversify/dts/interfaces/interfaces").interfaces.BindingInWhenOnSyntax<unknown>;
    singleton(id: any, value: any, override?: boolean): this;
    binding(id: any, value: any): this;
    instance(id: any, value: any, override?: boolean): this;
    ctxfactory(id: any, factory: any): this;
    factory(id: any, factory: any): this;
}
declare const app: Application;
declare const inject: (serviceIdentifier: import("inversify/dts/interfaces/interfaces").interfaces.ServiceIdentifier<any>) => (proto: any, key: string) => void;
export { app, inject };
export { provide, buildProviderModule, fluentProvide, autoProvide };
export { injectable, unmanaged, optional, decorate, named, tagged, postConstruct };
