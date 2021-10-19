import { AxiosInstance, AxiosRequestConfig, AxiosStatic, CancelTokenSource } from 'axios';
import { IBaseStream, IStreamLinks, IStreamMeta, IStreamResponse } from '../types';
import { IEntriesLinks, IEntriesMeta, IPaginatedEntriesLinks, IPaginatedEntriesMeta } from '../Streams/EntryCollection';
export declare class Http {
    Axios: AxiosStatic;
    axios: AxiosInstance;
    protected cancelTokenSource: CancelTokenSource;
    getStreams(params?: any, config?: AxiosRequestConfig): Promise<IStreamResponse<any, IStreamMeta, IStreamLinks<"entries" | "self">>>;
    postStream<T>(data: T, config?: AxiosRequestConfig): Promise<IStreamResponse<T>>;
    getStream<ID extends string>(stream: ID, params?: any, config?: AxiosRequestConfig): Promise<IStreamResponse<IBaseStream<ID>, IStreamMeta, IStreamLinks<"entries" | "self">>>;
    patchStream<ID extends string>(stream: ID, data?: any, config?: AxiosRequestConfig): Promise<IStreamResponse<IBaseStream<ID>, IStreamMeta, IStreamLinks<"entries" | "self">>>;
    putStream<ID extends string>(stream: ID, data?: any, config?: AxiosRequestConfig): Promise<IStreamResponse<IBaseStream<ID>, IStreamMeta, IStreamLinks<"entries" | "self">>>;
    deleteStream<ID extends string>(stream: ID, config?: AxiosRequestConfig): Promise<IStreamResponse<IBaseStream<ID>, IStreamMeta, IStreamLinks<"entries" | "self">>>;
    getEntries<DATA, TYPE extends keyof Http.Responses<DATA> = 'entries', ID extends string = string>(stream: ID, data?: any, params?: any, config?: AxiosRequestConfig): Promise<Http.Responses<DATA>[TYPE]>;
    postEntry<ID extends string>(stream: ID, data?: any, config?: AxiosRequestConfig): Promise<IStreamResponse<any, IStreamMeta, IStreamLinks<"entries" | "self">>>;
    getEntry<ID extends string, EID extends string>(stream: ID, entry: EID, config?: AxiosRequestConfig): Promise<IStreamResponse<any, IStreamMeta, IStreamLinks<"entries" | "self">>>;
    patchEntry<ID extends string, EID extends string>(stream: ID, entry: EID, data?: any, config?: AxiosRequestConfig): Promise<IStreamResponse<any, IStreamMeta, IStreamLinks<"entries" | "self">>>;
    putEntry<ID extends string, EID extends string>(stream: ID, entry: EID, data?: any, config?: AxiosRequestConfig): Promise<IStreamResponse<any, IStreamMeta, IStreamLinks<"entries" | "self">>>;
    deleteEntry<ID extends string, EID extends string>(stream: ID, entry: EID, config?: AxiosRequestConfig): Promise<IStreamResponse<any, IStreamMeta, IStreamLinks<"entries" | "self">>>;
    getUri(config?: AxiosRequestConfig): string;
    get<T = any, R = IStreamResponse<T>>(url: string, config?: AxiosRequestConfig): Promise<R>;
    delete<T = any, R = IStreamResponse<T>>(url: string, config?: AxiosRequestConfig): Promise<R>;
    head<T = any, R = IStreamResponse<T>>(url: string, config?: AxiosRequestConfig): Promise<R>;
    options<T = any, R = IStreamResponse<T>>(url: string, config?: AxiosRequestConfig): Promise<R>;
    post<T = any, R = IStreamResponse<T>>(url: string, data?: any, config?: AxiosRequestConfig): Promise<R>;
    put<T = any, R = IStreamResponse<T>>(url: string, data?: any, config?: AxiosRequestConfig): Promise<R>;
    patch<T = any, R = IStreamResponse<T>>(url: string, data?: any, config?: AxiosRequestConfig): Promise<R>;
    protected constructed(): void;
    request<T = any, R = IStreamResponse<T>>(config: AxiosRequestConfig): Promise<R>;
}
export declare namespace Http {
    interface StreamResponse<T, M extends IStreamMeta, L = IStreamLinks<any>> extends IStreamResponse<T, M, L> {
    }
    interface Responses<T> {
        entries: StreamResponse<T, IEntriesMeta, IEntriesLinks>;
        paginated: StreamResponse<T, IPaginatedEntriesMeta, IPaginatedEntriesLinks>;
    }
}
