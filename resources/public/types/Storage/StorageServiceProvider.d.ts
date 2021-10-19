import { ServiceProvider } from '../Support';
import { StorageAdapterInterface } from './StorageAdapterInterface';
export declare class StorageServiceProvider extends ServiceProvider {
    register(): void;
}
declare module '../Foundation/Application' {
    interface Application {
        storage: StorageAdapterInterface;
    }
}
