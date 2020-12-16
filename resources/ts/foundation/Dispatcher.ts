import EventEmitter             from 'eventemitter3';
import { decorate, injectable } from 'inversify';

export type EventTypes =
    'register'
    | 'registered'
    | 'boot'
    | 'booted'
    | 'start'
    | 'started'
    | 'loadProviders'
    | 'loadedProviders'
    | 'loadProvider'
    | 'loadedProvider'
    | 'registerProvider'
    | 'registeredProvider'
    | 'bootProvider'
    | 'bootedProvider'
    | string;

decorate(injectable(), EventEmitter);

@injectable()
export class Dispatcher<T extends string = EventTypes> extends EventEmitter<T> {
}
