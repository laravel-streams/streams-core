import { ETagCache } from './ETagCache';
import { AxiosError, AxiosInstance, AxiosRequestConfig, AxiosResponse } from 'axios';
import { injectable } from 'inversify';
import { inject } from '../Foundation';

const byLowerCase              = toFind => value => toLowerCase(value) === toFind;
const toLowerCase              = value => value.toLowerCase();
const getKeys                  = headers => Object.keys(headers);
const isCacheableMethod        = (config: AxiosRequestConfig) => ~ [ 'GET', 'HEAD' ].indexOf(config.method.toUpperCase());
const getHeaderCaseInsensitive = (headerName, headers = {}) => headers[ getKeys(headers).find(byLowerCase(headerName)) ];
const getBase64UrlFromConfig   = (config: AxiosRequestConfig) => btoa(config.url);

@injectable()
export class ETag {
    @inject('http.etag.cache') public cache: ETagCache;
    protected request: number  = null;
    protected response: number = null;
    protected enabled: boolean = false;

    constructor(protected axios: AxiosInstance) {
        Object.defineProperty(axios, 'etag', {
            get         : () => {return this;},
            configurable: true,
            enumerable  : true,
        });
    }

    enableEtag() {
        if ( this.enabled ) return;
        this.request  = this.axios.interceptors.request.use(this.getRequestInterceptor());
        this.response = this.axios.interceptors.response.use(this.getResponseInterceptor(), this.getResponseErrorInterceptor());
        this.enabled  = true;
    }

    disableEtag() {
        if ( !this.enabled ) return;
        this.axios.interceptors.request.eject(this.request);
        this.axios.interceptors.response.eject(this.response);
        this.enabled = false;
    }

    isEnabled() {return this.enabled;}

    protected getCacheByAxiosConfig(config: AxiosRequestConfig) {
        return this.cache.get(getBase64UrlFromConfig(config));
    }

    protected getRequestInterceptor() {
        return (config: AxiosRequestConfig) => {
            if ( isCacheableMethod(config) ) {
                const uuid             = getBase64UrlFromConfig(config);
                const lastCachedResult = this.cache.get(uuid);
                if ( lastCachedResult ) {
                    config.headers = { ...config.headers, 'If-None-Match': lastCachedResult.etag };
                }
            }
            return config;
        };
    }

    protected getResponseInterceptor() {
        return (response: AxiosResponse) => {
            if ( isCacheableMethod(response.config) ) {
                const responseETAG = getHeaderCaseInsensitive('etag', response.headers);
                if ( responseETAG ) {
                    this.cache.set(getBase64UrlFromConfig(response.config), responseETAG, response.data);
                }
            }
            return response;
        };
    }

    protected getResponseErrorInterceptor() {
        return (error: AxiosError) => {
            if ( error.response && error.response.status === 304 ) {
                const getCachedResult = this.getCacheByAxiosConfig(error.response.config);
                if ( !getCachedResult ) {
                    return Promise.reject(error);
                }
                const newResponse  = error.response;
                newResponse.status = 200;
                newResponse.data   = getCachedResult.value;
                return Promise.resolve(newResponse);
            }
            return Promise.reject(error);
        };
    }
}
