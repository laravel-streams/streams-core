import { injectable } from 'inversify';
import { StorageAdapter } from '@/Storage/StorageAdapter';

export class SessionStorageAdapter extends StorageAdapter {
    constructor() {
        super(window.sessionStorage);
    }
}
