import { Stream } from './Stream';
import { Entry } from './Entry';
import { EntryCollection } from './EntryCollection';


export class Criteria {
    // parameters
    // adapter
    stream: Stream;


    async all(): Promise<EntryCollection> {return; }

    find(): this {return this;}

    async first(): Promise<Entry> {return this;}

    cache(): this {return this;}

    orderBy(): this {return this;}

    limit(): this {return this;}

    where(): this {return this;}

    orWhere(): this {return this;}

    get(): EntryCollection {return;}

    count(): number {return 0;}

    create(): this {return this;}

    save(): this {return this;}

    delete(): this {return this;}

    truncate(): this {return this;}

    paginate(): this {return this;}

    newInstance(): this {return this;}

    getParameters(): this {return this;}

    setParameters(): this {return this;}
}
