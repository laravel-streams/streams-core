import { AxiosRequestConfig } from 'axios';
import { Application }        from './foundation';


export interface IServiceProvider {
    app: Application

    register?(): void

    boot?(): void
}

export interface IConfig {
    prefix?: string
    debug?: boolean
    csrf?: string
    delimiters?: [ string, string ]
    http?: AxiosRequestConfig
}


declare global {
    export interface StreamsGlobal {
        http: any;
        core: typeof import('./index')
    }

    export interface Window {
        app: Application
        streams: StreamsGlobal
        startLoadingAlpine: () => void
    }

}

