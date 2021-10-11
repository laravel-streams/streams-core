import { Entry, IEntry } from './Entry';
import { Collection } from '@/Support';
import { IStreamLinks, IStreamMeta } from '@/types';
import { Stream } from '@/Streams/Stream';
import { Http } from '@/Streams/Http';


export type IEntriesLinks = IStreamLinks<'self' | 'streams' | 'stream'>;
export type IPaginatedEntriesLinks = IStreamLinks<'next_page' | 'previous_page' | 'self' | 'first_page' | 'streams' | 'stream'>;

export interface IEntriesMeta extends IStreamMeta {
    total: number;
}

export interface IPaginatedEntriesMeta extends IStreamMeta {
    current_page: number;
    last_page: number;
    per_page: number;
}

export class EntryCollection<T=any> extends Collection<IEntry<T>> {
    constructor(entries: IEntry<T>[], public readonly meta?: IEntriesMeta, public readonly links?: IEntriesLinks) {
        super(...entries as any[]);
    }

    static fromResponse<T>(response: Http.Responses<T[]>['entries'], stream: Stream): EntryCollection<T> {
        const entries = Object.values(response.data).map(entry => new Entry(stream, entry, false));
        return new EntryCollection<T>(entries as any, response.meta, response.links);
    }
}

export class PaginatedEntryCollection<T=any> extends Collection<IEntry<T>> {
    constructor(entries: IEntry<T>[], public readonly meta?: IPaginatedEntriesMeta, public readonly links?: IPaginatedEntriesLinks) {
        super(...entries);
    }

    static fromResponse<T>(response: Http.Responses<T[]>['paginated'], stream: Stream): PaginatedEntryCollection<T> {
        const entries = Object.values(response.data).map(entry => new Entry(stream, entry, false));
        return new PaginatedEntryCollection<T>(entries as any, response.meta, response.links);
    }
}
