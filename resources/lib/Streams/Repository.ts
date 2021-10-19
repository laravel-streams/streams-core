import { Stream } from './Stream';
import { Criteria } from '../Streams/Criteria';
import { inject } from '../Foundation';
import { Http } from '../Streams/Http';
import { EntryCollection } from '../Streams/EntryCollection';
import { Entry } from '../Streams/Entry';


export class Repository<ID extends string = string> {

    @inject('streams.http') protected http: Http;

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

        await entry.save();

        return entry;
    }

    /**
     * Save an entry.
     *
     * @param entry
     * @returns
     */
    async save(entry: Entry): Promise<Boolean> {

        let result = await entry.save();

        return result;
    }

    /**
     * Save an entry.
     *
     * @param entry
     * @returns
     */
    async delete(entry: any): Promise<Boolean> {

        await this.http.deleteEntry(this.stream.id, entry.id);

        return true;
    }

    truncate(): this { return this; }

    /**
     * Return a new instance.
     *
     * @param attributes
     * @returns
     */
    newInstance(attributes: any): Entry {
        return this.newCriteria().newInstance(attributes);
    }

    /**
     * Return a new entry criteria.
     *
     * @returns Criteria
     */
    newCriteria(): Criteria<ID> {
        return new Criteria<ID>(this.stream);
    }
}
