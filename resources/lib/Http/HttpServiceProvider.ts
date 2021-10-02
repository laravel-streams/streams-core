import { ServiceProvider } from '@/Support';
import Axios, { AxiosInstance, AxiosRequestConfig } from 'axios';

export class HttpServiceProvider extends ServiceProvider {
    register() {
        const config = {
            ...this.app.config.http,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                ...(this.app.config.http && this.app.config.http.headers ? this.app.config.http.headers : {}),
            },
        };
        const axios  = Axios.create(config);
        this.app.instance('axios', Axios);
        this.app.instance('http', axios).addBindingGetter('http');
        this.app.instance('createHttp', (overrides: AxiosRequestConfig): AxiosInstance => {
            overrides = {
                ...config,
                ...overrides,
            };
            return Axios.create(overrides);
        });
    }
}

declare module '../Foundation/Application' {
    export interface Application {
        http: AxiosInstance;
        createHttp: (overrides: AxiosRequestConfig) => AxiosInstance;
    }
}
