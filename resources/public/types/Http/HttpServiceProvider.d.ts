import { ServiceProvider } from '@/Support';
import { AxiosInstance, AxiosRequestConfig } from 'axios';
export declare class HttpServiceProvider extends ServiceProvider {
    register(): void;
}
declare module '../Foundation/Application' {
    interface Application {
        http: AxiosInstance;
        createHttp: (overrides: AxiosRequestConfig) => AxiosInstance;
    }
}
