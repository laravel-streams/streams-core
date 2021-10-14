import { ETagCache } from './ETagCache';
import { AxiosError, AxiosInstance, AxiosRequestConfig, AxiosResponse } from 'axios';
export declare class ETag {
    protected axios: AxiosInstance;
    cache: ETagCache;
    protected request: number;
    protected response: number;
    protected enabled: boolean;
    constructor(axios: AxiosInstance);
    enableEtag(): void;
    disableEtag(): void;
    isEnabled(): boolean;
    protected getCacheByAxiosConfig(config: AxiosRequestConfig): import("./ETagCache").ETagCacheValue;
    protected getRequestInterceptor(): (config: AxiosRequestConfig) => AxiosRequestConfig;
    protected getResponseInterceptor(): (response: AxiosResponse) => AxiosResponse<any>;
    protected getResponseErrorInterceptor(): (error: AxiosError) => Promise<AxiosResponse<any>>;
}
