import { Stream } from './Stream';
import { Entry } from './Entry';
import { EntryCollection, PaginatedEntryCollection } from './EntryCollection';
import { IBaseStream } from '../types';
import { Http } from '../Streams/Http';
export declare type OrderByDirection = 'asc' | 'desc';
export declare type ComparisonOperator = '>' | '<' | '==' | '!=' | '>=' | '<=' | '!<' | '!>' | '<>';
export declare const comparisonOperators: ComparisonOperator[];
export declare type LogicalOperator = 'BETWEEN' | 'EXISTS' | 'OR' | 'AND' | 'NOT' | 'IN' | 'ALL' | 'ANY' | 'LIKE' | 'IS NULL' | 'UNIQUE';
export declare const logicalOperators: LogicalOperator[];
export declare const operators: Operator[];
export declare type Operator = ComparisonOperator | LogicalOperator;
export interface CriteriaParameter {
    name: string;
    value: any;
}
export declare class Criteria<ID extends string = string> {
    protected stream: Stream;
    http: Http;
    parameters: CriteriaParameter[];
    /**
     * Create a new instance.
     *
     * @param stream
     */
    constructor(stream: Stream);
    /**
     * Find an entry by ID.
     *
     * @param id
     * @returns
     */
    find<ID extends string>(id: ID): Promise<Entry>;
    /**
     * Return the first result.
     *
     * @returns
     */
    first(): Promise<Entry<ID> & IBaseStream<ID>>;
    cache(): this;
    /**
     * Order the query by field/direction.
     *
     * @param key
     * @param direction
     * @returns
     */
    orderBy(key: string, direction?: OrderByDirection): this;
    /**
     * Limit the entries returned.
     *
     * @param value
     * @returns
     */
    limit(value: number): this;
    /**
     * Constrain the query by a typical
     * field, operator, value argument.
     *
     * @param key
     * @param value
     */
    where(key: string, operator: Operator, value: any, nested: any): this;
    where(key: string, operator: Operator, value: any): this;
    where(key: string, value: any): this;
    orWhere(key: string, operator: Operator, value: any): this;
    orWhere(key: string, value: any): this;
    /**
     * Get the criteria results.
     *
     * @returns
     */
    get<T>(): Promise<EntryCollection>;
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
    delete(): this;
    /**
     * Get paginated criteria results.
     *
     * @param per_page
     * @param page
     * @returns
     */
    paginate<T>(per_page?: number, page?: number): Promise<PaginatedEntryCollection>;
    /**
     * Return an entry instance.
     *
     * @param attributes
     * @returns Entry
     */
    newInstance(attributes: any): Entry;
    /**
     * Get the parameters.
     *
     * @returns
     */
    getParameters(): any;
    /**
     * Set the parameters.
     *
     * @param parameters
     * @returns
     */
    setParameters(parameters: any): this;
    /**
     * Add a statement.
     *
     * @param name
     * @param value
     * @returns
     */
    protected addParameter(name: string, value: any | any[]): this;
    /**
     * Return standardized parameters.
     *
     * @returns
     */
    compileStatements(): {
        [x: string]: any[];
    }[];
}
