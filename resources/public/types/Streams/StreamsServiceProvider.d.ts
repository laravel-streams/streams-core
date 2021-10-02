import { ServiceProvider } from '@/Support';
import { HttpServiceProvider } from '@/Http/HttpServiceProvider';
export declare class StreamsServiceProvider extends ServiceProvider {
    providers: [
        HttpServiceProvider
    ];
    register(): void;
}
