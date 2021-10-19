import { ServiceProvider } from './Support';
import { StorageServiceProvider } from './Storage';
import { HttpServiceProvider } from './Http';
import { StreamsServiceProvider } from './Streams';

export class CoreServiceProvider extends ServiceProvider {
    providers = [
        StorageServiceProvider,
        HttpServiceProvider,
        StreamsServiceProvider
    ]
}
