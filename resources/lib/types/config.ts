import { Repository } from '@/Config';
import { AxiosRequestConfig } from 'axios';
import { IServiceProviderClass } from '@/Support';

export interface StreamsConfiguration {

}

export interface Configuration {
    streams?: StreamsConfiguration,
    http?: AxiosRequestConfig
}

export interface ApplicationInitOptions {
    providers?: IServiceProviderClass[];
    config?: Configuration;
}


export type Config =
    Repository<Configuration>
    & Configuration
