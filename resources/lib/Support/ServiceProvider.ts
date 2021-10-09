import { Application } from '../Foundation/Application';

export class ServiceProvider implements IServiceProvider {
    
    /**
     * Create a new ServiceProvider instance.
     * 
     * @param app 
     */
    constructor(public app: Application) {}
}

export type Constructor<Type = any> = new (...args: any[]) => Type

export type IServiceProviderClass = {
    new(app: Application): IServiceProvider
}

export interface IServiceProvider {
    
    app: Application;
    providers?: IServiceProviderClass[];
    singletons?: Record<string, Constructor>;
    bindings?: Record<string, Constructor>;

    register?(): any | Promise<any>;

    boot?(): any | Promise<any>;
}
