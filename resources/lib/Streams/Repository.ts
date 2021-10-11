import { Stream } from './Stream';
import { Criteria } from '@/Streams/Criteria';
import { inject } from '@/Foundation';
import { Http } from '@/Streams/Http';
import { EntryCollection } from '@/Streams/EntryCollection';
import { Entry } from '@/Streams/Entry';


export class Repository<ID extends string = string> {
    @inject('streams.http') protected http:Http

    constructor(protected stream: Stream) {}

    async all(): Promise<EntryCollection> {
        let res = await this.http.getEntries<any>(this.stream.id);
        let entries = res.data.map(entry => new Entry(this.stream, entry, false))
        return new EntryCollection(entries, res.meta as any, res.links as any)
    }

    find(): this {return this;}

    findAll(): this {return this;}

    findBy(): this {return this;}

    findAllWhere(): this {return this;}

    async create(data:any): Promise<Entry> {
        let entry = new Entry(this.stream, data, true)
        await entry.save()
        return entry;
    }

    save(): this {return this;}

    delete(): this {return this;}

    truncate(): this {return this;}

    newInstance(): this {return this;}

    newCriteria(): Criteria<ID> {return new Criteria<ID>(this.stream);}

    newSelfAdapter(): this {return this;}

    newFileAdapter(): this {return this;}

    newFilebaseAdapter(): this {return this;}

    newDatabaseAdapter(): this {return this;}

    newEloquentAdapter(): this {return this;}
}
