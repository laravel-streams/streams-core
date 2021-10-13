import { injectable } from 'inversify';
import { StorageAdapter } from '@/Storage/StorageAdapter';

@injectable()
export class LocalStorageAdapter extends StorageAdapter {
    constructor() {
        super(window.localStorage);
    }
}
