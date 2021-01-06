import { AxiosRequestConfig }     from 'axios';
import { StreamsServiceProvider } from '../StreamsServiceProvider';
import { Application }            from './Application';
import { Collection }             from './Collection';
import { Dispatcher }             from './Dispatcher';
import { ServiceProvider }        from './ServiceProvider';


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
    export interface StreamsGlobalCore {
        app: Application
        Application: typeof Application
        ServiceProvider: typeof ServiceProvider
        Dispatcher: typeof Dispatcher
        Collection: typeof Collection
        StreamsServiceProvider: typeof StreamsServiceProvider
    }

    export interface StreamsGlobal {
        http: any;
        core: StreamsGlobalCore
    }

    export interface Window {
        streams: StreamsGlobal
    }

}


export interface Stream {

}

export interface StreamsGlobal {
    make(stream: Stream): StreamsInstance
}

export interface StreamsRepository {
    where(col: any, op: any, val?: any): this

    get(): any

    find(id): any
}

export interface StreamsInstance {
    repository(): StreamsRepository
}

let stream: Stream;
let streams: StreamsGlobal;
let entries = streams.make(stream)
    .repository()
    .where('enabled', true)
    .get();
let entry = streams.make(stream)
    .repository()
    .find(1);
