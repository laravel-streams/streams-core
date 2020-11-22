import EventEmitter from 'eventemitter3';

export declare type EventTypes = 'register' | 'registered' | 'boot' | 'booted' | string;

export declare class Dispatcher<T extends string = EventTypes> extends EventEmitter<T> {
}

//# sourceMappingURL=Dispatcher.d.ts.map
