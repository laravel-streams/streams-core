import { Repository } from '../Config';
import { AxiosRequestConfig } from 'axios';
import { IServiceProviderClass } from '../Support';
export declare type Config = Repository<Configuration> & Configuration;
export interface Configuration {
    streams?: StreamsConfiguration;
    http?: HttpConfiguration;
    debug?: boolean;
    csrf?: string;
}
export interface StreamsConfiguration {
    [key: string]: any;
}
export interface HttpConfiguration extends AxiosRequestConfig {
    etag?: {
        enabled?: boolean;
        manifestKey?: string;
    };
}
export interface ApplicationInitOptions {
    providers?: IServiceProviderClass[];
    config?: Configuration;
}
