import { Stream } from './Stream';
import { Criteria } from '@/Streams/Criteria';
import { inject } from '@/Foundation';
import { Http } from '@/Streams/Http';
import { EntryCollection } from '@/Streams/EntryCollection';
import { Entry } from '@/Streams/Entry';
import { Collection } from '@';


export class Repository<ID extends string = string> {

    @inject('streams.http') protected http: Http

    /**
     * Create a new repository instance.
     * 
     * @param stream
     */
    constructor(protected stream: Stream) { }

    /**
     * Return all items.
     * 
     * @returns EntryCollection
     */
    async all(): Promise<EntryCollection> {

        let response = await this.http.getEntries<any>(this.stream.id);

        let entries = response.data.map(entry => new Entry(this.stream, entry, false));

        return new EntryCollection(entries, response.meta as any, response.links as any);
    }

    /**
     * Find an entry by ID.
     * 
     * @param id
     * @returns Entry
     */
    async find<ID extends string>(id: ID): Promise<Entry> {

        let criteria = this.stream.entries();

        return criteria.where('id', id).first();
    }

    /**
     * Find all records by IDs.
     * 
     * @param ids
     * @returns EntryCollection
     */
    async findAll(ids): Promise<EntryCollection> {

        let criteria = this.stream.entries();

        return criteria.where('id', 'IN', ids).get();
    }

    /**
     * Find an entry by a field value.
     * 
     * @param field
     * @param value
     * @returns Entry
     */
    async findBy<ID extends string, VID extends string>(field: ID, value: VID): Promise<Entry> {

        let criteria = this.stream.entries();

        return criteria.where(field, value).first();
    }

    /**
     * Find all entries by field value.
     * 
     * @param $field
     * @param $operator
     * @param $value
     * @return EntryCollection
     */
    async findAllWhere<ID extends string, VID extends string>(field: ID, value: VID): Promise<EntryCollection> {

        let criteria = this.stream.entries();

        return criteria.where(field, value).get();
    }

    /**
     * Create a new entry.
     * 
     * @param attributes 
     * @returns 
     */
    async create(attributes: any): Promise<Entry> {
        
        let entry = this.newCriteria().newInstance(attributes);

        await entry.save()

        return entry;
    }

    save(): this { return this; }

    delete(): this { return this; }

    truncate(): this { return this; }

    newInstance(): this { return this; }

    /**
     * Return a new entry criteria.
     * 
     * @returns Criteria
     */
    newCriteria(): Criteria<ID> {
        return new Criteria<ID>(this.stream);
    }
}
