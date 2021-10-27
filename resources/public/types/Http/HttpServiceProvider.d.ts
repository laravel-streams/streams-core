import { ServiceProvider } from '../Support';
import { AxiosInstance } from 'axios';
import { ETag } from '../Http/ETag';
export declare class HttpServiceProvider extends ServiceProvider {
    /**
     * Register the service.
     */
    register(): void;
    boot(): void;
    protected registerAxios(): void;
    protected bootETag(): void;
}
declare module 'axios' {
    interface AxiosInstance {
        etag: ETag;
    }
}
declare module '../Foundation/Application' {
    interface Application {
        http: AxiosInstance;
    }
}
