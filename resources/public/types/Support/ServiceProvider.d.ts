import { Application } from '../Foundation/Application';
export declare class ServiceProvider implements IServiceProvider {
    app: Application;
    constructor(app: Application);
}
export declare type Constructor<T = any> = new (...args: any[]) => T;
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
