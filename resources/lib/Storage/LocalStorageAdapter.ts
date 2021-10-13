import { injectable } from 'inversify';
import { StorageAdapter } from '@/Storage/StorageAdapter';

export class LocalStorageAdapter extends StorageAdapter {
    constructor() {
        super(window.localStorage);
    }
}
