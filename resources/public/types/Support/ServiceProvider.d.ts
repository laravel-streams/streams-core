import { Application } from '../Foundation/Application';
export declare class ServiceProvider implements IServiceProvider {
    app: Application;
    /**
     * Create a new ServiceProvider instance.
     *
     * @param app
     */
    constructor(app: Application);
}
export declare type Constructor<Type = any> = new (...args: any[]) => Type;
export declare type IServiceProviderClass = {
    new (app: Application): IServiceProvider;
};
export interface IServiceProvider {
    app: Application;
    providers?: IServiceProviderClass[];
    singletons?: Record<string, Constructor>;
    bindings?: Record<string, Constructor>;
    register?(): any | Promise<any>;
    boot?(): any | Promise<any>;
}
