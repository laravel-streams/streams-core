import { ServiceProvider } from '../Support';
import { LocalStorageAdapter } from './LocalStorageAdapter';
import { SessionStorageAdapter } from './SessionStorageAdapter';
import { StorageAdapterInterface } from './StorageAdapterInterface';


export class StorageServiceProvider extends ServiceProvider {
    register() {
        this.app.singleton('storage.local', LocalStorageAdapter);
        this.app.singleton('storage.session', SessionStorageAdapter);
        this.app.bind('storage').toDynamicValue(ctx => ctx.container.get('storage.local'));
        this.app.addBindingGetter('storage');
    }
}


declare module '../Foundation/Application' {
    export interface Application {
        storage: StorageAdapterInterface;
    }
}
