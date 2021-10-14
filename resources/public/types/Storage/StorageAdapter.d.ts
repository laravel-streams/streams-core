import { EventEmitter2 } from 'eventemitter2';
import { StorageAdapterInterface } from '@/Storage/StorageAdapterInterface';
export declare abstract class StorageAdapter extends EventEmitter2 implements StorageAdapterInterface {
    protected storage: Storage;
    constructor(storage: Storage);
    get<T>(key: string, defaultValue: T): T;
    has(key: string): boolean;
    set(key: string, value: any): this;
    unset(key: string): this;
    clear(): this;
}
