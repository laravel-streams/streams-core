import { AxiosRequestConfig } from 'axios';
import { StreamsServiceProvider } from '../StreamsServiceProvider';
import { Application } from './Application';
import { Collection } from './Collection';
import { Dispatcher } from './Dispatcher';
import { ServiceProvider } from './ServiceProvider';
export interface IServiceProvider {
    app: Application;
    register?(): void;
    boot?(): void;
}
export interface IConfig {
    prefix?: string;
    debug?: boolean;
    csrf?: string;
    delimiters?: [string, string];
    http?: AxiosRequestConfig;
}
export interface StreamsGlobal {
    app: Application;
    Application: typeof Application;
    ServiceProvider: typeof ServiceProvider;
    Dispatcher: typeof Dispatcher;
    Collection: typeof Collection;
    StreamsServiceProvider: typeof StreamsServiceProvider;
}
export interface Window {
    streams: StreamsGlobal;
}
