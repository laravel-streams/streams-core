import { ServiceProvider } from './Support';
import { StorageServiceProvider } from './Storage';
import { HttpServiceProvider } from './Http';

export class CoreServiceProvider extends ServiceProvider {
    providers = [
        StorageServiceProvider,
        HttpServiceProvider,
    ]
}
