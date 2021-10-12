import Axios, { AxiosInstance, AxiosRequestConfig, AxiosResponse, AxiosStatic, CancelTokenSource } from 'axios';
import { injectable, postConstruct } from 'inversify';
import { inject } from '@/Foundation';
import { Config, IBaseStream, IStreamLinks, IStreamMeta, IStreamResponse } from '@/types';
import { IEntriesLinks, IEntriesMeta, IPaginatedEntriesLinks, IPaginatedEntriesMeta } from '@/Streams/EntryCollection';


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

    async postStream<T>(data: T, config: AxiosRequestConfig = {}): Promise<IStreamResponse<T>> {
        config.data = data;
        return this.post<T>('/streams', data, config);
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

    async getEntries<DATA, TYPE extends keyof Http.Responses<DATA> = 'entries', ID extends string = string>(
        stream: ID,
        data: any = {},
        params: any = {},
        config: AxiosRequestConfig = {}
    ): Promise<Http.Responses<DATA>[TYPE]> {

        config.data = data;
        config.params = params;

        return this.get<DATA[], Http.Responses<DATA>[TYPE]>(`/streams/${stream}/entries`, config);
    }

    async postEntry<ID extends string>(stream: ID, data: any = {}, config: AxiosRequestConfig = {}) {
        config.data = data;
        return this.post<any>(`/streams/${stream}/entries`, data, config);
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

    /**
     * Perform a GET request.
     * 
     * @param url 
     * @param config 
     * @returns
     */
    async get<T = any, R = IStreamResponse<T>>(
        url: string,
        config?: AxiosRequestConfig
    ): Promise<R> {
        return this.request<T, R>({ url, method: 'GET', ...config || {} });
    }

    async delete<T = any, R = IStreamResponse<T>>(url: string, config?: AxiosRequestConfig): Promise<R> { return this.request<T, R>({ url, method: 'DELETE', ...config || {} }); }

    async head<T = any, R = IStreamResponse<T>>(url: string, config?: AxiosRequestConfig): Promise<R> { return this.request<T, R>({ url, method: 'HEAD', ...config || {} }); }

    async options<T = any, R = IStreamResponse<T>>(url: string, config?: AxiosRequestConfig): Promise<R> { return this.request<T, R>({ url, method: 'OPTIONS', ...config || {} }); }

    async post<T = any, R = IStreamResponse<T>>(url: string, data?: any, config?: AxiosRequestConfig): Promise<R> { return this.request<T, R>({ url, method: 'POST', data, ...config || {} }); }

    async put<T = any, R = IStreamResponse<T>>(url: string, data?: any, config?: AxiosRequestConfig): Promise<R> { return this.request<T, R>({ url, method: 'PUT', data, ...config || {} }); }

    async patch<T = any, R = IStreamResponse<T>>(url: string, data?: any, config?: AxiosRequestConfig): Promise<R> { return this.request<T, R>({ url, method: 'PATCH', data, ...config || {} }); }

    @postConstruct()
    protected constructed() {
        const Axios = this.Axios;
        this.cancelTokenSource = Axios.CancelToken.source();
        const config: AxiosRequestConfig = {
            baseURL: '/api',
            params: {},
            responseType: 'json',
            ...this.config.http,
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                ...(this.config.http && this.config.http.headers ? this.config.http.headers : {}),
            },
        };
        let streams = this.config.get<any>('streams');
        if (streams?.cache?.enabled) {

        }
        if (streams?.xdebug) {
            config.headers['Cookie'] = 'XDEBUG_SESSION=start';
            config.params['XDEBUG_SESSION'] = 'PHPSTORM';
        }
        if (streams?.authentication) {
            const { type, basic, token } = streams.authentication;
            if (type === 'basic') {
                config.auth = {
                    username: basic.username,
                    password: basic.password,
                };
            } else if (type === 'token') {
                config.headers['Authorization'] = 'Bearer ' + token;
            }
        }
        this.axios = this.Axios.create(config);
    }

    /**
     * Send the request.
     * 
     * @param config 
     * @returns 
     */
    async request<T = any, R = IStreamResponse<T>>(config: AxiosRequestConfig): Promise<R> {
        
        config.cancelToken = this.cancelTokenSource.token;

        /**
         * The HTTP spec doesn't allow body content
         * for GET requests so fallback to JSON param.
         */
        if (config.method === 'GET' && typeof config.data !== undefined) {
            config.params.json = JSON.stringify(config.data);
        }

        try {
            const response = await this.axios.request<T, AxiosResponse<R>>(config);
            
            //const { data, headers, status, statusText } = response;
            
            return response.data;
        } catch (e) {
            if (Axios.isCancel(e)) {

            }
            throw e;
        }
    }

}


export namespace Http {
    export interface StreamResponse<T, M extends IStreamMeta, L = IStreamLinks<any>> extends IStreamResponse<T, M, L> {

    }

    export interface Responses<T> {
        entries: StreamResponse<T, IEntriesMeta, IEntriesLinks>;
        paginated: StreamResponse<T, IPaginatedEntriesMeta, IPaginatedEntriesLinks>;
    }

}
