import { injectable } from 'inversify';
import { StorageAdapter } from '@/Storage/StorageAdapter';

@injectable()
export class SessionStorageAdapter extends StorageAdapter {
    constructor() {
        super(window.sessionStorage);
    }
}
