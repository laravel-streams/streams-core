import { CancelablePromise, EventEmitter2, GeneralEventEmitter, Listener, OnOptions, WaitForFilter, WaitForOptions } from 'eventemitter2';
import { decorate, injectable, unmanaged } from 'inversify';

decorate(injectable(), EventEmitter2);

@injectable()
export class Dispatcher extends EventEmitter2 {

    protected anyListeners: Array<(...args: any[]) => void> = [];

    /**
     * Create a new Dispatcher instance.
     *
     * @param opts
     */
    constructor(@unmanaged() opts?) {
        super({
            wildcard : true,
            delimiter: ':',
        });
    }

    /**
     * Emit an event by name.
     *
     * @param eventName
     * @param args
     * @returns
     */
    public emit(eventName: string | symbol, ...args): boolean {
        let result = super.emit(eventName, ...args);
        this.anyListeners.forEach(listener => listener(eventName, ...args));
        return result;
    }

    /**
     * Register an event listener.
     *
     * @param listener
     */
    public any(listener: (...args: any[]) => void) {
        this.anyListeners.push(listener);
    }
}

/**
 * Interface to augment from other scripts to provide code completion when using the dispatcher's methods.
 *
 * eventname -> listener parameters
 *
 * 'Application:start': [Application]
 *
 */
export interface DispatcherEvents {

}

export type DispatcherEvent = keyof DispatcherEvents

export interface ListenerFn<T extends keyof DispatcherEvents> {
    (...values: DispatcherEvents[T]): void;
}

export interface Dispatcher {
    emit<T extends keyof DispatcherEvents>(event: T, ...values: any[]): boolean;

    emitAsync<T extends keyof DispatcherEvents>(event: T, ...values: any[]): Promise<any[]>;

    addListener<T extends keyof DispatcherEvents>(event: T, listener: ListenerFn<T>): this | Listener;

    on<T extends keyof DispatcherEvents>(event: T, listener: ListenerFn<T>, options?: boolean | OnOptions): this | Listener;

    prependListener<T extends keyof DispatcherEvents>(event: T, listener: ListenerFn<T>, options?: boolean | OnOptions): this | Listener;

    once<T extends keyof DispatcherEvents>(event: T, listener: ListenerFn<T>, options?: true | OnOptions): this | Listener;

    prependOnceListener<T extends keyof DispatcherEvents>(event: T, listener: ListenerFn<T>, options?: boolean | OnOptions): this | Listener;

    many<T extends keyof DispatcherEvents>(event: T, timesToListen: number, listener: ListenerFn<T>, options?: boolean | OnOptions): this | Listener;

    prependMany<T extends keyof DispatcherEvents>(event: T, timesToListen: number, listener: ListenerFn<T>, options?: boolean | OnOptions): this | Listener;

    removeListener<T extends keyof DispatcherEvents>(event: T, listener: ListenerFn<T>): this;

    off<T extends keyof DispatcherEvents>(event: T, listener: ListenerFn<T>): this;

    removeAllListeners(event?: DispatcherEvent): this;

    listenerCount(event?: DispatcherEvent): number;

    waitFor<T extends keyof DispatcherEvents>(event: T, timeout?: number): CancelablePromise<any[]>;

    waitFor<T extends keyof DispatcherEvents>(event: T, filter?: WaitForFilter): CancelablePromise<any[]>;

    waitFor<T extends keyof DispatcherEvents>(event: T, options?: WaitForOptions): CancelablePromise<any[]>;

    stopListeningTo(target?: GeneralEventEmitter, event?: DispatcherEvent): Boolean;
}


