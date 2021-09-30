import { Stream } from './Stream';
import { Entry } from './Entry';
import { EntryCollection } from './EntryCollection';
export declare class Criteria {
    stream: Stream;
    all(): Promise<EntryCollection>;
    find(): this;
    first(): Promise<Entry>;
    cache(): this;
    orderBy(): this;
    limit(): this;
    where(): this;
    orWhere(): this;
    get(): EntryCollection;
    count(): number;
    create(): this;
    save(): this;
    delete(): this;
    truncate(): this;
    paginate(): this;
    newInstance(): this;
    getParameters(): this;
    setParameters(): this;
}
