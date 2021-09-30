import Axios, { AxiosInstance, AxiosRequestConfig, AxiosResponse, AxiosStatic, CancelTokenSource } from 'axios';
import { injectable, postConstruct } from 'inversify';
import { inject } from '@/Foundation';
import { IBaseStream, Config, IStreamResponse } from '@/types';

@injectable()
export class Http {
    @inject('axios') Axios: AxiosStatic;
    @inject('config') config: Config;
    protected cancelTokenSource: CancelTokenSource;
    protected axios: AxiosInstance;

    async getStreams(params: any = {}, config: AxiosRequestConfig = {}) {
        config.params = params;
        return this.get('/streams', config);
    }

    async postStream<T>(data:T, config: AxiosRequestConfig = {}):Promise<IStreamResponse<T>> {
        config.data = data;
        return this.post<T>('/streams', data,config);
    }

    async getStream<ID extends string>(stream: ID, params: any = {}, config: AxiosRequestConfig = {}) {
        config.params = params;
        return this.get<IBaseStream<ID>>(`/streams/${stream}`, config);
    }

    async patchStream<ID extends string>(stream: ID, params: any = {}, config: AxiosRequestConfig = {}) {
        config.params = params;
        return this.patch<IBaseStream<ID>>(`/streams/${stream}`, config);
    }

    async putStream<ID extends string>(stream: ID, params: any = {}, config: AxiosRequestConfig = {}) {
        config.params = params;
        return this.put<IBaseStream<ID>>(`/streams/${stream}`, config);
    }

    async deleteStream<ID extends string>(stream: ID, config: AxiosRequestConfig = {}) {
        return this.delete<IBaseStream<ID>>(`/streams/${stream}`, config);
    }

    async getEntries<ID extends string>(stream: ID, params: any = {}, config: AxiosRequestConfig = {}) {
        config.params = params;
        return this.get<any[]>(`/streams/${stream}/entries`, config);
    }

    async postEntry<ID extends string>(stream: ID, data: any = {}, config: AxiosRequestConfig = {}) {
        config.data = data;
        return this.post<any>(`/streams/${stream}/entries`,data, config);
    }


    async getEntry<ID extends string, EID extends string>(stream: ID, entry: EID, config: AxiosRequestConfig = {}) {
        return this.get<any>(`/streams/${stream}/entries/${entry}`, config);
    }

    async patchEntry<ID extends string, EID extends string>(stream: ID, entry: EID, data: any = {}, config: AxiosRequestConfig = {}) {
        config.data = data;
        return this.patch<any>(`/streams/${stream}/entries/${entry}`, config);
    }

    async putEntry<ID extends string, EID extends string>(stream: ID, entry: EID, data: any = {}, config: AxiosRequestConfig = {}) {
        config.data = data;
        return this.put<any>(`/streams/${stream}/entries/${entry}`, config);
    }

    async deleteEntry<ID extends string, EID extends string>(stream: ID, entry: EID, config: AxiosRequestConfig = {}) {
        return this.patch<any>(`/streams/${stream}/entries/${entry}`, config);
    }


    getUri(config?: AxiosRequestConfig): string { return this.axios.getUri(config); }

    async get<T = any, R = IStreamResponse<T>>(url: string, config?: AxiosRequestConfig): Promise<R> { return this.request<T, R>({ url, method: 'GET', ...config || {} }); }

    async delete<T = any, R = IStreamResponse<T>>(url: string, config?: AxiosRequestConfig): Promise<R> { return this.request<T, R>({ url, method: 'DELETE', ...config || {} }); }

    async head<T = any, R = IStreamResponse<T>>(url: string, config?: AxiosRequestConfig): Promise<R> { return this.request<T, R>({ url, method: 'HEAD', ...config || {} }); }

    async options<T = any, R = IStreamResponse<T>>(url: string, config?: AxiosRequestConfig): Promise<R> { return this.request<T, R>({ url, method: 'OPTIONS', ...config || {} }); }

    async post<T = any, R = IStreamResponse<T>>(url: string, data?: any, config?: AxiosRequestConfig): Promise<R> { return this.request<T, R>({ url, method: 'POST', data, ...config || {} }); }

    async put<T = any, R = IStreamResponse<T>>(url: string, data?: any, config?: AxiosRequestConfig): Promise<R> { return this.request<T, R>({ url, method: 'PUT', data, ...config || {} }); }

    async patch<T = any, R = IStreamResponse<T>>(url: string, data?: any, config?: AxiosRequestConfig): Promise<R> {return this.request<T, R>({ url, method: 'PATCH', data, ...config || {} }); }

    @postConstruct()
    protected constructed() {
        const Axios                      = this.Axios;
        this.cancelTokenSource           = Axios.CancelToken.source();
        const config: AxiosRequestConfig = {
            baseURL: '/api',
            params: {},
            ...this.config.http,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                ...(this.config.http && this.config.http.headers ? this.config.http.headers : {}),
            }
        };
        let streams                      = this.config.get<any>('streams');
        if ( streams?.cache?.enabled ) {

        }
        if(streams?.xdebug){
            config.headers['Cookie'] = 'XDEBUG_SESSION=start'
            config.params['XDEBUG_SESSION']='PHPSTORM';
        }
        if ( streams?.authentication ) {
            const { type, basic, token } = streams.authentication;
            if ( type === 'basic' ) {
                config.auth = {
                    username: basic.username,
                    password: basic.password,
                };
            } else if ( type === 'token' ) {
                config.headers[ 'Authorization' ] = 'Bearer ' + token;
            }
        }
        this.axios = this.Axios.create(config);
    }

    async request<T = any, R = IStreamResponse<T>>(config: AxiosRequestConfig): Promise<R> {
        config.cancelToken = this.cancelTokenSource.token;
        try {
            const response                              = await this.axios.request<T, AxiosResponse<R>>(config);
            const { data, headers, status, statusText } = response;
            return response.data;
        } catch (e) {
            if ( Axios.isCancel(e) ) {

            }
            throw e;
        }
    }

}

