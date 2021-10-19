import { ServiceProvider } from '@/Support';
import { StorageServiceProvider } from '@/Storage';
export declare class CoreServiceProvider extends ServiceProvider {
    providers: (typeof StorageServiceProvider)[];
}
