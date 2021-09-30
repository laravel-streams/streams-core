import { Entry } from './Entry';
import { Collection } from '@/Support';
import { IStreamLinks, IStreamMeta } from '@/types';


export type IEntriesLinks = IStreamLinks<'next_page'|'previous_page'|'self'>;
export interface IEntriesMeta extends IStreamMeta {
    current_page:number
    last_page:number
    per_page:number
    total:number
}

export class EntryCollection extends Collection<Entry> {
    constructor(entries:Entry[], public readonly meta?:IEntriesMeta, public readonly links?:IEntriesLinks) {
        super(...entries);
    }
}
