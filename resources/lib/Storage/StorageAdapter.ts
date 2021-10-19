import { EventEmitter2 } from 'eventemitter2';
import { StorageAdapterInterface } from '@/Storage/StorageAdapterInterface';
import { decorate, injectable } from 'inversify';
import { Transformer } from '@/Storage/Transformer';

@injectable()
export abstract class StorageAdapter extends EventEmitter2 implements StorageAdapterInterface {
    constructor(protected storage: Storage) {
        super({
            delimiter: ':',
            wildcard : true,
        });
    }

    public get<T>(key: string, defaultValue?: T): T {
        if ( !this.has(key) ) {
            return defaultValue;
        }
        let strValue = this.storage.getItem(key);
        strValue     = Transformer.decompress(strValue);
        return Transformer.decode(strValue);
    }

    public has(key: string): boolean {
        return !!this.storage.getItem(key);
    }

    public set(key: string, value: any): this {
        let strValue = Transformer.encode(value);
        strValue     = Transformer.compress(strValue);
        this.storage.setItem(key, strValue);
        this.emit('set:' + key, value,key);
        return this;
    }

    public unset(key: string): this {
        this.storage.removeItem(key);
        this.emit('unset:' + key);
        return this;
    }

    public clear() {
        this.storage.clear();
        this.emit('clear');
        return this;
    }
}
