import { Container, interfaces } from 'inversify';
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
    protected providers: any;
    protected booted: boolean;
    protected started: boolean;
    isBooted(): boolean;
    isStarted(): boolean;
    private constructor();
    initialize(options?: ApplicationInitOptions): Promise<this>;
    protected loadProviders(Providers: IServiceProviderClass[]): Promise<this>;
    protected loadProvider(Provider: IServiceProviderClass): Promise<IServiceProvider>;
    protected registerProviders(providers: any): Promise<this>;
    register(Provider: any): Promise<this>;
    boot(): Promise<this>;
    start(...args: any[]): Promise<this>;
    singleton<T>(serviceIdentifier: ServiceIdentifier<T>, constructor: new (...args: any[]) => T): this;
    binding<T>(serviceIdentifier: ServiceIdentifier<T>, func: (app: this) => T, singleton?: boolean): this;
    instance<T>(serviceIdentifier: ServiceIdentifier<T>, value: T): this;
    addBindingGetter(id: string, key?: string): this;
}
declare const app: Application;
declare const inject: (serviceIdentifier: string | symbol | interfaces.Newable<any> | interfaces.Abstract<any>) => (proto: any, key: string) => void;
export { app, inject, };
