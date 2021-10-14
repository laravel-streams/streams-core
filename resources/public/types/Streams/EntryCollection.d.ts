import { IEntry } from './Entry';
import { Collection } from '@/Support';
import { IStreamLinks, IStreamMeta } from '@/types';
import { Stream } from '@/Streams/Stream';
import { Http } from '@/Streams/Http';
export declare type IEntriesLinks = IStreamLinks<'self' | 'streams' | 'stream'>;
export declare type IPaginatedEntriesLinks = IStreamLinks<'next_page' | 'previous_page' | 'self' | 'first_page' | 'streams' | 'stream'>;
export interface IEntriesMeta extends IStreamMeta {
    total: number;
}
export interface IPaginatedEntriesMeta extends IStreamMeta {
    current_page: number;
    last_page: number;
    per_page: number;
}
export declare class EntryCollection<T = any> extends Collection<IEntry<T>> {
    readonly meta?: IEntriesMeta;
    readonly links?: IEntriesLinks;
    constructor(entries: IEntry<T>[], meta?: IEntriesMeta, links?: IEntriesLinks);
    static fromResponse<T>(response: Http.Responses<T[]>['entries'], stream: Stream): EntryCollection<T>;
}
export declare class PaginatedEntryCollection<T = any> extends Collection<IEntry<T>> {
    readonly meta?: IPaginatedEntriesMeta;
    readonly links?: IPaginatedEntriesLinks;
    constructor(entries: IEntry<T>[], meta?: IPaginatedEntriesMeta, links?: IPaginatedEntriesLinks);
    static fromResponse<T>(response: Http.Responses<T[]>['paginated'], stream: Stream): PaginatedEntryCollection<T>;
}
