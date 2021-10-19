import { Stream } from './Stream';
import { Criteria } from '../Streams/Criteria';
import { Http } from '../Streams/Http';
import { EntryCollection } from '../Streams/EntryCollection';
import { Entry } from '../Streams/Entry';
export declare class Repository<ID extends string = string> {
    protected stream: Stream;
    protected http: Http;
    /**
     * Create a new repository instance.
     *
     * @param stream
     */
    constructor(stream: Stream);
    /**
     * Return all items.
     *
     * @returns EntryCollection
     */
    all(): Promise<EntryCollection>;
    /**
     * Find an entry by ID.
     *
     * @param id
     * @returns Entry
     */
    find<ID extends string>(id: ID): Promise<Entry>;
    /**
     * Find all records by IDs.
     *
     * @param ids
     * @returns EntryCollection
     */
    findAll(ids: any): Promise<EntryCollection>;
    /**
     * Find an entry by a field value.
     *
     * @param field
     * @param value
     * @returns Entry
     */
    findBy<ID extends string, VID extends string>(field: ID, value: VID): Promise<Entry>;
    /**
     * Find all entries by field value.
     *
     * @param $field
     * @param $operator
     * @param $value
     * @return EntryCollection
     */
    findAllWhere<ID extends string, VID extends string>(field: ID, value: VID): Promise<EntryCollection>;
    /**
     * Create a new entry.
     *
     * @param attributes
     * @returns
     */
    create(attributes: any): Promise<Entry>;
    /**
     * Save an entry.
     *
     * @param entry
     * @returns
     */
    save(entry: Entry): Promise<Boolean>;
    /**
     * Save an entry.
     *
     * @param entry
     * @returns
     */
    delete(entry: any): Promise<Boolean>;
    truncate(): this;
    /**
     * Return a new instance.
     *
     * @param attributes
     * @returns
     */
    newInstance(attributes: any): Entry;
    /**
     * Return a new entry criteria.
     *
     * @returns Criteria
     */
    newCriteria(): Criteria<ID>;
}
