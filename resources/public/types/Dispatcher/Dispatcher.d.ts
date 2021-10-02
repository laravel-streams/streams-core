import { EventEmitter2 } from 'eventemitter2';
export declare class Dispatcher extends EventEmitter2 {
    protected anyListeners: Array<(...args: any[]) => void>;
    constructor(opts?: any);
    emit(eventName: string | symbol, ...args: any[]): boolean;
    any(listener: (...args: any[]) => void): void;
}
