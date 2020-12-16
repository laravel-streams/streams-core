import EventEmitter from 'eventemitter3';
export declare type EventTypes = 'register' | 'registered' | 'boot' | 'booted' | 'start' | 'started' | 'loadProviders' | 'loadedProviders' | 'loadProvider' | 'loadedProvider' | 'registerProvider' | 'registeredProvider' | 'bootProvider' | 'bootedProvider' | string;
export declare class Dispatcher<T extends string = EventTypes> extends EventEmitter<T> {
}
