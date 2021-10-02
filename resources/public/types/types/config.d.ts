import { Repository } from '@/Config';
import { AxiosRequestConfig } from 'axios';
import { IServiceProviderClass } from '@/Support';
export declare interface StreamsConfiguration {
}
export declare interface Configuration2 {
    streams?: StreamsConfiguration;
    http?: AxiosRequestConfig;
}
export declare interface ApplicationInitOptions {
    providers?: IServiceProviderClass[];
    config?: Configuration;
}
export declare type Config = Repository<Configuration> & Configuration;
